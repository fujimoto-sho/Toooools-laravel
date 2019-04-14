@extends('layouts.base')

@section('title', '退会')
@section('column', 'one-column')

@include('layouts.head')
@include('layouts.header')

@section('content')
  <!-- フォーム -->
  <div class="form-container">
    <form class="form" method="post" action="/user/withdraw">
      @csrf

      <h1 class="form-title">退会</h1>

      <p class="form-p">
        本当に退会しますか？
      </p>

      <input type="submit" name="withdraw" class="form-btn" value="退会">
    </form>
  </div>
@endsection

@include('layouts.footer')