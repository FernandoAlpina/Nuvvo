/* ============================================================
   MAIN — init geral
   - Lenis smooth scroll
   - Header scroll behavior (sticky transparente → cream)
   - Mobile menu toggle
   - Dropdown Catálogo
   - Skip link focus
   ============================================================ */

(() => {
  'use strict';

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- LENIS smooth scroll ---------- */
  let lenis = null;
  if (window.Lenis && !prefersReducedMotion) {
    lenis = new window.Lenis({
      duration: 1.1,
      easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
      smoothWheel: true,
      smoothTouch: false,
      wheelMultiplier: 1,
      touchMultiplier: 1.2,
    });

    function raf(time) {
      lenis.raf(time);
      requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);

    // expor para outros módulos
    window.__lenis = lenis;
  }

  /* ---------- HEADER scroll behavior ----------
     Header com data-static-header fica sempre is-scrolled (páginas sem hero escuro). */
  const header = document.querySelector('.site-header');
  if (header) {
    const staticHeader = header.hasAttribute('data-static-header');
    if (staticHeader) {
      header.classList.add('is-scrolled');
    } else {
      const onScroll = () => {
        const y = window.scrollY;
        if (y > 24) header.classList.add('is-scrolled');
        else header.classList.remove('is-scrolled');
      };
      onScroll();
      window.addEventListener('scroll', onScroll, { passive: true });
    }
  }

  /* ---------- MOBILE MENU + DROPDOWN (acordeão) ---------- */
  const menuToggle = document.querySelector('.header__menu-toggle');
  const nav = document.querySelector('.header__nav');
  const body = document.body;
  const mqDesktop = window.matchMedia('(min-width: 1024px)');
  const dropdowns = [...document.querySelectorAll('.has-dropdown')];
  const bgInert = [...document.querySelectorAll('main, .site-footer')];

  const collapseDropdowns = () =>
    dropdowns.forEach((d) => d.setAttribute('aria-expanded', 'false'));

  if (menuToggle && nav) {
    const isOpen = () => body.classList.contains('menu-open');

    // elementos focáveis dentro do menu aberto (toggle + links visíveis)
    const focusables = () =>
      [menuToggle, ...nav.querySelectorAll('a[href], button:not([disabled])')]
        .filter((el) => el === menuToggle || el.offsetParent !== null);

    const openMenu = () => {
      body.classList.add('menu-open');
      menuToggle.setAttribute('aria-expanded', 'true');
      menuToggle.setAttribute('aria-label', 'Fechar menu');
      document.documentElement.style.overflow = 'hidden';
      if (lenis) lenis.stop();
      bgInert.forEach((el) => el.setAttribute('inert', ''));
      const firstLink = nav.querySelector('a[href]');
      if (firstLink) requestAnimationFrame(() => firstLink.focus());
    };

    const closeMenu = ({ restoreFocus = false } = {}) => {
      body.classList.remove('menu-open');
      menuToggle.setAttribute('aria-expanded', 'false');
      menuToggle.setAttribute('aria-label', 'Abrir menu');
      document.documentElement.style.overflow = '';
      if (lenis) lenis.start();
      bgInert.forEach((el) => el.removeAttribute('inert'));
      collapseDropdowns(); // acordeão volta recolhido na próxima abertura
      if (restoreFocus) menuToggle.focus();
    };

    menuToggle.addEventListener('click', () => {
      if (isOpen()) closeMenu({ restoreFocus: true });
      else openMenu();
    });

    // Escape fecha + Tab faz focus-trap (combinado com inert no fundo)
    document.addEventListener('keydown', (e) => {
      if (!isOpen()) return;
      if (e.key === 'Escape') { closeMenu({ restoreFocus: true }); return; }
      if (e.key === 'Tab') {
        const items = focusables();
        if (!items.length) return;
        const first = items[0];
        const last = items[items.length - 1];
        if (e.shiftKey && document.activeElement === first) {
          e.preventDefault(); last.focus();
        } else if (!e.shiftKey && document.activeElement === last) {
          e.preventDefault(); first.focus();
        }
      }
    });

    // Fecha ao clicar num link de navegação real (delegação pega o "Ver catálogo"
    // injetado depois). O gatilho do acordeão "Catálogo" NÃO fecha o menu.
    nav.addEventListener('click', (e) => {
      const link = e.target.closest('a');
      if (!link || !nav.contains(link)) return;
      const isAccordionTrigger =
        link.classList.contains('header__nav-link') &&
        link.parentElement.classList.contains('has-dropdown');
      if (isAccordionTrigger) return;
      if (isOpen()) closeMenu();
    });

    // Ao alargar pra desktop com o menu aberto, fecha sem mexer no foco
    mqDesktop.addEventListener('change', () => {
      if (mqDesktop.matches && isOpen()) closeMenu();
    });

    // bfcache / botão voltar: garante estado limpo ao reexibir a página
    window.addEventListener('pageshow', () => {
      if (isOpen()) {
        body.classList.remove('menu-open');
        document.documentElement.style.overflow = '';
        bgInert.forEach((el) => el.removeAttribute('inert'));
        collapseDropdowns();
      }
    });
  }

  /* ---------- DROPDOWN catálogo (hover desktop / acordeão mobile) ---------- */
  dropdowns.forEach((item) => {
    const trigger = item.querySelector('.header__nav-link');
    if (!trigger) return;

    const open = () => item.setAttribute('aria-expanded', 'true');
    const close = () => item.setAttribute('aria-expanded', 'false');

    // O mega-menu (cards de categoria com imagem por termo) é renderizado no
    // servidor pelo header.php. Aqui cuidamos só de abrir/fechar.

    // hover só no desktop
    item.addEventListener('mouseenter', () => { if (mqDesktop.matches) open(); });
    item.addEventListener('mouseleave', () => { if (mqDesktop.matches) close(); });

    // mobile: clique no gatilho alterna o acordeão (sem navegar)
    trigger.addEventListener('click', (e) => {
      if (!mqDesktop.matches) {
        e.preventDefault();
        if (item.getAttribute('aria-expanded') === 'true') close(); else open();
      }
    });

    // ESC recolhe o submenu (desktop)
    item.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') close();
    });
  });

  /* ---------- SCROLL ÂNCORAS ---------- */
  document.querySelectorAll('a[href^="#"]').forEach((a) => {
    a.addEventListener('click', (e) => {
      const id = a.getAttribute('href');
      if (id.length <= 1) return;
      const el = document.querySelector(id);
      if (!el) return;
      e.preventDefault();
      if (lenis) lenis.scrollTo(el, { offset: -80 });
      else el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });

  /* ---------- VÍDEO institucional (lazy-load do embed ao clicar no play) ----------
     Componente compartilhado (Home + A Nuvvo). Sem .video-block na página → no-op. */
  document.querySelectorAll('.video-block').forEach((block) => {
    const handler = (e) => {
      e.preventDefault();
      const src    = block.dataset.videoSrc;
      const type   = block.dataset.videoType || 'iframe'; // 'iframe' (YouTube/Vimeo) | 'mp4' (local)
      const poster = block.dataset.videoPoster;

      if (!src) {
        // Sem src configurado — mostra mensagem discreta
        const label = block.querySelector('.video-block__label');
        if (label) label.textContent = 'Vídeo em breve';
        return;
      }

      let embed;
      if (type === 'mp4') {
        embed = document.createElement('video');
        embed.src = src;
        embed.controls = true;
        embed.autoplay = true;
        embed.playsInline = true;
        if (poster) embed.poster = poster;
        embed.className = 'video-block__embed';
      } else {
        embed = document.createElement('iframe');
        embed.src = src + (src.includes('?') ? '&' : '?') + 'autoplay=1';
        embed.title = 'Vídeo institucional Nuvvo Design';
        embed.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
        embed.allowFullscreen = true;
        embed.className = 'video-block__embed';
      }

      // Substitui o conteúdo do block pelo embed
      block.innerHTML = '';
      block.appendChild(embed);
      block.classList.add('is-playing');
    };

    block.addEventListener('click', handler);
    block.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') handler(e);
    });
  });

  /* ---------- YEAR no footer ---------- */
  const yearEl = document.querySelector('[data-year]');
  if (yearEl) yearEl.textContent = new Date().getFullYear();
})();
