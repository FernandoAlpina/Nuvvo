<?php
/**
 * Template da página (page-a-nuvvo). Fase F0: markup estático portado; vira editável (Meta Box) depois.
 * @package Nuvvo (Alpina V4)
 */
if (!defined('ABSPATH')) { exit; }
get_header();
?>

    <!-- ============ 1. HERO INSTITUCIONAL ============ -->
    <section class="about-hero" aria-label="Apresentação da Nuvvo Design">
      <div class="about-hero__media">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hero-2.jpg"
             alt="Ambiente residencial com mobiliário Nuvvo Design"
             loading="eager" fetchpriority="high"
             data-parallax="0.15"
             width="1920" height="1280">
      </div>

      <nav class="breadcrumb" aria-label="Você está aqui">
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <span class="breadcrumb__sep" aria-hidden="true">/</span>
        <span class="breadcrumb__current" aria-current="page">A Nuvvo</span>
      </nav>

      <div class="wrap about-hero__inner">
        <h1 class="about-hero__title">Uma jornada construída sobre a atenção aos detalhes</h1>
        <p class="about-hero__sub">A Nuvvo Design nasce para materializar a bagagem de duas décadas e meia de trabalho artesanal. Somos a evolução de uma trajetória dedicada à qualidade, seriedade e respeito em cada projeto executado.</p>
      </div>
    </section>

    <!-- ============ 2. ESSÊNCIA ============ -->
    <section class="section" aria-label="A conexão entre herança e inovação">
      <div class="wrap">
        <header class="reveal" style="text-align:center; margin-bottom: var(--space-5);">
          <span class="eyebrow" style="justify-content:center;">Nossa história</span>
          <h2 class="section-title section-title--center">A conexão entre herança e inovação</h2>
        </header>

        <article class="essence-text reveal reveal--delay-1">
          <span class="essence-text__quote-mark" aria-hidden="true">“</span>
          <?php
          $anv_ess = function_exists('rwmb_meta') ? rwmb_meta('nuvvo_anuvvo_essencia', [], get_the_ID()) : '';
          if ($anv_ess) :
              echo wp_kses_post($anv_ess);
          else : ?>
          <p>A trajetória de mais de <strong>25 anos de história</strong>, iniciada pela Sofá News em 2000, é a base sólida que nos move. Construímos uma reputação através do <strong>trabalho artesanal na alta decoração</strong>, com cada peça cuidadosamente desenvolvida a partir de <strong>matéria-prima selecionada</strong> e processos rigorosos.</p>

          <p>Hoje, essa herança ganha novo capítulo: a Nuvvo Design apresenta um <strong>portfólio de mobiliário singular</strong>, com <em>design exclusivo</em> que traduz nossa visão contemporânea em peças autorais — pensadas para arquitetos e clientes que enxergam o ambiente como extensão da identidade.</p>

          <p>Nossa cultura é feita de <strong>evolução contínua</strong>, <strong>zelo absoluto</strong> em cada acabamento e o compromisso com um <strong>relacionamento próximo e humano</strong> — porque entendemos que o melhor design nasce da escuta atenta.</p>
          <?php endif; ?>
        </article>
      </div>
    </section>

    <!-- ============ 3. LINHA DO TEMPO ============ -->
    <section class="section timeline-section noise-bg" aria-label="Linha do tempo da Nuvvo">
      <div class="wrap">
        <header class="timeline-section__head reveal">
          <span class="eyebrow" style="justify-content:center;">Trajetória</span>
          <h2 class="section-title section-title--center">Marcos de uma história em movimento</h2>
        </header>

        <?php
        $anv_tl = function_exists('rwmb_meta') ? (array) rwmb_meta('nuvvo_anuvvo_timeline', [], get_the_ID()) : [];
        if (!$anv_tl) {
            $anv_tl = [
                ['ano' => '2000', 'titulo' => 'Fundação', 'desc' => 'O início de tudo, em um espaço de 80 m², movidos pela paixão e trabalho manual.', 'destaque' => ''],
                ['ano' => '2009', 'titulo' => 'Primeira Ampliação', 'desc' => 'O crescimento consistente nos levou a uma estrutura de 200 m².', 'destaque' => ''],
                ['ano' => '2024', 'titulo' => 'Expansão Estratégica', 'desc' => 'Consolidamos nosso parque fabril com 650 m², ampliando nossa capacidade produtiva.', 'destaque' => ''],
                ['ano' => '2026', 'titulo' => 'O Nascimento da Nuvvo Design', 'desc' => 'O lançamento de uma marca focada no design autoral e no atendimento exclusivo ao mercado de alta decoração.', 'destaque' => '1'],
            ];
        }
        // >4 marcos: adiciona classe p/ virar carrossel (init futuro em carousels.js)
        $tl_extra = count($anv_tl) > 4 ? ' timeline--overflow' : '';
        ?>
        <ol class="timeline<?php echo $tl_extra; ?>" role="list" aria-label="Marcos da história">
          <?php foreach ($anv_tl as $i => $m) :
            $feat  = !empty($m['destaque']) ? ' timeline__item--featured' : '';
            $delay = $i > 0 ? ' reveal--delay-' . min($i, 4) : '';
          ?>
          <li class="timeline__item<?php echo $feat; ?> reveal<?php echo $delay; ?>" tabindex="0" aria-label="Ano <?php echo esc_attr($m['ano'] ?? ''); ?>: <?php echo esc_attr($m['titulo'] ?? ''); ?>">
            <span class="timeline__dot" aria-hidden="true"></span>
            <p class="timeline__year"><?php echo esc_html($m['ano'] ?? ''); ?></p>
            <p class="timeline__title"><?php echo esc_html($m['titulo'] ?? ''); ?></p>
            <p class="timeline__desc"><?php echo esc_html($m['desc'] ?? ''); ?></p>
          </li>
          <?php endforeach; ?>
        </ol>
      </div>
    </section>

    <!-- ============ 4. BIG NUMBERS (editável no painel Nuvvo) ============ -->
    <?php get_template_part('template-parts/big-numbers'); ?>

    <!-- ============ 5. DIFERENCIAIS (carrossel) ============ -->
    <section class="section" aria-label="A assinatura técnica da Nuvvo Design">
      <div class="wrap">
        <header class="features__head reveal">
          <div>
            <span class="eyebrow">Diferenciais</span>
            <h2 class="section-title">A assinatura técnica da Nuvvo Design</h2>
          </div>
          <div class="features__nav" role="group" aria-label="Navegar diferenciais">
            <button class="swiper-btn features__prev" type="button" aria-label="Diferencial anterior">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
            </button>
            <button class="swiper-btn features__next" type="button" aria-label="Próximo diferencial">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>
          </div>
        </header>

        <div class="swiper features__swiper reveal">
          <div class="swiper-wrapper">

            <article class="swiper-slide">
              <!-- href configurável por card (hoje: WhatsApp atual) -->
              <a class="card-feature" href="https://wa.me/5554999485915?text=Ol%C3%A1%21%20Gostaria%20de%20saber%20mais%20sobre%20o%20Design%20Exclusivo%20da%20Nuvvo." target="_blank" rel="noopener" aria-label="Design Exclusivo — falar no WhatsApp">
                <svg class="card-feature__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                  <path d="M16 2l3.7 9.5L29 13l-7 6.5L24 29l-8-5-8 5 2-9.5L3 13l9.3-1.5z"/>
                </svg>
                <h3 class="card-feature__title">Design Exclusivo</h3>
                <p class="card-feature__body">Peças com identidade única, pensadas para expressar autenticidade em cada ambiente.</p>
              </a>
            </article>

            <article class="swiper-slide">
              <a class="card-feature" href="https://wa.me/5554999485915?text=Ol%C3%A1%21%20Tenho%20interesse%20na%20personaliza%C3%A7%C3%A3o%20%28medidas%20e%20acabamentos%29%20da%20Nuvvo." target="_blank" rel="noopener" aria-label="Personalização de acabamentos — falar no WhatsApp">
                <svg class="card-feature__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                  <circle cx="9" cy="9" r="2.5"/><path d="M3 9h3.5M11.5 9H29"/>
                  <circle cx="20" cy="17" r="2.5"/><path d="M3 17h14.5M22.5 17H29"/>
                  <circle cx="13" cy="25" r="2.5"/><path d="M3 25h7.5M15.5 25H29"/>
                </svg>
                <h3 class="card-feature__title">Personalização de acabamentos</h3>
                <p class="card-feature__body">Diversas opções de tecidos e medidas pré-definidas para adequar cada peça ao seu projeto.</p>
              </a>
            </article>

            <article class="swiper-slide">
              <!-- destino: WhatsApp do consultor responsável (hoje: WhatsApp atual) -->
              <a class="card-feature" href="https://wa.me/5554999485915?text=Ol%C3%A1%21%20Sou%20arquiteto%28a%29%20e%20gostaria%20de%20falar%20com%20a%20equipe%20da%20Nuvvo." target="_blank" rel="noopener" aria-label="Parceria com o arquiteto — falar no WhatsApp">
                <svg class="card-feature__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                  <circle cx="10" cy="11" r="3.5"/><path d="M3 27c0-4 3-7 7-7s7 3 7 7"/>
                  <circle cx="22" cy="11" r="3.5"/><path d="M16 22c1.5-1 3.5-2 6-2s4.5 1 6 3"/>
                </svg>
                <h3 class="card-feature__title">Parceria com o arquiteto</h3>
                <p class="card-feature__body">Acompanhamento humano e próximo, garantindo suporte em todas as etapas: da especificação à entrega.</p>
              </a>
            </article>

            <article class="swiper-slide">
              <!-- Biblioteca de blocos 3D no 3D Warehouse -->
              <a class="card-feature" href="https://3dwarehouse.sketchup.com/user/61f45a49-50d6-41a1-8202-89e4f458c8ea" target="_blank" rel="noopener" aria-label="Praticidade na especificação — biblioteca de blocos 3D no 3D Warehouse">
                <svg class="card-feature__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                  <rect x="5" y="3" width="22" height="26" rx="2"/>
                  <path d="M10 11h12M10 16h12M10 21h7"/>
                  <path d="M19 24l3 3 5-6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h3 class="card-feature__title">Praticidade na especificação</h3>
                <p class="card-feature__body">Disponibilizamos blocos 3D e fichas técnicas detalhadas para integrar nosso design ao seu projeto com precisão e agilidade.</p>
              </a>
            </article>

            <article class="swiper-slide">
              <a class="card-feature" href="https://wa.me/5554999485915?text=Ol%C3%A1%21%20Gostaria%20de%20saber%20mais%20sobre%20a%20produ%C3%A7%C3%A3o%20artesanal%20da%20Nuvvo." target="_blank" rel="noopener" aria-label="Zelo e Produção Artesanal — falar no WhatsApp">
                <svg class="card-feature__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                  <path d="M6 16c0-5 4-9 10-9s10 4 10 9v9H6z"/>
                  <path d="M11 25v-6M16 25v-9M21 25v-6"/>
                </svg>
                <h3 class="card-feature__title">Zelo e Produção Artesanal</h3>
                <p class="card-feature__body">Nossos estofados unem a precisão da engenharia de ponta ao cuidado rigoroso do trabalho manual, assegurando um acabamento impecável em cada processo.</p>
              </a>
            </article>

          </div>
          <div class="swiper-pagination features__pagination"></div>
        </div>
      </div>
    </section>

    <!-- ============ 6. DESIGNER ============ -->
    <section class="section designer-section" aria-label="Designer Deivid de Almeida">
      <div class="wrap">
        <div class="designer-split">

          <div class="designer-split__photo reveal">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/designer-deivid.jpg"
                 alt="Retrato editorial em preto e branco do designer Deivid de Almeida"
                 loading="lazy"
                 width="600" height="750">
          </div>

          <div class="designer-split__content reveal reveal--delay-1">
            <span class="eyebrow">Designer assinado</span>
            <h2 class="designer-split__title">Design sob a assinatura de Deivid de Almeida</h2>

            <div class="designer-split__body">
              <p>Atuante na <em>indústria moveleira desde os anos 2000</em>, Deivid de Almeida construiu uma <strong>expertise técnica lapidada em um processo constante de evolução e refinamento</strong>. Cada peça que assina carrega o repertório de mais de duas décadas de prática.</p>

              <p>Seu trabalho parte de uma obsessão silenciosa: <strong>traduzir comportamento humano em mobiliário</strong>. <em>Ergonomia</em>, <em>conforto tátil</em> e <em>perfeição técnica</em> deixam de ser exigências para se tornarem ponto de partida — porque é assim que o design se torna invisível e essencial ao mesmo tempo.</p>
            </div>

            <span class="designer-split__signature">Deivid de Almeida</span>
          </div>

        </div>
      </div>
    </section>

    <!-- ============ 7. VÍDEO INSTITUCIONAL ============
         Para ocultar a seção inteira, troque data-video-available="true" → "false"
         Para ativar o vídeo, defina data-video-src no .video-block (ver README) -->
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

    <!-- ============ 8. MISSÃO / VISÃO / VALORES ============ -->
    <section class="section mvv-section" aria-label="Missão, visão e valores">
      <div class="wrap">
        <header class="reveal" style="text-align:center; margin-bottom: var(--space-6);">
          <span class="eyebrow" style="justify-content:center;">Nosso compasso</span>
          <h2 class="section-title section-title--center">Missão, visão e valores</h2>
          <p class="lede" style="margin-inline:auto; text-align:center;">A bússola interna que orienta cada decisão da Nuvvo Design.</p>
        </header>

        <div class="mvv-grid">

          <article class="mvv-block reveal">
            <span class="mvv-block__num">01</span>
            <svg class="mvv-block__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
              <circle cx="16" cy="16" r="11"/>
              <circle cx="16" cy="16" r="4"/>
              <path d="M16 5v6M16 21v6M5 16h6M21 16h6"/>
            </svg>
            <h3 class="mvv-block__title">Missão</h3>
            <p class="mvv-block__text"><?php echo esc_html(nuvvo_pgf('nuvvo_anuvvo_missao', 'Inspirar design que conecta pessoas e harmoniza ambientes exclusivos.')); ?></p>
          </article>

          <article class="mvv-block reveal reveal--delay-1">
            <span class="mvv-block__num">02</span>
            <svg class="mvv-block__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
              <path d="M2 16s5-9 14-9 14 9 14 9-5 9-14 9S2 16 2 16z"/>
              <circle cx="16" cy="16" r="4"/>
            </svg>
            <h3 class="mvv-block__title">Visão</h3>
            <p class="mvv-block__text"><?php echo esc_html(nuvvo_pgf('nuvvo_anuvvo_visao', 'Ser referência em design de mobiliário residencial de alta decoração.')); ?></p>
          </article>

          <article class="mvv-block reveal reveal--delay-2">
            <span class="mvv-block__num">03</span>
            <svg class="mvv-block__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
              <path d="M16 4l11 5v8c0 7-5 11-11 13C5 27 0 23 0 16V8z" transform="translate(2.5 0)"/>
              <path d="M12 16l3 3 6-6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h3 class="mvv-block__title">Valores</h3>
            <ul class="mvv-list" role="list">
              <?php
              $anv_val = function_exists('rwmb_meta') ? array_filter((array) rwmb_meta('nuvvo_anuvvo_valores', [], get_the_ID())) : [];
              if (!$anv_val) {
                  $anv_val = ['Zelo', 'Comprometimento', 'Espírito de Equipe', 'Prestatividade', 'Confiança'];
              }
              foreach ($anv_val as $val) : ?>
                <li class="mvv-list__chip"><?php echo esc_html($val); ?></li>
              <?php endforeach; ?>
            </ul>
          </article>

        </div>
      </div>
    </section>

    <!-- ============ 9. CTA FINAL (reusado da Home) ============ -->
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
