<?php
/**
 * Template da Home (front-page).
 * Fase F0: markup estático portado do index.html; será convertido em campos
 * editáveis (Meta Box) nas fases seguintes.
 * @package Nuvvo (Alpina V4)
 */
if (!defined('ABSPATH')) { exit; }
get_header();

$home_id = (int) get_option('page_on_front');
$read = function ($id, $default = '') use ($home_id) {
    if (!$home_id || !function_exists('rwmb_meta')) { return $default; }
    $v = rwmb_meta($id, [], $home_id);
    if (is_array($v)) { $v = reset($v); }
    $v = is_string($v) ? trim($v) : '';
    return $v !== '' ? $v : $default;
};

// Banner / hero
$hero_slides = ($home_id && function_exists('rwmb_meta')) ? (array) rwmb_meta('nuvvo_home_hero_slides', [], $home_id) : [];
$hero_titulo = $read('nuvvo_home_hero_titulo', 'Mobiliário personalizado de alta decoração');
$hero_sub    = $read('nuvvo_home_hero_sub', 'Design autoral que traduz a harmonia entre o rigor da produção artesanal e a sofisticação do morar contemporâneo.');
$hero_cta    = $read('nuvvo_home_hero_cta', 'Falar com especialista');
$hero_cta_msg = $read('nuvvo_home_hero_cta_msg', 'Olá, gostaria de falar com um especialista da Nuvvo Design');
$hero_cta_url = function_exists('nuvvo_wa_link') ? nuvvo_wa_link($hero_cta_msg) : 'https://wa.me/5554999485915?text=' . rawurlencode($hero_cta_msg);

// Catálogo (seção #catalog): título/sub editáveis + cards dinâmicos por termo.
$cat_titulo = $read('nuvvo_home_catalogo_titulo', '');
$cat_sub    = $read('nuvvo_home_catalogo_sub', 'Explore peças desenvolvidas com alta marcenaria, produção artesanal e acabamento impecável.');
$cat_terms  = get_terms(['taxonomy' => 'categoria_produto', 'parent' => 0, 'hide_empty' => false]);
if (is_wp_error($cat_terms)) { $cat_terms = []; }

// Produtos em destaque: título editável (slides via WP_Query na seção).
$destaque_titulo = $read('nuvvo_home_destaque_titulo', 'Seleção em destaque');

// Pilares (A essência): grupo clonável com fallback nos 3 atuais.
$pilares = [];
if ($home_id && function_exists('rwmb_meta')) {
    foreach ((array) rwmb_meta('nuvvo_home_pilares', [], $home_id) as $p) {
        $p_num = isset($p['numero']) ? trim((string) $p['numero']) : '';
        $p_tit = isset($p['titulo']) ? trim((string) $p['titulo']) : '';
        $p_txt = isset($p['texto']) ? trim((string) $p['texto']) : '';
        if ($p_tit === '' && $p_txt === '') { continue; }
        $pilares[] = ['numero' => $p_num, 'titulo' => $p_tit, 'texto' => $p_txt];
    }
}
if (!$pilares) {
    $pilares = [
        ['numero' => '01', 'titulo' => 'Design Exclusivo', 'texto' => 'Peças com identidade própria, assinadas e criadas para serem um convite ao bem estar, à contemplação e à celebração da vida.'],
        ['numero' => '02', 'titulo' => 'Capacidade de Personalização', 'texto' => 'Mais de 3.000 opções de cores e acabamentos, além de diversas medidas disponíveis para a especificação precisa do seu projeto.'],
        ['numero' => '03', 'titulo' => 'Acompanhamento Próximo', 'texto' => 'Atuamos lado a lado com o arquiteto em todas as etapas, da especificação técnica à entrega final.'],
    ];
}

// Nuvvo News: título editável (cards via WP_Query na seção).
$news_titulo = $read('nuvvo_home_news_titulo', 'Nuvvo News: dicas e tendências');

