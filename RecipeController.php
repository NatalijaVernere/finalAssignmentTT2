<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Recipe;
use App\Models\RecipeProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::all();
        return view('recipes', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('new_recipe', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $recipe = new Recipe();
        $recipe->user_id = 1; //!!! Šeit vajag nomainīt. Šis ir bruteforce. Kad būs login, tad varēs (varbūt ātrāk)
        $recipe->name = $request->name;
        $recipe->short_description = $request->short_description;
        $recipe->description = $request->description;
        $recipe->cooking_time = $request->cooking_time;

        $recipe = Recipe::where('id', $recipe->id)->first();
        $product = Product::where('id', $request->id)->first();
        $recipe->products()->attach($product);

        $recipe->save();

        return redirect('/recipe');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = Recipe::findOrFail($id);
        $comments = Comment::where('recipe_id', '=', $id)->get();

        $products = Recipe::findOrFail($id)->products()->orderBy('isAllergic', 'desc', 'type', 'asc')->get();
        return view('show_recipe', compact('recipe', 'comments', 'products'));
    }

    /**
     * @return void
     * Returns recipes than match search
     */
    public function showMultiple(request $request){
        if($request->name){
            $recipes = Recipe::where('name', 'like', '%'.$request->name.'%')->
            orWhere('short_description', 'like', '%'.$request->name.'%')->get();

            return view('recipes', compact('recipes'));
        }
        else{
            return redirect('/');
        }
    }

    /**
     * @return \Illuminate\Http\Response
     * Returns ordered recipes than match order by
     */

    public function filterNameDesc() {
        //dd('hello');
        $recipes = Recipe::orderBy('name', 'DESC')->get();
        dd($recipes);
        return view('recipes', compact('recipes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
