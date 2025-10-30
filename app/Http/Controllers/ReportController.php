<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{


    public function index()
    {
        // Get summary statistics
        $totalRevenue = Rental::where('payment_status', 'paid')->sum('total_price');
        $totalRentals = Rental::count();
        $activeRentals = Rental::where('status', 'active')->count();
        $totalUnits = Unit::count();
        $occupiedUnits = Unit::where('status', 'occupied')->count();
        $availableUnits = Unit::where('status', 'available')->count();
        $maintenanceUnits = Unit::where('status', 'maintenance')->count();
        $totalUsers = User::where('role', 'user')->count();

        // Get recent rentals
        $recentRentals = Rental::with(['user', 'unit'])
            ->latest()
            ->take(10)
            ->get();

        // Get units by category
        $unitsByCategory = Unit::with('categories')
            ->selectRaw('categories.name as category_name, COUNT(*) as count')
            ->join('category_unit', 'units.id', '=', 'category_unit.unit_id')
            ->join('categories', 'category_unit.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->get();

        // Get monthly revenue for the last 12 months
        $monthlyRevenue = Rental::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_price) as revenue')
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.reports.index', compact(
            'totalRevenue',
            'totalRentals',
            'activeRentals',
            'totalUnits',
            'occupiedUnits',
            'availableUnits',
            'maintenanceUnits',
            'totalUsers',
            'recentRentals',
            'unitsByCategory',
            'monthlyRevenue'
        ));
    }

    public function exportRevenue(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subMonths(12)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $rentals = Rental::with(['user', 'unit'])
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $rentals->sum('total_price');

        $pdf = Pdf::loadView('admin.reports.revenue-pdf', compact('rentals', 'totalRevenue', 'startDate', 'endDate'));
        return $pdf->download('laporan-revenue-' . $startDate . '-to-' . $endDate . '.pdf');
    }

    public function exportUnits(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Unit::with('categories');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $units = $query->orderBy('name')->get();

        $pdf = Pdf::loadView('admin.reports.units-pdf', compact('units', 'status'));
        return $pdf->download('laporan-unit-' . $status . '.pdf');
    }

    public function exportMaintenance(Request $request)
    {
        $units = Unit::where('status', 'maintenance')
            ->with('categories')
            ->orderBy('name')
            ->get();

        $pdf = Pdf::loadView('admin.reports.maintenance-pdf', compact('units'));
        return $pdf->download('laporan-maintenance.pdf');
    }

    public function exportAll(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subMonths(12)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        // Revenue data
        $rentals = Rental::with(['user', 'unit'])
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $rentals->sum('total_price');

        // Units data
        $allUnits = Unit::with('categories')->orderBy('name')->get();
        $availableUnits = $allUnits->where('status', 'available');
        $occupiedUnits = $allUnits->where('status', 'occupied');
        $maintenanceUnits = $allUnits->where('status', 'maintenance');

        // Users data
        $users = User::where('role', 'user')->with(['rentals' => function($query) {
            $query->latest()->take(5);
        }])->get();

        $pdf = Pdf::loadView('admin.reports.all-pdf', compact(
            'rentals', 'totalRevenue', 'startDate', 'endDate',
            'allUnits', 'availableUnits', 'occupiedUnits', 'maintenanceUnits',
            'users'
        ));
        return $pdf->download('laporan-keseluruhan-' . $startDate . '-to-' . $endDate . '.pdf');
    }
}
