@extends('layouts.base')

@section('title', '退会')
@section('column', 'one-column')

@include('layouts.head')
@include('layouts.header')

@section('content')
    <!-- フォーム -->
    <div class="form-container">
        <form class="form" method="post" action="{{ route('password.email') }}">
            @csrf
            <h1 class="form-title">パスワード再発行</h1>
            @if (session('status'))
                <p class="form-p">
                    再発行用のメールを送信しました。
                </p>
            @else
                <p class="form-p">
                    登録したメールアドレスを下記フォームに入力し、送信ボタンを押してください。<br>
                    入力したメールアドレスにパスワード再設定メールが通知されます。
                </p>

                @if ($errors->has('email'))
                    <div class="input-msg">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <label class="form-label {{ $errors->has('email') ? 'err' : '' }}">
                    Email
                    <input type="text" name="email" value="{{ old('email') }}" required autofocus>
                </label>

                <input type="submit" class="form-btn" value="送信">
            @endif
        </form>
    </div>
@endsection

@include('layouts.footer')