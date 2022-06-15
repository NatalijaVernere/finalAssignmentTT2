<!DOCTYPE html>
<html>
<head>
    <title>Countries</title>
<style>
    .drop {
       display: none;
    }
</style>
</head>
<body>

@include('includes.nav_bar')

<hr> <!-- delete later ?! -->



@if (count($recipes) == 0)
    <p color='red'> There are no records in the database!</p>
@else
    <form method='POST' action="{{ action([App\Http\Controllers\RecipeController::class, 'showMultiple']) }}">
        @csrf @method('POST')
        <label for="name">Search name:</label>
        <input type="text" name="name" id="name">

        <input type="submit" value="search" onclick="showFilter()">
    </form>
    <p><input type="button" value="Reset search" onclick="AllRecipes()"></p>

    <div class="dropdown">
        <button onclick="myFunction()" class="dropbtn">Choose the filter</button>
        <div id="myDropdown" class="dropdown-content">
            <p><input type="button" class="drop" value="Filter by name (from Z to A)" onclick="filterNameDesc()"></p>
            <p><input type="button" class="drop" value="Filter by name (from A to Z)" onclick="filterNameAsc()"></p>
            <p><input type="button" class="drop" value="Filter by cooking time (asc)" onclick="filterCookingTimeAsc()"></p>
            <p><input type="button" class="drop" value="Filter by cooking time (desc)" onclick="filterCookingTimeDesc()"></p>
            <p><input type="button" class="drop" value="Reset filter" onclick="AllRecipes()"></p>

        </div>
    </div>

    <table style="border: 1px solid black">
        <tr>
            <th> recipe id </th>
            <th> name </th>
            <th> short_description </th>
            <th> cooking_time </th>
            <th> more_info </th>
            <th> delete </th>
            <th> edit </th>
        </tr>
        @foreach ($recipes as $recipe)
            <tr>
                <td> {{ $recipe->id }} </td>
                <td> {{ $recipe->name }} </td>
                <td> {{ $recipe->short_description }} </td>
                <td> {{ $recipe->cooking_time }} </td>
                <td>
                    <input type="button" value="show" onclick="showRecipeInfo({{ $recipe->id }})">
                <td>
                @if(Auth::user()->id == $recipe->user_id || Auth::user()->role == 'admin')
                <td>
                    <form method="POST" action="{{action([App\Http\Controllers\RecipeController::class, 'destroy'], $recipe->id)}}">@csrf @method('DELETE')
                        <input class="delete-btn" type="submit" value="delete">
                    </form>
                </td>
                <td>
                    <form method="GET" action="{{action([App\Http\Controllers\RecipeController::class, 'edit'], $recipe->id)}}">
                        <input type="submit" value="update" onclick="editRecipe({{$recipe->id}})">@csrf @method('GET')
                    </form>
                </td>
                @endif
            </tr>
        @endforeach
    </table>
@endif
<p> <input type="button" value="New Recipe" onclick="newRecipe()"> </p>


<script>
    function editRecipe(recipeID){
        window.location.href = "recipe/edit/"+recipeID;
    }

    function AllRecipes(){
        window.location.href = "../recipe";
    }

    function showRecipeInfo(recipeID){
        window.location.href = "../recipe/" + recipeID;
    }

    function newRecipe(){
        window.location.href = "../recipe/create";
    }

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

    function myFunction() {
        const drops = document.querySelectorAll('.drop');

        drops.forEach(drop => {
            drop.style.display = 'inline';
        });
    }
</script>
</body>
</html>
