<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Recipe;
use App\Models\RecipeProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\NoReturn;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $data = request()->validate([
            'name' => 'unique:recipes|required|max:255',
            'short_description' => 'required|max:255',
            'description' => 'required|max:255',
            'cooking_time' => 'required|min:0.01|max:1000|numeric',
            'products' => 'required'
        ]);


        $recipe = new Recipe();
        $recipe->user_id = Auth::id(); //!!! Šeit vajag nomainīt. Šis ir bruteforce. Kad būs login, tad varēs (varbūt ātrāk)
        $recipe->name = $request->name;
        $recipe->short_description = $request->short_description;
        $recipe->description = $request->description;
        $recipe->cooking_time = $request->cooking_time;

        $recipe->save();

        $recipe = Recipe::where('name', $request->name)->first();

        $productIDString = $request->products;
        $arrOfIds = explode(",", $productIDString);

        for ($i = 0; $i < count($arrOfIds); $i++) {
            $product_id = intval($arrOfIds[$i]);
            //dd($product_id);
            $product = Product::where('id', $product_id)->first();
            $recipe->products()->attach($product);
        }

        //$request->products

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
        $recipe = Recipe::where('recipes.id', '=', $id)->
        select('users.username', 'recipes.id', 'recipes.name', 'recipes.short_description', 'recipes.description', 'recipes.cooking_time', 'recipes.created_at')
        ->join('users', 'users.id', '=', 'recipes.user_id')->first();
        //dd($recipe);


        $comments = Comment::where('recipe_id', '=', $id)->
        select('users.username', 'comments.id', 'comments.rating', 'comments.content', 'comments.created_at')->
            join('users', 'users.id', '=', 'comments.user_id')
            ->orderBy('comments.created_at', 'desc')
            ->get();

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
        $recipe = Recipe::findOrFail($id);
        $products_checked = Recipe::findOrFail($id)->products()->orderBy('isAllergic', 'desc', 'type', 'asc')->get();
        $products = Product::all();

        $products_not_checked = [];
        foreach($products as $product){
            if(!in_array($product->id, $products_checked->pluck('id')->toArray())){
                $products_not_checked[] = $product;
            }
        }

        return view('edit_recipe', compact('recipe', 'products',  'products_checked', 'products_not_checked'));
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
        //$recipe = new Recipe();
        $recipe = Recipe::findOrFail($id);
        $recipe->user_id = Auth::id(); //!!! Šeit vajag nomainīt. Šis ir bruteforce. Kad būs login, tad varēs (varbūt ātrāk)
        $recipe->name = $request->name;
        $recipe->short_description = $request->short_description;
        $recipe->description = $request->description;
        $recipe->cooking_time = $request->cooking_time;

        $recipe->save();

        RecipeProduct::where('recipe_id', $id)->delete();

        $recipe = Recipe::where('name', $request->name)->first();

        $productIDString = $request->products;
        $arrOfIds = explode(",", $productIDString);

        for ($i = 0; $i < count($arrOfIds); $i++) {
            $product_id = intval($arrOfIds[$i]);
            //dd($product_id);
            $product = Product::where('id', $product_id)->first();
            $recipe->products()->attach($product);
        }

        return redirect('/recipe');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::where('recipe_id', $id)->delete();
        Recipe::findOrFail($id)->delete();
        return redirect('recipe');
    }
}
