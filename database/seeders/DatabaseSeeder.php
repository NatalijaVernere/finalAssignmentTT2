<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Comment;
use App\Models\RecipeProduct;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //users:
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $user = User::create([
            'username' => 'NatalyVerner',
            'email' => 'natashavernere@gmail.com',
            'password' => 'mamaamakriminal12369',
            'role' => 'admin',
        ]);

        $user = User::create([
            'username' => 'RolandsK',
            'email' => 'rolands.kungs@gmail.com',
            'password' => 'BMWloverx5@',
            'role' => 'admin',
        ]);

        $user = User::create([
            'username' => 'SabineVanaga',
            'email' => 'natalyverner@inbox.lv',
            'password' => 'yurtavpitere9',
            'role' => 'user',
        ]);

        //recipes:
        $user = User::where('username', 'NatalyVerner')->first();
        $user->recipes()->create([
           'name'=>'Makaroni ar kečupu',
            'short_description'=>'Iespēja iepriecināt bērnus.',
            'description'=>'Uzvāriet makaronus un pielieciet klāt kečupu. Volā!',
            'cooking_time'=>10
        ]);

        $user = User::where('username', 'RolandsK')->first();
        $user->recipes()->create([
            'name'=>'Vēršacis',
            'short_description'=>'Ideālas brokastis ģimenes lokā',
            'description'=>'Viegli! ērti! ātri! Uzmet uz pannas olas un gatavs',
            'cooking_time'=>9
        ]);

        $user = User::where('username', 'SabineVanaga')->first();
        $user->recipes()->create([
            'name'=>'Gurķu un kāpostu salāti',
            'short_description'=>'Palīdzēs uzturēt sevi formā',
            'description'=>'Sagrieziet gurķus un kāpostus nelielos kubīšos. Pievienojiet klāt grieķu jogurtu. Lai garšīgi salātiņi :)',
            'cooking_time'=>11,
        ]);

        //products:
        $product = Product::create([
            'name'=>'makaroni',
            'type'=>'graudu produkti',
            'isAllergic'=>false
        ]);

        $product = Product::create([
            'name'=>'kečups',
            'type'=>'mērces',
            'isAllergic'=>false
        ]);

        $product = Product::create([
            'name'=>'siers',
            'type'=>'piena produkti',
            'isAllergic'=>true
        ]);

        $product = Product::create([
            'name'=>'gurki',
            'type'=>'dārzeņi',
            'isAllergic'=>false
        ]);

        $product = Product::create([
            'name'=>'kāposti',
            'type'=>'dārzeņi',
            'isAllergic'=>false
        ]);

        $product = Product::create([
            'name'=>'vistas olas',
            'type'=>'olas',
            'isAllergic'=>false
        ]);

        $product = Product::create([
            'name'=>'skābais krējums',
            'type'=>'piena produkti',
            'isAllergic'=>true
        ]);

        //RecipeProduct
        $product = Product::where('name', 'makaroni')->first();
        $recipe = Recipe::where('name', 'Makaroni ar kečupu')->first();
        $recipe->products()->attach($product);
        /*$recipe_product = new RecipeProduct();
        $recipe_product->product()->associate($product);
        $recipe_product->recipe()->associate($recipe);
        $recipe_product->save();*/

        $product = Product::where('name', 'kečups')->first();
        $recipe = Recipe::where('name', 'Makaroni ar kečupu')->first();
        $recipe->products()->attach($product);
        /*$recipeproduct = new RecipeProduct();
        $recipeproduct->product()->associate($product);
        $recipeproduct->recipe()->associate($recipe);
        $recipeproduct->save();*/

        $product = Product::where('name', 'siers')->first();
        $recipe = Recipe::where('name', 'Makaroni ar kečupu')->first();
        $recipe->products()->attach($product);
        /*$recipeproduct = new RecipeProduct();
        $recipeproduct->product()->associate($product);
        $recipeproduct->recipe()->associate($recipe);
        $recipeproduct->save();*/

        $product = Product::where('name', 'vistas olas')->first();
        $recipe = Recipe::where('name', 'Vēršacis')->first();
        $recipe->products()->attach($product);
        /*$recipeproduct = new RecipeProduct();
        $recipeproduct->product()->associate($product);
        $recipeproduct->recipe()->associate($recipe);
        $recipeproduct->save();*/

        $product = Product::where('name', 'siers')->first();
        $recipe = Recipe::where('name', 'Vēršacis')->first();
        $recipe->products()->attach($product);
        /*$recipeproduct = new RecipeProduct();
        $recipeproduct->product()->associate($product);
        $recipeproduct->recipe()->associate($recipe);
        $recipeproduct->save();*/

        $product = Product::where('name', 'gurki')->first();
        $recipe = Recipe::where('name', 'Gurķu un kāpostu salāti')->first();
        $recipe->products()->attach($product);
        /*$recipeproduct = new RecipeProduct();
        $recipeproduct->product()->associate($product);
        $recipeproduct->recipe()->associate($recipe);
        $recipeproduct->save();*/

        $product = Product::where('name', 'kāposti')->first();
        $recipe = Recipe::where('name', 'Gurķu un kāpostu salāti')->first();
        $recipe->products()->attach($product);
        /*$recipeproduct = new RecipeProduct();
        $recipeproduct->product()->associate($product);
        $recipeproduct->recipe()->associate($recipe);
        $recipeproduct->save();*/

        $product = Product::where('name', 'skābais krējums')->first();
        $recipe = Recipe::where('name', 'Gurķu un kāpostu salāti')->first();
        $recipe->products()->attach($product);
        /*$recipeproduct = new RecipeProduct();
        $recipeproduct->product()->associate($product);
        $recipeproduct->recipe()->associate($recipe);
        $recipeproduct->save();*/


        //comments:
        $user = User::where('username', 'NatalyVerner')->first();
        $recipe = Recipe::where('name', 'Gurķu un kāpostu salāti')->first();
        $comment = new Comment();
        $comment->rating = 8;
        $comment->content = 'Garšīgi, bet šī gurķu diēta man jau riebjas :|';
        $comment->user()->associate($user);
        $comment->recipe()->associate($recipe);
        $comment->save();

        $user = User::where('username', 'RolandsK')->first();
        $recipe = Recipe::where('name', 'Vēršacis')->first();
        $comment = new Comment();
        $comment->rating = 7;
        $comment->content = 'Šoreiz nesagāja. Piedega:(';
        $comment->user()->associate($user);
        $comment->recipe()->associate($recipe);
        $comment->save();

        $user = User::where('username', 'SabineVanaga')->first();
        $recipe = Recipe::where('name', 'Makaroni ar kečupu')->first();
        $comment = new Comment();
        $comment->rating = 4;
        $comment->content = 'Aizmirsu pieliet ūdeni vārot (nebija rakstīts, ka vjg ūdeni). Piedega :(';
        $comment->user()->associate($user);
        $comment->recipe()->associate($recipe);
        $comment->save();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
