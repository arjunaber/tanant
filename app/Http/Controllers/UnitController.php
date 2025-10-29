<?php
// app/Http/Controllers/UnitController.php
namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Category;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 3;

        $units = Unit::with('categories')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        $categories = Category::all(); // Sederhanakan query categories

        $user = auth()->user();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.unit-cards', compact('units'))->render(),
                'hasMore' => $units->hasMorePages()
            ]);
        }

        // Tampilan khusus untuk admin
        if ($user && $user->role === 'admin') {
            return view('admin.index', compact('categories', 'units'));
        }

        // Default untuk user biasa
        return view('home', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        // Validasi untuk multiple categories
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:available,occupied,maintenance',
            'category_id' => 'required|array', // Ubah menjadi array
            'category_id.*' => 'exists:categories,id', // Validasi setiap item array
            'description' => 'nullable|string',
            'price_per_day' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'facilities' => 'nullable|string',
        ]);

        // Generate kode otomatis dan buat unit
        $unit = Unit::create(array_merge($validated, [
            'code' => 'UNIT-' . str_pad((Unit::max('id') ?? 0) + 1, 3, '0', STR_PAD_LEFT)
        ]));

        // Attach multiple categories
        $unit->categories()->attach($validated['category_id']);

        return redirect()->route('admin.index')->with('success', 'Unit baru berhasil ditambahkan!');
    }


    // Update data unit - FIXED untuk multiple categories
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:available,unavailable',
            'category_id' => 'required|array', // Ubah menjadi array
            'category_id.*' => 'exists:categories,id', // Validasi setiap item array
            'description' => 'nullable|string',
            'price_per_day' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'facilities' => 'nullable|string',
        ]);

        $unit = Unit::findOrFail($id);
        $unit->update([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description,
            'price_per_day' => $request->price_per_day,
            'capacity' => $request->capacity,
            'facilities' => $request->facilities,
        ]);

        // Update relasi kategori dengan sync (untuk multiple categories)
        $unit->categories()->sync($request->category_id);

        return redirect()->route('admin.index')->with('success', 'Data unit berhasil diperbarui!');
    }

    // Hapus unit
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->categories()->detach();
        $unit->delete();

        return redirect()->route('admin.index')->with('success', 'Unit berhasil dihapus!');
    }

    public function show($id)
    {
        $unit = Unit::with('categories')->findOrFail($id);

        // Check if user can rent this unit
        $canRent = false;
        if (auth()->check()) {
            $user = auth()->user();
            $activeRentals = $user->rentals()->whereIn('status', ['pending', 'confirmed', 'active'])->count();
            $canRent = $unit->status === 'available' && $activeRentals < 2;
        }

        // Get related units (same category, excluding current unit)
        $relatedUnits = Unit::whereHas('categories', function ($query) use ($unit) {
            $query->whereIn('categories.id', $unit->categories->pluck('id'));
        })
        ->where('id', '!=', $unit->id)
        ->where('status', 'available')
        ->take(3)
        ->get();

        return view('units.show', compact('unit', 'canRent', 'relatedUnits'));
    }

    public function getUnitsData(Request $request)
    {
        $units = Unit::with('categories')
            ->select(['id', 'name', 'status', 'price_per_day', 'capacity', 'facilities', 'description', 'created_at'])
            ->get();

        return datatables()->of($units)
            ->addColumn('action', function ($unit) {
                return view('admin.partials.actions', compact('unit'))->render();
            })
            ->addColumn('categories', function ($unit) {
                return $unit->categories->pluck('name')->implode(', ');
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
