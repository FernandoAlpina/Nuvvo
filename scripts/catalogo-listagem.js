/* ============================================================
   CATÁLOGO LISTAGEM — filtros (subcat) + load-more
   ============================================================ */

(() => {
  'use strict';

  const grid       = document.querySelector('[data-catalog-grid]');
  const chipsBar   = document.querySelector('[data-subcat-chips]');
  const resultsEl  = document.querySelector('[data-results-count]');
  const loadMore   = document.querySelector('[data-load-more]');
  const emptyEl    = document.querySelector('[data-empty-state]');
  const filterBar  = document.querySelector('.catalog-filter-bar');

  if (!grid) return;

  const BATCH = 9;
  let currentSub  = 'todos';
  let renderedCount = 0;
  let visibleItems  = [];
  const allItems    = Array.from(grid.querySelectorAll('.card-prod'));

  /* ---------- URL query support ---------- */
  const params = new URLSearchParams(window.location.search);
  if (params.get('subcategoria')) currentSub = params.get('subcategoria').toLowerCase();

  const setURL = () => {
    const url = new URL(window.location.href);
    if (currentSub === 'todos') url.searchParams.delete('subcategoria');
    else url.searchParams.set('subcategoria', currentSub);
    window.history.replaceState({}, '', url);
  };

  /* ---------- Filter + Search ---------- */
  const matchesFilter = (el) => {
    const subs = (el.dataset.subcategory || '').split(',').map(s => s.trim().toLowerCase()).filter(Boolean);
    return currentSub === 'todos' || subs.includes(currentSub);
  };

  const apply = (animate = true) => {
    visibleItems = allItems.filter(matchesFilter);
    renderedCount = 0;

    allItems.forEach((el) => {
      el.classList.add('is-filtered', 'is-deferred');
      el.classList.remove('is-entering');
    });

    renderBatch(animate);
    updateChips();
    updateResults();
    setURL();
  };

  const renderBatch = (animate = true) => {
    const slice = visibleItems.slice(renderedCount, renderedCount + BATCH);
    slice.forEach((el, idx) => {
      el.classList.remove('is-filtered', 'is-deferred');
      if (animate) {
        el.style.animationDelay = `${idx * 60}ms`;
        el.classList.add('is-entering');
        setTimeout(() => el.classList.remove('is-entering'), 500 + idx * 60);
      }
    });
    renderedCount += slice.length;
    updateLoadMore();
    toggleEmpty();
  };

  const updateChips = () => {
    chipsBar?.querySelectorAll('.filter-chip').forEach((chip) => {
      const pressed = (chip.dataset.filter || '').toLowerCase() === currentSub;
      chip.setAttribute('aria-pressed', pressed ? 'true' : 'false');
    });
  };

  const updateResults = () => {
    if (!resultsEl) return;
    const n = visibleItems.length;
    if (n === 0)      resultsEl.textContent = 'nenhum produto';
    else if (n === 1) resultsEl.textContent = '1 produto';
    else              resultsEl.textContent = `${n} produtos`;
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

  /* ---------- Chips ---------- */
  chipsBar?.querySelectorAll('.filter-chip').forEach((chip) => {
    chip.addEventListener('click', () => {
      const sub = (chip.dataset.filter || 'todos').toLowerCase();
      if (sub === currentSub) return;
      currentSub = sub;
      apply();
    });
  });

  /* ---------- Empty state CTAs ---------- */
  document.querySelector('[data-clear-filters]')?.addEventListener('click', (e) => {
    e.preventDefault();
    currentSub = 'todos';
    apply();
    filterBar?.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  /* ---------- Load more ---------- */
  loadMore?.addEventListener('click', () => {
    loadMore.classList.add('is-loading');
    setTimeout(() => renderBatch(true), 280);
  });

  /* ---------- Sticky shadow ---------- */
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
  apply(false);
})();
