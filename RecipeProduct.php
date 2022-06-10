<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;//
use App\Models\Product;
use App\Models\Recipe;


//class RecipeProduct extends Model
class RecipeProduct extends Pivot
{
    use HasFactory;

    protected $table = 'product_recipe';

    public function product()
    { // FKrelationship
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function recipe()
    { // FKrelationship
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}
