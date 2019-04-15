@extends('layouts.base')

@section('title', $title)
@section('column', 'one-column')

@include('layouts.head')
@include('layouts.header')

@section('content')
  <div class="form-container">
    <form class="form" method="post" action="{{ '/' . request()->path() }}" enctype="multipart/form-data">
      @csrf
      <h1 class="form-title">{{ $title }}</h1>

      @isset($form['id'])
        <input type="hidden" name="id" value="{{ $form['id'] }}">
      @endisset
      @if ($errors->has('name'))
        <div class="input-msg">
          {{ $errors->first('name') }}
        </div>
      @endif
      <label class="form-label {{ $errors->has('name') ? ' err' : '' }}">
        ツール名
        <input type="text" name="name" value="{{ old('name') ?? $form['name'] }}" required>
      </label>

      @if ($errors->has('introduction'))
        <div class="input-msg">
          {{ $errors->first('introduction') }}
        </div>
      @endif
      <label class="form-label {{ $errors->has('introduction') ? ' err' : '' }}">
        ツール紹介
        <textarea name="introduction" cols="30" rows="5">{{ old('introduction') ?? $form['introduction'] }}</textarea>
      </label>

      @if ($errors->has('url'))
        <div class="input-msg">
          {{ $errors->first('url') }}
        </div>
      @endif
      <label class="form-label {{ $errors->has('url') ? ' err' : '' }}">
        URL
        <input type="text" name="url" value="{{ old('url') ?? $form['url'] }}">
      </label>

      @if ($errors->has('img'))
        <div class="input-msg">
          {{ $errors->first('img') }}
        </div>
      @endif
      ツール画像
      <div class="form-input-container">
        <label class="form-label form-label-file">
          <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
          <input type="file" name="img" id="js-img-input" hidden>
          <img src="{{ $form['img_filename'] }}" id="js-img-show" class="form-input-file-img">
        </label>
      </div>

      <input type="submit" class="form-btn" value="変更">
    </form>
  </div>
@endsection

@include('layouts.footer')