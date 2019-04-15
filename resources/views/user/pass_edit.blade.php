@extends('layouts.base')

@section('title', 'パスワード変更')
@section('column', 'one-column')

@include('layouts.head')
@include('layouts.header')

@section('content')
  <div class="form-container">
    <form class="form" method="post" action="/user/pass_edit">
      @csrf
      <h1 class="form-title">パスワード変更</h1>

      @if ($errors->has('old_password'))
        <div class="input-msg">
          {{ $errors->first('old_password') }}
        </div>
      @endif
      <label class="form-label {{ $errors->has('old_password') ? ' err' : '' }}">
        現在のパスワード
        <input type="password" name="old_password" value="{{ old('old_password') }}" required>
      </label>

      @if ($errors->has('password'))
        <div class="input-msg">
          {{ $errors->first('password') }}
        </div>
      @endif
      <label class="form-label {{ $errors->has('password') ? ' err' : '' }}">
        新しいパスワード
        <input type="password" name="password" placeholder="英数字8文字以上" value="{{ old('password') }}" required>
      </label>

      <label class="form-label">
        新しいパスワード（再入力）
        <input type="password" name="password_confirmation" placeholder="英数字8文字以上" value="{{ old('password_confirmation') }}" required>
      </label>

      <input type="submit" class="form-btn" value="送信">
    </form>
  </div>
@endsection

@include('layouts.footer')