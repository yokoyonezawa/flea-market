<header>
    <div class="header__logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo">
        </a>
    </div>
    <div class="header-search">
        <form action="{{ request()->is('mylist') ? route('product.mylist') : route('index') }}" method="get">
            <input type="text" name="query" placeholder="なにをお探しですか？" class="search-box" value="{{ request('query') }}">
            <button type="submit" class="search-button">検索</button>
        </form>



    </div>
    <nav>
        <ul class="header-links">
            @guest
                <li><a href="{{ route('login') }}">ログイン</a></li>
            @endguest
            @auth
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                    <button type="submit" class="logout-button">ログアウト</button>
                </form>
            @endauth
            <li><a href="{{ route('mypage') }}">マイページ</a></li>
            <li><a href="{{ route('sell') }}">出品</a></li>

        </ul>
    </nav>

</header>