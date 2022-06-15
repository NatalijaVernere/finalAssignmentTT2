<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}">
</head>
<body>

    @include('includes.nav_bar')

    <hr>

    <p> <input type="button" value="back" onclick="goBack()"> </p>
    <!--Recipe info:-->
    <h1>{{ $recipe->name }}</h1>
    <h2>{{ $recipe->short_description }}</h2>
    <h3>Cooking time: {{ $recipe->cooking_time }} minutes</h3>
    <h4>Description:</h4>
    <p>{{ $recipe->description }}</p>
    <p>Added by: <span>{{ $recipe->username }}</span></p>

    <hr>

    <!--Products:-->
    <h2>Products:</h2>
    @if(count($products) == 0)
        <h3>No Products added!</h3>
    @else
        @foreach($products as $product)
            <div>
                <h4>name: {{ $product->name }}</h4>
                <h5>type: {{ $product->type }}</h5>
                @if($product->isAllergic)
                    <h6 style="color:red;">allergic</h6>
                @else
                    <h6>not allergic</h6>
                @endif
                <hr>
            </div>
        @endforeach
    @endif


    <hr>
    <!--Comments:-->

    <form method="POST" action="{{action([App\Http\Controllers\CommentController::class, 'store'], $recipe->id) }}">
        @csrf

        <label for="rating">Rating: </label>
        <input type="text" name="rating" id="rating">
        <p class="err-msg">@error('rating') {{$message}} @enderror</p>

        <label for="comment_content">Add comment: </label>
        <input type="text" name="comment_content" id="comment_content">
        <p class="err-msg">@error('comment_content') {{$message}} @enderror</p>

        <input type="submit" value="add" onclick="storeComment({{$recipe->id}})">
    </form>



    @if(count($comments) == 0)
        <h3>No comments found</h3>
    @else
        <h3>Comments:</h3>
        @foreach($comments as $comment)
            <div style="border:1px solid black; padding: 1em; border-radius: 1em">
                <h4>Rating: {{ $comment->rating }}</h4>
                <p>{{ $comment->content }}</p>
                <p>{{ $comment->username }}</p>
                @if(Auth::user()->id == $comment->user_id || Auth::user()->role == 'admin')
                    <form method="POST" action="{{action([App\Http\Controllers\CommentController::class, 'destroy'], $comment->id)}}">
                        @csrf @method('DELETE')
                        <input class="delete-btn" type="submit" value="delete">
                    </form>
                @endif
            </div>
        @endforeach
    @endif




    <script>
        function goBack(){
            window.location.href = "/";
        }

        function storeComment(recipeID){
            window.location.href = "recipe/" + recipeID + "/comment/store";
        }
    </script>
</body>
</html>
