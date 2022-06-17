<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <style>
        .drop {
            display: none;
        }
    </style>
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

        @if (count($users) == 0)
            <p color='red'> There are no records in the database!</p>
        @else
            <form class="search-form" method='POST' action="{{ action([App\Http\Controllers\UserController::class, 'showMultiple']) }}">
                @csrf @method('POST')
                <input class="search-box-input-field" type="text" name="name" id="name" placeholder="search">
                <input class="search-submit-btn" type="submit" value="search" onclick="showFilter()">
            </form>

            <!--<p><input type="button" value="Reset search" onclick="AllUsers()"></p>-->

            <table class="info-table">
                <tr>
                    <th> user id </th>
                    <th> username </th>
                    <th> email </th>
                    <th> delete </th>
                    <th> edit </th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td> {{ $user->id }} </td>
                        <td> {{ $user->username }} </td>
                        <td> {{ $user->email }} </td>
                        @if(Auth::user()->id != $user->id)
                            <td>
                                <form method="POST" action="{{action([App\Http\Controllers\UserController::class, 'destroy'], $user->id)}}">@csrf @method('DELETE')
                                    <input class="btn delete-btn" type="submit" value="delete">
                                </form>
                            </td>
                            <td>
                                <form method="GET" action="{{action([App\Http\Controllers\UserController::class, 'edit'], $user->id)}}">
                                    <input class="btn edit-btn" type="submit" value="update" onclick="editUser({{$user->id}})">@csrf @method('GET')
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
</div>
</body>
<script>
    function editUser(userID) {
        window.location.href = 'users/edit/' + userID;
    }

    function goBack(){
        window.location.href = "/recipe";
    }

    function AllUsers(){
        window.location.href = "../users";
    }

    function showFilter(){
        window.location.href = "../users/filter";
    }
</script>
</html>
