@extends('layouts.base')

@section('title', 'ユーザー登録')
@section('column', 'one-column')

@include('layouts.head')
@include('layouts.header')

@section('content')
  <!-- フォーム -->
  <div class="form-container">
    <form class="form" method="post" action="{{ route('register') }}">
      @csrf

      <h1 class="form-title">ユーザ登録</h1>

      @if ($errors->has('email'))
        <div class="input-msg">
          {{ $errors->first('email') }}
        </div>
      @endif
      <label class="form-label {{ $errors->has('email') ? ' err' : '' }}">
        Email
        <input type="text" name="email" value="{{ old('email') }}" required autofocus>
      </label>

      @if ($errors->has('name'))
        <div class="input-msg">
          {{ $errors->first('name') }}
        </div>
      @endif
        <label class="form-label {{ $errors->has('name') ? ' err' : '' }}">
        ユーザー名
        <input type="text" name="name" value="{{ old('name') }}" required>
      </label>

      @if ($errors->has('password'))
        <div class="input-msg">
          {{ $errors->first('password') }}
        </div>
      @endif
      <label class="form-label {{ $errors->has('password') ? ' err' : '' }}">
        パスワード
        <input type="password" name="password" placeholder="英数字8文字以上" value="{{ old('password') }}" required>
      </label>

      <label class="form-label">
        パスワード（再入力）
        <input type="password" name="password_confirmation" placeholder="英数字8文字以上" value="{{ old('password_confirmation') }}" required>
      </label>

      <input type="submit" class="form-btn" value="登録">
    </form>
  </div>
@endsection

@include('layouts.footer')