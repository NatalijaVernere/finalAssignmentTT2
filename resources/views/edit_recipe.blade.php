<!DOCTYPE html>
<html>
<head>
    <title>Edit recipe</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="app">
    <div class="left-col">
        @include('includes.nav_bar')
    </div>

    <div class="right-col">
        <div class="go-back-bar">
            <p> <input class="btn go-back-btn" type="button" value="<< back" onclick="goBack()"> </p>
        </div>

        <h1>Update recipe:</h1>
        <form class="recipe-form" method="POST" action="{{
        action([App\Http\Controllers\RecipeController::class, 'update'], $recipe->id) }}">
            @csrf
            <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">

            <label for="name">Recipe Name: </label><br>
            <input type="text" name="name" id="name" value="{{ $recipe->name }}"><br>
            <p class="err-msg">@error('name') {{$message}} @enderror</p>

            <label for="short_description">Short recipe description: </label><br>
            <input type="text" name="short_description" id="short_description" value="{{ $recipe->short_description }}"><br>
            <p class="err-msg">@error('short_description') {{$message}} @enderror</p>

            <label for="description">Extended recipe description: </label><br>

            <textarea name="description" id="description" cols="30" rows="10">{{ $recipe->description }}</textarea>
            <p class="err-msg">@error('description') {{$message}} @enderror</p>

            <label for="cooking_time">Cooking time (minutes): </label><br>
            <input type="text" name="cooking_time" id="cooking_time" value="{{ $recipe->cooking_time }}"><br>
            <p class="err-msg">@error('cooking_time') {{$message}} @enderror</p><br>


            <input type="hidden" name="products" id="products">
            <!-- ----------------------------------- -->
            <p>Choose products for recipe: </p>
            @if(count($products) == 0)
                <p color='red'> There are no products in the database!</p>
            @else
                <div class="product-list">
                    <div id="product_list" class="product-list-content">
                        <input class='drop' type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
                        @foreach($products_checked as $product)
                            <div class="check">
                                <input type="checkbox" id="product" name="product" value="{{ $product->id }}" checked>
                                <label for="product"> {{ $product->name }}</label><br>
                            </div>
                        @endforeach
                        @foreach($products_not_checked as $product)
                            <div class="check">
                                <input type="checkbox" id="product" name="product" value="{{ $product->id }}">
                                <label for="product"> {{ $product->name }}</label><br>
                            </div>
                        @endforeach

                    </div>
                </div>
                <p class="err-msg">@error('products') {{$message}} @enderror</p>
                <br>
            @endif
            <input class="add-new-btn" type="submit" value="add" onclick="addProductIds({{ $recipe->id }})">
        </form>
    </div>
</div>
<script>
    function goBack(){
        window.location.href = "/";
    }

    function updateRecipe(RecipeID) {
        window.location.href="/recipe/update/"+RecipeID;
    }

    function filterFunction() {
        var input, filter, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("product_list");
        a = document.getElementsByClassName("check");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }

    function addProductIds(recipeID){
        let el = document.getElementById("products");

        let productIds = document.querySelectorAll('input[name=product]:checked');
        const ids = [];

        for(let i = 0; i < productIds.length; i++){
            ids[i] = productIds[i].value;
        }
        let elString = '';
        for(let i = 0; i < ids.length; i++){
            elString += ids[i].toString();
            if (i !== ids.length-1) elString += ',';
        }
        el.value = elString;

        window.location.href="/recipe/update/"+RecipeID;
    }
</script>
</body>
</html>


