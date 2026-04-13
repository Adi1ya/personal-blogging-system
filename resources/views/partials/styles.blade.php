<style>
    /* ============================================
       CSS VARIABLES & DESIGN TOKENS
    ============================================ */
    :root {
        --ink:        #1a1614;
        --ink-light:  #4a4542;
        --ink-muted:  #8a8480;
        --paper:      #f7f4ef;
        --paper-warm: #ede9e1;
        --paper-dark: #e0dbd2;
        --accent:     #c8402a;
        --accent-dk:  #a83320;
        --gold:       #b8922a;
        --white:      #fdfcfa;

        --font-display: 'Playfair Display', Georgia, serif;
        --font-body:    'DM Sans', system-ui, sans-serif;

        --max-w:    1140px;
        --radius:   3px;
        --radius-lg: 8px;

        --ease-out-expo: cubic-bezier(0.16, 1, 0.3, 1);
        --ease-in-out:   cubic-bezier(0.65, 0, 0.35, 1);
    }

    /* ============================================
       RESET & BASE
    ============================================ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html { scroll-behavior: smooth; font-size: 16px; }

    body {
        font-family: var(--font-body);
        background: var(--paper);
        color: var(--ink);
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        overflow-x: hidden;
    }

    img { max-width: 100%; display: block; }
    a { color: inherit; text-decoration: none; }
    button { cursor: pointer; font-family: inherit; border: none; background: none; }
    input, textarea, select { font-family: inherit; }

    /* ============================================
       TYPOGRAPHY UTILITIES
    ============================================ */
    .display-font { font-family: var(--font-display); }
    .body-font    { font-family: var(--font-body); }

    /* ============================================
       LAYOUT UTILITIES
    ============================================ */
    .container {
        width: 100%;
        max-width: var(--max-w);
        margin-inline: auto;
        padding-inline: clamp(1.25rem, 5vw, 3rem);
    }

    /* ============================================
       NAVIGATION
    ============================================ */
    .site-nav {
        position: fixed;
        top: 0; left: 0; right: 0;
        z-index: 100;
        padding: 0;
        transition: background 0.4s var(--ease-out-expo),
                    box-shadow 0.4s var(--ease-out-expo),
                    padding 0.4s var(--ease-out-expo);
    }

    .site-nav.scrolled {
        background: rgba(247, 244, 239, 0.95);
        backdrop-filter: blur(12px);
        box-shadow: 0 1px 0 rgba(26,22,20,0.1);
    }

    .nav-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 72px;
        gap: 2rem;
    }

    .nav-logo {
        font-family: var(--font-display);
        font-size: 1.5rem;
        font-weight: 900;
        letter-spacing: -0.02em;
        color: var(--ink);
        transition: color 0.2s;
        flex-shrink: 0;
    }

    .nav-logo span {
        color: var(--accent);
    }

    .nav-logo:hover { color: var(--accent); }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 2rem;
        list-style: none;
    }

    .nav-links a {
        font-size: 0.8125rem;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--ink-light);
        transition: color 0.2s;
        position: relative;
    }

    .nav-links a::after {
        content: '';
        position: absolute;
        bottom: -2px; left: 0;
        width: 0; height: 1px;
        background: var(--accent);
        transition: width 0.3s var(--ease-out-expo);
    }

    .nav-links a:hover { color: var(--ink); }
    .nav-links a:hover::after { width: 100%; }

    .nav-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    /* Hamburger */
    .nav-toggle {
        display: none;
        flex-direction: column;
        gap: 5px;
        padding: 4px;
        background: none;
        border: none;
        cursor: pointer;
    }

    .nav-toggle span {
        display: block;
        width: 24px; height: 1.5px;
        background: var(--ink);
        transition: transform 0.3s, opacity 0.3s;
    }

    .nav-toggle.open span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
    .nav-toggle.open span:nth-child(2) { opacity: 0; }
    .nav-toggle.open span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }

    /* Mobile nav */
    .nav-mobile {
        display: none;
        flex-direction: column;
        gap: 0;
        border-top: 1px solid var(--paper-dark);
        background: var(--white);
        padding: 1rem 0 1.5rem;
    }

    .nav-mobile.open { display: flex; }

    .nav-mobile a {
        padding: 0.75rem clamp(1.25rem, 5vw, 3rem);
        font-size: 1rem;
        font-weight: 500;
        color: var(--ink-light);
        border-bottom: 1px solid var(--paper-warm);
        transition: color 0.2s, background 0.2s;
    }

    .nav-mobile a:last-child { border-bottom: none; }
    .nav-mobile a:hover { color: var(--ink); background: var(--paper-warm); }

    /* ============================================
       BUTTONS
    ============================================ */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.625rem 1.375rem;
        font-size: 0.8125rem;
        font-weight: 500;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        border-radius: var(--radius);
        transition: all 0.25s var(--ease-out-expo);
        white-space: nowrap;
        line-height: 1;
    }

    .btn-primary {
        background: var(--accent);
        color: var(--white);
        box-shadow: 0 2px 12px rgba(200,64,42,0.3);
    }

    .btn-primary:hover {
        background: var(--accent-dk);
        transform: translateY(-1px);
        box-shadow: 0 4px 20px rgba(200,64,42,0.4);
    }

    .btn-primary:active { transform: translateY(0); }

    .btn-ghost {
        color: var(--ink);
        border: 1px solid var(--paper-dark);
        background: transparent;
    }

    .btn-ghost:hover {
        border-color: var(--ink-light);
        background: var(--paper-warm);
    }

    .btn-outline-white {
        color: var(--white);
        border: 1px solid rgba(255,255,255,0.5);
        background: transparent;
    }

    .btn-outline-white:hover {
        border-color: var(--white);
        background: rgba(255,255,255,0.1);
    }

    .btn-lg {
        padding: 0.875rem 2rem;
        font-size: 0.875rem;
    }

    /* ============================================
       FLASH MESSAGES
    ============================================ */
    .flash-wrap {
        position: fixed;
        top: 88px; right: 1.5rem;
        z-index: 200;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        max-width: 360px;
    }

    .flash {
        padding: 0.875rem 1.25rem;
        border-radius: var(--radius-lg);
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        box-shadow: 0 4px 24px rgba(0,0,0,0.12);
        animation: flashIn 0.4s var(--ease-out-expo) both;
    }

    .flash-success { background: #1a6640; color: #fff; }
    .flash-error   { background: var(--accent); color: #fff; }
    .flash-info    { background: var(--ink); color: #fff; }
    .flash-warning { background: var(--gold); color: #fff; }

    @keyframes flashIn {
        from { opacity: 0; transform: translateX(20px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    /* ============================================
       FOOTER
    ============================================ */
    .site-footer {
        background: var(--ink);
        color: var(--paper-warm);
        margin-top: auto;
    }

    .footer-top {
        padding: 4rem 0 3rem;
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1fr;
        gap: 3rem;
        border-bottom: 1px solid rgba(247,244,239,0.1);
    }

    .footer-brand .logo {
        font-family: var(--font-display);
        font-size: 1.5rem;
        font-weight: 900;
        color: var(--white);
        margin-bottom: 1rem;
        display: block;
    }

    .footer-brand .logo span { color: var(--accent); }

    .footer-brand p {
        font-size: 0.875rem;
        color: var(--ink-muted);
        line-height: 1.7;
        max-width: 240px;
    }

    .footer-col h4 {
        font-family: var(--font-display);
        font-size: 0.9375rem;
        font-weight: 700;
        color: var(--white);
        margin-bottom: 1.25rem;
        letter-spacing: 0.02em;
    }

    .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 0.625rem; }

    .footer-col ul a {
        font-size: 0.875rem;
        color: var(--ink-muted);
        transition: color 0.2s;
    }

    .footer-col ul a:hover { color: var(--paper-warm); }

    .footer-bottom {
        padding: 1.5rem 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        font-size: 0.8125rem;
        color: var(--ink-muted);
    }

    .footer-bottom a {
        color: var(--ink-muted);
        transition: color 0.2s;
    }

    .footer-bottom a:hover { color: var(--paper-warm); }

    /* ============================================
       FORM ELEMENTS (shared across auth pages)
    ============================================ */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
    }

    .form-label {
        font-size: 0.8125rem;
        font-weight: 500;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: var(--ink-light);
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        background: var(--white);
        border: 1px solid var(--paper-dark);
        border-radius: var(--radius);
        font-size: 0.9375rem;
        color: var(--ink);
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        appearance: none;
    }

    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(200,64,42,0.12);
    }

    .form-control::placeholder { color: var(--ink-muted); }

    .form-control.is-invalid {
        border-color: var(--accent);
    }

    .invalid-feedback {
        font-size: 0.8125rem;
        color: var(--accent);
        margin-top: 0.25rem;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }

    .form-check-input {
        width: 16px; height: 16px;
        border: 1.5px solid var(--paper-dark);
        border-radius: 2px;
        accent-color: var(--accent);
        cursor: pointer;
        flex-shrink: 0;
    }

    .form-check-label {
        font-size: 0.875rem;
        color: var(--ink-light);
        cursor: pointer;
    }

    /* ============================================
       AUTH PAGES
    ============================================ */
    .auth-body {
        min-height: 100vh;
        background: var(--ink);
        margin: 0;
        padding: 0;
    }

    .auth-main {
        min-height: 100vh;
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .auth-panel {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: clamp(2rem, 6vw, 5rem);
        min-height: 100vh;
    }

    .auth-panel-left {
        background: var(--ink);
        position: relative;
        overflow: hidden;
    }

    .auth-panel-right {
        background: var(--white);
        overflow-y: auto;
        /* Always fills its column at full height */
        min-height: 100vh;
    }

    /* Left panel decorative elements */
    .auth-deco-circle {
        position: absolute;
        border-radius: 50%;
        opacity: 0.06;
        background: var(--white);
    }

    .auth-deco-circle-1 { width: 600px; height: 600px; top: -200px; right: -200px; }
    .auth-deco-circle-2 { width: 300px; height: 300px; bottom: 100px; left: -100px; }
    .auth-deco-line {
        position: absolute;
        background: rgba(255,255,255,0.06);
        width: 1px;
        height: 100%;
        top: 0;
    }

    .auth-panel-content { position: relative; z-index: 1; max-width: 440px; }

    .auth-brand {
        font-family: var(--font-display);
        font-size: 1.75rem;
        font-weight: 900;
        color: var(--white);
        margin-bottom: 3rem;
        display: block;
    }

    .auth-brand span { color: var(--accent); }

    .auth-panel-left h2 {
        font-family: var(--font-display);
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 900;
        color: var(--white);
        line-height: 1.1;
        margin-bottom: 1.25rem;
        letter-spacing: -0.02em;
    }

    .auth-panel-left p {
        font-size: 1rem;
        color: rgba(247,244,239,0.6);
        line-height: 1.7;
        margin-bottom: 2.5rem;
    }

    .auth-features { list-style: none; display: flex; flex-direction: column; gap: 1rem; }

    .auth-features li {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        font-size: 0.9375rem;
        color: rgba(247,244,239,0.75);
    }

    .auth-feature-icon {
        width: 28px; height: 28px;
        background: rgba(200,64,42,0.25);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: var(--accent);
        font-size: 0.75rem;
    }

    /* Right panel form */
    .auth-form-wrap {
        max-width: 420px;
        width: 100%;
        margin: 0 auto;
    }

    .auth-form-wrap h1 {
        font-family: var(--font-display);
        font-size: 2rem;
        font-weight: 900;
        color: var(--ink);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .auth-form-wrap .subtitle {
        font-size: 0.9375rem;
        color: var(--ink-muted);
        margin-bottom: 2.5rem;
    }

    .auth-form {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .auth-form .btn {
        margin-top: 0.5rem;
        padding: 0.875rem;
        font-size: 0.875rem;
        width: 100%;
    }

    .auth-switch {
        text-align: center;
        font-size: 0.875rem;
        color: var(--ink-muted);
        margin-top: 1.75rem;
    }

    .auth-switch a {
        color: var(--accent);
        font-weight: 500;
    }

    .auth-switch a:hover { text-decoration: underline; }

    .divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: var(--ink-muted);
        font-size: 0.8125rem;
    }

    .divider::before, .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--paper-dark);
    }

    /* ============================================
       HERO SECTION
    ============================================ */
    .hero {
        padding-top: 72px; /* nav height */
        position: relative;
        overflow: hidden;
        background: var(--ink);
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    .hero-bg {
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 80% 60% at 70% 50%, rgba(200,64,42,0.12) 0%, transparent 60%),
            radial-gradient(ellipse 50% 80% at 20% 80%, rgba(184,146,42,0.08) 0%, transparent 60%);
    }

    .hero-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 60px 60px;
    }

    .hero-inner {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
        padding-block: 6rem;
    }

    .hero-label {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        font-weight: 500;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--accent);
        border: 1px solid rgba(200,64,42,0.3);
        padding: 0.375rem 0.875rem;
        border-radius: 100px;
        margin-bottom: 1.75rem;
        animation: fadeUp 0.8s var(--ease-out-expo) 0.1s both;
    }

    .hero-label-dot {
        width: 6px; height: 6px;
        background: var(--accent);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.5; transform: scale(0.7); }
    }

    .hero-title {
        font-family: var(--font-display);
        font-size: clamp(3rem, 6vw, 5.5rem);
        font-weight: 900;
        color: var(--white);
        line-height: 1.0;
        letter-spacing: -0.03em;
        margin-bottom: 1.5rem;
        animation: fadeUp 0.8s var(--ease-out-expo) 0.2s both;
    }

    .hero-title em {
        font-style: italic;
        color: var(--accent);
    }

    .hero-desc {
        font-size: 1.125rem;
        color: rgba(247,244,239,0.65);
        line-height: 1.75;
        max-width: 480px;
        margin-bottom: 2.5rem;
        animation: fadeUp 0.8s var(--ease-out-expo) 0.3s both;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        animation: fadeUp 0.8s var(--ease-out-expo) 0.4s both;
    }

    .hero-stats {
        display: flex;
        gap: 2.5rem;
        margin-top: 4rem;
        padding-top: 2.5rem;
        border-top: 1px solid rgba(247,244,239,0.1);
        animation: fadeUp 0.8s var(--ease-out-expo) 0.5s both;
    }

    .hero-stat-num {
        font-family: var(--font-display);
        font-size: 2rem;
        font-weight: 900;
        color: var(--white);
        line-height: 1;
    }

    .hero-stat-label {
        font-size: 0.8125rem;
        color: rgba(247,244,239,0.5);
        margin-top: 0.25rem;
        letter-spacing: 0.04em;
    }

    /* Hero visual side */
    .hero-visual {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        animation: fadeUp 0.9s var(--ease-out-expo) 0.3s both;
    }

    .hero-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        backdrop-filter: blur(8px);
        transition: transform 0.3s, background 0.3s;
    }

    .hero-card:hover {
        transform: translateY(-3px);
        background: rgba(255,255,255,0.08);
    }

    .hero-card-tag {
        font-size: 0.6875rem;
        font-weight: 500;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 0.625rem;
    }

    .hero-card-title {
        font-family: var(--font-display);
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--white);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .hero-card-meta {
        font-size: 0.8125rem;
        color: rgba(247,244,239,0.4);
        display: flex;
        gap: 1rem;
    }

    .hero-card-main {
        background: rgba(200,64,42,0.15);
        border-color: rgba(200,64,42,0.2);
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ============================================
       FEATURED POSTS SECTION
    ============================================ */
    .section {
        padding: clamp(4rem, 8vw, 7rem) 0;
    }

    .section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .section-eyebrow {
        font-size: 0.75rem;
        font-weight: 500;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 0.5rem;
    }

    .section-title {
        font-family: var(--font-display);
        font-size: clamp(1.75rem, 4vw, 2.75rem);
        font-weight: 900;
        color: var(--ink);
        letter-spacing: -0.02em;
        line-height: 1.1;
    }

    .posts-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .posts-grid.featured {
        grid-template-columns: 1.6fr 1fr;
        grid-template-rows: auto;
    }

    .posts-grid.featured .post-card:first-child {
        grid-row: span 2;
    }

    .post-card {
        display: flex;
        flex-direction: column;
        background: var(--white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--paper-dark);
        transition: transform 0.3s var(--ease-out-expo),
                    box-shadow 0.3s var(--ease-out-expo);
    }

    .post-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(26,22,20,0.1);
    }

    .post-card-img {
        aspect-ratio: 16/9;
        background: var(--paper-dark);
        overflow: hidden;
        position: relative;
    }

    .posts-grid.featured .post-card:first-child .post-card-img {
        aspect-ratio: unset;
        flex: 1;
        min-height: 260px;
    }

    .post-card-img img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.5s var(--ease-out-expo);
    }

    .post-card:hover .post-card-img img { transform: scale(1.04); }

    .post-card-img-placeholder {
        width: 100%; height: 100%;
        background: linear-gradient(135deg, var(--paper-dark) 0%, var(--paper-warm) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--ink-muted);
        font-family: var(--font-display);
        font-size: 3rem;
        font-style: italic;
    }

    .post-card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.625rem;
        flex: 1;
    }

    .post-card-category {
        font-size: 0.6875rem;
        font-weight: 500;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--accent);
    }

    .post-card-title {
        font-family: var(--font-display);
        font-size: 1.1875rem;
        font-weight: 700;
        color: var(--ink);
        line-height: 1.3;
        transition: color 0.2s;
    }

    .post-card:hover .post-card-title { color: var(--accent); }

    .posts-grid.featured .post-card:first-child .post-card-title {
        font-size: 1.75rem;
    }

    .post-card-excerpt {
        font-size: 0.875rem;
        color: var(--ink-muted);
        line-height: 1.65;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .post-card-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.8125rem;
        color: var(--ink-muted);
        margin-top: auto;
        padding-top: 0.5rem;
    }

    .post-meta-author {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .author-avatar {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: var(--paper-dark);
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.6875rem;
        font-weight: 700;
        color: var(--ink-light);
        font-family: var(--font-display);
    }

    /* ============================================
       CTA SECTION
    ============================================ */
    .cta-section {
        background: var(--ink);
        padding: 6rem 0;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 80% at 50% 50%, rgba(200,64,42,0.15), transparent 70%);
    }

    .cta-inner {
        position: relative;
        text-align: center;
        max-width: 640px;
        margin: 0 auto;
    }

    .cta-inner h2 {
        font-family: var(--font-display);
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 900;
        color: var(--white);
        line-height: 1.1;
        letter-spacing: -0.02em;
        margin-bottom: 1.25rem;
    }

    .cta-inner p {
        font-size: 1.0625rem;
        color: rgba(247,244,239,0.6);
        line-height: 1.7;
        margin-bottom: 2.5rem;
    }

    .cta-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    /* ============================================
       TOPICS / CATEGORIES STRIP
    ============================================ */
    .topics-section {
        background: var(--paper-warm);
        border-top: 1px solid var(--paper-dark);
        border-bottom: 1px solid var(--paper-dark);
        padding: 2rem 0;
    }

    .topics-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .topics-label {
        font-size: 0.75rem;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--ink-muted);
        margin-right: 0.5rem;
        flex-shrink: 0;
    }

    .topic-tag {
        padding: 0.375rem 1rem;
        border-radius: 100px;
        font-size: 0.8125rem;
        font-weight: 500;
        background: var(--white);
        color: var(--ink-light);
        border: 1px solid var(--paper-dark);
        transition: all 0.2s;
        white-space: nowrap;
    }

    .topic-tag:hover {
        background: var(--accent);
        color: var(--white);
        border-color: var(--accent);
    }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 900px) {
        .footer-top {
            grid-template-columns: 1fr 1fr;
        }

        .posts-grid { grid-template-columns: 1fr 1fr; }
        .posts-grid.featured { grid-template-columns: 1fr; }
        .posts-grid.featured .post-card:first-child { grid-row: span 1; }

        .auth-main { grid-template-columns: 1fr; background: var(--white); }
        .auth-panel-left { display: none; }
        .auth-panel-right { min-height: 100vh; width: 100%; }

        .hero-inner { grid-template-columns: 1fr; }
        .hero-visual { display: none; }
    }

    @media (max-width: 680px) {
        .nav-links { display: none; }
        .nav-actions .btn-ghost { display: none; }
        .nav-toggle { display: flex; }

        .footer-top { grid-template-columns: 1fr; gap: 2rem; }
        .footer-bottom { flex-direction: column; text-align: center; }

        .posts-grid { grid-template-columns: 1fr; }

        .section-header { flex-direction: column; align-items: flex-start; }
    }
</style>