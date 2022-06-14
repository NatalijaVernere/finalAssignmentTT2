<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <style>

    </style>
</head>
<body>

<h1>Login</h1>

<form method="POST"
      action="{{action([App\Http\Controllers\UserController::class, 'show']) }}">
    @csrf

    <label for="username">Username: </label>
    <input type="text" name="username" id="username">

    <label for="password">Password: </label>
    <input type="text" name="password" id="password">


    <input type="submit" value="add" onclick="storeComment({{$recipe->id}})">
</form>

</body>
</html>
