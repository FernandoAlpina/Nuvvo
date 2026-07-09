<?php
/**
 * Template da página (page-a-nuvvo). Fase F0: markup estático portado; vira editável (Meta Box) depois.
 * @package Nuvvo (Alpina V4)
 */
if (!defined('ABSPATH')) { exit; }
get_header();
?>

    <!-- ============ 1. HERO INSTITUCIONAL ============ -->
    <?php
    // Hero editável (imagem via single_image; textos via campos da página) — fallback no conteúdo atual.
    $anv_hero_img_id = function_exists('rwmb_meta') ? rwmb_meta('nuvvo_anuvvo_hero_img', [], get_the_ID()) : '';
    if (is_array($anv_hero_img_id)) { $anv_hero_img_id = reset($anv_hero_img_id); }
    $anv_hero_img = $anv_hero_img_id ? wp_get_attachment_image_url((int) $anv_hero_img_id, 'full') : '';
    if (!$anv_hero_img) { $anv_hero_img = get_template_directory_uri() . '/assets/img/hero-2.jpg'; }

    $anv_hero_eyebrow = nuvvo_pgf('nuvvo_anuvvo_hero_eyebrow', '');
    $anv_hero_titulo  = nuvvo_pgf('nuvvo_anuvvo_hero_titulo', 'Uma jornada construída sobre a atenção aos detalhes');
    $anv_hero_sub     = nuvvo_pgf('nuvvo_anuvvo_hero_sub', 'A Nuvvo Design nasce para materializar a bagagem de duas décadas e meia de trabalho artesanal. Somos a evolução de uma trajetória dedicada à qualidade, seriedade e respeito em cada projeto executado.');
    ?>
    <section class="about-hero" aria-label="Apresentação da Nuvvo Design">
      <div class="about-hero__media">
        <img src="<?php echo esc_url($anv_hero_img); ?>"
             alt="Ambiente residencial com mobiliário Nuvvo Design"
             loading="eager" fetchpriority="high"
             data-parallax="0.15"<?php if (!$anv_hero_img_id) : ?>
             width="1920" height="1280"<?php endif; ?>>
      </div>

      <nav class="breadcrumb" aria-label="Você está aqui">
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <span class="breadcrumb__sep" aria-hidden="true">/</span>
        <span class="breadcrumb__current" aria-current="page">A Nuvvo</span>
      </nav>

      <div class="wrap about-hero__inner">
        <?php if ($anv_hero_eyebrow) : ?><span class="eyebrow" style="color: var(--color-cream);"><?php echo esc_html($anv_hero_eyebrow); ?></span><?php endif; ?>
        <h1 class="about-hero__title"><?php echo esc_html($anv_hero_titulo); ?></h1>
        <p class="about-hero__sub"><?php echo esc_html($anv_hero_sub); ?></p>
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
        // Trajetória: grid até 4 marcos; carrossel (Swiper) quando >4.
        $tl_carousel = count($anv_tl) > 4;
        ?>
        <?php if ($tl_carousel) : ?>
        <div class="swiper timeline__swiper" aria-label="Marcos da história">
          <div class="swiper-wrapper">
            <?php foreach ($anv_tl as $m) :
              $feat = !empty($m['destaque']) ? ' timeline__item--featured' : '';
            ?>
            <div class="swiper-slide timeline__item<?php echo $feat; ?>" tabindex="0" aria-label="Ano <?php echo esc_attr($m['ano'] ?? ''); ?>: <?php echo esc_attr($m['titulo'] ?? ''); ?>">
              <span class="timeline__dot" aria-hidden="true"></span>
              <p class="timeline__year"><?php echo esc_html($m['ano'] ?? ''); ?></p>
              <p class="timeline__title"><?php echo esc_html($m['titulo'] ?? ''); ?></p>
              <p class="timeline__desc"><?php echo esc_html($m['desc'] ?? ''); ?></p>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="timeline__pagination swiper-pagination"></div>
        </div>
        <?php else : ?>
        <ol class="timeline" role="list" aria-label="Marcos da história">
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
        <?php endif; ?>
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

        <?php
        // Diferenciais editáveis (grupo clonável) — fallback nos 5 cards atuais.
        // Ícones pré-definidos (chave => markup interno do SVG) reusando os SVGs originais.
        $anv_dif_icons = [
            'star'    => '<path d="M16 2l3.7 9.5L29 13l-7 6.5L24 29l-8-5-8 5 2-9.5L3 13l9.3-1.5z"/>',
            'sliders' => '<circle cx="9" cy="9" r="2.5"/><path d="M3 9h3.5M11.5 9H29"/><circle cx="20" cy="17" r="2.5"/><path d="M3 17h14.5M22.5 17H29"/><circle cx="13" cy="25" r="2.5"/><path d="M3 25h7.5M15.5 25H29"/>',
            'people'  => '<circle cx="10" cy="11" r="3.5"/><path d="M3 27c0-4 3-7 7-7s7 3 7 7"/><circle cx="22" cy="11" r="3.5"/><path d="M16 22c1.5-1 3.5-2 6-2s4.5 1 6 3"/>',
            'doc'     => '<rect x="5" y="3" width="22" height="26" rx="2"/><path d="M10 11h12M10 16h12M10 21h7"/><path d="M19 24l3 3 5-6" stroke-linecap="round" stroke-linejoin="round"/>',
            'craft'   => '<path d="M6 16c0-5 4-9 10-9s10 4 10 9v9H6z"/><path d="M11 25v-6M16 25v-9M21 25v-6"/>',
        ];
        $anv_dif = function_exists('rwmb_meta') ? array_filter((array) rwmb_meta('nuvvo_anuvvo_diferenciais', [], get_the_ID())) : [];
        if (!$anv_dif) {
            $anv_dif = [
                ['icone' => 'star',    'titulo' => 'Design Exclusivo',                'texto' => 'Peças com identidade única, pensadas para expressar autenticidade em cada ambiente.',                                                          'link' => 'https://wa.me/5554999485915?text=Ol%C3%A1%21%20Gostaria%20de%20saber%20mais%20sobre%20o%20Design%20Exclusivo%20da%20Nuvvo.',                    'target' => '1', 'aria' => 'Design Exclusivo — falar no WhatsApp'],
                ['icone' => 'sliders', 'titulo' => 'Personalização de acabamentos',   'texto' => 'Diversas opções de tecidos e medidas pré-definidas para adequar cada peça ao seu projeto.',                                                     'link' => 'https://wa.me/5554999485915?text=Ol%C3%A1%21%20Tenho%20interesse%20na%20personaliza%C3%A7%C3%A3o%20%28medidas%20e%20acabamentos%29%20da%20Nuvvo.', 'target' => '1', 'aria' => 'Personalização de acabamentos — falar no WhatsApp'],
                ['icone' => 'people',  'titulo' => 'Parceria com o arquiteto',        'texto' => 'Acompanhamento humano e próximo, garantindo suporte em todas as etapas: da especificação à entrega.',                                          'link' => 'https://wa.me/5554999485915?text=Ol%C3%A1%21%20Sou%20arquiteto%28a%29%20e%20gostaria%20de%20falar%20com%20a%20equipe%20da%20Nuvvo.',              'target' => '1', 'aria' => 'Parceria com o arquiteto — falar no WhatsApp'],
                ['icone' => 'doc',     'titulo' => 'Praticidade na especificação',    'texto' => 'Disponibilizamos blocos 3D e fichas técnicas detalhadas para integrar nosso design ao seu projeto com precisão e agilidade.',                    'link' => 'https://3dwarehouse.sketchup.com/user/61f45a49-50d6-41a1-8202-89e4f458c8ea',                                                             'target' => '1', 'aria' => 'Praticidade na especificação — biblioteca de blocos 3D no 3D Warehouse'],
                ['icone' => 'craft',   'titulo' => 'Zelo e Produção Artesanal',       'texto' => 'Nossos estofados unem a precisão da engenharia de ponta ao cuidado rigoroso do trabalho manual, assegurando um acabamento impecável em cada processo.', 'link' => 'https://wa.me/5554999485915?text=Ol%C3%A1%21%20Gostaria%20de%20saber%20mais%20sobre%20a%20produ%C3%A7%C3%A3o%20artesanal%20da%20Nuvvo.',        'target' => '1', 'aria' => 'Zelo e Produção Artesanal — falar no WhatsApp'],
            ];
        }
        ?>
        <div class="swiper features__swiper reveal">
          <div class="swiper-wrapper">
            <?php foreach ($anv_dif as $d) :
              $d_titulo = $d['titulo'] ?? '';
              $d_texto  = $d['texto'] ?? '';
              $d_link   = $d['link'] ?? '';
              $d_icon   = $d['icone'] ?? '';
              $d_svg    = $anv_dif_icons[$d_icon] ?? $anv_dif_icons['star'];
              $d_aria   = $d['aria'] ?? $d_titulo;
              $d_target = !empty($d['target']);
              $d_tag    = $d_link ? 'a' : 'div'; // vira <a> se tiver link, senão <div> (preserva comportamento atual)
            ?>
            <article class="swiper-slide">
              <<?php echo $d_tag; ?> class="card-feature"<?php
                if ($d_link) {
                    echo ' href="' . esc_url($d_link) . '"';
                    if ($d_target) { echo ' target="_blank" rel="noopener"'; }
                    echo ' aria-label="' . esc_attr($d_aria) . '"';
                }
              ?>>
                <svg class="card-feature__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><?php echo $d_svg; ?></svg>
                <h3 class="card-feature__title"><?php echo esc_html($d_titulo); ?></h3>
                <p class="card-feature__body"><?php echo esc_html($d_texto); ?></p>
              </<?php echo $d_tag; ?>>
            </article>
            <?php endforeach; ?>
          </div>
          <div class="swiper-pagination features__pagination"></div>
        </div>
      </div>
    </section>

    <!-- ============ 6. DESIGNER ============ -->
    <?php
    // Designer editável — fallback nos dados atuais.
    $anv_designer_nome  = nuvvo_pgf('nuvvo_anuvvo_designer_nome', 'Deivid de Almeida');
    $anv_designer_cargo = nuvvo_pgf('nuvvo_anuvvo_designer_cargo', 'Designer assinado');

    $anv_designer_foto_id = function_exists('rwmb_meta') ? rwmb_meta('nuvvo_anuvvo_designer_foto', [], get_the_ID()) : '';
    if (is_array($anv_designer_foto_id)) { $anv_designer_foto_id = reset($anv_designer_foto_id); }
    $anv_designer_foto = $anv_designer_foto_id ? wp_get_attachment_image_url((int) $anv_designer_foto_id, 'full') : '';
    if (!$anv_designer_foto) { $anv_designer_foto = get_template_directory_uri() . '/assets/img/designer-deivid.jpg'; }

    $anv_designer_bio = function_exists('rwmb_meta') ? rwmb_meta('nuvvo_anuvvo_designer_bio', [], get_the_ID()) : '';
    if (is_array($anv_designer_bio)) { $anv_designer_bio = reset($anv_designer_bio); }
    ?>
    <section class="section designer-section" aria-label="<?php echo esc_attr('Designer ' . $anv_designer_nome); ?>">
      <div class="wrap">
        <div class="designer-split">

          <div class="designer-split__photo reveal">
            <img src="<?php echo esc_url($anv_designer_foto); ?>"
                 alt="<?php echo esc_attr('Retrato editorial em preto e branco do designer ' . $anv_designer_nome); ?>"
                 loading="lazy"<?php if (!$anv_designer_foto_id) : ?>
                 width="600" height="750"<?php endif; ?>>
          </div>

          <div class="designer-split__content reveal reveal--delay-1">
            <span class="eyebrow"><?php echo esc_html($anv_designer_cargo); ?></span>
            <h2 class="designer-split__title">Design sob a assinatura de <?php echo esc_html($anv_designer_nome); ?></h2>

            <div class="designer-split__body">
              <?php if ($anv_designer_bio) :
                  echo wp_kses_post($anv_designer_bio);
              else : ?>
              <p>Atuante na <em>indústria moveleira desde os anos 2000</em>, Deivid de Almeida construiu uma <strong>expertise técnica lapidada em um processo constante de evolução e refinamento</strong>. Cada peça que assina carrega o repertório de mais de duas décadas de prática.</p>

              <p>Seu trabalho parte de uma obsessão silenciosa: <strong>traduzir comportamento humano em mobiliário</strong>. <em>Ergonomia</em>, <em>conforto tátil</em> e <em>perfeição técnica</em> deixam de ser exigências para se tornarem ponto de partida — porque é assim que o design se torna invisível e essencial ao mesmo tempo.</p>
              <?php endif; ?>
            </div>

            <span class="designer-split__signature"><?php echo esc_html($anv_designer_nome); ?></span>
          </div>

        </div>
      </div>
    </section>

    <!-- ============ 7. VÍDEO INSTITUCIONAL (editável) ============ -->
    <?php
    $anv_id = (int) get_the_ID();
    $anv_video = function_exists('nuvvo_video_source')
        ? nuvvo_video_source('nuvvo_anuvvo_video_url', 'nuvvo_anuvvo_video_mp4', $anv_id)
        : ['src' => '', 'type' => ''];
    $anv_video_poster_id = function_exists('rwmb_meta') ? rwmb_meta('nuvvo_anuvvo_video_poster', [], $anv_id) : '';
    if (is_array($anv_video_poster_id)) { $anv_video_poster_id = reset($anv_video_poster_id); }
    $anv_video_poster = $anv_video_poster_id ? wp_get_attachment_image_url((int) $anv_video_poster_id, 'full') : '';
    $anv_video_exibir = nuvvo_pgf('nuvvo_anuvvo_video_exibir', '1');
    get_template_part('template-parts/video-institucional', null, [
        'exibir'  => ($anv_video_exibir !== '0' && $anv_video_exibir !== ''),
        'eyebrow' => nuvvo_pgf('nuvvo_anuvvo_video_eyebrow', 'Conheça por dentro'),
        'titulo'  => nuvvo_pgf('nuvvo_anuvvo_video_titulo', 'Bastidores e processo'),
        'src'     => $anv_video['src'],
        'type'    => $anv_video['type'] !== '' ? $anv_video['type'] : 'iframe',
        'poster'  => $anv_video_poster,
    ]);
    ?>

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
    <?php
    // CTA final editável — fallback no conteúdo atual.
    $anv_cta_titulo = nuvvo_pgf('nuvvo_anuvvo_cta_titulo', 'Vamos construir juntos espaços que inspiram?');
    $anv_cta_lede   = nuvvo_pgf('nuvvo_anuvvo_cta_lede', 'Deixe-se inspirar pela harmonia e conforto que o nosso design pode oferecer. Nossa equipe está pronta para te orientar.');
    $anv_cta_btn    = nuvvo_pgf('nuvvo_anuvvo_cta_btn', 'Falar com consultor');
    $anv_cta_msg    = nuvvo_pgf('nuvvo_anuvvo_cta_msg', 'Olá, gostaria de falar com um consultor da Nuvvo Design');
    $anv_cta_url    = function_exists('nuvvo_wa_link') ? nuvvo_wa_link($anv_cta_msg) : 'https://wa.me/5554999485915?text=' . rawurlencode($anv_cta_msg);
    ?>
    <section class="cta-final" aria-label="Vamos conversar">
      <div class="wrap cta-final__inner reveal">
        <h2 class="cta-final__title"><?php echo esc_html($anv_cta_titulo); ?></h2>
        <p class="cta-final__lede"><?php echo esc_html($anv_cta_lede); ?></p>
        <a href="<?php echo esc_url($anv_cta_url); ?>"
           class="btn btn--cream"
           target="_blank" rel="noopener">
          <?php echo esc_html($anv_cta_btn); ?>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>
    </section>

<?php
get_footer();
