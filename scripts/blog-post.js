/* ============================================================
   BLOG POST — share bar + copy link + sticky behavior
   ============================================================ */

(() => {
  'use strict';

  const url   = window.location.href;
  const title = document.title.split(' | ')[0];

  /* ---------- Botões de compartilhar ---------- */
  document.querySelectorAll('[data-share]').forEach((btn) => {
    const platform = btn.dataset.share;
    let href = '';

    switch (platform) {
      case 'whatsapp':
        href = `https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`;
        break;
      case 'linkedin':
        href = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
        break;
      case 'facebook':
        href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
        break;
    }

    if (href) {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        window.open(href, '_blank', 'noopener,width=600,height=500');
      });
    }
  });

  /* ---------- Copiar link ---------- */
  document.querySelectorAll('[data-share-copy]').forEach((btn) => {
    btn.addEventListener('click', async () => {
      try {
        await navigator.clipboard.writeText(url);
      } catch {
        const ta = document.createElement('textarea');
        ta.value = url;
        ta.style.position = 'fixed';
        ta.style.opacity = '0';
        document.body.appendChild(ta);
        ta.select();
        try { document.execCommand('copy'); } catch (_) {}
        document.body.removeChild(ta);
      }
      btn.dataset.copied = 'true';
      clearTimeout(btn._t);
      btn._t = setTimeout(() => { delete btn.dataset.copied; }, 2200);
    });
  });

  /* ---------- Estimar tempo de leitura (caso elemento esteja sem valor) ---------- */
  const timeEl = document.querySelector('[data-reading-time]');
  if (timeEl && !timeEl.dataset.readingTime) {
    const body = document.querySelector('.post-body');
    if (body) {
      const wpm = 200;
      const words = body.innerText.trim().split(/\s+/).length;
      const minutes = Math.max(1, Math.round(words / wpm));
      timeEl.textContent = `${minutes} min de leitura`;
    }
  }
})();
