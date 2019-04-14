@extends('layouts.base')

@section('title', 'プロフィール編集')
@section('column', 'one-column')

@include('layouts.head')
@include('layouts.header')

@section('content')
  <!-- フォーム -->
  <div class="form-container">
    <form class="form" method="post" action="/profile/edit" enctype="multipart/form-data">
      @csrf
      <h1 class="form-title">プロフィール編集</h1>

      @if ($errors->has('email'))
        <div class="input-msg">
          {{ $errors->first('email') }}
        </div>
      @endif
      <label class="form-label {{ $errors->has('email') ? ' err' : '' }}">
        Email
        <input type="text" name="email" value="{{ old('email') ?? $form['email'] }}" required autofocus>
      </label>

      @if ($errors->has('name'))
        <div class="input-msg">
          {{ $errors->first('name') }}
        </div>
      @endif
      <label class="form-label {{ $errors->has('name') ? ' err' : '' }}">
        ユーザー名
        <input type="text" name="name" value="{{ old('name') ?? $form['name'] }}" required>
      </label>

      @if ($errors->has('bio'))
        <div class="input-msg">
          {{ $errors->first('bio') }}
        </div>
      @endif
      <label class="form-label {{ $errors->has('bio') ? ' err' : '' }}">
        自己紹介
        <textarea name="bio" cols="30" rows="5">{{ old('bio') ?? $form['bio'] }}</textarea>
      </label>

      @if ($errors->has('like_tool'))
        <div class="input-msg">
          {{ $errors->first('like_tool') }}
        </div>
      @endif
      <label class="form-label {{ $errors->has('like_tool') ? ' err' : '' }}">
        一番好きなツール
        <input type="text" name="like_tool" value="{{ old('like_tool') ?? $form['like_tool'] }}">
      </label>

      <!-- アバター -->
      @if ($errors->has('img'))
        <div class="input-msg">
          {{ $errors->first('img') }}
        </div>
      @endif
      アバター
      <div class="form-input-container">
        <label class="form-label form-label-file">
          <input type="file" name="img" id="js-img-input" hidden>
          <img src="{{ $form['img'] }}" id="js-img-show" class="form-input-file-img">
        </label>
      </div>

      <input type="submit" class="form-btn" value="変更">
    </form>
  </div>
@endsection

@include('layouts.footer')