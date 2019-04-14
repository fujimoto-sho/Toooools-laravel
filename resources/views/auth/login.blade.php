@extends('layouts.base')

@section('title', 'ログイン')
@section('column', 'one-column')

@include('layouts.head')
@include('layouts.header')

@section('content')
  <!-- フォーム -->
  <div class="form-container">
    <form class="form" method="post" action="{{ route('login') }}">
      @csrf

      <h1 class="form-title">ログイン</h1>

      @if ($errors->has('email'))
        <div class="input-msg">
          {{ $errors->first('email') }}
        </div>
      @endif
      <label class="form-label">
        Email
        <input type="text" name="email" value="{{ old('email') }}" required autofocus>
      </label>

      <label class="form-label">
        パスワード
        <input type="password" name="password" placeholder="英数字6文字以上" value="{{ old('password') }}" required>
      </label>

      <label class="form-label-checkbox">
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
        <span>ログイン情報を保持する</span>
      </label>

      <input type="submit" class="form-btn" value="ログイン">

      <div class="form-link-list">
        <a href="{{ route('register') }}">新規登録</a> | <a href="{{ route('password.request') }}">パスワードを忘れてしまった方はこちら</a>
      </div>
    </form>
  </div>
@endsection

@include('layouts.footer')