// Depoimentos: título/subtítulo editáveis (itens via WP_Query na seção).
$testi_titulo = $read('nuvvo_home_testi_titulo', 'A experiência Nuvvo');
$testi_sub    = $read('nuvvo_home_testi_sub', 'A experiência Nuvvo');

// CTA final.
$cta_titulo = $read('nuvvo_home_cta_titulo', 'Vamos construir juntos espaços que inspiram?');
$cta_lede   = $read('nuvvo_home_cta_lede', 'Deixe-se inspirar pela harmonia e conforto que o nosso design pode oferecer. Nossa equipe está pronta para te orientar.');
$cta_btn    = $read('nuvvo_home_cta_btn', 'Falar com consultor');
$cta_msg    = $read('nuvvo_home_cta_msg', 'Olá, gostaria de falar com um consultor da Nuvvo Design');
$cta_url    = function_exists('nuvvo_wa_link') ? nuvvo_wa_link($cta_msg) : 'https://wa.me/5554999485915?text=' . rawurlencode($cta_msg);
?>

    <!-- ============ 1. HERO ============ -->
    <section class="hero" id="hero" aria-label="Apresentação">
      <div class="hero__media" data-parallax="0.15">
        <!-- Carrossel de 3 fotos lifestyle. Quando vídeo institucional chegar, substituir por <video autoplay muted loop playsinline poster="..."> -->
        <div class="swiper hero__swiper">
          <div class="swiper-wrapper">
            <?php if ($hero_slides) :
                foreach ($hero_slides as $i => $slide) :
                    $sid  = $slide['imagem'] ?? '';
                    $surl = $sid ? wp_get_attachment_image_url((int) $sid, 'full') : '';
                    if (!$surl) { continue; }
                    ?>
            <div class="swiper-slide hero__slide">
              <img src="<?php echo esc_url($surl); ?>" alt="<?php echo esc_attr($slide['alt'] ?? ''); ?>" loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>"<?php echo $i === 0 ? ' fetchpriority="high"' : ''; ?>>
            </div>
            <?php endforeach; else : ?>
            <div class="swiper-slide hero__slide">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hero-1.png" alt="Sofá Pecan em ambiente residencial com plantas e mesa lateral de madeira" loading="eager" fetchpriority="high" width="1920" height="1080">
            </div>
            <div class="swiper-slide hero__slide">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hero-2.jpg" alt="Sofá Pecan em sala iluminada com escada de vidro e palmeira ao fundo" loading="lazy" width="1920" height="1280">
            </div>
            <div class="swiper-slide hero__slide">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hero-3.jpg" alt="Sofá modular branco com mesa de centro baixa e revistas, ambiente contemporâneo" loading="lazy" width="1920" height="1280">
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="wrap hero__inner">
        <div>
          <h1 class="hero__title"><?php echo esc_html($hero_titulo); ?></h1>
          <p class="hero__sub"><?php echo esc_html($hero_sub); ?></p>
        </div>
        <div class="hero__cta">
          <a href="<?php echo esc_url($hero_cta_url); ?>"
             class="btn btn--cream"
             target="_blank" rel="noopener">
            <?php echo esc_html($hero_cta); ?>
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

    <!-- ============ VÍDEO INSTITUCIONAL (editável na Home) ============ -->
    <?php
    $home_video = function_exists('nuvvo_video_source')
        ? nuvvo_video_source('nuvvo_home_video_url', 'nuvvo_home_video_mp4', $home_id)
        : ['src' => '', 'type' => ''];
    $home_video_poster_id = ($home_id && function_exists('rwmb_meta')) ? rwmb_meta('nuvvo_home_video_poster', [], $home_id) : '';
    if (is_array($home_video_poster_id)) { $home_video_poster_id = reset($home_video_poster_id); }
    $home_video_poster = $home_video_poster_id ? wp_get_attachment_image_url((int) $home_video_poster_id, 'full') : '';
    $home_video_exibir = $read('nuvvo_home_video_exibir', '1');
    get_template_part('template-parts/video-institucional', null, [
        'exibir'  => ($home_video_exibir !== '0' && $home_video_exibir !== ''),
        'eyebrow' => $read('nuvvo_home_video_eyebrow', 'Conheça por dentro'),
        'titulo'  => $read('nuvvo_home_video_titulo', 'Bastidores e processo'),
        'src'     => $home_video['src'],
        'type'    => $home_video['type'] !== '' ? $home_video['type'] : 'iframe',
        'poster'  => $home_video_poster,
    ]);
    ?>

    <!-- ============ 3. CATÁLOGO ============ -->
    <section class="section" id="catalog" aria-label="Catálogo">
      <div class="wrap">
        <header class="catalog__head">
          <div class="reveal">
            <span class="eyebrow">Catálogo</span>
            <?php if ($cat_titulo !== '') : ?>
            <h2 class="section-title"><?php echo esc_html($cat_titulo); ?></h2>
            <?php else : ?>
            <h2 class="section-title">Catálogo Nuvvo:<br>Mobiliário de alta decoração</h2>
            <?php endif; ?>
            <p class="lede"><?php echo esc_html($cat_sub); ?></p>
          </div>
          <a href="<?php echo esc_url(home_url('/catalogo/')); ?>" class="btn btn--secondary reveal reveal--delay-1">
            Ver catálogo
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </a>
        </header>

        <div class="catalog__grid">

          <?php if ($cat_terms) :
              foreach ($cat_terms as $ci => $ct) :
                  $ct_link = get_term_link($ct);
                  if (is_wp_error($ct_link)) { continue; }

                  // Imagem do termo (term meta single image); fallback = SVG placeholder.
                  $ct_img_url = '';
                  if (function_exists('rwmb_meta')) {
                      $ct_imgs = rwmb_meta('categoria_produto_imagem', ['object_type' => 'term', 'size' => 'large'], $ct->term_id);
                      if (is_array($ct_imgs) && $ct_imgs) {
                          $ct_first   = reset($ct_imgs);
                          $ct_img_url = is_array($ct_first) ? ($ct_first['url'] ?? '') : (wp_get_attachment_image_url((int) $ct_first, 'large') ?: '');
                      }
                  }
                  $ct_delay = $ci > 0 ? ' reveal--delay-' . min((int) $ci, 3) : '';
                  ?>
          <a href="<?php echo esc_url($ct_link); ?>" class="card-cat reveal<?php echo $ct_delay; ?>">
            <div class="card-cat__media">
              <?php if ($ct_img_url) : ?>
                <img src="<?php echo esc_url($ct_img_url); ?>"
                     alt="Coleção de <?php echo esc_attr($ct->name); ?> Nuvvo"
                     loading="lazy"
                     width="800" height="1000">
              <?php else : ?>
                <svg viewBox="0 0 400 500" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <rect width="400" height="500" fill="#7A6B5C"/>
                  <g opacity="0.4" fill="#F0EDE4">
                    <rect x="120" y="180" width="160" height="220" rx="20"/>
                    <rect x="120" y="280" width="160" height="100" rx="8"/>
                    <rect x="100" y="260" width="30" height="160" rx="4"/>
                    <rect x="270" y="260" width="30" height="160" rx="4"/>
                  </g>
                </svg>
              <?php endif; ?>
            </div>
            <div class="card-cat__label">
              <span class="card-cat__name"><?php echo esc_html($ct->name); ?></span>
              <span class="card-cat__arrow" aria-hidden="true">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M7 17 17 7M10 7h7v7"/></svg>
              </span>
            </div>
          </a>
          <?php endforeach; else : ?>

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

          <?php endif; ?>

        </div>
      </div>
    </section>

    <!-- ============ 4. PRODUTOS EM DESTAQUE ============ -->
    <section class="section" aria-label="Produtos em destaque">
      <div class="wrap">
        <header class="featured__head reveal">
          <div>
            <span class="eyebrow">Seleção</span>
            <h2 class="section-title"><?php echo esc_html($destaque_titulo); ?></h2>
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

            <?php
            $destaque_q = new WP_Query([
                'post_type'      => 'produto',
                'posts_per_page' => 8,
                'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
                'meta_query'     => [[
                    'key'   => 'produto_destaque_home',
                    'value' => '1',
                ]],
            ]);
            if ($destaque_q->have_posts()) :
                while ($destaque_q->have_posts()) : $destaque_q->the_post();
                    $prod_id  = get_the_ID();
                    $prod_sig = rwmb_meta('produto_signature', [], $prod_id);
                    $prod_des = (array) rwmb_meta('produto_designer', [], $prod_id);
                    $prod_des_id = $prod_des ? (int) reset($prod_des) : 0;

                    // Imagem: destaque (thumbnail) ou 1ª imagem do hero.
                    $prod_img = get_the_post_thumbnail_url($prod_id, 'nuvvo_card');
                    if (!$prod_img) {
                        $prod_hero = (array) rwmb_meta('produto_hero_imagens', ['size' => 'nuvvo_card'], $prod_id);
                        if ($prod_hero) {
                            $prod_hero_first = reset($prod_hero);
                            $prod_img = is_array($prod_hero_first) ? ($prod_hero_first['url'] ?? '') : '';
                        }
                    }
                    ?>
            <article class="swiper-slide">
              <a href="<?php echo esc_url(get_permalink($prod_id)); ?>" class="card-prod">
                <div class="card-prod__media">
                  <?php if ($prod_sig) : ?><span class="card-prod__tag">Nuvvo Signature</span><?php endif; ?>
                  <?php if ($prod_img) : ?>
                  <img src="<?php echo esc_url($prod_img); ?>" alt="<?php echo esc_attr(get_the_title($prod_id)); ?>" loading="lazy" width="600" height="450">
                  <?php endif; ?>
                </div>
                <h3 class="card-prod__title"><?php echo esc_html(get_the_title($prod_id)); ?></h3>
                <?php if ($prod_des_id) : ?>
                <p class="card-prod__designer">Designer <?php echo esc_html(get_the_title($prod_des_id)); ?></p>
                <?php elseif ($prod_sig) : ?>
                <p class="card-prod__designer">Nuvvo Signature</p>
                <?php endif; ?>
                <span class="card-prod__link">Ver detalhes</span>
              </a>
            </article>
                <?php
                endwhile;
                wp_reset_postdata();
            else : ?>

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

            <?php endif; ?>

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

          <?php
          // Ícones fixos do tema (o grupo editável não tem campo de ícone): ciclados por posição.
          $pillar_icons = [
              '<svg class="card-pillar__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><circle cx="16" cy="16" r="11"/><path d="M16 5v22M5 16h22"/></svg>',
              '<svg class="card-pillar__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><rect x="4" y="4" width="11" height="11"/><rect x="17" y="4" width="11" height="11"/><rect x="4" y="17" width="11" height="11"/><rect x="17" y="17" width="11" height="11"/></svg>',
              '<svg class="card-pillar__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><path d="M4 24c4-8 8-12 12-12s8 4 12 12"/><circle cx="10" cy="10" r="3"/><circle cx="22" cy="10" r="3"/></svg>',
          ];
          foreach ($pilares as $pk => $pilar) :
              $pilar_delay = $pk > 0 ? ' reveal--delay-' . min((int) $pk, 4) : '';
              $pilar_icon  = $pillar_icons[$pk % count($pillar_icons)];
              ?>
          <article class="card-pillar reveal<?php echo $pilar_delay; ?>">
            <?php if ($pilar['numero'] !== '') : ?><span class="card-pillar__num"><?php echo esc_html($pilar['numero']); ?></span><?php endif; ?>
            <?php echo $pilar_icon; // SVG fixo do tema, seguro ?>
            <h3 class="card-pillar__title"><?php echo esc_html($pilar['titulo']); ?></h3>
            <p class="card-pillar__body"><?php echo esc_html($pilar['texto']); ?></p>
          </article>
          <?php endforeach; ?>

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

            <?php
            $insp_q = new WP_Query([
                'post_type'      => 'inspiracao',
                'posts_per_page' => 6,
                'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
            ]);
            if ($insp_q->have_posts()) :
                while ($insp_q->have_posts()) : $insp_q->the_post();
                    $insp_id   = get_the_ID();
                    $insp_url  = '';
                    $insp_meta_alt = '';
                    $insp_imgs = rwmb_meta('inspiracao_imagem', ['size' => 'large'], $insp_id);
                    if (is_array($insp_imgs) && $insp_imgs) {
                        $insp_first = reset($insp_imgs);
                        if (is_array($insp_first)) {
                            $insp_url      = $insp_first['url'] ?? '';
                            $insp_meta_alt = $insp_first['alt'] ?? '';
                        } else {
                            $insp_url = wp_get_attachment_image_url((int) $insp_first, 'large') ?: '';
                        }
                    }
                    if (!$insp_url) { continue; }
                    $insp_alt = rwmb_meta('inspiracao_alt', [], $insp_id);
                    $insp_alt = is_string($insp_alt) ? trim($insp_alt) : '';
                    if ($insp_alt === '') { $insp_alt = $insp_meta_alt !== '' ? $insp_meta_alt : get_the_title($insp_id); }
                    ?>
            <a href="<?php echo esc_url(home_url('/inspire-se/')); ?>" class="swiper-slide" aria-label="Ver galeria — <?php echo esc_attr($insp_alt); ?>">
              <img src="<?php echo esc_url($insp_url); ?>" alt="<?php echo esc_attr($insp_alt); ?>" loading="lazy" width="800" height="1000">
              <span class="gallery__slide-zoom" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/></svg>
              </span>
            </a>
                <?php
                endwhile;
                wp_reset_postdata();
            else : ?>

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

            <?php endif; ?>

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
            <h2 class="section-title section-title--nowrap"><?php echo esc_html($news_titulo); ?></h2>
          </div>
          <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="link-underline reveal reveal--delay-1">Ver todas as publicações</a>
        </header>

        <div class="news__grid">

          <?php
          $news_q = new WP_Query([
              'post_type'           => 'post',
              'posts_per_page'      => 3,
              'ignore_sticky_posts' => true,
          ]);
          if ($news_q->have_posts()) :
              while ($news_q->have_posts()) : $news_q->the_post();
                  $post_id    = get_the_ID();
                  $post_img   = get_the_post_thumbnail_url($post_id, 'nuvvo_card');
                  $post_delay = $news_q->current_post > 0 ? ' reveal--delay-' . min($news_q->current_post, 2) : '';
                  $post_cats  = get_the_category($post_id);
                  $post_cat   = ($post_cats && !is_wp_error($post_cats)) ? $post_cats[0]->name : '';
                  ?>
          <article class="reveal<?php echo $post_delay; ?>">
            <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="card-post">
              <div class="card-post__media">
                <?php if ($post_img) : ?>
                <img src="<?php echo esc_url($post_img); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>" loading="lazy" width="400" height="280">
                <?php else : ?>
                <svg viewBox="0 0 400 280" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <rect width="400" height="280" fill="#9F8D7A"/>
                  <g opacity="0.4" fill="#F0EDE4"><rect x="40" y="140" width="320" height="100" rx="8"/></g>
                </svg>
                <?php endif; ?>
              </div>
              <div class="card-post__meta">
                <?php if ($post_cat !== '') : ?>
                <span><?php echo esc_html($post_cat); ?></span>
                <span class="card-post__meta-sep">/</span>
                <?php endif; ?>
                <time datetime="<?php echo esc_attr(get_the_date('Y-m-d', $post_id)); ?>"><?php echo esc_html(get_the_date('j M Y', $post_id)); ?></time>
              </div>
              <h3 class="card-post__title"><?php echo esc_html(get_the_title($post_id)); ?></h3>
            </a>
          </article>
              <?php
              endwhile;
              wp_reset_postdata();
          else : ?>

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

          <?php endif; ?>

        </div>
      </div>
    </section>

    <!-- ============ 8. DEPOIMENTOS (carrossel) ============ -->
    <section class="section testi" aria-label="Depoimentos">
      <div class="wrap">
        <header class="testi__head reveal">
          <div>
            <span class="eyebrow"><?php echo esc_html($testi_sub); ?></span>
            <h2 class="section-title"><?php echo esc_html($testi_titulo); ?></h2>
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

            <?php
            $testi_q = new WP_Query([
                'post_type'      => 'depoimento',
                'posts_per_page' => -1,
                'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
            ]);
            if ($testi_q->have_posts()) :
                while ($testi_q->have_posts()) : $testi_q->the_post();
                    $dep_id    = get_the_ID();
                    $dep_texto = rwmb_meta('depoimento_texto', [], $dep_id);
                    $dep_texto = is_string($dep_texto) ? trim($dep_texto) : '';
                    if ($dep_texto === '') { continue; }
                    $dep_nome = rwmb_meta('depoimento_nome', [], $dep_id);
                    $dep_nome = is_string($dep_nome) ? trim($dep_nome) : '';
                    if ($dep_nome === '') { $dep_nome = get_the_title($dep_id); }
                    $dep_cargo = rwmb_meta('depoimento_cargo', [], $dep_id);
                    $dep_cargo = is_string($dep_cargo) ? trim($dep_cargo) : '';

                    // Avatar: foto (se houver) ou inicial do nome.
                    $dep_foto_url = '';
                    $dep_fotos = rwmb_meta('depoimento_foto', ['size' => 'thumbnail'], $dep_id);
                    if (is_array($dep_fotos) && $dep_fotos) {
                        $dep_first    = reset($dep_fotos);
                        $dep_foto_url = is_array($dep_first) ? ($dep_first['url'] ?? '') : (wp_get_attachment_image_url((int) $dep_first, 'thumbnail') ?: '');
                    }
                    $dep_inicial = $dep_nome !== '' ? mb_strtoupper(mb_substr($dep_nome, 0, 1)) : '·';
                    ?>
            <figure class="swiper-slide testi__item">
              <blockquote class="testi__quote"><?php echo esc_html($dep_texto); ?></blockquote>
              <figcaption class="testi__author">
                <span class="testi__avatar" aria-hidden="true"><?php if ($dep_foto_url) : ?><img src="<?php echo esc_url($dep_foto_url); ?>" alt="" loading="lazy" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;"><?php else : echo esc_html($dep_inicial); endif; ?></span>
                <div>
                  <div class="testi__name"><?php echo esc_html($dep_nome); ?></div>
                  <?php if ($dep_cargo !== '') : ?><div class="testi__role"><?php echo esc_html($dep_cargo); ?></div><?php endif; ?>
                </div>
              </figcaption>
            </figure>
                <?php
                endwhile;
                wp_reset_postdata();
            else : ?>

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

            <?php endif; ?>

          </div>
          <div class="swiper-pagination testi__pagination"></div>
        </div>
      </div>
    </section>

    <!-- ============ 9. CTA FINAL ============ -->
    <section class="cta-final" aria-label="Vamos conversar">
      <div class="wrap cta-final__inner reveal">
        <h2 class="cta-final__title"><?php echo esc_html($cta_titulo); ?></h2>
        <p class="cta-final__lede"><?php echo esc_html($cta_lede); ?></p>
        <a href="<?php echo esc_url($cta_url); ?>"
           class="btn btn--cream"
           target="_blank" rel="noopener">
          <?php echo esc_html($cta_btn); ?>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>
    </section>

<?php
get_footer();
