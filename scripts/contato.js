/* ============================================================
   CONTATO — scripts específicos
   - Lazy load do mapa (Google Maps via iframe, só após clique = LGPD-friendly)
   - Copiar endereço com feedback visual
   ============================================================ */

(() => {
  'use strict';

  /* ---------- LAZY MAP ---------- */
  document.querySelectorAll('.map-block').forEach((block) => {
    const placeholder = block.querySelector('.map-block__placeholder');
    if (!placeholder) return;

    const load = () => {
      const src = block.dataset.mapSrc;
      if (!src) return;
      const iframe = document.createElement('iframe');
      iframe.src = src;
      iframe.className = 'map-block__iframe';
      iframe.loading = 'lazy';
      iframe.title = 'Mapa do Studio Nuvvo Design — Marau/RS';
      iframe.setAttribute('referrerpolicy', 'no-referrer-when-downgrade');
      iframe.allowFullscreen = true;
      block.innerHTML = '';
      block.appendChild(iframe);
      block.classList.add('is-loaded');
    };

    placeholder.addEventListener('click', load);
    placeholder.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        load();
      }
    });
  });

  /* ---------- COPIAR ENDEREÇO ---------- */
  document.querySelectorAll('[data-copy-address]').forEach((btn) => {
    btn.addEventListener('click', async () => {
      const address = btn.dataset.copyAddress;
      if (!address) return;

      const block = btn.closest('.address-block');

      try {
        await navigator.clipboard.writeText(address);
      } catch {
        // Fallback antigo (textarea)
        const ta = document.createElement('textarea');
        ta.value = address;
        ta.style.position = 'fixed';
        ta.style.opacity = '0';
        document.body.appendChild(ta);
        ta.select();
        try { document.execCommand('copy'); } catch (_) { /* nope */ }
        document.body.removeChild(ta);
      }

      if (block) {
        block.classList.add('is-copied');
        clearTimeout(block._copyTimer);
        block._copyTimer = setTimeout(() => {
          block.classList.remove('is-copied');
        }, 2200);
      }
    });
  });
})();
