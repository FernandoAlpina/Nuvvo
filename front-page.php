<?php
/**
 * Template da Home (front-page).
 * Fase F0: markup estático portado do index.html; será convertido em campos
 * editáveis (Meta Box) nas fases seguintes.
 * @package Nuvvo (Alpina V4)
 */
if (!defined('ABSPATH')) { exit; }
get_header();
?>

    <!-- ============ 1. HERO ============ -->
    <section class="hero" id="hero" aria-label="Apresentação">
      <div class="hero__media" data-parallax="0.15">
        <!-- Carrossel de 3 fotos lifestyle. Quando vídeo institucional chegar, substituir por <video autoplay muted loop playsinline poster="..."> -->
        <div class="swiper hero__swiper">
          <div class="swiper-wrapper">

            <div class="swiper-slide hero__slide">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hero-1.png"
                   alt="Sofá Pecan em ambiente residencial com plantas e mesa lateral de madeira"
                   loading="eager" fetchpriority="high"
                   width="1920" height="1080">
            </div>

            <div class="swiper-slide hero__slide">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hero-2.jpg"
                   alt="Sofá Pecan em sala iluminada com escada de vidro e palmeira ao fundo"
                   loading="lazy"
                   width="1920" height="1280">
            </div>

            <div class="swiper-slide hero__slide">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hero-3.jpg"
                   alt="Sofá modular branco com mesa de centro baixa e revistas, ambiente contemporâneo"
                   loading="lazy"
                   width="1920" height="1280">
            </div>

          </div>
        </div>
      </div>

      <div class="wrap hero__inner">
        <div>
          <h1 class="hero__title">Mobiliário personalizado de alta decoração</h1>
          <p class="hero__sub">Design autoral que traduz a harmonia entre o rigor da produção artesanal e a sofisticação do morar contemporâneo.</p>
        </div>
        <div class="hero__cta">
          <a href="https://wa.me/5554999485915?text=Ol%C3%A1%2C%20gostaria%20de%20falar%20com%20um%20especialista%20da%20Nuvvo%20Design"
             class="btn btn--cream"
             target="_blank" rel="noopener">
            Falar com especialista
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
              <path d="M5 12h14M13 6l6 6-6 6"/>
            </svg>
          </a>
        </div>
      </div>

      <div class="hero__scroll-hint" aria-hidden="true">Scroll</div>
    </section>

    <!-- ============ 2. BIG NUMBERS (editável no painel Nuvvo) ============ -->
    <?php get_template_part('template-parts/big-numbers'); ?>

    <!-- ============ VÍDEO INSTITUCIONAL ============
         Para ocultar a seção inteira, troque data-video-available="true" → "false".
         Para ativar o vídeo, defina data-video-src no .video-block. -->
    <section class="section video-section" data-video-available="true" aria-label="Vídeo institucional">
      <div class="wrap">
        <header class="reveal" style="text-align:center; margin-bottom: var(--space-5);">
          <span class="eyebrow" style="justify-content:center;">Conheça por dentro</span>
          <h2 class="section-title section-title--center">Bastidores e processo</h2>
        </header>

        <button
          type="button"
          class="video-block reveal reveal--delay-1"
          data-video-src=""
          data-video-type="iframe"
          data-video-poster="<?php echo get_template_directory_uri(); ?>/assets/img/hero-1.png"
          aria-label="Assistir vídeo institucional da Nuvvo Design">
          <img class="video-block__poster" src="<?php echo get_template_directory_uri(); ?>/assets/img/hero-1.png" alt="" aria-hidden="true">
          <span class="video-block__play" aria-hidden="true"></span>
          <span class="video-block__label">Vídeo institucional em breve</span>
        </button>
      </div>
    </section>

    <!-- ============ 3. CATÁLOGO ============ -->
    <section class="section" id="catalog" aria-label="Catálogo">
      <div class="wrap">
        <header class="catalog__head">
          <div class="reveal">
            <span class="eyebrow">Catálogo</span>
            <h2 class="section-title">Catálogo Nuvvo:<br>Mobiliário de alta decoração</h2>
            <p class="lede">Explore peças desenvolvidas com alta marcenaria, produção artesanal e acabamento impecável.</p>
          </div>
          <a href="<?php echo esc_url(home_url('/catalogo/')); ?>" class="btn btn--secondary reveal reveal--delay-1">
            Ver catálogo
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </a>
        </header>

        <div class="catalog__grid">

          <a href="<?php echo esc_url(home_url('/catalogo/sofas/')); ?>" class="card-cat reveal">
            <div class="card-cat__media">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/cat-sofas.png"
                   alt="Coleção de sofás Nuvvo"
                   loading="lazy"
                   width="800" height="1000">
            </div>
            <div class="card-cat__label">
              <span class="card-cat__name">Sofás</span>
              <span class="card-cat__arrow" aria-hidden="true">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M7 17 17 7M10 7h7v7"/></svg>
              </span>
            </div>
          </a>

          <a href="<?php echo esc_url(home_url('/catalogo/poltronas/')); ?>" class="card-cat reveal reveal--delay-1">
            <div class="card-cat__media">
              <svg viewBox="0 0 400 500" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <rect width="400" height="500" fill="#7A6B5C"/>
                <g opacity="0.4" fill="#F0EDE4">
                  <rect x="120" y="180" width="160" height="220" rx="20"/>
                  <rect x="120" y="280" width="160" height="100" rx="8"/>
                  <rect x="100" y="260" width="30" height="160" rx="4"/>
                  <rect x="270" y="260" width="30" height="160" rx="4"/>
                </g>
              </svg>
            </div>
            <div class="card-cat__label">
              <span class="card-cat__name">Poltronas</span>
              <span class="card-cat__arrow" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M7 17 17 7M10 7h7v7"/></svg></span>
            </div>
          </a>

          <a href="<?php echo esc_url(home_url('/catalogo/bancos/')); ?>" class="card-cat reveal reveal--delay-2">
            <div class="card-cat__media">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/cat-bancos.jpg"
                   alt="Coleção de bancos Nuvvo"
                   loading="lazy"
                   width="800" height="1000">
            </div>
            <div class="card-cat__label">
              <span class="card-cat__name">Bancos</span>
              <span class="card-cat__arrow" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M7 17 17 7M10 7h7v7"/></svg></span>
            </div>
          </a>

          <a href="<?php echo esc_url(home_url('/catalogo/camas/')); ?>" class="card-cat reveal reveal--delay-3">
            <div class="card-cat__media">
              <svg viewBox="0 0 400 600" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <rect width="400" height="600" fill="#50071A"/>
                <g opacity="0.35" fill="#F0EDE4">
                  <rect x="40" y="200" width="320" height="80" rx="8"/>
                  <rect x="40" y="290" width="320" height="220" rx="6"/>
                  <rect x="40" y="510" width="320" height="6"/>
                </g>
              </svg>
            </div>
            <div class="card-cat__label">
              <span class="card-cat__name">Camas</span>
              <span class="card-cat__arrow" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M7 17 17 7M10 7h7v7"/></svg></span>
            </div>
          </a>

        </div>
      </div>
    </section>

    <!-- ============ 4. PRODUTOS EM DESTAQUE ============ -->
    <section class="section" aria-label="Produtos em destaque">
      <div class="wrap">
        <header class="featured__head reveal">
          <div>
            <span class="eyebrow">Seleção</span>
            <h2 class="section-title">Seleção em destaque</h2>
          </div>
          <div class="featured__nav" role="group" aria-label="Navegar produtos">
            <button class="swiper-btn featured__prev" type="button" aria-label="Produto anterior">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
            </button>
            <button class="swiper-btn featured__next" type="button" aria-label="Próximo produto">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>
          </div>
        </header>

        <div class="swiper featured__swiper reveal">
          <div class="swiper-wrapper">

            <!-- Sofá Pecan — lançamento Nuvvo Signature -->
            <article class="swiper-slide">
              <a href="<?php echo esc_url(home_url('/produto/pecan/')); ?>" class="card-prod">
                <div class="card-prod__media">
                  <span class="card-prod__tag">Nuvvo Signature</span>
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/img/prod-pecan.jpg" alt="Sofá Pecan — Nuvvo Signature" loading="lazy" width="600" height="450">
                </div>
                <h3 class="card-prod__title">Sofá Pecan</h3>
                <p class="card-prod__designer">Designer Deivid de Almeida</p>
                <span class="card-prod__link">Ver detalhes</span>
              </a>
            </article>

            <article class="swiper-slide">
              <a href="#" class="card-prod" aria-label="Coleção 02 — em definição">
                <div class="card-prod__media">
                  <svg viewBox="0 0 600 450" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect width="600" height="450" fill="#E8E3D6"/>
                    <g fill="#9F8D7A">
                      <path d="M 80 280 Q 80 220 160 220 L 440 220 Q 520 220 520 280 L 520 340 L 80 340 Z"/>
                      <rect x="60" y="260" width="40" height="100" rx="8"/>
                      <rect x="500" y="260" width="40" height="100" rx="8"/>
                    </g>
                    <text x="300" y="430" font-family="DM Sans, sans-serif" font-size="11" fill="#7A6B5C" text-anchor="middle" letter-spacing="2">[ COLEÇÃO 02 · EM DEFINIÇÃO ]</text>
                  </svg>
                </div>
                <h3 class="card-prod__title">Coleção 02 <em>· em definição</em></h3>
                <p class="card-prod__designer">Próximo lançamento Nuvvo</p>
                <span class="card-prod__link">Em breve</span>
              </a>
            </article>

            <article class="swiper-slide">
              <a href="#" class="card-prod" aria-label="Coleção 03 — em definição">
                <div class="card-prod__media">
                  <svg viewBox="0 0 600 450" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect width="600" height="450" fill="#9F8D7A"/>
                    <g opacity="0.45" fill="#F0EDE4">
                      <rect x="60" y="240" width="220" height="100" rx="10"/>
                      <rect x="320" y="240" width="220" height="100" rx="10"/>
                      <rect x="60" y="180" width="220" height="70" rx="8"/>
                      <rect x="320" y="180" width="220" height="70" rx="8"/>
                    </g>
                    <text x="300" y="430" font-family="DM Sans, sans-serif" font-size="11" fill="#F0EDE4" text-anchor="middle" letter-spacing="2">[ COLEÇÃO 03 · EM DEFINIÇÃO ]</text>
                  </svg>
                </div>
                <h3 class="card-prod__title">Coleção 03 <em>· em definição</em></h3>
                <p class="card-prod__designer">Próximo lançamento Nuvvo</p>
                <span class="card-prod__link">Em breve</span>
              </a>
            </article>

            <article class="swiper-slide">
              <a href="#" class="card-prod" aria-label="Coleção 04 — em definição">
                <div class="card-prod__media">
                  <svg viewBox="0 0 600 450" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect width="600" height="450" fill="#C4B6A5"/>
                    <g opacity="0.55" fill="#1A1A1A">
                      <rect x="80" y="260" width="440" height="80" rx="10"/>
                      <rect x="80" y="200" width="440" height="70" rx="10"/>
                      <rect x="100" y="340" width="10" height="40"/>
                      <rect x="490" y="340" width="10" height="40"/>
                    </g>
                    <text x="300" y="430" font-family="DM Sans, sans-serif" font-size="11" fill="#1A1A1A" text-anchor="middle" letter-spacing="2">[ COLEÇÃO 04 · EM DEFINIÇÃO ]</text>
                  </svg>
                </div>
                <h3 class="card-prod__title">Coleção 04 <em>· em definição</em></h3>
                <p class="card-prod__designer">Próximo lançamento Nuvvo</p>
                <span class="card-prod__link">Em breve</span>
              </a>
            </article>

            <article class="swiper-slide">
              <a href="#" class="card-prod" aria-label="Coleção 05 — em definição">
                <div class="card-prod__media">
                  <svg viewBox="0 0 600 450" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect width="600" height="450" fill="#7A6B5C"/>
                    <g opacity="0.4" fill="#F0EDE4">
                      <rect x="60" y="220" width="320" height="120" rx="10"/>
                      <rect x="380" y="180" width="160" height="160" rx="80"/>
                    </g>
                    <text x="300" y="430" font-family="DM Sans, sans-serif" font-size="11" fill="#F0EDE4" text-anchor="middle" letter-spacing="2">[ COLEÇÃO 05 · EM DEFINIÇÃO ]</text>
                  </svg>
                </div>
                <h3 class="card-prod__title">Coleção 05 <em>· em definição</em></h3>
                <p class="card-prod__designer">Próximo lançamento Nuvvo</p>
                <span class="card-prod__link">Em breve</span>
              </a>
            </article>

          </div>
          <div class="swiper-pagination featured__pagination"></div>
        </div>
      </div>
    </section>

    <!-- ============ 5. ESSÊNCIA ============ -->
    <section class="section" aria-label="A essência da Nuvvo">
      <div class="wrap">
        <header class="reveal">
          <span class="eyebrow">Nossa essência</span>
          <h2 class="section-title section-title--nowrap">A essência da nossa curadoria</h2>
          <p class="essence__lede">O mobiliário Nuvvo é o encontro entre a expertise fabril de 25 anos e a sensibilidade do <em>design autoral</em>. Oferecemos soluções pensadas para arquitetos e clientes que compreendem que o design é a base de um viver&nbsp;extraordinário.</p>
        </header>

        <div class="essence__grid">

          <article class="card-pillar reveal">
            <span class="card-pillar__num">01</span>
            <svg class="card-pillar__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
              <circle cx="16" cy="16" r="11"/>
              <path d="M16 5v22M5 16h22"/>
            </svg>
            <h3 class="card-pillar__title">Design Exclusivo</h3>
            <p class="card-pillar__body">Peças com identidade própria, assinadas e criadas para serem um convite ao bem estar, à contemplação e à celebração da vida.</p>
          </article>

          <article class="card-pillar reveal reveal--delay-1">
            <span class="card-pillar__num">02</span>
            <svg class="card-pillar__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
              <rect x="4" y="4" width="11" height="11"/>
              <rect x="17" y="4" width="11" height="11"/>
              <rect x="4" y="17" width="11" height="11"/>
              <rect x="17" y="17" width="11" height="11"/>
            </svg>
            <h3 class="card-pillar__title">Capacidade de Personalização</h3>
            <p class="card-pillar__body">Mais de 3.000 opções de cores e acabamentos, além de diversas medidas disponíveis para a especificação precisa do seu projeto.</p>
          </article>

          <article class="card-pillar reveal reveal--delay-2">
            <span class="card-pillar__num">03</span>
            <svg class="card-pillar__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
              <path d="M4 24c4-8 8-12 12-12s8 4 12 12"/>
              <circle cx="10" cy="10" r="3"/>
              <circle cx="22" cy="10" r="3"/>
            </svg>
            <h3 class="card-pillar__title">Acompanhamento Próximo</h3>
            <p class="card-pillar__body">Atuamos lado a lado com o arquiteto em todas as etapas, da especificação técnica à entrega final.</p>
          </article>

        </div>
      </div>
    </section>

    <!-- ============ 6. GALERIA — INSPIRE-SE ============ -->
    <section class="section gallery" id="gallery" aria-label="Inspire-se">
      <div class="wrap">
        <header class="gallery__head">
          <div class="reveal">
            <span class="eyebrow">Inspire-se</span>
            <h2 class="section-title">Inspire-se</h2>
          </div>
          <div class="reveal reveal--delay-1" style="display:flex; gap: var(--space-2); align-items:center;">
            <a href="<?php echo esc_url(home_url('/inspire-se/')); ?>" class="link-underline">Ver mais inspirações</a>
            <div style="display:flex; gap: var(--space-1); margin-left: var(--space-3);">
              <button class="swiper-btn gallery__prev" type="button" aria-label="Imagem anterior">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
              </button>
              <button class="swiper-btn gallery__next" type="button" aria-label="Próxima imagem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
              </button>
            </div>
          </div>
        </header>

        <div class="swiper gallery__swiper reveal">
          <div class="swiper-wrapper">

            <a href="<?php echo esc_url(home_url('/inspire-se/')); ?>" class="swiper-slide" aria-label="Ver galeria — detalhe do braço do sofá Pecan">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-1.png" alt="Detalhe do braço do sofá Pecan com mesa lateral de madeira" loading="lazy" width="800" height="1000">
              <span class="gallery__slide-zoom" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
              </span>
            </a>
            <a href="<?php echo esc_url(home_url('/inspire-se/')); ?>" class="swiper-slide" aria-label="Ver galeria — sofá modular com cachorrinho">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-2.jpg" alt="Sofá modular com cachorrinho branco, janela ao fundo" loading="lazy" width="800" height="1000">
              <span class="gallery__slide-zoom" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
              </span>
            </a>
            <a href="<?php echo esc_url(home_url('/inspire-se/')); ?>" class="swiper-slide" aria-label="Ver galeria — sofá modular em varanda">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-3.png" alt="Sofá modular em varanda com vegetação e cachorrinho" loading="lazy" width="800" height="1000">
              <span class="gallery__slide-zoom" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
              </span>
            </a>
            <a href="<?php echo esc_url(home_url('/inspire-se/')); ?>" class="swiper-slide" aria-label="Ver galeria — vista superior do sofá Pecan">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-4.jpg" alt="Vista superior do sofá Pecan com almofadas e mesa de madeira" loading="lazy" width="800" height="1000">
              <span class="gallery__slide-zoom" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
              </span>
            </a>
            <a href="<?php echo esc_url(home_url('/inspire-se/')); ?>" class="swiper-slide" aria-label="Ver galeria — close lateral do sofá Pecan">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-5.jpg" alt="Close lateral do sofá Pecan com luz natural" loading="lazy" width="800" height="1000">
              <span class="gallery__slide-zoom" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
              </span>
            </a>
            <a href="<?php echo esc_url(home_url('/inspire-se/')); ?>" class="swiper-slide" aria-label="Ver galeria — detalhe das almofadas">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-6.png" alt="Detalhe das almofadas e braço do sofá Pecan" loading="lazy" width="800" height="1000">
              <span class="gallery__slide-zoom" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
              </span>
            </a>

          </div>
        </div>
      </div>
    </section>

    <!-- ============ 7. BLOG — NUVVO NEWS ============ -->
    <section class="section" aria-label="Nuvvo News">
      <div class="wrap">
        <header class="news__head">
          <div class="reveal">
            <span class="eyebrow">Nuvvo News</span>
            <h2 class="section-title section-title--nowrap">Nuvvo News: dicas e tendências</h2>
          </div>
          <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="link-underline reveal reveal--delay-1">Ver todas as publicações</a>
        </header>

        <div class="news__grid">

          <article class="reveal">
            <a href="<?php echo esc_url(home_url('/blog/escolher-sofa-living-contemporaneo/')); ?>" class="card-post">
              <div class="card-post__media">
                <svg viewBox="0 0 400 280" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <rect width="400" height="280" fill="#9F8D7A"/>
                  <g opacity="0.4" fill="#F0EDE4"><rect x="40" y="140" width="320" height="100" rx="8"/></g>
                </svg>
              </div>
              <div class="card-post__meta">
                <span>Decoração</span>
                <span class="card-post__meta-sep">/</span>
                <time datetime="2026-05-12">12 mai 2026</time>
              </div>
              <h3 class="card-post__title">Como escolher um sofá para o living contemporâneo</h3>
            </a>
          </article>

          <article class="reveal reveal--delay-1">
            <a href="<?php echo esc_url(home_url('/blog/tendencias-tecidos-2026/')); ?>" class="card-post">
              <div class="card-post__media">
                <svg viewBox="0 0 400 280" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <rect width="400" height="280" fill="#50071A"/>
                  <g opacity="0.35" fill="#F0EDE4"><rect x="40" y="60" width="320" height="160"/></g>
                </svg>
              </div>
              <div class="card-post__meta">
                <span>Tendências</span>
                <span class="card-post__meta-sep">/</span>
                <time datetime="2026-04-28">28 abr 2026</time>
              </div>
              <h3 class="card-post__title">Tendências de tecidos para 2026</h3>
            </a>
          </article>

          <article class="reveal reveal--delay-2">
            <a href="<?php echo esc_url(home_url('/blog/processo-artesanal-nuvvo/')); ?>" class="card-post">
              <div class="card-post__media">
                <svg viewBox="0 0 400 280" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <rect width="400" height="280" fill="#7A6B5C"/>
                  <g opacity="0.4" fill="#F0EDE4"><circle cx="200" cy="140" r="100"/></g>
                </svg>
              </div>
              <div class="card-post__meta">
                <span>Bastidores</span>
                <span class="card-post__meta-sep">/</span>
                <time datetime="2026-04-15">15 abr 2026</time>
              </div>
              <h3 class="card-post__title">O processo artesanal por trás de cada peça Nuvvo</h3>
            </a>
          </article>

        </div>
      </div>
    </section>

    <!-- ============ 8. DEPOIMENTOS (carrossel) ============ -->
    <section class="section testi" aria-label="Depoimentos">
      <div class="wrap">
        <header class="testi__head reveal">
          <div>
            <span class="eyebrow">A experiência Nuvvo</span>
            <h2 class="section-title">A experiência Nuvvo</h2>
          </div>
          <div class="featured__nav" role="group" aria-label="Navegar depoimentos">
            <button class="swiper-btn testi__prev" type="button" aria-label="Depoimento anterior">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
            </button>
            <button class="swiper-btn testi__next" type="button" aria-label="Próximo depoimento">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>
          </div>
        </header>

        <div class="swiper testi__swiper reveal">
          <div class="swiper-wrapper">

            <figure class="swiper-slide testi__item">
              <blockquote class="testi__quote">
                O acompanhamento da Nuvvo desde a especificação até a entrega foi impecável. Cada projeto ganha um nível de cuidado que faz toda a diferença para nossos clientes.
              </blockquote>
              <figcaption class="testi__author">
                <span class="testi__avatar" aria-hidden="true">M</span>
                <div>
                  <div class="testi__name">[Arq. Mariana Lopes]</div>
                  <div class="testi__role">Arquiteta — São Paulo</div>
                </div>
              </figcaption>
            </figure>

            <figure class="swiper-slide testi__item">
              <blockquote class="testi__quote">
                A personalização é real: tecido, medida, acabamento — tudo conversado, tudo entregue exatamente como especifiquei. É raro encontrar esse nível de execução no Brasil.
              </blockquote>
              <figcaption class="testi__author">
                <span class="testi__avatar" aria-hidden="true">R</span>
                <div>
                  <div class="testi__name">[Arq. Rafael Andrade]</div>
                  <div class="testi__role">Arquiteto — Porto Alegre</div>
                </div>
              </figcaption>
            </figure>

            <figure class="swiper-slide testi__item">
              <blockquote class="testi__quote">
                A escolha de materiais e a atenção ao acabamento elevam a percepção do ambiente como um todo. Recomendo sem ressalvas para projetos de alta decoração.
              </blockquote>
              <figcaption class="testi__author">
                <span class="testi__avatar" aria-hidden="true">C</span>
                <div>
                  <div class="testi__name">[Arq. Camila Ribeiro]</div>
                  <div class="testi__role">Arquiteta — Florianópolis</div>
                </div>
              </figcaption>
            </figure>

            <figure class="swiper-slide testi__item">
              <blockquote class="testi__quote">
                Encontrei na Nuvvo o equilíbrio raro entre design autoral e disponibilidade técnica. A disponibilização de blocos 3D agilizou meu projeto desde a primeira etapa.
              </blockquote>
              <figcaption class="testi__author">
                <span class="testi__avatar" aria-hidden="true">P</span>
                <div>
                  <div class="testi__name">[Arq. Paulo Henrique]</div>
                  <div class="testi__role">Arquiteto — Curitiba</div>
                </div>
              </figcaption>
            </figure>

            <figure class="swiper-slide testi__item">
              <blockquote class="testi__quote">
                O sofá ficou exatamente como imaginei. A entrega no prazo e o cuidado na montagem mostraram o nível da equipe — desde o consultor até o entregador.
              </blockquote>
              <figcaption class="testi__author">
                <span class="testi__avatar" aria-hidden="true">L</span>
                <div>
                  <div class="testi__name">[Letícia Vasconcelos]</div>
                  <div class="testi__role">Cliente — Belo Horizonte</div>
                </div>
              </figcaption>
            </figure>

            <figure class="swiper-slide testi__item">
              <blockquote class="testi__quote">
                Cada conversa com o consultor mostrou que a Nuvvo entende o trabalho de arquitetura: precisão de medidas, vocabulário técnico e proatividade em sugestões.
              </blockquote>
              <figcaption class="testi__author">
                <span class="testi__avatar" aria-hidden="true">F</span>
                <div>
                  <div class="testi__name">[Arq. Fernanda Tavares]</div>
                  <div class="testi__role">Arquiteta — Vitória</div>
                </div>
              </figcaption>
            </figure>

          </div>
          <div class="swiper-pagination testi__pagination"></div>
        </div>
      </div>
    </section>

    <!-- ============ 9. CTA FINAL ============ -->
    <section class="cta-final" aria-label="Vamos conversar">
      <div class="wrap cta-final__inner reveal">
        <h2 class="cta-final__title">Vamos construir juntos espaços que inspiram?</h2>
        <p class="cta-final__lede">Deixe-se inspirar pela harmonia e conforto que o nosso design pode oferecer. Nossa equipe está pronta para te orientar.</p>
        <a href="https://wa.me/5554999485915?text=Ol%C3%A1%2C%20gostaria%20de%20falar%20com%20um%20consultor%20da%20Nuvvo%20Design"
           class="btn btn--cream"
           target="_blank" rel="noopener">
          Falar com consultor
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>
    </section>

<?php
get_footer();
