/* ============================================================
   BLOG LISTAGEM — filtros + load-more + transição do banner de categoria
   ============================================================ */

(() => {
  'use strict';

  const grid       = document.querySelector('[data-blog-grid]');
  const chipsBar   = document.querySelector('[data-filter-chips]');
  const resultsEl  = document.querySelector('[data-filter-results]');
  const loadMore   = document.querySelector('[data-load-more]');
  const emptyEl    = document.querySelector('[data-blog-empty]');
  const banner     = document.querySelector('[data-category-banner]');
  const filterBar  = document.querySelector('.filter-bar');

  if (!grid) return;

  const BATCH = 6; // posts adicionais por clique
  let currentCategory = 'todos';
  let renderedCount   = 0;
  let visibleItems    = [];
  const allItems      = Array.from(grid.querySelectorAll('.post-card'));

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

    allItems.forEach((el) => {
      el.classList.add('is-filtered', 'is-deferred');
      el.classList.remove('is-entering');
    });

    renderBatch(animate);
    updateChips(cat);
    updateResults();
    updateBanner(cat);
    setURL(cat);
  };

  const renderBatch = (animate = true) => {
    // No load inicial, mostra o featured + BATCH posts; depois, só posts normais
    const featuredFirst = visibleItems.find(el => el.classList.contains('post-card--featured'));
    const normal = visibleItems.filter(el => !el.classList.contains('post-card--featured'));

    let toRender = [];
    if (renderedCount === 0 && featuredFirst) {
      toRender = [featuredFirst, ...normal.slice(0, BATCH)];
      renderedCount = toRender.length;
    } else {
      const slice = normal.slice(renderedCount - (featuredFirst ? 1 : 0), renderedCount - (featuredFirst ? 1 : 0) + BATCH);
      toRender = slice;
      renderedCount += slice.length;
    }

    toRender.forEach((el, idx) => {
      el.classList.remove('is-filtered', 'is-deferred');
      if (animate) {
        el.style.animationDelay = `${idx * 60}ms`;
        el.classList.add('is-entering');
        setTimeout(() => el.classList.remove('is-entering'), 500 + idx * 60);
      }
    });
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
    if (n === 0)      resultsEl.textContent = 'nenhum post';
    else if (n === 1) resultsEl.textContent = '1 post';
    else              resultsEl.textContent = `${n} posts`;
  };

  const updateBanner = (cat) => {
    if (!banner) return;
    const next = banner.querySelector(`[data-banner-cat="${cat}"]`);
    const all  = banner.querySelectorAll('[data-banner-cat]');
    if (!next) return;
    banner.classList.add('is-changing');
    setTimeout(() => {
      all.forEach(el => el.hidden = true);
      next.hidden = false;
      banner.classList.remove('is-changing');
    }, 180);
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
    setTimeout(() => renderBatch(true), 280);
  });

  /* ---------- Sticky filter bar shadow on scroll ---------- */
  if (filterBar) {
    const sentinel = document.createElement('div');
    sentinel.style.cssText = 'height: 1px; position: absolute; top: 0;';
    filterBar.parentNode.insertBefore(sentinel, filterBar);
    const stickyIO = new IntersectionObserver(([entry]) => {
      filterBar.classList.toggle('is-stuck', !entry.isIntersecting);
    }, { threshold: [0] });
    stickyIO.observe(sentinel);
  }

  /* ---------- Init ---------- */
  applyFilter(currentCategory, false);
})();
