<article class="post-card">
    <div class="post-card-img">
        @if($post->cover_image)
            <img src="{{ $post->cover_image }}"
                 alt="{{ $post->title }}"
                 loading="{{ isset($featured) && $featured ? 'eager' : 'lazy' }}">
        @else
            <div class="post-card-img-placeholder">◆</div>
        @endif
    </div>

    <div class="post-card-body">
        @if($post->category)
            <span class="post-card-category">
                {{ is_string($post->category) ? $post->category : $post->category->name }}
            </span>
        @endif

        <h3 class="post-card-title">
            <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
        </h3>

        @if($post->excerpt)
            <p class="post-card-excerpt">{{ $post->excerpt }}</p>
        @endif

        <div class="post-card-meta">
            <div class="post-meta-author">
                <div class="author-avatar">
                    @if($post->author?->avatar)
                        <img src="{{ $post->author->avatar }}" alt="{{ $post->author->name }}">
                    @else
                        {{ strtoupper(substr($post->author?->name ?? 'A', 0, 1)) }}{{ strtoupper(substr(strstr($post->author?->name ?? ' B', ' '), 1, 1)) }}
                    @endif
                </div>
                <span>{{ $post->author?->name ?? 'Anonymous' }}</span>
            </div>
            <span>·</span>
            <span>{{ $post->reading_time ?? ceil(str_word_count($post->body ?? '') / 200) }} min read</span>
            @if($post->published_at)
                <span>·</span>
                <span>{{ $post->published_at->diffForHumans() }}</span>
            @endif
        </div>
    </div>
</article>
