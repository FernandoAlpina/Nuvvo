/* ============================================================
   COOKIE BANNER — global (carregado em todas as páginas)
   - Auto-injeta HTML do banner + modal
   - Persistência via localStorage (12 meses)
   - Focus trap, ESC, ARIA completos
   - Honra prefers-reduced-motion
   - Expõe API: window.NuvvoCookies.openPreferences()
   ============================================================ */

(() => {
  'use strict';

  const STORAGE_KEY = 'nuvvo-cookie-consent';
  const STORAGE_TTL_MS = 365 * 24 * 60 * 60 * 1000; // 12 meses

  /* ---------- Estado persistido ---------- */
  const loadConsent = () => {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      if (!raw) return null;
      const data = JSON.parse(raw);
      if (!data || !data.timestamp) return null;
      if (Date.now() - data.timestamp > STORAGE_TTL_MS) return null;
      return data;
    } catch { return null; }
  };

  const saveConsent = (prefs) => {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify({
        prefs,
        timestamp: Date.now(),
        version: 1,
      }));
    } catch { /* localStorage indisponível */ }

    // Dispatch evento custom pra integrações futuras (GA Consent Mode, etc.)
    window.dispatchEvent(new CustomEvent('nuvvo:cookie-consent', { detail: prefs }));
  };

  /* ---------- HTML do banner + modal ---------- */
  const BANNER_HTML = `
    <div class="cookie-banner" id="nuvvo-cookie-banner" role="dialog" aria-modal="false" aria-labelledby="cookie-banner-title" aria-describedby="cookie-banner-text">
      <div class="cookie-banner__content">
        <h2 class="cookie-banner__title" id="cookie-banner-title">Sua privacidade é importante</h2>
        <p class="cookie-banner__text" id="cookie-banner-text">Utilizamos cookies para melhorar sua experiência de navegação, analisar o uso do site e personalizar conteúdo. Saiba mais em nossa <a href="POLICY_HREF">Política de Privacidade</a>.</p>
      </div>
      <div class="cookie-banner__actions">
        <button type="button" class="cookie-banner__link" data-cookie-action="customize">Personalizar</button>
        <button type="button" class="btn btn--secondary" data-cookie-action="essentials">Apenas essenciais</button>
        <button type="button" class="btn btn--primary" data-cookie-action="accept-all">Aceitar todos</button>
      </div>
    </div>
  `;

  const MODAL_HTML = `
    <div class="cookie-modal" id="nuvvo-cookie-modal" role="dialog" aria-modal="true" aria-labelledby="cookie-modal-title">
      <div class="cookie-modal__dialog">
        <h2 class="cookie-modal__title" id="cookie-modal-title">Preferências de cookies</h2>
        <p class="cookie-modal__intro">Escolha quais categorias de cookies você permite. Você pode mudar essas preferências a qualquer momento.</p>

        <div class="cookie-modal__categories">
          <div class="cookie-category">
            <div class="cookie-category__head">
              <h3 class="cookie-category__name">Essenciais</h3>
              <label class="toggle-switch">
                <input type="checkbox" checked disabled aria-label="Cookies essenciais (sempre ativos)">
                <span class="toggle-switch__track"></span>
              </label>
            </div>
            <p class="cookie-category__desc">Necessários para o funcionamento básico do site (navegação, segurança, preferências de cookies). Não podem ser desativados.</p>
          </div>

          <div class="cookie-category">
            <div class="cookie-category__head">
              <h3 class="cookie-category__name">Funcionais</h3>
              <label class="toggle-switch">
                <input type="checkbox" data-cookie-cat="functional" aria-label="Cookies funcionais">
                <span class="toggle-switch__track"></span>
              </label>
            </div>
            <p class="cookie-category__desc">Lembram suas preferências (idioma, formatação) para personalizar sua experiência em visitas futuras.</p>
          </div>

          <div class="cookie-category">
            <div class="cookie-category__head">
              <h3 class="cookie-category__name">Analíticos</h3>
              <label class="toggle-switch">
                <input type="checkbox" data-cookie-cat="analytics" aria-label="Cookies analíticos">
                <span class="toggle-switch__track"></span>
              </label>
            </div>
            <p class="cookie-category__desc">Nos ajudam a entender como você usa o site (páginas visitadas, tempo de permanência) para que possamos melhorá-lo. Ferramentas: Google Analytics.</p>
          </div>

          <div class="cookie-category">
            <div class="cookie-category__head">
              <h3 class="cookie-category__name">Marketing</h3>
              <label class="toggle-switch">
                <input type="checkbox" data-cookie-cat="marketing" aria-label="Cookies de marketing">
                <span class="toggle-switch__track"></span>
              </label>
            </div>
            <p class="cookie-category__desc">Utilizados para exibir conteúdo relevante e medir a eficácia de campanhas de comunicação.</p>
          </div>
        </div>

        <div class="cookie-modal__actions">
          <button type="button" class="btn btn--secondary" data-cookie-action="modal-cancel">Cancelar</button>
          <button type="button" class="btn btn--primary" data-cookie-action="modal-save">Salvar preferências</button>
        </div>
      </div>
    </div>
  `;

  /* ---------- Inicialização ---------- */
  const init = () => {
    // Detecta path para a política (raiz vs /blog/)
    const pathDepth = window.location.pathname.split('/').filter(Boolean).length;
    const policyHref = pathDepth >= 2
      ? '../politica-de-privacidade.html'
      : 'politica-de-privacidade.html';

    // Injetar HTML
    const container = document.createElement('div');
    container.innerHTML = BANNER_HTML.replace('POLICY_HREF', policyHref) + MODAL_HTML;
    document.body.appendChild(container);

    const banner = document.getElementById('nuvvo-cookie-banner');
    const modal  = document.getElementById('nuvvo-cookie-modal');
    const dialog = modal.querySelector('.cookie-modal__dialog');

    /* ---------- Show banner se não tem consentimento válido ---------- */
    const consent = loadConsent();
    if (!consent) {
      setTimeout(() => banner.classList.add('is-visible'), 400);
    } else {
      // Já tem consentimento — disparar evento pra integrações
      window.dispatchEvent(new CustomEvent('nuvvo:cookie-consent', { detail: consent.prefs }));
    }

    /* ---------- Funções ---------- */
    const hideBanner = () => banner.classList.remove('is-visible');

    const openModal = () => {
      // Carrega preferências salvas no estado atual
      const cur = loadConsent();
      const prefs = cur?.prefs || { functional: false, analytics: false, marketing: false };
      modal.querySelectorAll('[data-cookie-cat]').forEach(input => {
        input.checked = !!prefs[input.dataset.cookieCat];
      });
      modal.classList.add('is-open');
      document.body.classList.add('cookie-modal-open');
      if (window.__lenis) window.__lenis.stop();
      // Focus primeiro toggle
      setTimeout(() => modal.querySelector('input:not([disabled])')?.focus(), 50);
    };

    const closeModal = () => {
      modal.classList.remove('is-open');
      document.body.classList.remove('cookie-modal-open');
      if (window.__lenis) window.__lenis.start();
    };

    const saveAll = () => {
      saveConsent({ functional: true, analytics: true, marketing: true });
      hideBanner();
      closeModal();
    };
    const saveEssentialsOnly = () => {
      saveConsent({ functional: false, analytics: false, marketing: false });
      hideBanner();
      closeModal();
    };
    const saveFromModal = () => {
      const prefs = {};
      modal.querySelectorAll('[data-cookie-cat]').forEach(input => {
        prefs[input.dataset.cookieCat] = input.checked;
      });
      saveConsent(prefs);
      hideBanner();
      closeModal();
    };

    /* ---------- Event listeners ---------- */
    container.addEventListener('click', (e) => {
      const action = e.target.closest('[data-cookie-action]')?.dataset.cookieAction;
      if (!action) return;
      switch (action) {
        case 'accept-all':   saveAll(); break;
        case 'essentials':   saveEssentialsOnly(); break;
        case 'customize':    openModal(); break;
        case 'modal-save':   saveFromModal(); break;
        case 'modal-cancel': closeModal(); break;
      }
    });

    // Click fora do dialog fecha
    modal.addEventListener('click', (e) => {
      if (e.target === modal) closeModal();
    });

    // ESC fecha modal (banner não fecha com ESC — decisão UX: usuário precisa escolher)
    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });

    // Focus trap no modal
    modal.addEventListener('keydown', (e) => {
      if (e.key !== 'Tab' || !modal.classList.contains('is-open')) return;
      const focusables = dialog.querySelectorAll('input:not([disabled]), button:not([disabled])');
      if (!focusables.length) return;
      const first = focusables[0];
      const last  = focusables[focusables.length - 1];
      if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
      else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    });

    /* ---------- API pública ---------- */
    window.NuvvoCookies = {
      openPreferences: openModal,
      reset: () => {
        try { localStorage.removeItem(STORAGE_KEY); } catch {}
        banner.classList.add('is-visible');
      },
      getConsent: () => loadConsent()?.prefs || null,
    };

    /* ---------- Hook: botão "Abrir preferências" da Política ---------- */
    document.querySelectorAll('[data-reopen-cookies]').forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        openModal();
      });
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
