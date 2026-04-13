@extends('layouts.app')

@section('title', 'The Journal — A Home for Thoughtful Writing')
@section('meta_description', 'Discover and share ideas that matter. A curated space for writers who value depth, nuance, and the power of a well-crafted sentence.')

@section('content')

    {{-- ═══════════════════════════════════════
         HERO SECTION
    ════════════════════════════════════════ --}}
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-grid"></div>

        <div class="container">
            <div class="hero-inner">
                {{-- Left: Copy --}}
                <div class="hero-copy">
                    <div class="hero-label">
                        <span class="hero-label-dot"></span>
                        A space for real writing
                    </div>

                    <h1 class="hero-title">
                        Where ideas<br>find their<br><em>voice.</em>
                    </h1>

                    <p class="hero-desc">
                        The Journal is a home for writers who believe words still matter.
                        Share your thinking, discover new perspectives, and join a community
                        that reads with intention.
                    </p>

                    <div class="hero-actions">
                        @auth
                            <a href="{{ url('/new-post') }}" class="btn btn-primary btn-lg">Write Something</a>
                            <a href="{{ url('/blog') }}" class="btn btn-outline-white btn-lg">Browse Articles</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Start Writing Free</a>
                            <a href="{{ url('/blog') }}" class="btn btn-outline-white btn-lg">Read Articles</a>
                        @endauth
                    </div>

                    <div class="hero-stats">
                        <div>
                            <div class="hero-stat-num">{{ number_format($stats['writers'] ?? 1240) }}</div>
                            <div class="hero-stat-label">Writers</div>
                        </div>
                        <div>
                            <div class="hero-stat-num">{{ number_format($stats['articles'] ?? 8500) }}</div>
                            <div class="hero-stat-label">Articles</div>
                        </div>
                        <div>
                            <div class="hero-stat-num">{{ number_format($stats['reads'] ?? 92000) }}</div>
                            <div class="hero-stat-label">Monthly Reads</div>
                        </div>
                    </div>
                </div>

                {{-- Right: Preview Cards --}}
                <div class="hero-visual">
                    <div class="hero-card hero-card-main">
                        <div class="hero-card-tag">Featured · Technology</div>
                        <div class="hero-card-title">The Quiet Revolution Happening Inside Our Attention Spans</div>
                        <div class="hero-card-meta">
                            <span>Maya R.</span>
                            <span>·</span>
                            <span>8 min read</span>
                        </div>
                    </div>

                    <div class="hero-card">
                        <div class="hero-card-tag">Philosophy</div>
                        <div class="hero-card-title">On the Strange Comfort of Unfinished Things</div>
                        <div class="hero-card-meta">
                            <span>James K.</span>
                            <span>·</span>
                            <span>5 min read</span>
                        </div>
                    </div>

                    <div class="hero-card">
                        <div class="hero-card-tag">Design</div>
                        <div class="hero-card-title">Why Constraints Are the Ultimate Creative Tool</div>
                        <div class="hero-card-meta">
                            <span>Priya S.</span>
                            <span>·</span>
                            <span>6 min read</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         TOPICS STRIP
    ════════════════════════════════════════ --}}
    <section class="topics-section">
        <div class="container">
            <div class="topics-row">
                <span class="topics-label">Browse Topics</span>
                @php
                    $topics = $categories ?? [
                        'Technology', 'Philosophy', 'Design', 'Science',
                        'Culture', 'Personal Growth', 'Politics', 'Art',
                        'Business', 'Travel', 'Health', 'Fiction'
                    ];
                @endphp
                @foreach($topics as $topic)
                    <a href="{{ url('/topics/' . Str::slug(is_array($topic) ? $topic['name'] : $topic)) }}"
                       class="topic-tag">
                        {{ is_array($topic) ? $topic['name'] : $topic }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         FEATURED POSTS
    ════════════════════════════════════════ --}}
    <section class="section">
        <div class="container">
            <div class="section-header">
                <div>
                    <p class="section-eyebrow">Editor's Pick</p>
                    <h2 class="section-title">Featured Articles</h2>
                </div>
                <a href="{{ url('/blog') }}" class="btn btn-ghost">View All</a>
            </div>

            <div class="posts-grid featured">
                @if(isset($featuredPosts) && $featuredPosts->count())
                    @foreach($featuredPosts as $post)
                        @include('partials.post-card', ['post' => $post, 'featured' => $loop->first])
                    @endforeach
                @else
                    {{-- Placeholder cards when no posts exist yet --}}
                    @for($i = 0; $i < 3; $i++)
                        <article class="post-card">
                            <div class="post-card-img">
                                <div class="post-card-img-placeholder">
                                    {{ ['✦', '◈', '❋'][$i] }}
                                </div>
                            </div>
                            <div class="post-card-body">
                                <span class="post-card-category">
                                    {{ ['Technology', 'Philosophy', 'Design'][$i] }}
                                </span>
                                <h3 class="post-card-title">
                                    <a href="#">
                                        {{ [
                                            'The Quiet Revolution Happening Inside Our Attention Spans',
                                            'On the Strange Comfort of Unfinished Things',
                                            'Why Constraints Are the Ultimate Creative Tool'
                                        ][$i] }}
                                    </a>
                                </h3>
                                <p class="post-card-excerpt">
                                    {{ [
                                        'We live in an era of infinite content but ever-shrinking focus. What does it mean to truly pay attention — and can we learn to do it again?',
                                        'There is a peculiar peace in things left open. A half-written letter, an unresolved chord, a story with no ending yet.',
                                        'The blank canvas is a lie. Real creativity doesn\'t flourish in endless possibility — it thrives in the friction of limits.'
                                    ][$i] }}
                                </p>
                                <div class="post-card-meta">
                                    <div class="post-meta-author">
                                        <div class="author-avatar">
                                            {{ ['MR', 'JK', 'PS'][$i] }}
                                        </div>
                                        <span>{{ ['Maya R.', 'James K.', 'Priya S.'][$i] }}</span>
                                    </div>
                                    <span>·</span>
                                    <span>{{ [8, 5, 6][$i] }} min read</span>
                                </div>
                            </div>
                        </article>
                    @endfor
                @endif
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         LATEST POSTS
    ════════════════════════════════════════ --}}
    <section class="section" style="background: var(--paper-warm); border-top: 1px solid var(--paper-dark); border-bottom: 1px solid var(--paper-dark);">
        <div class="container">
            <div class="section-header">
                <div>
                    <p class="section-eyebrow">Fresh Off the Press</p>
                    <h2 class="section-title">Latest Articles</h2>
                </div>
                <a href="{{ url('/blog') }}" class="btn btn-ghost">See More</a>
            </div>

            <div class="posts-grid">
                @if(isset($latestPosts) && $latestPosts->count())
                    @foreach($latestPosts as $post)
                        @include('partials.post-card', ['post' => $post])
                    @endforeach
                @else
                    @php
                        $placeholders = [
                            ['cat' => 'Science', 'title' => 'What Fungi Know That We Don\'t', 'excerpt' => 'Underground networks of mycelia are rewriting everything we thought we knew about intelligence, memory, and communication in nature.', 'author' => 'Leo B.', 'initials' => 'LB', 'time' => 7],
                            ['cat' => 'Culture', 'title' => 'The Return of Slow Media', 'excerpt' => 'Long-form journalism, newsletters, and audio essays are all surging. Readers are hungry for something that respects their time and intelligence.', 'author' => 'Anita M.', 'initials' => 'AM', 'time' => 4],
                            ['cat' => 'Personal Growth', 'title' => 'Learning to Sit with Not Knowing', 'excerpt' => 'Certainty is comfortable. Uncertainty is where growth actually happens — if you can resist the urge to resolve it too quickly.', 'author' => 'Tom W.', 'initials' => 'TW', 'time' => 6],
                        ];
                    @endphp
                    @foreach($placeholders as $p)
                        <article class="post-card">
                            <div class="post-card-img">
                                <div class="post-card-img-placeholder" style="font-size:2rem;">◆</div>
                            </div>
                            <div class="post-card-body">
                                <span class="post-card-category">{{ $p['cat'] }}</span>
                                <h3 class="post-card-title"><a href="#">{{ $p['title'] }}</a></h3>
                                <p class="post-card-excerpt">{{ $p['excerpt'] }}</p>
                                <div class="post-card-meta">
                                    <div class="post-meta-author">
                                        <div class="author-avatar">{{ $p['initials'] }}</div>
                                        <span>{{ $p['author'] }}</span>
                                    </div>
                                    <span>·</span>
                                    <span>{{ $p['time'] }} min read</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         CTA SECTION
    ════════════════════════════════════════ --}}
    @guest
    <section class="cta-section">
        <div class="container">
            <div class="cta-inner">
                <h2>Ready to share your thinking?</h2>
                <p>
                    Join thousands of writers who have found their voice on The Journal.
                    No algorithms, no noise — just good writing, read by people who care.
                </p>
                <div class="cta-actions">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Create Your Account</a>
                    <a href="{{ url('/about') }}" class="btn btn-outline-white btn-lg">Learn More</a>
                </div>
            </div>
        </div>
    </section>
    @endguest

@endsection
