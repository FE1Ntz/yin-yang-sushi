<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        $categories = Category::all();
        $products = Product::query()->with(['ingredients', 'category'])->get();
        return Inertia::render('Menu', ['categories' => $categories, 'products' => $products]);
    }
}
