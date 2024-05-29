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
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        $products = Session::get('products', []);

        return Inertia::render('Cart', ['products' => $products]);
    }

    public function addToCart(Request $request){
        $productIds = array_column($request->all(), 'id');

        // Отримання продуктів за допомогою whereIn
        $products = Product::whereIn('id', $productIds)->get();

        // Перетворення $cartItems на асоціативний масив для зручного доступу за ID
        $cartItemsAssoc = collect($request->all())->keyBy('id');

        // Додавання кількості до кожного продукту
        $products->each(function($product) use ($cartItemsAssoc) {
            $product->quantity = $cartItemsAssoc[$product->id]['quantity'];
        });

        Session::put('products', $products);
    }
}
