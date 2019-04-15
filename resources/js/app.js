import $ from 'jquery';

$(function() {
  // フラッシュメッセージ
  const $flash = $('.flash-msg');
  if ($flash.length > 0) {
    $flash.slideToggle();
    setTimeout(function() {
      $flash.slideToggle();
    }, 5000);
  };
  // 画像ライブプレビュー
  const $imagesContainer = $('.form-input-container');
  $imagesContainer.on('dragover', function(e) {
    e.stopPropagation();
    e.preventDefault();
    $imagesContainer.css('border', '3px dashed #ccc');
  });
  $imagesContainer.on('dragleave', function(e) {
    e.stopPropagation();
    e.preventDefault();
    $imagesContainer.css('border', 'none');
  });
  $('#js-img-input').on('change', function() {
    const file = this.files[0];
    let $img = $('#js-img-show');
    let reader = new FileReader();
    reader.onload = function(e) {
      $img.attr('src', reader.result);
    };
    reader.readAsDataURL(file);
    $imagesContainer.css('border', 'none');
  });

  // いいね送信
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('.js-like-icon').on('click', function() {
    $.ajax({
      type: "POST",
      url: "/ajax/like",
      data: {
        'id': $(this).data('post_id'),
      },
      dataType: "text",
    })
      .done((data) => {
        if (data !== undefined && data !== null && data !== '') {
          $(this).toggleClass('fa-heart-active');
          $(this).siblings('.post-like-count').text(data);
        }
      });
  });
  // 投稿削除
  $('.js-delete-icon').on('click', function() {
    $('#js-dlt-form').submit();
  });
});