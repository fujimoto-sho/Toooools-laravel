<div class="post-list">
  <img src="{{ empty($post->user_img) ? '/img/avatar/default.png' : $post->user_img }}" alt="アバター" class="post-user-img">
  <p class="post-user-name">
    <a href="/profile?id={{ $post->user_id }}">
      {{ $post->user_name }}
    </a>
  </p>
  <time class="post-time" datetime="{{ $post->created_at }}">
    {{ $post->created_at }}</time>
  <h1 class="post-tool-name">
    <a href="/post/show?id={{ $post->post_id }}">
      {{ $post->post_name }}
    </a>
  </h1>
  <div class="post-wrap-center">
    <p class="post-tool-introduction">
      {{ $post->introduction }}
    </p>
    <a href="{{ $post->url }}">
      <img src="{{ (empty($post->post_img)) ? '/img/tool/default.png' : $post->post_img }}" alt="ツール" class="post-tool-img">
    </a>
  </div>
  <div class="post-wrap-icon">
    <i class="fas fa-reply"></i>
    <span class="post-reply-count">
      {{ $post->reply_cnt ?? 0 }}
    </span>
    <i class="fas fa-heart js-like-icon icon-pointer {{ (isset($post->is_like)) ? 'fa-heart-active' : '' }}"
       data-post_id="{{ $post->post_id }}" @click="sendLike"></i>
    <span class="post-like-count" >
      {{ $post->like_cnt ?? 0 }}
    </span>
    @if (Auth::check() && $post->user_id === Auth::user()->id)
      @isset($show)
        <a href="/post/edit?id={{ $post->post_id }}"><i class="fas fa-edit icon-pointer"></i></a>
        <i class="fas fa-trash-alt js-delete-icon icon-pointer" onclick="event.preventDefault();
                   document.getElementById('destroy-form').submit();"></i>
        <form id="destroy-form" action="/post/destroy?id={{ $post->post_id }}" method="POST" style="display: none;">
          @csrf
        </form>
      @endisset
    @endif
  </div>
</div>