<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Recipe;
use App\Models\RecipeProduct;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            if(Auth::user()->role!='admin'){
                abort('403');
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @return void
     * Returns users than match search
     */
    public function showMultiple(request $request){
        if($request->name){
            $users = User::where('username', 'like', '%'.$request->name.'%')->
            orWhere('email', 'like', '%'.$request->name.'%')->get();

            return view('users', compact('users'));
        }
        else{
            return redirect('/users');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('edit_user', compact('user'));
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
        $data = request()->validate([
            'username' => 'required|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:user,admin',
        ]);

        if(Auth::user()->role != 'admin' || Auth::user()->id == $id){
            abort('403');
        }

        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->email = $request->email;
        if(Auth::user()->role == 'admin' && Auth::user()->id != $id){
            $user->role = $request->role;
        }

        $user->save();

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->role != 'admin' || Auth::user()->id == $id){
            abort('403');
        }
        $user = User::findOrFail($id);
        Comment::where('user_id', $id)->delete();
        $recipes = Recipe::where('user_id', $id)->get();
        foreach ($recipes as $recipe){
            Comment::where('recipe_id', $recipe->id)->delete();
            RecipeProduct::where('recipe_id', $recipe->id)->delete();
            //$recipe->delete();
        }

        foreach ($recipes as $recipe){
            $recipe->delete();
        }

        $user->delete();

        return redirect('users');
    }
}
