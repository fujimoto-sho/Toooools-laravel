@extends('layouts.base')

@section('title', 'パスワード再設定')
@section('column', 'one-column')

@include('layouts.head')
@include('layouts.header')

@section('content')
    <!-- フォーム -->
    <div class="form-container">
        <form class="form" method="post" action="{{ route('password.update') }}">
            @csrf
            <h1 class="form-title">パスワード再設定</h1>

            <input type="hidden" name="token" value="{{ $token }}">

            @if ($errors->has('email'))
                <div class="input-msg">
                    {{ $errors->first('email') }}
                </div>
            @endif
            <label class="form-label {{ $errors->has('email') ? 'err' : '' }}">
                Email
                <input type="text" name="email" value="{{ $email ?? old('email') }}" required autofocus>
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

            <input type="submit" class="form-btn" value="送信">
        </form>
    </div>
@endsection

@include('layouts.footer')