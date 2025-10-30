<?php
// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Ambil unit terbaru dengan relasi kategori (3 per halaman)
        $units = Unit::with('categories')
            ->latest()
            ->paginate(3);

        // Ambil kategori + jumlah unit tersedia
        $categories = Category::withCount(['units' => function ($query) {
            $query->where('status', 'available');
        }])->get();

        // Handle AJAX (load more)
        if ($request->ajax()) {
            return response()->json([
                'html'     => view('partials.unit-cards', compact('units'))->render(),
                'hasMore'  => $units->hasMorePages(),
                'nextPage' => $units->nextPageUrl(),
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
