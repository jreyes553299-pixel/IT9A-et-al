<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::where('is_featured', true)->get();
        $reviews = Review::all();

        return view('welcome', compact('categories', 'products', 'reviews'));
    }
}
