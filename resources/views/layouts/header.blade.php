<!-- フラッシュメッセージの表示 -->
@if (session('flash_msg'))
<div class="flash-msg" hidden>
    {{ session('flash_msg') }}
</div>
@endif

<header class="header">
  <div class="header-content">
    <h1 class="logo"><a href="/">Toooools</a></h1>
    <span class="logo-sub">- お気に入りのツールを共有しよう！ -</span>
    <nav class="top-nav">
      <ul>
        @if(Auth::check())
          <li><a class="top-nav-link top-nav-login" href="/post/create">新規投稿</a></li>
          <li><a class="top-nav-link top-nav-login" href="/profile">プロフィール</a></li>
          <li><a class="top-nav-link top-nav-signup" href="{{ route('logout') }}" onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">ログアウト</a></li>
        @else
          <li><a class="top-nav-link top-nav-login" href="{{ route('login') }}">ログイン</a></li>
          <li><a class="top-nav-link top-nav-signup" href="{{ route('register') }}">ユーザー登録</a></li>
        @endif
      </ul>
    </nav>
  </div>

  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
</header>