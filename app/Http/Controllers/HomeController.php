<?php
// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Homepage
    public function index(Request $request)
    {
        // Get all units with pagination for load more (3 per page)
        $unitsQuery = Unit::with('categories')
            ->orderBy('created_at', 'desc');

        $units = $unitsQuery->paginate(3);

        // Get categories with available units count
        $categories = Category::withCount(['units' => function ($query) {
            $query->where('status', 'available');
        }])->get();

        // Check if it's AJAX request for load more
        if ($request->ajax()) {
            $view = view('partials.unit-cards', compact('units'))->render();

            return response()->json([
                'html' => $view,
                'hasMore' => $units->hasMorePages(),
                'nextPage' => $units->nextPageUrl()
            ]);
        }

        return view('home', compact('categories', 'units'));
    }

    public function adminIndex(Request $request)
    {
        $query = Unit::with('categories')->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $units = $query->paginate(10); // 10 items per page
        $categories = Category::withCount('units')
            ->paginate(10);

        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            return view('admin.index', compact('categories', 'units'));
        }

        return view('home', compact('categories', 'units'));
    }
}
