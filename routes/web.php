<?php

use App\Models\Product;
use App\Models\Recipe;
use App\Models\Comment;
use App\Models\User;
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
use App\Http\Controllers\UserController;


Auth::routes();
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');


Route::redirect('/', 'login');
Route::resource('recipe', RecipeController::class, ['except'=> ['update']]);

Route::resource('comment', CommentController::class, ['except'=> ['store']]);

Route::resource('users', UserController::class, ['except'=> ['update', 'edit']]);

Route::get('/recipes/filterDescName', [RecipeController::class, 'filter'])
    ->defaults('filterColumn', 'name')
    ->defaults('filterType', 'DESC');

Route::get('/recipes/filterAscName', [RecipeController::class, 'filter'])
    ->defaults('filterColumn', 'name')
    ->defaults('filterType', 'ASC');

Route::get('/recipes/filterAscCookingTime', [RecipeController::class, 'filter'])
    ->defaults('filterColumn', 'cooking_time')
    ->defaults('filterType', 'DESC');

Route::get('/recipes/filterDescCookingTime', [RecipeController::class, 'filter'])
    ->defaults('filterColumn', 'cooking_time')
    ->defaults('filterType', 'ASC');


Route::get('/recipe/{id}/', [RecipeController::class, 'show']);
Route::get('/recipe/create', [RecipeController::class, 'create']);
Route::post('/recipe/filter', [RecipeController::class, 'showMultiple']);

Route::get('recipe/edit/{id}', [RecipeController::class, 'edit']);
Route::post('recipe/update/{id}', [RecipeController::class, 'update']);

Route::post('recipe/{id}/comment/store', [CommentController::class, 'store']);

//Route::post('user', [UserController::class, 'show']);
Route::get('users/edit/{id}', [UserController::class, 'edit']);
Route::post('users/update/{id}', [UserController::class, 'update']);
Route::post('/users/filter', [UserController::class, 'showMultiple']);




