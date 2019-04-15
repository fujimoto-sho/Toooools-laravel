@extends('layouts.base')

@section('title', '投稿詳細')
@section('column', 'one-column')

@include('layouts.head')
@include('layouts.header')

@section('content')
  <div class="post-detail">

    @include('components.post', ['post' => $post, 'show' => true])

    @if (Auth::check())
      <div class="post-detail-reply">
        <form action="{{ '/post/show?id=' . request()->id }}" method="post">
          @csrf

          @if ($errors->has('message'))
            <div class="input-msg">
              {{ $errors->first('message') }}
            </div>
          @endif
          <input type="text" name="message" value="{{ old('message') }}">

          <input type="submit" value="送信">
        </form>
      </div>
    @endif

    @isset($replies)
      @foreach ($replies as $reply)
        <div class="post-list">
          <div class="post-detail-reply-icon">
            <i class="fas fa-reply"></i>
            reply
          </div>
          <img src="{{ empty($reply->img_filename) ? '/img/avatar/default.png' : $reply->img_filename }}" alt="" class="post-user-img">
          <p class="post-user-name">
            {{ $reply->user_name }}
          </p>
          <time class="post-time" datetime="{{ $reply->created_at }}">
            {{ $reply->created_at }}
          </time>
          <p class="post-reply-text">
            {{ $reply->message }}
          </p>
        </div>
      @endforeach
    @endisset

  </div>
@endsection

@include('layouts.footer')