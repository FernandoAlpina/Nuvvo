<?php
/**
 * Template da página (page-catalogo). Fase F0: markup estático portado; vira editável (Meta Box) depois.
 * @package Nuvvo (Alpina V4)
 */
if (!defined('ABSPATH')) { exit; }
get_header();

$pid = get_the_ID();

// Categorias (termos-pai) para os cards dinâmicos.
$cat_terms = get_terms([
    'taxonomy'   => 'categoria_produto',
    'parent'     => 0,
    'hide_empty' => false,
]);
if (is_wp_error($cat_terms)) {
    $cat_terms = [];
}
?>

    <!-- ============ 1. HERO ============ -->
    <section class="catalog-hero" aria-label="Catálogo">
      <div class="wrap catalog-hero__inner">
        <span class="catalog-hero__eyebrow"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_hero_eyebrow', 'Catálogo')); ?></span>
        <h1 class="catalog-hero__title"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_hero_titulo', 'Coleção')); ?></h1>
        <p class="catalog-hero__sub"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_hero_sub', 'Mobiliário autoral concebido para projetos que pedem singularidade.')); ?></p>
      </div>
    </section>

    <!-- ============ 2. CATEGORIAS (cards dinâmicos por termo) ============ -->
    <section class="section catalog-categories" aria-label="Categorias">
      <div class="wrap">
        <div class="catalog-categories__grid">

          <?php foreach ($cat_terms as $i => $t) :
              $link = get_term_link($t);
              if (is_wp_error($link)) { continue; }

              // Imagem do termo (term meta single image); fallback = SVG placeholder.
              $cat_img_url = '';
              if (function_exists('rwmb_meta')) {
                  $cat_imgs = rwmb_meta('categoria_produto_imagem', ['object_type' => 'term', 'size' => 'large'], $t->term_id);
                  if (is_array($cat_imgs) && $cat_imgs) {
                      $first = reset($cat_imgs);
                      $cat_img_url = is_array($first) ? ($first['url'] ?? '') : '';
                  }
              }

              $delay = $i > 0 ? ' reveal--delay-' . min((int) $i, 3) : '';
              ?>
          <a href="<?php echo esc_url($link); ?>" class="card-cat reveal<?php echo $delay; ?>">
            <div class="card-cat__media">
              <?php if ($cat_img_url) : ?>
                <img src="<?php echo esc_url($cat_img_url); ?>" alt="Coleção de <?php echo esc_attr($t->name); ?> Nuvvo Design" loading="lazy">
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
              <span class="card-cat__name"><?php echo esc_html($t->name); ?></span>
              <span class="card-cat__arrow" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M7 17 17 7M10 7h7v7"/></svg></span>
            </div>
          </a>
          <?php endforeach; ?>

        </div>
      </div>
    </section>

    <!-- ============ 3. DIFERENCIAIS (carrossel 5 cards) ============ -->
    <section class="section catalog-features" aria-label="Diferenciais">
      <div class="wrap">
        <header class="catalog-features__head reveal">
          <div>
            <span class="eyebrow"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_dif_eyebrow', 'Diferenciais')); ?></span>
            <h2 class="section-title"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_dif_titulo', 'A assinatura técnica da Nuvvo')); ?></h2>
          </div>
          <div class="featured__nav" role="group" aria-label="Navegar diferenciais">
            <button class="swiper-btn cat-features__prev" type="button" aria-label="Diferencial anterior"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M19 12H5M11 18l-6-6 6-6"/></svg></button>
            <button class="swiper-btn cat-features__next" type="button" aria-label="Próximo diferencial"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12h14M13 6l6 6-6 6"/></svg></button>
          </div>
        </header>

        <div class="swiper cat-features__swiper reveal">
          <div class="swiper-wrapper">

            <?php
            // Ícones padrão de cada diferencial do tema (usados no fallback).
            $dif_icons_default = [
                '<svg class="card-feature__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><path d="M16 2l3.7 9.5L29 13l-7 6.5L24 29l-8-5-8 5 2-9.5L3 13l9.3-1.5z"/></svg>',
                '<svg class="card-feature__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><rect x="4" y="4" width="11" height="11"/><rect x="17" y="4" width="11" height="11"/><rect x="4" y="17" width="11" height="11"/><rect x="17" y="17" width="11" height="11"/></svg>',
                '<svg class="card-feature__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><path d="M16 3l11 5v8c0 7-5 11-11 13C5 27 0 23 0 16V8l11-5z" transform="translate(2.5 0)"/><path d="M12 16l3 3 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                '<svg class="card-feature__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><path d="M6 16c0-5 4-9 10-9s10 4 10 9v9H6z"/><path d="M11 25v-6M16 25v-9M21 25v-6"/></svg>',
                '<svg class="card-feature__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><rect x="5" y="3" width="22" height="26" rx="2"/><path d="M10 11h12M10 16h12M10 21h7"/><path d="M19 24l3 3 5-6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            ];

            // Conteúdo padrão (fallback) replica os diferenciais atuais.
            $dif_fallback = [
                ['titulo' => 'Design Exclusivo',          'texto' => 'Peças com identidade própria, criadas para projetos que recusam o genérico.'],
                ['titulo' => 'Curadoria de Acabamentos',  'texto' => 'Mais de 3.000 opções entre tecidos, texturas e cores, selecionadas com critério técnico e estético.'],
                ['titulo' => 'Qualidade Certificada',     'texto' => 'Espumas certificadas, madeiras nobres e processos rigorosamente controlados.'],
                ['titulo' => 'Excelência Artesanal',      'texto' => 'Cada peça é produzida com cuidado manual e atenção a cada detalhe do acabamento.'],
                ['titulo' => 'Suporte ao Arquiteto',      'texto' => 'Acompanhamento técnico próximo, com blocos 3D e fichas detalhadas para especificação precisa.'],
            ];

            // Grupo editável; se vazio, usa o fallback.
            $dif_items = [];
            $dif_group = function_exists('rwmb_meta') ? (array) rwmb_meta('nuvvo_catalogo_diferenciais', [], $pid) : [];
            foreach ($dif_group as $g) {
                $gt = isset($g['titulo']) ? trim((string) $g['titulo']) : '';
                $gb = isset($g['texto']) ? trim((string) $g['texto']) : '';
                if ($gt === '' && $gb === '') { continue; }
                $dif_items[] = ['titulo' => $gt, 'texto' => $gb];
            }
            if (!$dif_items) {
                $dif_items = $dif_fallback;
            }

            foreach ($dif_items as $di => $ditem) :
                $icon = $dif_icons_default[$di % count($dif_icons_default)];
                ?>
            <article class="swiper-slide">
              <div class="card-feature">
                <?php echo $icon; // SVG fixo do tema, seguro ?>
                <h3 class="card-feature__title"><?php echo esc_html($ditem['titulo']); ?></h3>
                <p class="card-feature__body"><?php echo esc_html($ditem['texto']); ?></p>
              </div>
            </article>
            <?php endforeach; ?>

          </div>
          <div class="swiper-pagination cat-features__pagination"></div>
        </div>
      </div>
    </section>

    <!-- ============ 4. CTA CURADORIA ESPECIALIZADA ============ -->
    <?php
    $pers_msg = nuvvo_pgf('nuvvo_catalogo_pers_msg', 'Olá, gostaria de falar com um consultor Nuvvo');
    $pers_url = function_exists('nuvvo_wa_link') ? nuvvo_wa_link($pers_msg) : 'https://wa.me/5554999485915?text=' . rawurlencode($pers_msg);
    ?>
    <section class="cta-banner" aria-label="Curadoria especializada">
      <div class="cta-banner__inner reveal">
        <span class="cta-banner__eyebrow"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_pers_eyebrow', 'Personalização')); ?></span>
        <h2 class="cta-banner__title"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_pers_titulo', 'Curadoria especializada')); ?></h2>
        <p class="cta-banner__text"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_pers_texto', 'Cada peça de nossa coleção foi pensada para ser personalizada. Com diversas texturas e várias possibilidades em medidas, estamos prontos para adaptar o mobiliário Nuvvo à singularidade do seu ambiente.')); ?></p>
        <a href="<?php echo esc_url($pers_url); ?>"
           class="btn btn--primary"
           target="_blank" rel="noopener noreferrer">
          <?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_pers_btn', 'Falar com consultor Nuvvo')); ?>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>
    </section>

    <!-- ============ 5. INSPIRE-SE prévia ============ -->
    <section class="section catalog-inspire" aria-label="Inspire-se">
      <div class="wrap">
        <header class="catalog-inspire__head">
          <div class="reveal">
            <span class="eyebrow"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_insp_eyebrow', 'Inspire-se')); ?></span>
            <h2 class="section-title"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_insp_titulo', 'Ambientes assinados')); ?></h2>
          </div>
          <div class="reveal reveal--delay-1" style="display:flex; gap: var(--space-3); align-items:center;">
            <a href="<?php echo esc_url(home_url('/inspire-se/')); ?>" class="link-underline">Ver mais inspirações</a>
            <div style="display:flex; gap: var(--space-1);">
              <button class="swiper-btn cat-inspire__prev" type="button" aria-label="Imagem anterior"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M19 12H5M11 18l-6-6 6-6"/></svg></button>
              <button class="swiper-btn cat-inspire__next" type="button" aria-label="Próxima imagem"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12h14M13 6l6 6-6 6"/></svg></button>
            </div>
          </div>
        </header>

        <div class="swiper gallery__swiper cat-inspire__swiper reveal">
          <div class="swiper-wrapper">
            <?php
            // Imagens dinâmicas das Inspirações (mais recentes); fallback estático.
            $insp_slides = [];
            $catinsp_q = new WP_Query([
                'post_type'      => 'inspiracao',
                'posts_per_page' => 8,
                'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
            ]);
            if ($catinsp_q->have_posts()) {
                while ($catinsp_q->have_posts()) {
                    $catinsp_q->the_post();
                    $iid = get_the_ID();
                    $u = '';
                    $alt = '';
                    $imgs = rwmb_meta('inspiracao_imagem', ['size' => 'large'], $iid);
                    if (is_array($imgs) && $imgs) {
                        $f = reset($imgs);
                        if (is_array($f)) { $u = $f['url'] ?? ''; $alt = $f['alt'] ?? ''; }
                        else { $u = wp_get_attachment_image_url((int) $f, 'large') ?: ''; }
                    }
                    $a2 = rwmb_meta('inspiracao_alt', [], $iid);
                    if (is_string($a2) && trim($a2) !== '') { $alt = $a2; }
                    if ($alt === '') { $alt = get_the_title($iid); }
                    if ($u) { $insp_slides[] = ['url' => $u, 'alt' => $alt]; }
                }
                wp_reset_postdata();
            }
            if (!$insp_slides) {
                $b = get_template_directory_uri() . '/assets/img/';
                $insp_slides = [
                    ['url' => $b . 'gallery-1.png', 'alt' => 'Detalhe do braço do sofá Pecan com mesa lateral de madeira'],
                    ['url' => $b . 'gallery-3.png', 'alt' => 'Sofá modular em varanda com vegetação'],
                    ['url' => $b . 'gallery-2.jpg', 'alt' => 'Sofá com cachorrinho branco em ambiente claro'],
                    ['url' => $b . 'gallery-4.jpg', 'alt' => 'Vista superior das almofadas e mesa'],
                    ['url' => $b . 'gallery-5.jpg', 'alt' => 'Close lateral do sofá Pecan com luz natural'],
                    ['url' => $b . 'gallery-6.png', 'alt' => 'Detalhe das almofadas e braço'],
                ];
            }
            foreach ($insp_slides as $s) : ?>
            <div class="swiper-slide"><img src="<?php echo esc_url($s['url']); ?>" alt="<?php echo esc_attr($s['alt']); ?>" loading="lazy"></div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ 6. SUPORTE AO ARQUITETO ============ -->
    <?php
    // Ícones fixos do tema (por ordem dos itens).
    $sup_icons = [
        '<svg class="support-item__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><path d="M16 3 4 9v14l12 6 12-6V9z"/><path d="M4 9l12 6 12-6M16 15v14"/></svg>',
        '<svg class="support-item__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><path d="M9 3h10l6 6v20H9z"/><path d="M19 3v6h6"/><path d="M13 16h10M13 21h10M13 11h4"/></svg>',
        '<svg class="support-item__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><path d="M27 5H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6l5 5 5-5h6a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2z"/><path d="M9 12h14M9 17h10"/></svg>',
    ];
    $sup_fallback = [
        ['titulo' => 'Blocos 3D / 3D Warehouse', 'texto' => 'Modelos 3D prontos para integrar ao seu projeto de arquitetura.', 'link' => 'https://3dwarehouse.sketchup.com/user/61f45a49-50d6-41a1-8202-89e4f458c8ea', 'link_label' => 'Ver no 3D Warehouse'],
        ['titulo' => 'Fichas técnicas', 'texto' => 'Especificações detalhadas em PDF para download imediato.', 'link' => '', 'link_label' => ''],
        ['titulo' => 'Consultoria dedicada', 'texto' => 'Atendimento humano e próximo para especificações personalizadas.', 'link' => '', 'link_label' => ''],
    ];
    $sup_items = [];
    foreach ((array) (function_exists('rwmb_meta') ? rwmb_meta('nuvvo_catalogo_sup_items', [], $pid) : []) as $g) {
        $gt = isset($g['titulo']) ? trim((string) $g['titulo']) : '';
        $gx = isset($g['texto']) ? trim((string) $g['texto']) : '';
        if ($gt === '' && $gx === '') { continue; }
        $sup_items[] = [
            'titulo'     => $gt,
            'texto'      => $gx,
            'link'       => isset($g['link']) ? trim((string) $g['link']) : '',
            'link_label' => isset($g['link_label']) ? trim((string) $g['link_label']) : '',
        ];
    }
    if (!$sup_items) { $sup_items = $sup_fallback; }
    $sup_msg = nuvvo_pgf('nuvvo_catalogo_sup_msg', 'Olá, sou arquiteto/designer e gostaria de receber materiais técnicos da Nuvvo');
    $sup_url = function_exists('nuvvo_wa_link') ? nuvvo_wa_link($sup_msg) : 'https://wa.me/5554999485915?text=' . rawurlencode($sup_msg);
    ?>
    <section class="catalog-support" aria-label="Suporte ao Arquiteto">
      <div class="wrap">
        <header class="catalog-support__head reveal">
          <span class="eyebrow" style="justify-content:center;"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_sup_eyebrow', 'Para profissionais')); ?></span>
          <h2 class="section-title section-title--center"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_sup_titulo', 'Suporte técnico para o seu projeto')); ?></h2>
          <p class="catalog-support__lede"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_sup_lede', 'A precisão é um dos pilares do nosso design. Oferecemos suporte completo para profissionais da arquitetura e design de interiores, disponibilizando blocos 3D, fichas técnicas detalhadas e consultoria personalizada para a especificação de cada peça.')); ?></p>
        </header>

        <div class="support-grid">
          <?php foreach ($sup_items as $si => $item) :
              $icon  = $sup_icons[$si % count($sup_icons)];
              $delay = $si > 0 ? ' reveal--delay-' . min($si, 3) : '';
              ?>
          <article class="support-item reveal<?php echo $delay; ?>">
            <?php echo $icon; // SVG fixo do tema ?>
            <h3 class="support-item__title"><?php echo esc_html($item['titulo']); ?></h3>
            <p class="support-item__body"><?php echo esc_html($item['texto']); ?></p>
            <?php if ($item['link'] !== '') : ?>
            <a class="link-underline support-item__link" href="<?php echo esc_url($item['link']); ?>" target="_blank" rel="noopener noreferrer">
              <?php echo esc_html($item['link_label'] !== '' ? $item['link_label'] : 'Saiba mais'); ?>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
            <?php endif; ?>
          </article>
          <?php endforeach; ?>
        </div>

        <div style="text-align:center; margin-top: var(--space-5);" class="reveal reveal--delay-3">
          <a href="<?php echo esc_url($sup_url); ?>"
             class="btn btn--secondary"
             target="_blank" rel="noopener noreferrer">
            <?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_sup_btn', 'Sou arquiteto · quero acesso aos materiais técnicos')); ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </a>
        </div>
      </div>
    </section>

    <!-- ============ 7. CTA FINAL ============ -->
    <?php
    $ccta_msg = nuvvo_pgf('nuvvo_catalogo_cta_msg', 'Olá, gostaria de falar com um especialista da Nuvvo sobre um projeto');
    $ccta_url = function_exists('nuvvo_wa_link') ? nuvvo_wa_link($ccta_msg) : 'https://wa.me/5554999485915?text=' . rawurlencode($ccta_msg);
    ?>
    <section class="cta-final" aria-label="Vamos conversar">
      <div class="wrap cta-final__inner reveal">
        <h2 class="cta-final__title"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_cta_titulo', 'Vamos transformar seu próximo projeto?')); ?></h2>
        <p class="cta-final__lede"><?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_cta_lede', 'Compartilhe seu projeto conosco e nossa equipe traduzirá sua visão.')); ?></p>
        <a href="<?php echo esc_url($ccta_url); ?>"
           class="btn btn--cream"
           target="_blank" rel="noopener">
          <?php echo esc_html(nuvvo_pgf('nuvvo_catalogo_cta_label', 'Falar com especialista')); ?>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>
    </section>

<?php
get_footer();
