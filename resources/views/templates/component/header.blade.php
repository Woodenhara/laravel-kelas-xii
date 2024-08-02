<div class="header">
  <div class="container">
    <div class="w3layouts_logo">
      <a href="{{ route('home') }}"><h1>One<span>Movies</span></h1></a>
    </div>
    <div class="w3_search">
      <form action="#" method="post">
        <input type="text" name="Search" placeholder="Search" required="">
        <input type="submit" value="Go">
      </form>
    </div>
    <div class="w3l_sign_in_register">
      <ul>
        <li>
            @if (Auth::check())
                <a href="{{ route('logout') }}">Logout</a>
            @else
                <a href="#" data-toggle="modal" data-target="#myModal">Login</a>
            @endif
        </li>
      </ul>
    </div>
    <div class="clearfix"> </div>
  </div>
</div>
