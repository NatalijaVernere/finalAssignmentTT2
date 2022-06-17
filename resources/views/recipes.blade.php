<!DOCTYPE html>
<html>
<head>
    <title>Recipes</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body>
<div class="app">
    <div class="left-col">
        @include('includes.nav_bar')
    </div>

    <div class="right-col">
        @if (count($recipes) == 0)
            <p color='red'> There are no records in the database!</p>
        @else
            <form class="search-form" method='POST' action="{{ action([App\Http\Controllers\RecipeController::class, 'showMultiple']) }}">
                @csrf @method('POST')
                <!--<label for="name">Search name:</label>-->
                <input class="search-box-input-field" id="search_box_input_field_1" type="text" name="name" id="name" placeholder="">

                <input class="search-submit-btn" type="submit" value="search" onclick="showFilter()">
            </form>
            <!--<p><input class="search-reset-btn" type="button" value="Reset search" onclick="allRecipes()"></p>-->

            <div class="recipe-btn-box">
                <div class="dropdown-recipe-filter">
                    <button class="dropbtn">Choose the filter</button>
                    <div class="dropdown-content">
                        <div id="myDropdown" class="dropdown-content">
                            <div class="drop"><hr><p><input type="button" value="Filter by name (from Z to A)" onclick="filterNameDesc()"></p><hr></div>
                            <div class="drop"><p><input type="button" value="Filter by name (from A to Z)" onclick="filterNameAsc()"></p><hr></div>
                            <div class="drop"><p><input type="button" value="Filter by cooking time (asc)" onclick="filterCookingTimeAsc()"></p><hr></div>
                            <div class="drop"><p><input type="button" value="Filter by cooking time (desc)" onclick="filterCookingTimeDesc()"></p><hr></div>
                            <div class="drop"><p><input type="button" value="Reset filter" onclick="allRecipes()"></p><hr></div>
                        </div>
                    </div>
                </div>

                <input class="btn show-btn my-recipes-btn" type="button" onclick="myRecipes()" value="My recipes">

                <input class="btn edit-btn all-recipes-btn" type="button" onclick="allRecipes()" value="All recipes">
            </div>

            <table class="info-table">
                <tr>
                    <th> name </th>
                    <th> description </th>
                    <th> time </th>
                    <th> more </th>
                    <th> delete </th>
                    <th> edit </th>
                </tr>
                @foreach ($recipes as $recipe)
                    <tr>
                        <td> {{ $recipe->name }} </td>
                        <td> {{ $recipe->short_description }} </td>
                        <td> {{ $recipe->cooking_time }} <small>min</small> </td>
                        <td>
                            <input class="btn show-btn" type="button" value="show" onclick="showRecipeInfo({{ $recipe->id }})">
                        </td>
                        @if(Auth::user()->id == $recipe->user_id || Auth::user()->role == 'admin')
                            <td>
                                <form method="POST" action="{{action([App\Http\Controllers\RecipeController::class, 'destroy'], $recipe->id)}}">@csrf @method('DELETE')
                                    <input class="btn delete-btn" type="submit" value="delete">
                                </form>
                            </td>
                            <td>
                                <form method="GET" action="{{action([App\Http\Controllers\RecipeController::class, 'edit'], $recipe->id)}}">
                                    <input class="btn edit-btn" type="submit" value="update" onclick="editRecipe({{$recipe->id}})">@csrf @method('GET')
                                </form>
                            </td>
                        @else
                            <td>
                                <form method="POST" action="#" onclick="return cantDeleteAlert()">@csrf @method('DELETE')
                                    <input class="btn inactive-btn" type="submit" value="delete">
                                </form>
                            </td>
                            <td>
                                <form method="GET" action="#" onclick="return cantUpdateAlert()">
                                    <input class="btn inactive-btn" type="submit" value="update">@csrf @method('GET')
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </table>
        @endif
        <p> <input class="add-new-btn" type="button" value="New Recipe" onclick="newRecipe()"> </p> <br>
    </div>
</div>


<script>
    function editRecipe(recipeID){
        window.location.href = "recipe/edit/"+recipeID;
    }

    function allRecipes(){
        window.location.href = "../recipe";
    }

    function showRecipeInfo(recipeID){
        window.location.href = "../recipe/" + recipeID;
    }

    /*function newRecipe(){
        window.location.href = "../recipe/create";
    }*/

    function showFilter(){
        window.location.href = "../recipe/filter";
    }

    function filterNameDesc() {
        window.location.href = "../recipes/filterDescName";
    }

    function filterNameAsc() {
        window.location.href = "../recipes/filterAscName";
    }

    function filterCookingTimeAsc() {
        window.location.href = "../recipes/filterAscCookingTime";
    }

    function filterCookingTimeDesc() {
        window.location.href = "../recipes/filterDescCookingTime";
    }

    function cantDeleteAlert(){
        alert("Error. You cannot delete this record because you are not authorized to do so!");
        return false;
    }

    function cantUpdateAlert(){
        alert("Error. You cannot update this record because you are not authorized to do so!");
        return false;
    }

    function myRecipes(){
        window.location.href = "../myrecipes";
    }



    document.addEventListener('DOMContentLoaded', function() {
        let i = 0;
        //let txt = 'Pizza with chicken';
        const recipeNames = ['pizza with chicken...', 'breakfast...', 'chicken wings...', 'afternoon snack..'];
        let speed = 70;

        let z = 0;
        typeWriter(recipeNames[z]);

        function typeWriter(txt) {
            if(i === 0){
                document.getElementById("search_box_input_field_1").placeholder = "";
            }
            if (i < txt.length && document.getElementById("search_box_input_field_1").value === "") {
                document.getElementById("search_box_input_field_1").placeholder += txt.charAt(i);
                i++;
                setTimeout(typeWriter, speed, recipeNames[z]);
            }
            else if(i === txt.length && z+1 < recipeNames.length){

                z++;
                i = 0;

                //document.getElementById("search_box_input_field_1").placeholder = "";


                setTimeout(typeWriter, 3000, recipeNames[z]);
                //typeWriter(recipeNames[z]);
                //alert('shit');
            }
        }
    }, false);

    function seeUsers() {
        window.location.href = "../users";
    }
</script>
</body>
</html>
