<div class="nav-bar">
    <p>You are logged in as</p>
    @if(Auth::user()->role == 'admin')
        <b>(admin)</b><br>
    @endif
    <b>{{ Auth::user()->email }}</b><br>
    <a href="#">Recipes</a><br>
    <!-- <a href="#">My recipes</a> -->
    <a href="#">Add new recipes</a>
    <a href="{{ url('/logout') }}"> logout </a>
</div>
