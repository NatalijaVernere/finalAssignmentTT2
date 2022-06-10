<?php

use App\Models\Product;
use App\Models\Recipe;
use App\Models\Comment;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;

Route::redirect('/', 'recipe');
Route::resource('recipe', RecipeController::class);

Route::get('/recipes/filterDescName', function () { //ja šeit vienkārši ievada '/filterDesc' (un nomaina izsaukumu tādu pašu), tad strādā. weird
    //dd('hello route filterDesc');
    $recipes = Recipe::orderBy('name', 'DESC')->get();
    //dd($recipes);
    return view('recipes', compact('recipes'));
})->name('filterDesc.name');

Route::get('/recipes/filterAscName', function () {
    //dd('hello route filterDesc');
    $recipes = Recipe::orderBy('name', 'ASC')->get();
    //dd($recipes);
    return view('recipes', compact('recipes'));
})->name('filterAsc.name');

//recipes/filterAsc/name
//recipes/filterAsc/cookingTime'

Route::get('/recipes/filterAscCookingTime', function () {
    //dd('hello route filterDesc');
    $recipes = Recipe::orderBy('cooking_time', 'ASC')->get();
    //dd($recipes);
    return view('recipes', compact('recipes'));
})->name('filterAsc.cookingTime');

Route::get('/recipes/filterDescCookingTime', function () {
    //dd('hello route filterDesc');
    $recipes = Recipe::orderBy('cooking_time', 'DESC')->get();
    //dd($recipes);
    return view('recipes', compact('recipes'));
})->name('filterDesc.cookingTime');

Route::get('/recipe/{id}/', [RecipeController::class, 'show']);
Route::get('/recipe/create', [RecipeController::class, 'create']);
Route::post('/recipe/filter', [RecipeController::class, 'showMultiple']);

//Route::get('/recipe/filterNameDesc', [RecipeController::class, 'filterNameDesc']);


Route::post('recipe/{id}/comment/store', [CommentController::class, 'store']);




