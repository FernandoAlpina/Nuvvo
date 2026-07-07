/* ============================================================
   ANIMATIONS
   - Reveal on scroll (IntersectionObserver)
   - Counter animado nos big numbers
   - Timeline draw (linha que se desenha ao entrar viewport)
   ============================================================ */

(() => {
  'use strict';

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- REVEAL on scroll ---------- */
  const revealEls = document.querySelectorAll('.reveal');
  if (revealEls.length) {
    if (prefersReducedMotion) {
      revealEls.forEach((el) => el.classList.add('is-visible'));
    } else {
      const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            io.unobserve(entry.target);
          }
        });
      }, { threshold: 0.15, rootMargin: '0px 0px -10% 0px' });

      revealEls.forEach((el) => io.observe(el));
    }
  }

  /* ---------- COUNTER (big numbers) ---------- */
  const counters = document.querySelectorAll('[data-counter]');
  if (counters.length) {
    const animateCount = (el) => {
      const target = parseFloat(el.dataset.counter);
      const decimals = parseInt(el.dataset.decimals || '0', 10);
      const duration = parseInt(el.dataset.duration || '1800', 10);
      const startTime = performance.now();
      const easeOutCubic = (t) => 1 - Math.pow(1 - t, 3);

      const tick = (now) => {
        const elapsed = now - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const eased = easeOutCubic(progress);
        const value = target * eased;
        el.textContent = decimals > 0
          ? value.toFixed(decimals).replace('.', ',')
          : String(Math.floor(value));
        if (progress < 1) requestAnimationFrame(tick);
        else el.textContent = decimals > 0
          ? target.toFixed(decimals).replace('.', ',')
          : String(Math.floor(target));
      };
      requestAnimationFrame(tick);
    };

    if (prefersReducedMotion) {
      counters.forEach((el) => {
        const target = parseFloat(el.dataset.counter);
        const decimals = parseInt(el.dataset.decimals || '0', 10);
        el.textContent = decimals > 0
          ? target.toFixed(decimals).replace('.', ',')
          : String(Math.floor(target));
      });
    } else {
      const counterIO = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animateCount(entry.target);
            counterIO.unobserve(entry.target);
          }
        });
      }, { threshold: 0.5 });

      counters.forEach((el) => counterIO.observe(el));
    }
  }

  /* ---------- TIMELINE draw ---------- */
  const timelines = document.querySelectorAll('.timeline');
  if (timelines.length) {
    if (prefersReducedMotion) {
      timelines.forEach((el) => el.classList.add('is-visible'));
    } else {
      const timelineIO = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            timelineIO.unobserve(entry.target);
          }
        });
      }, { threshold: 0.25 });

      timelines.forEach((el) => timelineIO.observe(el));
    }
  }

  /* ---------- HERO PARALLAX sutil (data-parallax) ---------- */
  const parallaxEls = document.querySelectorAll('[data-parallax]');
  if (parallaxEls.length && !prefersReducedMotion) {
    let ticking = false;
    const update = () => {
      const y = window.scrollY;
      parallaxEls.forEach((el) => {
        const speed = parseFloat(el.dataset.parallax) || 0.15;
        el.style.transform = `translate3d(0, ${y * speed}px, 0)`;
      });
      ticking = false;
    };
    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(update);
        ticking = true;
      }
    }, { passive: true });
  }

  /* ---------- SCROLL PROGRESS BAR ---------- */
  const progressBar = document.querySelector('.scroll-progress');
  if (progressBar && !prefersReducedMotion) {
    let progressTick = false;
    const updateProgress = () => {
      const scrolled = window.scrollY;
      const max = document.documentElement.scrollHeight - window.innerHeight;
      const pct = max > 0 ? (scrolled / max) * 100 : 0;
      progressBar.style.width = `${pct}%`;
      progressTick = false;
    };
    window.addEventListener('scroll', () => {
      if (!progressTick) {
        requestAnimationFrame(updateProgress);
        progressTick = true;
      }
    }, { passive: true });
    updateProgress();
  }
})();
