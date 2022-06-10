<?php

namespace App\Models;

use App\Http\Controllers\RecipeController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RecipeProduct;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'isAllergic'];

    public function recipes(){
        return $this->belongsToMany(Recipe::class);
    }
}
