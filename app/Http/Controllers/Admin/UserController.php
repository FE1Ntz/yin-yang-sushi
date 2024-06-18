<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return Inertia::render('Admin/User/Index', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = $this->createProduct($request);

        $ingredients = request()->input('ingredients');
        $ingredientsIds = collect($ingredients)->pluck('id')->toArray();
        $product->ingredients()->attach($ingredientsIds);

        return redirect()->route('products.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $product->update($request->all());

        $ingredients = request()->input('ingredients');
        $ingredientsIds = collect($ingredients)->pluck('id')->toArray();
        $product->ingredients()->sync($ingredientsIds);


        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }

    private function createProduct(Request $request): Product
    {
        return Product::query()->create($request->all());
    }
}
