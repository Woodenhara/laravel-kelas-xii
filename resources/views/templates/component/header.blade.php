<div class="header">
    <div class="container">
        <div class="w3layouts_logo">
            <a href="{{ route('home') }}">
                <h1>One<span>Movies</span></h1>
            </a>
        </div>
        <div class="w3_search">
            <form action="#" method="post">
                <input type="text" name="Search" placeholder="Search" required="">
                <input type="submit" value="Go">
            </form>
        </div>
        <div class="w3l_sign_in_register">
            <ul>
                @guest
                    <li><a href="#" data-toggle="modal" data-target="#myModal">Login</a></li>
                @else
                    <li>
                        <a id="logout-link" href="#" onclick="confirmLogout(event);" style="background-color: red;">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('login.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
        <div class="clearfix"> </div>
    </div>
</div>

<script>
    function confirmLogout(event) {
        event.preventDefault();
        if (confirm('Yakin mau logout?')) {
            document.getElementById('logout-form').submit();
        }
    }
</script>
