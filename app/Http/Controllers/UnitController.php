<?php
// app/Http/Controllers/UnitController.php
namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Category;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    // List all available units
    public function index(Request $request)
    {
        $query = Unit::with('categories')->available();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id != '') {
            $query->byCategory($request->category_id);
        }

        $units = $query->latest()->paginate(9);
        $categories = Category::all();

        return view('units.index', compact('units', 'categories'));
    }

    // Show unit details
    public function show($id)
    {
        $unit = Unit::with('categories')->findOrFail($id);

        // Check if user can rent this unit
        $canRent = auth()->check() && auth()->user()->canRentAnotherUnit() && $unit->isAvailable();

        return view('units.show', compact('unit', 'canRent'));
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
