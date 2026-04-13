<script>
(function () {
    /* ── Sticky nav on scroll ── */
    const nav = document.getElementById('site-nav');
    if (nav) {
        const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 20);
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    /* ── Mobile nav toggle ── */
    const toggle = document.getElementById('nav-toggle');
    const mobileNav = document.getElementById('nav-mobile');
    if (toggle && mobileNav) {
        toggle.addEventListener('click', () => {
            const open = mobileNav.classList.toggle('open');
            toggle.classList.toggle('open', open);
            toggle.setAttribute('aria-expanded', open);
        });
        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!nav.contains(e.target)) {
                mobileNav.classList.remove('open');
                toggle.classList.remove('open');
            }
        });
    }

    /* ── Auto-dismiss flash messages ── */
    const flashWrap = document.getElementById('flash-wrap');
    if (flashWrap) {
        setTimeout(() => {
            flashWrap.style.transition = 'opacity 0.5s, transform 0.5s';
            flashWrap.style.opacity   = '0';
            flashWrap.style.transform = 'translateX(20px)';
            setTimeout(() => flashWrap.remove(), 500);
        }, 4000);
    }

    /* ── Smooth scroll for anchor links ── */
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', (e) => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
})();
</script>
