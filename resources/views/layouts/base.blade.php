<!DOCTYPE html>
<html lang="ja">
<head>
  @yield('head')
</head>
<body>
  @yield('header')

  <main class="main site-width @yield('column')">
    @yield('content')
  </main>

  @yield('footer')
</body>
</html>