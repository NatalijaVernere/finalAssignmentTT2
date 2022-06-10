<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .drop {
            display: block;
        }
    </style>
</head>
<body>
    <h1>Add new recipe</h1>

    <form method="POST" action="{{action([App\Http\Controllers\RecipeController::class, 'store']) }}">
        @csrf
        <label for="name">Recipe Name: </label><br>
        <input type="text" name="name" id="name"><br>

        <label for="short_description">Short recipe description: </label><br>
        <input type="text" name="short_description" id="short_description"><br>

        <label for="description">Extended recipe description: </label><br>
        <input type="text" name="description" id="description"><br>

        <label for="cooking_time">Cooking time (minutes): </label><br>
        <input type="text" name="cooking_time" id="cooking_time"><br><br>

        <!-- ----------------------------------- -->
        <p>Choose products for recipe: </p>
        @if(count($products) == 0)
            <p color='red'> There are no products in the database!</p>
        @else
                <div class="dropdown">
                    <div id="myDropdown" class="dropdown-content">
                        <input class='drop' type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
                        @foreach($products as $product)
                            <div class="check">
                                <input type="checkbox" id="product" name="product" value="{{ $product->id }}">
                                <label for="product"> {{ $product->name }}</label><br>
                            </div>
                        @endforeach
                    </div>
                </div>
            <br>
        @endif

        <input type="submit" value="add">
    </form>

</body>
<script>
    function filterFunction() {
        var input, filter, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("myDropdown");
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

    function checkBoxes() {
        return document.querySelectorAll('input[name=product]:checked');
    }

</script>
</html>
