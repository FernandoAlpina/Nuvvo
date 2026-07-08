<?php
/**
 * Template da página (page-inspire-se). Fase F0: markup estático portado; vira editável (Meta Box) depois.
 * @package Nuvvo (Alpina V4)
 */
if (!defined('ABSPATH')) { exit; }
get_header();
?>

    <!-- ============ 1. HERO ============ -->
    <section class="inspire-hero" aria-label="Apresentação">
      <div class="wrap inspire-hero__inner">
        <span class="inspire-hero__eyebrow">Galeria</span>
        <h1 class="inspire-hero__title">Inspirações</h1>
        <p class="inspire-hero__sub">Compomos cenários para as suas melhores histórias.</p>
      </div>
    </section>

    <!-- ============ 2. FILTER BAR (sticky) ============ -->
    <div class="filter-bar" role="region" aria-label="Filtros de categoria">
      <div class="wrap filter-bar__inner">
        <div class="filter-chips" data-filter-chips role="group" aria-label="Filtrar por categoria">
          <button type="button" class="filter-chip" data-filter="todos"               aria-pressed="true">Todos</button>
          <button type="button" class="filter-chip" data-filter="living"              aria-pressed="false">Living</button>
          <button type="button" class="filter-chip" data-filter="area-social"         aria-pressed="false">Área Social</button>
          <button type="button" class="filter-chip" data-filter="detalhes"            aria-pressed="false">Detalhes &amp; Texturas</button>
          <button type="button" class="filter-chip" data-filter="suites"              aria-pressed="false">Suítes</button>
        </div>
        <span class="filter-results" data-filter-results aria-live="polite">20 ambientes</span>
      </div>
    </div>

    <!-- ============ 3. GALERIA ============ -->
    <section class="section gallery-section">
      <div class="wrap gallery-section__inner">

        <div class="gallery-grid" data-gallery aria-live="polite">

          <!-- ====== LIVING (7) ====== -->

          <button type="button" class="gallery-item gallery-item--wide" data-category="living" aria-label="Ambiente Living — Pecan com escada de vidro e palmeira">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hero-2.jpg" alt="Sofá Pecan em sala iluminada com escada de vidro e palmeira" loading="lazy">
            <span class="gallery-item__zoom" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
            </span>
          </button>

          <button type="button" class="gallery-item" data-category="living" aria-label="Ambiente Living — Sofá modular com mesa baixa">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hero-3.jpg" alt="Sofá modular com mesa baixa e revistas, ambiente contemporâneo" loading="lazy">
            <span class="gallery-item__zoom" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
            </span>
          </button>

          <button type="button" class="gallery-item" data-category="living" aria-label="Ambiente Living — Close lateral do Pecan">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-5.jpg" alt="Close lateral do sofá Pecan com luz natural" loading="lazy">
            <span class="gallery-item__zoom" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
            </span>
          </button>

          <button type="button" class="gallery-item" data-category="living" aria-label="Living — Ambiente em breve">
            <svg viewBox="0 0 400 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <rect width="400" height="320" fill="#E8E3D6"/>
              <g fill="#9F8D7A" opacity="0.45"><rect x="40" y="180" width="320" height="100" rx="6"/><rect x="40" y="100" width="320" height="80" rx="6"/></g>
              <text x="200" y="305" font-family="DM Sans, sans-serif" font-size="10" fill="#7A6B5C" text-anchor="middle" letter-spacing="2">[ LIVING 05 · EM BREVE ]</text>
            </svg>
          </button>

          <button type="button" class="gallery-item gallery-item--tall" data-category="living" aria-label="Living — Ambiente em breve">
            <svg viewBox="0 0 400 600" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <rect width="400" height="600" fill="#9F8D7A"/>
              <g opacity="0.35" fill="#F0EDE4"><rect x="60" y="180" width="280" height="320" rx="6"/></g>
              <g opacity="0.55" fill="#F0EDE4"><rect x="80" y="320" width="240" height="120" rx="4"/></g>
              <text x="200" y="580" font-family="DM Sans, sans-serif" font-size="10" fill="#F0EDE4" text-anchor="middle" letter-spacing="2">[ LIVING 06 · EM BREVE ]</text>
            </svg>
          </button>

          <button type="button" class="gallery-item" data-category="living" aria-label="Living — Ambiente em breve">
            <svg viewBox="0 0 400 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <rect width="400" height="320" fill="#7A6B5C"/>
              <g opacity="0.3" fill="#F0EDE4"><circle cx="200" cy="160" r="100"/></g>
              <text x="200" y="305" font-family="DM Sans, sans-serif" font-size="10" fill="#F0EDE4" text-anchor="middle" letter-spacing="2">[ LIVING 07 · EM BREVE ]</text>
            </svg>
          </button>

          <button type="button" class="gallery-item" data-category="living" aria-label="Living — Ambiente em breve">
            <svg viewBox="0 0 400 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <rect width="400" height="320" fill="#C4B6A5"/>
              <g opacity="0.5" fill="#1A1A1A"><rect x="60" y="180" width="280" height="80" rx="4"/></g>
              <text x="200" y="305" font-family="DM Sans, sans-serif" font-size="10" fill="#1A1A1A" text-anchor="middle" letter-spacing="2">[ LIVING 08 · EM BREVE ]</text>
            </svg>
          </button>

          <!-- ====== ÁREA SOCIAL (4) ====== -->

          <button type="button" class="gallery-item gallery-item--wide" data-category="area-social" aria-label="Área Social — Varanda com sofá modular e cachorrinho">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-3.png" alt="Sofá modular em varanda com vegetação e cachorrinho" loading="lazy">
            <span class="gallery-item__zoom" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
            </span>
          </button>

          <button type="button" class="gallery-item gallery-item--tall" data-category="area-social" aria-label="Área Social — Sofá modular com cachorrinho">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-2.jpg" alt="Sofá modular com cachorrinho branco, janela ao fundo" loading="lazy">
            <span class="gallery-item__zoom" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
            </span>
          </button>

          <button type="button" class="gallery-item" data-category="area-social" aria-label="Área Social — Ambiente em breve">
            <svg viewBox="0 0 400 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <rect width="400" height="320" fill="#9F8D7A"/>
              <g opacity="0.35" fill="#F0EDE4"><rect x="0" y="220" width="400" height="100"/></g>
              <g opacity="0.5" fill="#F0EDE4"><rect x="60" y="160" width="120" height="120" rx="60"/><rect x="220" y="160" width="120" height="120" rx="60"/></g>
              <text x="200" y="305" font-family="DM Sans, sans-serif" font-size="10" fill="#F0EDE4" text-anchor="middle" letter-spacing="2">[ ÁREA SOCIAL 03 · EM BREVE ]</text>
            </svg>
          </button>

          <button type="button" class="gallery-item" data-category="area-social" aria-label="Área Social — Ambiente em breve">
            <svg viewBox="0 0 400 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <rect width="400" height="320" fill="#50071A"/>
              <g opacity="0.25" fill="#F0EDE4"><rect x="80" y="100" width="240" height="160" rx="6"/></g>
              <text x="200" y="305" font-family="DM Sans, sans-serif" font-size="10" fill="#F0EDE4" text-anchor="middle" letter-spacing="2">[ ÁREA SOCIAL 04 · EM BREVE ]</text>
            </svg>
          </button>

          <!-- ====== DETALHES & TEXTURAS (5) ====== -->

          <button type="button" class="gallery-item gallery-item--tall" data-category="detalhes" aria-label="Detalhes — Close vertical do braço Pecan com mesa de madeira">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-1.png" alt="Detalhe do braço do sofá Pecan com mesa lateral de madeira" loading="lazy">
            <span class="gallery-item__zoom" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
            </span>
          </button>

          <button type="button" class="gallery-item" data-category="detalhes" aria-label="Detalhes — Vista superior das almofadas do Pecan">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-4.jpg" alt="Vista superior das almofadas e mesa de madeira do Pecan" loading="lazy">
            <span class="gallery-item__zoom" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
            </span>
          </button>

          <button type="button" class="gallery-item gallery-item--tall" data-category="detalhes" aria-label="Detalhes — Almofadas e braço do Pecan">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-6.png" alt="Detalhe das almofadas e braço do sofá Pecan" loading="lazy">
            <span class="gallery-item__zoom" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
            </span>
          </button>

          <button type="button" class="gallery-item" data-category="detalhes" aria-label="Detalhes — Close de banco/daybed">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/cat-bancos.jpg" alt="Close vertical do banco/daybed com almofada cilíndrica" loading="lazy">
            <span class="gallery-item__zoom" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
            </span>
          </button>

          <button type="button" class="gallery-item" data-category="detalhes" aria-label="Detalhes — Em breve">
            <svg viewBox="0 0 400 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <rect width="400" height="320" fill="#E8E3D6"/>
              <g fill="#7A6B5C" opacity="0.5">
                <rect x="40" y="40" width="60" height="60" rx="4"/>
                <rect x="120" y="40" width="60" height="60" rx="4"/>
                <rect x="200" y="40" width="60" height="60" rx="4"/>
                <rect x="280" y="40" width="60" height="60" rx="4"/>
                <rect x="40" y="120" width="60" height="60" rx="4"/>
                <rect x="120" y="120" width="60" height="60" rx="4"/>
                <rect x="200" y="120" width="60" height="60" rx="4"/>
                <rect x="280" y="120" width="60" height="60" rx="4"/>
              </g>
              <text x="200" y="305" font-family="DM Sans, sans-serif" font-size="10" fill="#7A6B5C" text-anchor="middle" letter-spacing="2">[ TEXTURAS · EM BREVE ]</text>
            </svg>
          </button>

          <!-- ====== SUÍTES (4) — todos placeholders ====== -->

          <button type="button" class="gallery-item gallery-item--wide" data-category="suites" aria-label="Suíte — Em breve">
            <svg viewBox="0 0 800 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <rect width="800" height="320" fill="#7A6B5C"/>
              <g opacity="0.35" fill="#F0EDE4"><rect x="100" y="120" width="600" height="60" rx="6"/><rect x="100" y="180" width="600" height="100" rx="4"/></g>
              <text x="400" y="305" font-family="DM Sans, sans-serif" font-size="11" fill="#F0EDE4" text-anchor="middle" letter-spacing="2">[ SUÍTE PRINCIPAL · EM BREVE ]</text>
            </svg>
          </button>

          <button type="button" class="gallery-item gallery-item--tall" data-category="suites" aria-label="Suíte — Em breve">
            <svg viewBox="0 0 400 600" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <rect width="400" height="600" fill="#50071A"/>
              <g opacity="0.25" fill="#F0EDE4"><rect x="60" y="220" width="280" height="80" rx="6"/><rect x="60" y="310" width="280" height="220" rx="4"/></g>
              <text x="200" y="580" font-family="DM Sans, sans-serif" font-size="10" fill="#F0EDE4" text-anchor="middle" letter-spacing="2">[ SUÍTE 02 · EM BREVE ]</text>
            </svg>
          </button>

          <button type="button" class="gallery-item" data-category="suites" aria-label="Suíte — Em breve">
            <svg viewBox="0 0 400 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <rect width="400" height="320" fill="#C4B6A5"/>
              <g opacity="0.55" fill="#1A1A1A"><rect x="80" y="140" width="240" height="40" rx="4"/><rect x="80" y="180" width="240" height="100" rx="4"/></g>
              <text x="200" y="305" font-family="DM Sans, sans-serif" font-size="10" fill="#1A1A1A" text-anchor="middle" letter-spacing="2">[ SUÍTE 03 · EM BREVE ]</text>
            </svg>
          </button>

          <button type="button" class="gallery-item" data-category="suites" aria-label="Suíte — Em breve">
            <svg viewBox="0 0 400 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <rect width="400" height="320" fill="#E8E3D6"/>
              <g fill="#9F8D7A"><rect x="40" y="140" width="320" height="40" rx="4"/><rect x="40" y="180" width="320" height="100" rx="4"/></g>
              <text x="200" y="305" font-family="DM Sans, sans-serif" font-size="10" fill="#7A6B5C" text-anchor="middle" letter-spacing="2">[ SUÍTE 04 · EM BREVE ]</text>
            </svg>
          </button>

          <!-- Empty state -->
          <div class="gallery-empty" data-gallery-empty hidden>
            <h3 class="gallery-empty__title">Em breve, novas inspirações nesta categoria.</h3>
            <button type="button" class="btn btn--secondary gallery-empty__btn" data-show-all>
              Ver todos os ambientes
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>
          </div>

        </div>

        <div class="load-more-wrapper">
          <button type="button" class="btn btn--secondary load-more" data-load-more hidden>
            <span class="load-more__label">Carregar mais</span>
            <span class="load-more__spinner" aria-hidden="true"></span>
          </button>
        </div>

      </div>
    </section>

    <!-- ============ 4. CTA FINAL ============ -->
    <section class="cta-final" aria-label="Vamos conversar">
      <div class="wrap cta-final__inner reveal">
        <h2 class="cta-final__title">Inspirado?<br>Vamos criar o próximo<br>ambiente juntos.</h2>
        <p class="cta-final__lede">Compartilhe seu projeto conosco e nossa equipe traduzirá sua&nbsp;visão.</p>
        <a href="https://wa.me/5554999485915?text=Ol%C3%A1%2C%20me%20inspirei%20na%20galeria%20da%20Nuvvo%20e%20gostaria%20de%20falar%20com%20um%20especialista"
           class="btn btn--cream"
           target="_blank" rel="noopener">
          Falar com especialista
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>
    </section>

<?php
get_footer();
