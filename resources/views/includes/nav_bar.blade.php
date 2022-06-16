<div class="nav-bar">
    <div class="info">
        <p class="logged-in">You are logged in as</p>
        @if(Auth::user()->role == 'admin')
            <b>(admin)</b><br>
        @endif
        <b>{{ Auth::user()->username }}</b><br>
    </div>

    <div class="page-links">
        <a href="#">Recipes</a><br>
        <!--<a href="#">My recipes</a>-->
        <a href="#">Add new recipes</a>
    </div>

    <div class="logout-box">
        <a href="{{ url('/logout') }}" class="logout-btn"> log out </a>
    </div>

</div>
