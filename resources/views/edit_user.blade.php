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
        We will update a user with id <b>{{$user->id}}</b>:
        <form class="recipe-form" method="POST" action="{{
        action([App\Http\Controllers\UserController::class, 'update'], $user->id) }}">
            @csrf

            <label for="username">Username: </label><br>
            <input type="text" name="username" id="username" value="{{ $user->username }}"><br>
            <p class="err-msg">@error('username') {{$message}} @enderror</p>

            <label for="email">Email: </label><br>
            <input type="text" name="email" id="email" value="{{ $user->email }}"><br>
            <p class="err-msg">@error('email') {{$message}} @enderror</p>

            <input type="radio" name="role" id="role_user" value="user"@if($user->role=='user') checked @endif>
            <label for="role_user">User</label><br>

            <input type="radio" name="role" id="role_admin" value="admin" @if($user->role=='admin') checked @endif>
            <label for="role_admin">Admin</label><br>


            <p class="err-msg">@error('role') {{$message}} @enderror</p>


            <input class="add-new-btn" type="submit" value="add" onclick="updateUser({{ $user->id }})">
        </form>
    </div>
</div>

<script>
    function updateUser(userID){
        window.location.href = "user/update/" +userID;
    }

    function goBack(){
        window.location.href = "/users"
    }
</script>
</body>
</html>
