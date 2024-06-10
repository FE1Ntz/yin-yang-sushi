<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $products = Product::query()->with(['ingredients', 'category'])->get()->toArray();

        if(Auth::user() !== null) {
            $likedProducts = DB::table('product_user')
                ->where('user_id', Auth::user()->id)
                ->pluck('product_id')
                ->toArray();

            $products = array_map(function ($product) use ($likedProducts) {
                $product['isLiked'] = in_array($product['id'], $likedProducts);
                return $product;
            }, $products);
        }

        return Inertia::render('Menu', ['categories' => $categories, 'products' => $products]);
    }

    public function addToFavorite(Request $request)
    {
        $likedProduct = $request->input(['productId']);
        $user = Auth::user();

        $user->likedProducts()->attach($likedProduct);
    }

    public function removeFromFavorite(Request $request)
    {
        $likedProduct = $request->input(['productId']);
        $user = Auth::user();

        $user->likedProducts()->detach($likedProduct);
    }
}
