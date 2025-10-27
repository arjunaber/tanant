<?php
// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Homepage
    public function index()
    {
        $featuredUnits = Unit::with('categories')
            ->available()
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $categories = Category::withCount(['units' => function ($query) {
            $query->available();
        }])->get();

        return view('home', compact('featuredUnits', 'categories'));
    }
}
