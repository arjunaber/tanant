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

        $categories = Category::withCount(['units' => function ($query) {
            $query->where('status', 'available');
        }])->get();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.unit-cards', compact('units'))->render(),
                'hasMore' => $units->hasMorePages()
            ]);
        }

        return view('home', compact('categories', 'units'));
    }

    // Show unit details
    public function show($id)
    {
        $unit = Unit::with('categories')->findOrFail($id);

        // Check if user can rent this unit
        $canRent = auth()->check() && auth()->user()->canRentAnotherUnit() && $unit->isAvailable();

        // Get related units (same categories)
        $relatedUnits = Unit::whereHas('categories', function ($query) use ($unit) {
            $query->whereIn('categories.id', $unit->categories->pluck('id'));
        })
            ->where('id', '!=', $unit->id)
            ->available()
            ->limit(4)
            ->get();

        return view('units.show', compact('unit', 'canRent', 'relatedUnits'));
    }

    // Search units API for AJAX
    public function search(Request $request)
    {
        $query = Unit::with('categories')->available();

        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->byCategory($request->category_id);
        }

        $units = $query->take(10)->get();

        return response()->json($units);
    }
}
