<?php
// app/Http/Controllers/RentalController.php
namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;

class RentalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Set Midtrans configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    // Show rental form
    public function create($unitId)
    {
        $unit = Unit::available()->findOrFail($unitId);
        $user = Auth::user();

        // Check if user can rent another unit
        if (!$user->canRentAnotherUnit()) {
            return redirect()->route('units.show', $unit->id)
                ->with('error', 'Anda sudah meminjam 2 unit. Tidak bisa meminjam lagi.');
        }

        return view('rentals.create', compact('unit'));
    }

    // Process rental
    public function store(Request $request, $unitId)
    {
        $unit = Unit::available()->findOrFail($unitId);
        $user = Auth::user();

        // Validation
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'purpose' => 'required|string|max:500',
        ], [
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh kurang dari hari ini.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        // Check max rental days (5 days)
        if ($request->start_date && $request->end_date) {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $rentalDays = $startDate->diffInDays($endDate) + 1;

            if ($rentalDays > 5) {
                $validator->errors()->add(
                    'end_date',
                    'Maksimal peminjaman adalah 5 hari. Anda memilih ' . $rentalDays . ' hari.'
                );
            }
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if user can rent another unit
        if (!$user->canRentAnotherUnit()) {
            return redirect()->route('units.show', $unit->id)
                ->with('error', 'Anda sudah meminjam 2 unit. Tidak bisa meminjam lagi.');
        }

        // Calculate total price
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $rentalDays = $startDate->diffInDays($endDate) + 1;
        $totalPrice = $unit->calculateRentalPrice($rentalDays);

        // Create rental with pending payment status
        $rental = Rental::create([
            'user_id' => $user->id,
            'unit_id' => $unit->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $totalPrice,
            'purpose' => $request->purpose,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        // Create Midtrans transaction
        $transactionId = 'RENT-' . $rental->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $transactionId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $unit->id,
                    'price' => $unit->price_per_day,
                    'quantity' => $rentalDays,
                    'name' => 'Peminjaman ' . $unit->name . ' (' . $rentalDays . ' hari)',
                ]
            ],
            'callbacks' => [
                'finish' => route('payment.success'),
                'error' => route('payment.failed'),
                'pending' => route('payment.pending'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            // Update rental with transaction details
            $rental->update([
                'transaction_id' => $transactionId,
                'payment_url' => $snapToken,
            ]);

            // Redirect to payment page
            return view('rentals.payment', compact('rental', 'snapToken'));
        } catch (\Exception $e) {
            // If payment creation fails, delete rental and redirect back
            $rental->delete();

            return redirect()->back()
                ->withErrors(['payment' => 'Gagal membuat pembayaran. Silakan coba lagi.'])
                ->withInput();
        }
    }

    // Show user's rentals
    public function myRentals()
    {
        $user = Auth::user();
        $rentals = Rental::with('unit')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('rentals.my-rentals', compact('rentals'));
    }

    // Show rental details
    public function show($id)
    {
        $rental = Rental::with(['unit', 'unit.categories'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        // Check for overdue
        $rental->checkOverdue();

        return view('rentals.show', compact('rental'));
    }

    // Show payment page
    public function payment(Rental $rental)
    {
        // Pastikan Midtrans sudah dikonfigurasi di config/midtrans.php
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false; // true jika sudah live
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Data transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $rental->transaction_id,
                'gross_amount' => (int) $rental->total_price,
            ],
            'customer_details' => [
                'first_name' => $rental->user->name,
                'email' => $rental->user->email,
            ],
        ];

        // Generate Snap Token
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('rentals.payment', compact('rental', 'snapToken'));
    }


    // Calculate rental price (AJAX)
    public function calculatePrice(Request $request, $unitId)
    {
        $unit = Unit::findOrFail($unitId);

        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $rentalDays = $startDate->diffInDays($endDate) + 1;

        // Check max days
        if ($rentalDays > 5) {
            return response()->json([
                'success' => false,
                'message' => 'Maksimal peminjaman adalah 5 hari'
            ]);
        }

        $totalPrice = $unit->calculateRentalPrice($rentalDays);

        return response()->json([
            'success' => true,
            'rental_days' => $rentalDays,
            'price_per_day' => $unit->price_per_day,
            'total_price' => $totalPrice,
            'formatted_total_price' => 'Rp ' . number_format($totalPrice, 0, ',', '.')
        ]);
    }
}
