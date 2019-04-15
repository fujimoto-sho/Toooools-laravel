@extends('layouts.base')

@section('title', '投稿一覧')
@section('column', 'two-column')

@include('layouts.head')
@include('layouts.header')

@section('content')
  <!-- サイドバー -->
  <div class="sidebar">
    <form method="get" class="search-form">
      <label>
        並び順
        <select name="order">
          <option value="create_desc" {{ ($order === 'create_desc') ? 'selected' : '' }}>新着順</option>
          <option value="create_asc" {{ ($order === 'create_asc') ? 'selected' : '' }}>古い順</option>
          <option value="like_desc" {{ ($order === 'like_desc') ? 'selected' : '' }}>いいねが多い順</option>
        </select>
      </label>
      <label>
        検索対象
        <select name="search_target" id="">
          <option value="tool_name" {{ ($search_target === 'tool_name') ? 'selected' : '' }}>ツール名</option>
          <option value="tool_introduction" {{ ($search_target === 'tool_introduction') ? 'selected' : '' }}>ツール紹介</option>
        </select>
      </label>
      <label>
        検索ワード
        <input type="text" name="search_word" value="{{ $search_word }}">
      </label>
      <input type="submit" value="検索">
    </form>
    <div class="sideber-line"></div>
    <p class="sidebar-page-count">
        {{ $minPostNum }} -
        {{ $maxPostNum }} 件（全
        {{ $postCount }} 件）
    </p>
  </div>

  <div class="post">

    @if(isset($posts))
      @foreach($posts as $post)
        @include('components.post', ['post' => $post])
      @endforeach
      {{ $posts->appends(array('order' => $order, 'search_target' => $search_target, 'search_word' => $search_word))->links('vendor.pagination.default') }}
    @else
      検索結果がありません。
    @endif

  </div>
@endsection

@include('layouts.footer')