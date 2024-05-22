<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredients = Ingredient::all();
        return Inertia::render('Admin/Ingredient/Index', ['ingredients' => $ingredients]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Ingredient::create($request->all());

            return redirect()->route('ingredients.index');
        } catch (Exception $ex) {
            return redirect()->route('ingredients.index');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        try {
            $ingredient->update($request->all());

            return redirect()->route('ingredients.index');
        } catch (Exception $ex){
            return redirect()->route('ingredients.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredient $ingredient)
    {
        try {
            if ($ingredient->products()->exists()) {
                throw new \Exception('Цей інгредієнт використовується у продуктах. Видалення неможливе.');
            }

            $ingredient->delete();
            return redirect()->route('ingredients.index');
        } catch (Exception $ex){
            dd($ex->getMessage());
            return redirect()->route('ingredients.index');
        }
    }
}
