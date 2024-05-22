<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()->with(['ingredients', 'category'])->get();
        $ingredients = Ingredient::all();
        $categories = Category::all();

        return Inertia::render('Admin/Product/Index', [
            'products' => $products,
            'ingredients' => $ingredients,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //dd(request()->all());
            $product = $this->createProduct($request);

            $ingredients = request()->input('ingredients');
            $ingredientsIds = collect($ingredients)->pluck('id')->toArray();
            $product->ingredients()->attach($ingredientsIds);

            return redirect()->route('products.index');
        } catch (Exception $ex) {
            dd($request->all(), $ex);
            return redirect()->route('products.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        try {
            $product->update($request->all());

            $ingredients = request()->input('ingredients');
            $ingredientsIds = collect($ingredients)->pluck('id')->toArray();
            $product->ingredients()->sync($ingredientsIds);

            return redirect()->route('products.index');
        } catch (Exception $ex){
            return redirect()->route('products.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return redirect()->route('products.index');
        } catch (Exception $ex){
            dd($ex->getMessage());
            return redirect()->route('products.index');
        }
    }

    private function createProduct(Request $request): Product
    {
        return Product::query()->create($request->all());
    }
}
