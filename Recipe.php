<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RecipeProduct;
use App\Models\User;
use App\Models\Comment;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['name, short_description', 'description', 'cooking_time'];

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
