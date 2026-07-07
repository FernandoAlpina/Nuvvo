/* ============================================================
   POLÍTICA DE PRIVACIDADE — scroll spy do sumário
   - Destaca o item ativo conforme a seção entra na viewport
   - Suporta sumário sticky (desktop) e accordion (mobile)
   ============================================================ */

(() => {
  'use strict';

  const sections = document.querySelectorAll('.policy-body section[id]');
  const tocLinks = document.querySelectorAll('.toc-nav__link');

  if (!sections.length || !tocLinks.length) return;

  const linkByHash = new Map();
  tocLinks.forEach((link) => {
    const hash = link.getAttribute('href')?.replace('#', '');
    if (hash) linkByHash.set(hash, link);
  });

  let currentActiveId = null;
  const setActive = (id) => {
    if (id === currentActiveId) return;
    currentActiveId = id;
    tocLinks.forEach((link) => link.classList.remove('is-active'));
    const link = linkByHash.get(id);
    if (link) link.classList.add('is-active');
  };

  // Observer: detecta qual seção está mais visível
  const io = new IntersectionObserver(
    (entries) => {
      // Pega a entry mais visível (maior intersectionRatio)
      const visible = entries
        .filter(e => e.isIntersecting)
        .sort((a, b) => b.intersectionRatio - a.intersectionRatio);
      if (visible.length > 0) {
        setActive(visible[0].target.id);
      }
    },
    {
      rootMargin: '-100px 0px -55% 0px',
      threshold: [0, 0.25, 0.5, 0.75, 1],
    }
  );

  sections.forEach((sec) => io.observe(sec));

  // Click em link do sumário (mobile/desktop): fechar accordion mobile após click
  tocLinks.forEach((link) => {
    link.addEventListener('click', () => {
      const accordion = link.closest('details.toc-nav--mobile');
      if (accordion) {
        // Fecha depois do scroll
        setTimeout(() => { accordion.open = false; }, 400);
      }
    });
  });
})();
