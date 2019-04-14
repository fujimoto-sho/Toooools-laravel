@extends('layouts.base')

@section('title', 'プロフィール編集')
@section('column', 'one-column')

@include('layouts.head')
@include('layouts.header')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    You are logged in!
@endsection

@include('layouts.footer')