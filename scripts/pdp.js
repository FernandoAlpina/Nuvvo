/* ============================================================
   PDP — sticky info + hotspots/modais + módulos + drawing + mobile bar
   ============================================================ */

(() => {
  'use strict';

  /* ---------- TECH HOTSPOTS + MODAL ---------- */
  const techModal = document.querySelector('[data-tech-modal]');
  const techModalTitle = techModal?.querySelector('.tech-modal__title');
  const techModalBody  = techModal?.querySelector('.tech-modal__body');
  const techModalNum   = techModal?.querySelector('.tech-modal__num');
  const techModalClose = techModal?.querySelector('.tech-modal__close');
  let techReturnFocus = null;

  const openTechModal = (data, returnEl) => {
    if (!techModal) return;
    techModalNum.textContent = `Detalhe ${data.num}`;
    techModalTitle.textContent = data.title;
    techModalBody.textContent = data.body;
    techModal.classList.add('is-open');
    techModal.removeAttribute('aria-hidden');
    document.body.classList.add('cookie-modal-open');
    techReturnFocus = returnEl;
    setTimeout(() => techModalClose?.focus(), 50);
  };

  const closeTechModal = () => {
    if (!techModal) return;
    techModal.classList.remove('is-open');
    techModal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('cookie-modal-open');
    if (techReturnFocus) techReturnFocus.focus();
  };

  document.querySelectorAll('.tech-hotspot').forEach((spot) => {
    spot.addEventListener('click', () => {
      openTechModal({
        num:   spot.dataset.num,
        title: spot.dataset.title,
        body:  spot.dataset.body,
      }, spot);
    });
  });

  techModalClose?.addEventListener('click', closeTechModal);
  techModal?.addEventListener('click', (e) => { if (e.target === techModal) closeTechModal(); });
  window.addEventListener('keydown', (e) => {
    if (techModal?.classList.contains('is-open')) {
      if (e.key === 'Escape') closeTechModal();
      else if (e.key === 'Tab') {
        // focus trap simples
        e.preventDefault();
        techModalClose?.focus();
      }
    }
  });

  /* ---------- DIMENSIONS SELECTOR (módulos) ---------- */
  const modules = {
    '190': { width: 190, cushions: 6 },
    '210': { width: 210, cushions: 7 },
    '230': { width: 230, cushions: 8 },
    '250': { width: 250, cushions: 9 },
  };

  const modChips = document.querySelectorAll('[data-module-chip]');
  const modPanel = document.querySelector('[data-module-panel]');

  const renderModule = (key) => {
    if (!modules[key] || !modPanel) return;
    const m = modules[key];
    modPanel.innerHTML = `
      <strong>${m.width} cm</strong>
      ${m.cushions} almofadas 45 × 45 cm · profundidade 100 cm · altura 80 cm
    `;
    modChips.forEach(c => c.setAttribute('aria-pressed', c.dataset.moduleChip === key ? 'true' : 'false'));
  };

  modChips.forEach((chip) => {
    chip.addEventListener('click', () => renderModule(chip.dataset.moduleChip));
  });

  // Init com primeiro módulo
  if (modChips.length) renderModule('190');

  /* ---------- TECH DRAWING animation on scroll ---------- */
  const dimSection = document.querySelector('.dim-section');
  if (dimSection) {
    const io = new IntersectionObserver(([entry]) => {
      if (entry.isIntersecting) {
        dimSection.classList.add('is-visible');
        io.unobserve(dimSection);
      }
    }, { threshold: 0.35 });
    io.observe(dimSection);
  }

  /* ---------- PDP GALLERY + HERO MEDIA → LIGHTBOX ---------- */
  // Reutiliza a estrutura do lightbox da página Inspire-se
  const lightbox = document.querySelector('[data-pdp-lightbox]');
  const lbStage  = lightbox?.querySelector('.lightbox__img-wrap');
  const lbPrev   = lightbox?.querySelector('.lightbox__prev');
  const lbNext   = lightbox?.querySelector('.lightbox__next');
  const lbClose  = lightbox?.querySelector('.lightbox__close');
  const lbCounter = lightbox?.querySelector('.lightbox__counter');

  // Coleta todas as imagens (hero media + galeria) em ordem
  const lbItems = Array.from(document.querySelectorAll('[data-lb-trigger]'));
  let lbIndex = 0;
  let lbReturnFocus = null;

  const renderLb = () => {
    if (!lbItems[lbIndex]) return;
    const img = lbItems[lbIndex].querySelector('img');
    if (!img) return;
    lbStage.innerHTML = '';
    const big = document.createElement('img');
    big.src = img.dataset.full || img.src;
    big.alt = img.alt || '';
    big.className = 'lightbox__img';
    lbStage.appendChild(big);
    lbCounter.textContent = `${lbIndex + 1} / ${lbItems.length}`;
    lbPrev.disabled = lbIndex === 0;
    lbNext.disabled = lbIndex === lbItems.length - 1;
  };

  const openLb = (idx, src) => {
    lbIndex = idx;
    lbReturnFocus = src;
    lightbox?.classList.add('is-open');
    lightbox?.removeAttribute('aria-hidden');
    document.body.classList.add('lightbox-open');
    if (window.__lenis) window.__lenis.stop();
    renderLb();
    lbClose?.focus();
  };
  const closeLb = () => {
    lightbox?.classList.remove('is-open');
    lightbox?.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('lightbox-open');
    if (window.__lenis) window.__lenis.start();
    lbReturnFocus?.focus();
  };
  const navLb = (delta) => {
    const n = lbIndex + delta;
    if (n < 0 || n >= lbItems.length) return;
    lbIndex = n;
    renderLb();
  };

  lbItems.forEach((item, idx) => {
    item.addEventListener('click', () => openLb(idx, item));
  });
  lbPrev?.addEventListener('click', () => navLb(-1));
  lbNext?.addEventListener('click', () => navLb(1));
  lbClose?.addEventListener('click', closeLb);
  lightbox?.addEventListener('click', (e) => { if (e.target === lightbox) closeLb(); });

  window.addEventListener('keydown', (e) => {
    if (!lightbox?.classList.contains('is-open')) return;
    if (e.key === 'Escape') closeLb();
    else if (e.key === 'ArrowLeft') navLb(-1);
    else if (e.key === 'ArrowRight') navLb(1);
  });
})();
