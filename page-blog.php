<?php
/**
 * Template da página (page-{slug}). Fase F0: markup estático portado; vira editável (Meta Box) depois.
 * @package Nuvvo (Alpina V4)
 */
if (!defined('ABSPATH')) { exit; }
get_header();
?>

    <!-- ============ 1. HERO ============ -->
    <section class="blog-hero" aria-label="Apresentação">
      <div class="wrap blog-hero__inner">
        <span class="blog-hero__eyebrow">Blog</span>
        <h1 class="blog-hero__title">Nuvvo News</h1>
        <p class="blog-hero__sub">Reflexões, guias e tendências do universo da alta&nbsp;decoração.</p>
      </div>
    </section>

    <!-- ============ 2. FILTER BAR ============ -->
    <div class="filter-bar" role="region" aria-label="Filtros de categoria do blog">
      <div class="wrap filter-bar__inner">
        <div class="filter-chips" data-filter-chips role="group" aria-label="Filtrar por categoria">
          <button type="button" class="filter-chip" data-filter="todos"               aria-pressed="true">Todos</button>
          <button type="button" class="filter-chip" data-filter="cuidados-materiais"  aria-pressed="false">Cuidados e Materiais</button>
          <button type="button" class="filter-chip" data-filter="dicas-decoracao"     aria-pressed="false">Dicas de Decoração</button>
          <button type="button" class="filter-chip" data-filter="tendencias"          aria-pressed="false">Tendências</button>
        </div>
        <span class="filter-results" data-filter-results aria-live="polite">5 posts</span>
      </div>
    </div>

    <!-- ============ 3. CATEGORY BANNER ============ -->
    <section class="section section--tight">
      <div class="wrap">
        <div class="category-banner" data-category-banner>
          <div data-banner-cat="todos">
            <h2 class="category-banner__title">Todos</h2>
            <p class="category-banner__text">Uma curadoria completa sobre o universo Nuvvo. Explore nossas tendências, guias técnicos e reflexões sobre o design contemporâneo que transforma o morar.</p>
          </div>
          <div data-banner-cat="cuidados-materiais" hidden>
            <h2 class="category-banner__title">Cuidados e Materiais</h2>
            <p class="category-banner__text">A sofisticação começa na estrutura. Conheça a ciência por trás do nosso conforto: do rigor técnico das espumas certificadas à durabilidade da madeira e a estética impecável de nossa curadoria de tecidos.</p>
          </div>
          <div data-banner-cat="dicas-decoracao" hidden>
            <h2 class="category-banner__title">Dicas de Decoração</h2>
            <p class="category-banner__text">Onde o design encontra a vida cotidiana. Dicas sobre proporção, respiro e o uso consciente do espaço, para que seu ambiente seja, acima de tudo, um reflexo do seu bem-estar.</p>
          </div>
          <div data-banner-cat="tendencias" hidden>
            <h2 class="category-banner__title">Tendências</h2>
            <p class="category-banner__text">Um olhar atento sobre o viver contemporâneo. Acompanhe as reflexões de Deivid de Almeida sobre a evolução do mobiliário, a ergonomia tátil e a nova cultura do morar&nbsp;bem.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ 4. LISTAGEM ============ -->
    <section class="section blog-listagem">
      <div class="wrap">
        <div class="blog-grid" data-blog-grid>

          <!-- Post 1 — FEATURED double-width -->
          <a href="<?php echo esc_url(home_url('/blog/tendencias-em-design-contemporaneo/')); ?>"
             class="post-card post-card--featured blog-grid__featured"
             data-category="tendencias"
             aria-label="Leia: O novo morar — a ergonomia tátil e a era dos estofados Puffy">
            <div class="post-card__media">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-4.jpg" alt="Vista superior das almofadas com volume e dobras — estética puffy" loading="lazy">
            </div>
            <div class="post-card__content">
              <span class="post-card__tag">Tendências</span>
              <h2 class="post-card__title">O novo morar: a ergonomia tátil e a era dos estofados Puffy</h2>
              <p class="post-card__meta">
                <time datetime="2026-05-15">15 mai 2026</time>
                <span class="post-card__meta-sep"></span>
                <span>5 min de leitura</span>
                <span class="post-card__meta-sep"></span>
                <span>por Deivid de Almeida</span>
              </p>
              <p class="post-card__excerpt">O designer da Nuvvo compartilha um olhar crítico sobre a transformação do setor moveleiro: a aceleração das tendências, a ascensão do estofado puffy e o desafio das indústrias na nova cultura do morar.</p>
              <span class="post-card__cta">Leia mais</span>
            </div>
          </a>

          <div class="blog-grid__rest">

            <!-- Post 2 — Cuidados e Materiais -->
            <a href="<?php echo esc_url(home_url('/blog/guia-de-tecidos-para-estofados-de-alta-decoracao/')); ?>"
               class="post-card"
               data-category="cuidados-materiais"
               aria-label="Leia: Guia de tecidos para estofados de alta decoração">
              <div class="post-card__media">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-6.png" alt="Close das almofadas e braço com textura de tecido" loading="lazy">
              </div>
              <span class="post-card__tag">Cuidados e Materiais</span>
              <h3 class="post-card__title">Guia de tecidos para estofados de alta decoração: como escolher o ideal para seu projeto</h3>
              <p class="post-card__meta">
                <time datetime="2026-05-02">02 mai 2026</time>
                <span class="post-card__meta-sep"></span>
                <span>6 min de leitura</span>
              </p>
              <span class="post-card__cta">Leia mais</span>
            </a>

            <!-- Post 3 — Dicas de Decoração -->
            <a href="<?php echo esc_url(home_url('/blog/proporcao-e-respiro-na-sala-de-estar/')); ?>"
               class="post-card"
               data-category="dicas-decoracao"
               aria-label="Leia: Proporção e respiro na sala de estar">
              <div class="post-card__media">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hero-1.png" alt="Ambiente residencial Nuvvo com composição bem-resolvida" loading="lazy">
              </div>
              <span class="post-card__tag">Dicas de Decoração</span>
              <h3 class="post-card__title">Proporção e respiro: os princípios invisíveis de uma sala de estar bem-resolvida</h3>
              <p class="post-card__meta">
                <time datetime="2026-04-20">20 abr 2026</time>
                <span class="post-card__meta-sep"></span>
                <span>5 min de leitura</span>
              </p>
              <span class="post-card__cta">Leia mais</span>
            </a>

            <!-- Post 4 — Tendências -->
            <a href="<?php echo esc_url(home_url('/blog/cores-e-texturas-2026-paleta-do-morar-contemporaneo/')); ?>"
               class="post-card"
               data-category="tendencias"
               aria-label="Leia: A paleta do morar contemporâneo 2026">
              <div class="post-card__media">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-1.png" alt="Detalhe do sofá Pecan com mesa lateral de madeira" loading="lazy">
              </div>
              <span class="post-card__tag">Tendências</span>
              <h3 class="post-card__title">A paleta do morar contemporâneo: cores e texturas que definem 2026</h3>
              <p class="post-card__meta">
                <time datetime="2026-04-08">08 abr 2026</time>
                <span class="post-card__meta-sep"></span>
                <span>4 min de leitura</span>
              </p>
              <span class="post-card__cta">Leia mais</span>
            </a>

            <!-- Post 5 — Cuidados e Materiais -->
            <a href="<?php echo esc_url(home_url('/blog/como-conservar-seu-estofado-de-alta-decoracao/')); ?>"
               class="post-card"
               data-category="cuidados-materiais"
               aria-label="Leia: Como conservar seu estofado de alta decoração">
              <div class="post-card__media">
                <svg viewBox="0 0 600 400" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <rect width="600" height="400" fill="#9F8D7A"/>
                  <g opacity="0.35" fill="#F0EDE4">
                    <rect x="80" y="180" width="440" height="80" rx="6"/>
                    <rect x="80" y="100" width="440" height="80" rx="6"/>
                    <rect x="60" y="160" width="40" height="160" rx="4"/>
                    <rect x="500" y="160" width="40" height="160" rx="4"/>
                  </g>
                  <text x="300" y="385" font-family="DM Sans, sans-serif" font-size="11" fill="#F0EDE4" text-anchor="middle" letter-spacing="2">[ CUIDADOS · CAPA EM BREVE ]</text>
                </svg>
              </div>
              <span class="post-card__tag">Cuidados e Materiais</span>
              <h3 class="post-card__title">Como conservar seu estofado de alta decoração: guia prático de limpeza e manutenção</h3>
              <p class="post-card__meta">
                <time datetime="2026-03-25">25 mar 2026</time>
                <span class="post-card__meta-sep"></span>
                <span>7 min de leitura</span>
              </p>
              <span class="post-card__cta">Leia mais</span>
            </a>

            <!-- Empty state -->
            <div class="blog-empty" data-blog-empty hidden>
              <h3 class="blog-empty__title">Em breve, novos conteúdos nesta categoria.</h3>
              <button type="button" class="btn btn--secondary" data-show-all>
                Ver todos os posts
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
              </button>
            </div>

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

    <!-- ============ 5. CTA FINAL ============ -->
    <section class="cta-final" aria-label="Vamos conversar">
      <div class="wrap cta-final__inner reveal">
        <h2 class="cta-final__title">Vamos transformar suas inspirações em projeto?</h2>
        <p class="cta-final__lede">Compartilhe seu projeto conosco e nossa equipe traduzirá sua&nbsp;visão.</p>
        <a href="https://wa.me/5554999485915?text=Ol%C3%A1%2C%20li%20no%20blog%20da%20Nuvvo%20e%20gostaria%20de%20falar%20com%20um%20especialista"
           class="btn btn--cream"
           target="_blank" rel="noopener">
          Falar com especialista
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>
    </section>

<?php
get_footer();
