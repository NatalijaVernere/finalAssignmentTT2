<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <style>
        .drop {
            display: none;
        }
    </style>
</head>
<body>

@include('includes.nav_bar')

<hr> <!-- delete later ?! -->


<p> <input type="button" value="back" onclick="goBack()"> </p>
@if (count($users) == 0)
    <p color='red'> There are no records in the database!</p>
@else
    <form method='POST' action="{{ action([App\Http\Controllers\UserController::class, 'showMultiple']) }}">
        @csrf @method('POST')
        <label for="name">Search by username or email:</label>
        <input type="text" name="name" id="name">

        <input type="submit" value="search" onclick="showFilter()">
    </form>

    <p><input type="button" value="Reset search" onclick="AllUsers()"></p>

    <table style="border: 1px solid black">
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
                            <input class="delete-btn" type="submit" value="delete">
                        </form>
                    </td>
                    <td>
                        <form method="GET" action="{{action([App\Http\Controllers\UserController::class, 'edit'], $user->id)}}">
                            <input type="submit" value="update" onclick="editUser({{$user->id}})">@csrf @method('GET')
                        </form>
                    </td>
                @endif
            </tr>
        @endforeach
    </table>
@endif
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
