/* ============================================================
   INSPIRE-SE — galeria com filtros, load-more e lightbox
   ============================================================ */

(() => {
  'use strict';

  const grid       = document.querySelector('[data-gallery]');
  const chipsBar   = document.querySelector('[data-filter-chips]');
  const resultsEl  = document.querySelector('[data-filter-results]');
  const loadMore   = document.querySelector('[data-load-more]');
  const emptyEl    = document.querySelector('[data-gallery-empty]');
  const filterBar  = document.querySelector('.filter-bar');

  if (!grid) return;

  const BATCH = 12;
  let currentCategory = 'todos';
  let renderedCount   = 0;
  let visibleItems    = [];
  const allItems      = Array.from(grid.querySelectorAll('.gallery-item'));

  /* ---------- URL query support ---------- */
  const params = new URLSearchParams(window.location.search);
  const startCategory = params.get('categoria');
  if (startCategory) currentCategory = startCategory.toLowerCase();

  const setURL = (cat) => {
    const url = new URL(window.location.href);
    if (cat === 'todos') url.searchParams.delete('categoria');
    else url.searchParams.set('categoria', cat);
    window.history.replaceState({}, '', url);
  };

  /* ---------- Filter logic ---------- */
  const applyFilter = (cat, animate = true) => {
    currentCategory = cat;
    visibleItems = allItems.filter((el) => {
      const cats = (el.dataset.category || '').split(',').map(s => s.trim().toLowerCase());
      return cat === 'todos' || cats.includes(cat);
    });
    renderedCount = 0;

    // Esconde todos
    allItems.forEach((el) => {
      el.classList.add('is-filtered');
      el.classList.add('is-deferred');
      el.classList.remove('is-entering');
    });

    renderBatch(animate);
    updateChips(cat);
    updateResults();
    setURL(cat);
  };

  const renderBatch = (animate = true) => {
    const nextSlice = visibleItems.slice(renderedCount, renderedCount + BATCH);
    nextSlice.forEach((el, idx) => {
      el.classList.remove('is-filtered');
      el.classList.remove('is-deferred');
      if (animate) {
        el.style.animationDelay = `${idx * 40}ms`;
        el.classList.add('is-entering');
        // limpar após a animação
        setTimeout(() => el.classList.remove('is-entering'), 500 + idx * 40);
      }
    });
    renderedCount += nextSlice.length;
    updateLoadMore();
    toggleEmpty();
  };

  const updateChips = (cat) => {
    chipsBar?.querySelectorAll('.filter-chip').forEach((chip) => {
      const pressed = (chip.dataset.filter || '').toLowerCase() === cat;
      chip.setAttribute('aria-pressed', pressed ? 'true' : 'false');
    });
  };

  const updateResults = () => {
    if (!resultsEl) return;
    const n = visibleItems.length;
    if (n === 0) resultsEl.textContent = 'nenhum resultado';
    else if (n === 1) resultsEl.textContent = '1 ambiente';
    else resultsEl.textContent = `${n} ambientes`;
  };

  const updateLoadMore = () => {
    if (!loadMore) return;
    if (renderedCount >= visibleItems.length) loadMore.setAttribute('hidden', '');
    else loadMore.removeAttribute('hidden');
    loadMore.classList.remove('is-loading');
  };

  const toggleEmpty = () => {
    if (!emptyEl) return;
    if (visibleItems.length === 0) emptyEl.removeAttribute('hidden');
    else emptyEl.setAttribute('hidden', '');
  };

  /* ---------- Chips clicks ---------- */
  chipsBar?.querySelectorAll('.filter-chip').forEach((chip) => {
    chip.addEventListener('click', () => {
      const cat = (chip.dataset.filter || 'todos').toLowerCase();
      if (cat === currentCategory) return;
      applyFilter(cat);
    });
  });

  /* ---------- Empty state CTA ---------- */
  document.querySelector('[data-show-all]')?.addEventListener('click', (e) => {
    e.preventDefault();
    applyFilter('todos');
    filterBar?.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  /* ---------- Load more ---------- */
  loadMore?.addEventListener('click', () => {
    loadMore.classList.add('is-loading');
    // simula latência sutil pra dar feedback (300ms — em prod real seria fetch)
    setTimeout(() => renderBatch(true), 280);
  });

  /* ---------- Sticky filter bar shadow on scroll ---------- */
  if (filterBar) {
    const sentinel = document.createElement('div');
    sentinel.style.height = '1px';
    sentinel.style.position = 'absolute';
    sentinel.style.top = '0';
    filterBar.parentNode.insertBefore(sentinel, filterBar);
    const stickyIO = new IntersectionObserver(([entry]) => {
      filterBar.classList.toggle('is-stuck', !entry.isIntersecting);
    }, { threshold: [0], rootMargin: '0px 0px 0px 0px' });
    stickyIO.observe(sentinel);
  }

  /* ============================================================
     LIGHTBOX
     ============================================================ */
  const lightbox    = document.querySelector('[data-lightbox]');
  const lbStage     = lightbox?.querySelector('.lightbox__img-wrap');
  const lbCounter   = lightbox?.querySelector('.lightbox__counter');
  const lbPrev      = lightbox?.querySelector('.lightbox__prev');
  const lbNext      = lightbox?.querySelector('.lightbox__next');
  const lbClose     = lightbox?.querySelector('.lightbox__close');

  let lbIndex     = 0;
  let lbReturnFocus = null;

  const renderLightbox = () => {
    if (!visibleItems[lbIndex]) return;
    const src = visibleItems[lbIndex];
    const img = src.querySelector('img');
    const svg = src.querySelector('svg');

    lbStage.innerHTML = '';
    if (img) {
      const big = document.createElement('img');
      big.src   = img.dataset.full || img.src;
      big.alt   = img.alt || '';
      big.className = 'lightbox__img';
      lbStage.appendChild(big);
    } else if (svg) {
      const clone = svg.cloneNode(true);
      clone.classList.add('lightbox__svg');
      clone.removeAttribute('width');
      clone.removeAttribute('height');
      clone.style.maxWidth = 'min(720px, 90vw)';
      clone.style.maxHeight = '90vh';
      lbStage.appendChild(clone);
    }

    lbCounter.textContent = `${lbIndex + 1} / ${visibleItems.length}`;
    lbPrev.disabled = lbIndex === 0;
    lbNext.disabled = lbIndex === visibleItems.length - 1;
  };

  const openLightbox = (item) => {
    lbIndex = visibleItems.indexOf(item);
    if (lbIndex < 0) return;
    lbReturnFocus = item;
    lightbox.classList.add('is-open');
    lightbox.removeAttribute('aria-hidden');
    document.body.classList.add('lightbox-open');
    if (window.__lenis) window.__lenis.stop();
    renderLightbox();
    lbClose.focus();
  };

  const closeLightbox = () => {
    lightbox.classList.remove('is-open');
    lightbox.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('lightbox-open');
    if (window.__lenis) window.__lenis.start();
    if (lbReturnFocus) lbReturnFocus.focus();
  };

  const navLightbox = (delta) => {
    const next = lbIndex + delta;
    if (next < 0 || next >= visibleItems.length) return;
    lbIndex = next;
    renderLightbox();
  };

  // Bind clique nos items
  allItems.forEach((item) => {
    item.addEventListener('click', () => {
      // só abre se está visível
      if (!visibleItems.includes(item)) return;
      openLightbox(item);
    });
  });

  // Bind botões
  lbPrev?.addEventListener('click', () => navLightbox(-1));
  lbNext?.addEventListener('click', () => navLightbox(1));
  lbClose?.addEventListener('click', closeLightbox);

  // Bind keyboard
  window.addEventListener('keydown', (e) => {
    if (!lightbox?.classList.contains('is-open')) return;
    if (e.key === 'Escape') closeLightbox();
    else if (e.key === 'ArrowLeft') navLightbox(-1);
    else if (e.key === 'ArrowRight') navLightbox(1);
    else if (e.key === 'Tab') {
      // focus trap simples — só temos 3 botões focáveis
      const focusables = [lbClose, lbPrev, lbNext].filter(Boolean);
      const i = focusables.indexOf(document.activeElement);
      if (e.shiftKey) {
        if (i <= 0) { e.preventDefault(); focusables[focusables.length - 1].focus(); }
      } else {
        if (i === focusables.length - 1 || i === -1) { e.preventDefault(); focusables[0].focus(); }
      }
    }
  });

  // Click no fundo (overlay) fecha
  lightbox?.addEventListener('click', (e) => {
    if (e.target === lightbox) closeLightbox();
  });

  /* ---------- Init ---------- */
  applyFilter(currentCategory, false);
})();
