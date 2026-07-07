/* ============================================================
   CATÁLOGO HUB — carrosséis de diferenciais e inspire-se
   ============================================================ */

(() => {
  'use strict';
  if (!window.Swiper) return;

  /* ---------- DIFERENCIAIS (5 cards) ---------- */
  const featuresEl = document.querySelector('.cat-features__swiper');
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
        nextEl: '.cat-features__next',
        prevEl: '.cat-features__prev',
      },
      pagination: { el: '.cat-features__pagination', clickable: true },
      a11y: { prevSlideMessage: 'Diferencial anterior', nextSlideMessage: 'Próximo diferencial' },
    });
  }

  /* ---------- INSPIRE-SE prévia ---------- */
  const inspireEl = document.querySelector('.cat-inspire__swiper');
  if (inspireEl) {
    new Swiper(inspireEl, {
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
        nextEl: '.cat-inspire__next',
        prevEl: '.cat-inspire__prev',
      },
      a11y: { prevSlideMessage: 'Imagem anterior', nextSlideMessage: 'Próxima imagem' },
    });
  }
})();
