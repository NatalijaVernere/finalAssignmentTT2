<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<div class="nav-bar">
    <div class="info">
        <p class="logged-in">You are logged in as</p>
        @if(Auth::user()->role == 'admin')
            <b>(admin)</b><br>
        @endif
        <b>{{ Auth::user()->username }}</b><br>
    </div>

    <div class="page-links">
        <a href="/recipe">Recipes</a>
        {{--<input class="btn show-btn my-recipes-btn" type="button" onclick="myRecipes()" value="My recipes">--}}
        <a href="../myrecipes">My Recipes</a>
        <a href="#" onclick="newRecipe()">New Recipe</a>

        @if(Auth::user()->role == 'admin') <!--Ability to see users is only available for admin-->
            <p> <input type="button" value="See users" class="see-users-btn" onclick="seeUsers()"> </p>
        @endif
    </div>

    <div class="logout-box">
        <a href="{{ url('/logout') }}" class="logout-btn"> log out </a>
    </div>
</div>

<script>
    function seeUsers() {
        window.location.href = "../users";
    }

    function newRecipe() {
        window.location.href = "../recipe/create";
    }
</script>

</body>
</html>
