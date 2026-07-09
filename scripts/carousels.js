/* ============================================================
   CAROUSELS — inicialização do Swiper
   - Hero (fade entre slides quando vídeo não disponível)
   - Featured (3 visíveis desktop, 1 mobile)
   - Gallery (free mode, larguras assimétricas)
   - Testimonials (mobile only)
   ============================================================ */

(() => {
  'use strict';

  if (!window.Swiper) return;

  /* ---------- HERO carrossel (fallback do vídeo) ---------- */
  const heroEl = document.querySelector('.hero__swiper');
  if (heroEl) {
    new Swiper(heroEl, {
      slidesPerView: 1,
      loop: true,
      effect: 'fade',
      fadeEffect: { crossFade: true },
      autoplay: {
        delay: 5200,
        disableOnInteraction: false,
      },
      speed: 1200,
      allowTouchMove: false,
    });
  }

  /* ---------- FEATURED produtos ---------- */
  const featuredEl = document.querySelector('.featured__swiper');
  if (featuredEl) {
    new Swiper(featuredEl, {
      slidesPerView: 1,
      spaceBetween: 16,
      grabCursor: true,
      speed: 600,
      breakpoints: {
        640:  { slidesPerView: 2, spaceBetween: 20 },
        1024: { slidesPerView: 3, spaceBetween: 24 },
      },
      navigation: {
        nextEl: '.featured__next',
        prevEl: '.featured__prev',
      },
      pagination: {
        el: '.featured__pagination',
        clickable: true,
      },
      a11y: {
        prevSlideMessage: 'Produto anterior',
        nextSlideMessage: 'Próximo produto',
      },
    });
  }

  /* ---------- GALLERY ---------- */
  const galleryEl = document.querySelector('.gallery__swiper');
  if (galleryEl) {
    new Swiper(galleryEl, {
      slidesPerView: 'auto',
      spaceBetween: 16,
      grabCursor: true,
      freeMode: { enabled: true, sticky: false, momentumRatio: 0.7 },
      speed: 700,
      breakpoints: {
        768:  { spaceBetween: 20 },
        1024: { spaceBetween: 24 },
      },
      navigation: {
        nextEl: '.gallery__next',
        prevEl: '.gallery__prev',
      },
      a11y: {
        prevSlideMessage: 'Imagem anterior',
        nextSlideMessage: 'Próxima imagem',
      },
    });
  }

  /* ---------- TESTIMONIALS (carrossel responsivo) ---------- */
  const testiEl = document.querySelector('.testi__swiper');
  if (testiEl) {
    const testiSwiper = new Swiper(testiEl, {
      slidesPerView: 1,
      spaceBetween: 20,
      grabCursor: true,
      speed: 600,
      breakpoints: {
        640:  { slidesPerView: 2, spaceBetween: 24 },
        1024: { slidesPerView: 3, spaceBetween: 32 },
      },
      navigation: {
        nextEl: '.testi__next',
        prevEl: '.testi__prev',
      },
      pagination: {
        el: '.testi__pagination',
        clickable: true,
      },
      a11y: {
        prevSlideMessage: 'Depoimento anterior',
        nextSlideMessage: 'Próximo depoimento',
      },
    });
    initTestiReadMore(testiEl, testiSwiper);
  }

  /* ---------- FEATURES (diferenciais — página A Nuvvo) ---------- */
  const featuresEl = document.querySelector('.features__swiper');
  if (featuresEl) {
    new Swiper(featuresEl, {
      slidesPerView: 1,
      spaceBetween: 16,
      grabCursor: true,
      speed: 600,
      breakpoints: {
        640:  { slidesPerView: 2, spaceBetween: 20 },
        1024: { slidesPerView: 3, spaceBetween: 24 },
      },
      navigation: {
        nextEl: '.features__next',
        prevEl: '.features__prev',
      },
      pagination: {
        el: '.features__pagination',
        clickable: true,
      },
      a11y: {
        prevSlideMessage: 'Diferencial anterior',
        nextSlideMessage: 'Próximo diferencial',
      },
    });
  }

  /* ---------- TIMELINE (trajetória — carrossel quando >4 marcos) ---------- */
  const timelineEl = document.querySelector('.timeline__swiper');
  if (timelineEl) {
    new Swiper(timelineEl, {
      slidesPerView: 1.15,
      spaceBetween: 16,
      grabCursor: true,
      speed: 600,
      breakpoints: {
        640:  { slidesPerView: 2, spaceBetween: 20 },
        1024: { slidesPerView: 4, spaceBetween: 24 },
      },
      pagination: {
        el: '.timeline__pagination',
        clickable: true,
      },
      a11y: {
        prevSlideMessage: 'Marco anterior',
        nextSlideMessage: 'Próximo marco',
      },
    });
  }

  /* ---------- DEPOIMENTOS: "Ver mais" para textos longos ----------
     A citação é limitada a 6 linhas via CSS (-webkit-line-clamp). Aqui
     medimos cada card: se o texto estoura, injetamos um botão "Ver mais"
     que expande/recolhe. Cards curtos não recebem botão (sem poluição). */
  function initTestiReadMore(root, swiper) {
    const items = root.querySelectorAll('.testi__item');
    if (!items.length) return;

    const chevron =
      '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>';

    const setLabel = (btn, expanded) => {
      btn.setAttribute('aria-expanded', String(expanded));
      btn.querySelector('.testi__more-label').textContent = expanded ? 'Ver menos' : 'Ver mais';
    };

    const refresh = () => {
      items.forEach((item) => {
        const quote = item.querySelector('.testi__quote');
        if (!quote) return;
        let btn = item.querySelector('.testi__more');
        const wasExpanded = item.classList.contains('is-expanded');

        // Mede sempre no estado recolhido (senão clientHeight == scrollHeight)
        item.classList.remove('is-expanded');
        const overflowing = quote.scrollHeight - quote.clientHeight > 6;

        if (overflowing) {
          if (!btn) {
            btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'testi__more';
            btn.innerHTML = '<span class="testi__more-label">Ver mais</span>' + chevron;
            quote.insertAdjacentElement('afterend', btn);
            btn.addEventListener('click', () => {
              const expanded = item.classList.toggle('is-expanded');
              setLabel(btn, expanded);
              if (swiper && typeof swiper.update === 'function') swiper.update();
            });
          }
          // Restaura o estado anterior (resize não deve recolher o que estava aberto)
          if (wasExpanded) item.classList.add('is-expanded');
          setLabel(btn, wasExpanded);
        } else if (btn) {
          // Ficou largo o suficiente (ex.: resize) e não estoura mais → remove botão
          btn.remove();
        }
      });
      if (swiper && typeof swiper.update === 'function') swiper.update();
    };

    // Mede depois das fontes carregarem (Cormorant muda a contagem de linhas)
    if (document.fonts && document.fonts.ready) {
      document.fonts.ready.then(() => requestAnimationFrame(refresh));
    } else {
      window.addEventListener('load', refresh);
    }

    let resizeTimer;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(refresh, 200);
    });
  }
})();
