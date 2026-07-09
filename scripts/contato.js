/* ============================================================
   CONTATO — scripts específicos
   - Lazy load do mapa, só após clique = LGPD-friendly:
       • com chave da Google Maps JS API → mapa nas cores da marca
       • sem chave → embed padrão do Google (iframe)
   - Copiar endereço com feedback visual
   ============================================================ */

(() => {
  'use strict';

  /* Estilo do mapa — paleta da marca (preto / branco / marrom). */
  const NUVVO_MAP_STYLE = [
    { elementType: 'geometry', stylers: [{ color: '#efece3' }] },
    { elementType: 'labels.text.fill', stylers: [{ color: '#7a6b5c' }] },
    { elementType: 'labels.text.stroke', stylers: [{ color: '#efece3' }, { weight: 2 }] },
    { elementType: 'labels.icon', stylers: [{ visibility: 'off' }] },
    { featureType: 'administrative', elementType: 'geometry', stylers: [{ color: '#c4b6a5' }] },
    { featureType: 'administrative.land_parcel', stylers: [{ visibility: 'off' }] },
    { featureType: 'poi', stylers: [{ visibility: 'off' }] },
    { featureType: 'transit', stylers: [{ visibility: 'off' }] },
    { featureType: 'landscape.man_made', elementType: 'geometry', stylers: [{ color: '#e6e1d5' }] },
    { featureType: 'road', elementType: 'geometry', stylers: [{ color: '#ffffff' }] },
    { featureType: 'road', elementType: 'geometry.stroke', stylers: [{ color: '#e2ddd1' }] },
    { featureType: 'road.arterial', elementType: 'geometry', stylers: [{ color: '#f5f2ea' }] },
    { featureType: 'road.highway', elementType: 'geometry', stylers: [{ color: '#c4b6a5' }] },
    { featureType: 'road.highway', elementType: 'geometry.stroke', stylers: [{ color: '#b0a08e' }] },
    { featureType: 'water', elementType: 'geometry', stylers: [{ color: '#9f8d7a' }] },
    { featureType: 'water', elementType: 'labels.text.fill', stylers: [{ color: '#ffffff' }] },
  ];

  let gmapsPromise = null;

  /* Carrega o script da Google Maps JS API uma única vez.
     Usa o callback oficial → garante que google.maps esteja pronto. */
  function loadGoogleMaps(key) {
    if (window.google && window.google.maps) return Promise.resolve();
    if (gmapsPromise) return gmapsPromise;
    gmapsPromise = new Promise((resolve, reject) => {
      window.__nuvvoGmapsReady = () => resolve();
      const s = document.createElement('script');
      s.src = 'https://maps.googleapis.com/maps/api/js?key=' + encodeURIComponent(key) + '&loading=async&callback=__nuvvoGmapsReady';
      s.async = true;
      s.onerror = reject;
      document.head.appendChild(s);
    });
    return gmapsPromise;
  }

  /* Renderiza o embed padrão do Google (iframe). */
  function renderIframe(block) {
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
  }

  /* Renderiza o mapa estilizado. Retorna false se faltam dados (chave/coords). */
  function renderStyledMap(block) {
    const key = block.dataset.mapKey;
    const lat = parseFloat(block.dataset.mapLat);
    const lng = parseFloat(block.dataset.mapLng);
    if (!key || Number.isNaN(lat) || Number.isNaN(lng)) return false;

    const canvas = document.createElement('div');
    canvas.className = 'map-block__canvas';
    block.innerHTML = '';
    block.appendChild(canvas);
    block.classList.add('is-loaded');

    loadGoogleMaps(key)
      .then(() => {
        const pos = { lat, lng };
        const map = new google.maps.Map(canvas, {
          center: pos,
          zoom: 15,
          styles: NUVVO_MAP_STYLE,
          mapTypeControl: false,
          streetViewControl: false,
          fullscreenControl: true,
          zoomControl: true,
        });
        new google.maps.Marker({ position: pos, map, title: 'Nuvvo Design' });
      })
      .catch(() => {
        // Falhou (chave inválida/offline): cai para o embed, se houver.
        block.classList.remove('is-loaded');
        renderIframe(block);
      });

    return true;
  }

  /* ---------- LAZY MAP ---------- */
  document.querySelectorAll('.map-block').forEach((block) => {
    const placeholder = block.querySelector('.map-block__placeholder');
    if (!placeholder) return;

    const load = () => {
      if (block.classList.contains('is-loaded')) return;
      if (!renderStyledMap(block)) renderIframe(block);
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
