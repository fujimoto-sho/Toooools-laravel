@section('head')
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title') | Toooools</title>
  <link rel="stylesheet" href="/css/app.css">
@endsection