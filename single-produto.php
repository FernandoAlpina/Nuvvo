<?php
/**
 * Template da página de produto (PDP).
 * Lê os campos Meta Box do CPT `produto` via rwmb_meta().
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();
    $pid   = get_the_ID();
    $title = get_the_title();
    $wa    = '5554999485915';

    // Helpers de leitura Meta Box
    $lede      = rwmb_meta('produto_lede', [], $pid);
    $chips     = (array) rwmb_meta('produto_chips', [], $pid);
    $hero_imgs = (array) rwmb_meta('produto_hero_imagens', ['size' => 'full'], $pid);
    $story     = rwmb_meta('produto_story_texto', [], $pid);
    $galeria   = (array) rwmb_meta('produto_galeria', [], $pid);
    $desenho   = (array) rwmb_meta('produto_desenho', ['size' => 'full'], $pid);
    $dimensoes = (array) rwmb_meta('produto_dimensoes', [], $pid);
    $modulos   = (array) rwmb_meta('produto_modulos', [], $pid);
    $extras    = rwmb_meta('produto_extras', [], $pid);
    $ficha     = (array) rwmb_meta('produto_ficha_pdf', [], $pid);
    $skp       = (array) rwmb_meta('produto_bloco_skp', [], $pid);
    $relacion  = (array) rwmb_meta('produto_relacionados', [], $pid);
    $designer  = (array) rwmb_meta('produto_designer', [], $pid);
    $designer_id = $designer ? (int) reset($designer) : 0;

    // Categoria (para breadcrumb e eyebrow "Sofás · Living")
    $terms = get_the_terms($pid, 'categoria_produto');
    $cat_label = '';
    $cat_link  = home_url('/catalogo/');
    if ($terms && !is_wp_error($terms)) {
        $parts = [];
        foreach ($terms as $t) {
            $parts[] = $t->name;
        }
        $cat_label = implode(' · ', $parts);
        $first = reset($terms);
        $cat_link = get_term_link($first);
        if (is_wp_error($cat_link)) {
            $cat_link = home_url('/catalogo/');
        }
    }

    // Link WhatsApp com origem
    $wa_url = 'https://wa.me/' . $wa . '?text=' . rawurlencode('Olá, gostaria de conhecer mais sobre o ' . $title);

    // Fallback do hero: imagem destacada
    if (!$hero_imgs && has_post_thumbnail($pid)) {
        $hero_imgs = [[
            'url' => get_the_post_thumbnail_url($pid, 'full'),
            'alt' => $title,
        ]];
    }

    // Prepara módulos para o JS (configurador imagem + texto)
    $modules_js = [];
    foreach ($modulos as $m) {
        $img_id = is_array($m['imagem'] ?? null) ? reset($m['imagem']) : ($m['imagem'] ?? '');
        $modules_js[] = [
            'label'     => $m['label'] ?? '',
            'largura'   => $m['largura'] ?? '',
            'descricao' => $m['descricao'] ?? '',
            'imagem'    => $img_id ? wp_get_attachment_image_url((int) $img_id, 'full') : '',
        ];
    }
    if ($modules_js) {
        wp_localize_script('nuvvo-pdp', 'NUVVO_PDP', ['modules' => $modules_js]);
    }
    ?>

    <!-- ============ BREADCRUMB ============ -->
    <nav class="breadcrumb-bar" aria-label="Você está aqui">
        <div class="wrap">
            <ol class="breadcrumb-bar__list">
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                <li class="breadcrumb-bar__sep" aria-hidden="true">/</li>
                <li class="breadcrumb-bar__intermediate"><a href="<?php echo esc_url(home_url('/catalogo/')); ?>">Catálogo</a></li>
                <?php if ($cat_label) : ?>
                    <li class="breadcrumb-bar__sep breadcrumb-bar__intermediate" aria-hidden="true">/</li>
                    <li class="breadcrumb-bar__intermediate"><a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat_label); ?></a></li>
                <?php endif; ?>
                <li class="breadcrumb-bar__sep" aria-hidden="true">/</li>
                <li class="breadcrumb-bar__current" aria-current="page"><?php echo esc_html($title); ?></li>
            </ol>
        </div>
    </nav>

    <!-- ============ HERO ============ -->
    <section class="pdp-hero" aria-label="<?php echo esc_attr($title); ?>">
        <div class="wrap pdp-hero__grid">
            <div class="pdp-hero__media">
                <?php foreach ($hero_imgs as $i => $img) :
                    $url = is_array($img) ? ($img['url'] ?? '') : $img;
                    $alt = is_array($img) ? ($img['alt'] ?? $title) : $title;
                    if (!$url) { continue; } ?>
                    <button type="button" class="pdp-hero__media-item" data-lb-trigger aria-label="Ampliar imagem <?php echo (int) $i + 1; ?>">
                        <img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr($alt); ?>" loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>"<?php echo $i === 0 ? ' fetchpriority="high"' : ''; ?>>
                    </button>
                <?php endforeach; ?>
            </div>

            <aside class="pdp-hero__info">
                <?php if ($cat_label) : ?><span class="pdp-hero__category"><?php echo esc_html($cat_label); ?></span><?php endif; ?>
                <h1 class="pdp-hero__title"><?php echo esc_html($title); ?></h1>
                <?php if ($designer_id) : ?>
                    <p class="pdp-hero__designer">Designer <?php echo esc_html(get_the_title($designer_id)); ?></p>
                <?php endif; ?>

                <?php if ($lede) : ?><p class="pdp-hero__lede"><?php echo esc_html($lede); ?></p><?php endif; ?>

                <div class="pdp-hero__cta-primary">
                    <a href="<?php echo esc_url($wa_url); ?>" class="btn btn--primary" target="_blank" rel="noopener noreferrer">
                        Falar com consultor
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                </div>

                <div class="pdp-hero__cta-secondary">
                    <?php if ($dimensoes || $modulos) : ?><a href="#dimensoes">Ver dimensões</a><?php endif; ?>
                    <?php if ($ficha) : ?><a href="#downloads">Baixar ficha técnica</a><?php endif; ?>
                </div>

                <?php if ($chips) : ?>
                    <div class="pdp-hero__chips">
                        <?php foreach ($chips as $chip) : if (!$chip) { continue; } ?>
                            <span class="pdp-hero__chip"><?php echo esc_html($chip); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </aside>
        </div>
    </section>

    <?php if ($story) : ?>
    <!-- ============ STORYTELLING ============ -->
    <section class="pdp-story" aria-label="Sobre o produto">
        <div class="wrap">
            <div class="pdp-story__inner">
                <span class="pdp-story__quote-mark" aria-hidden="true">"</span>
                <p class="pdp-story__text"><?php echo wp_kses_post($story); ?></p>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($galeria) : ?>
    <!-- ============ GALERIA ============ -->
    <section class="pdp-gallery" aria-label="Galeria">
        <div class="wrap">
            <header class="pdp-gallery__head reveal">
                <div>
                    <span class="eyebrow">Galeria</span>
                    <h2 class="section-title">Ambientes e detalhes</h2>
                </div>
                <a href="<?php echo esc_url($wa_url); ?>" class="link-underline" target="_blank" rel="noopener noreferrer">Falar com consultor</a>
            </header>
            <div class="pdp-gallery__grid reveal">
                <?php
                $prop_map = ['first' => ' pdp-gallery__item--first', 'wide' => ' pdp-gallery__item--wide', 'tall' => ' pdp-gallery__item--tall'];
                foreach ($galeria as $g) :
                    $gid = is_array($g['imagem'] ?? null) ? reset($g['imagem']) : ($g['imagem'] ?? '');
                    if (!$gid) { continue; }
                    $gurl = wp_get_attachment_image_url((int) $gid, 'full');
                    $galt = get_post_meta((int) $gid, '_wp_attachment_image_alt', true) ?: $title;
                    $cls  = $prop_map[$g['proporcao'] ?? ''] ?? '';
                    ?>
                    <button type="button" class="pdp-gallery__item<?php echo esc_attr($cls); ?>" data-lb-trigger aria-label="Ampliar imagem">
                        <img src="<?php echo esc_url($gurl); ?>" alt="<?php echo esc_attr($galt); ?>" loading="lazy">
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($designer_id) :
        $d_foto = rwmb_meta('designer_foto', ['size' => 'full'], $designer_id);
        $d_foto_url = is_array($d_foto) ? ($d_foto['url'] ?? '') : '';
        if (!$d_foto_url && has_post_thumbnail($designer_id)) { $d_foto_url = get_the_post_thumbnail_url($designer_id, 'full'); }
        $d_bio  = rwmb_meta('designer_bio_curta', [], $designer_id);
        $d_name = get_the_title($designer_id);
        ?>
    <!-- ============ DESIGNER ============ -->
    <section class="designer-sig" aria-label="Designer">
        <div class="wrap">
            <div class="designer-sig__grid">
                <?php if ($d_foto_url) : ?>
                <div class="designer-sig__media reveal">
                    <img src="<?php echo esc_url($d_foto_url); ?>" alt="Retrato do designer <?php echo esc_attr($d_name); ?>" loading="lazy">
                </div>
                <?php endif; ?>
                <div class="designer-sig__content reveal reveal--delay-1">
                    <span class="eyebrow">Designer assinado</span>
                    <h2 class="designer-sig__title">Designer: <?php echo esc_html($d_name); ?></h2>
                    <?php if ($d_bio) : ?><p class="designer-sig__body"><?php echo wp_kses_post($d_bio); ?></p><?php endif; ?>
                    <span class="designer-sig__name"><?php echo esc_html($d_name); ?></span>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($dimensoes || $modulos || $desenho || $extras) : ?>
    <!-- ============ DIMENSÕES E CONFIGURADOR ============ -->
    <section class="dim-section" id="dimensoes" aria-label="Dimensões e configurações">
        <div class="wrap">
            <div class="dim-section__grid">
                <?php $des_url = $desenho ? ($desenho['url'] ?? '') : ''; ?>
                <?php if ($des_url) : ?>
                <div class="dim-section__drawing reveal">
                    <img src="<?php echo esc_url($des_url); ?>" alt="Desenho técnico de <?php echo esc_attr($title); ?>" loading="lazy">
                </div>
                <?php endif; ?>

                <div class="dim-data reveal reveal--delay-1">
                    <h3>Dimensões e configurações</h3>

                    <?php if ($dimensoes) : ?>
                    <dl class="dim-data__general">
                        <?php foreach ($dimensoes as $d) : if (empty($d['rotulo'])) { continue; } ?>
                            <dt><?php echo esc_html($d['rotulo']); ?></dt>
                            <dd><?php echo esc_html($d['valor'] ?? ''); ?></dd>
                        <?php endforeach; ?>
                    </dl>
                    <?php endif; ?>

                    <?php if ($modulos) : ?>
                    <p class="dim-modules-label">Módulos disponíveis</p>
                    <div class="dim-modules-chips" role="group" aria-label="Selecionar módulo">
                        <?php foreach ($modulos as $idx => $m) : ?>
                            <button type="button" class="dim-module-chip" data-module-chip="<?php echo (int) $idx; ?>" aria-pressed="<?php echo $idx === 0 ? 'true' : 'false'; ?>"><?php echo esc_html($m['label'] ?? ''); ?></button>
                        <?php endforeach; ?>
                    </div>
                    <img class="dim-module-image" data-module-image src="" alt="" hidden>
                    <div class="dim-module-panel" data-module-panel aria-live="polite"></div>
                    <?php endif; ?>

                    <?php if ($extras) : ?>
                    <div class="dim-section__extras"><?php echo wp_kses_post($extras); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($ficha || $skp) : ?>
    <!-- ============ DOWNLOADS ============ -->
    <section class="section downloads-section" id="downloads" aria-label="Downloads">
        <div class="wrap">
            <header class="reveal" style="text-align:center; margin-bottom: var(--space-5);">
                <span class="eyebrow" style="justify-content:center;">Para arquitetos</span>
                <h2 class="section-title section-title--center">Materiais técnicos</h2>
            </header>
            <div class="downloads-grid">
                <?php $ficha_f = $ficha ? reset($ficha) : null; if ($ficha_f) : ?>
                <a href="<?php echo esc_url($ficha_f['url']); ?>" class="download-card reveal" download>
                    <svg class="download-card__icon" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M14 4h16l8 8v28a4 4 0 0 1-4 4H14a4 4 0 0 1-4-4V8a4 4 0 0 1 4-4z"/><path d="M30 4v8h8"/></svg>
                    <div><p class="download-card__label">Ficha Técnica</p><p class="download-card__sub">PDF</p></div>
                    <span class="download-card__link">Baixar<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><path d="M12 4v14M5 11l7 7 7-7"/></svg></span>
                </a>
                <?php endif; ?>

                <?php $skp_f = $skp ? reset($skp) : null; ?>
                <a href="<?php echo $skp_f ? esc_url($skp_f['url']) : '#'; ?>" class="download-card reveal reveal--delay-1"<?php echo $skp_f ? ' download' : ' aria-disabled="true"'; ?>>
                    <svg class="download-card__icon" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M24 6L8 14v20l16 8 16-8V14z"/><path d="M8 14l16 8 16-8M24 22v20"/></svg>
                    <div><p class="download-card__label">Bloco 3D · SketchUp</p><p class="download-card__sub"><?php echo $skp_f ? 'SKP' : 'SKP · em breve'; ?></p></div>
                    <span class="download-card__link"><?php echo $skp_f ? 'Baixar' : 'Em breve'; ?></span>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ============ CTA PERSONALIZAÇÃO ============ -->
    <section class="cta-final" aria-label="Personalização">
        <div class="wrap cta-final__inner reveal">
            <h2 class="cta-final__title">Personalização exclusiva</h2>
            <p class="cta-final__lede">Peça de produção artesanal, disponível em diferentes medidas para adaptar ao seu projeto. Consulte opções de acabamentos e tecidos.</p>
            <a href="https://wa.me/<?php echo $wa; ?>?text=<?php echo rawurlencode('Olá, gostaria de personalizar o ' . $title . ' - tecidos e medidas'); ?>" class="btn btn--cream" target="_blank" rel="noopener noreferrer">
                Falar com consultor
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </div>
    </section>

    <?php if ($relacion) : ?>
    <!-- ============ PRODUTOS RELACIONADOS ============ -->
    <section class="related-posts" aria-label="Outras peças da coleção">
        <div class="wrap">
            <h2 class="related-posts__title">Outras peças da coleção</h2>
            <div class="related-posts__grid">
                <?php foreach ($relacion as $rid) :
                    $rid = (int) $rid;
                    $rimg = get_the_post_thumbnail_url($rid, 'nuvvo_card') ?: get_the_post_thumbnail_url($rid, 'full');
                    $rdes = rwmb_meta('produto_designer', [], $rid);
                    $rdes_id = is_array($rdes) && $rdes ? (int) reset($rdes) : 0;
                    ?>
                    <a href="<?php echo esc_url(get_permalink($rid)); ?>" class="card-prod">
                        <div class="product-card-btn-wrap">
                            <?php if ($rimg) : ?><img src="<?php echo esc_url($rimg); ?>" alt="<?php echo esc_attr(get_the_title($rid)); ?>" loading="lazy">
                            <?php endif; ?>
                            <span class="product-card__overlay-btn">Ver detalhes<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
                        </div>
                        <h3 class="card-prod__title"><?php echo esc_html(get_the_title($rid)); ?></h3>
                        <?php if ($rdes_id) : ?><p class="card-prod__designer"><?php echo esc_html(get_the_title($rdes_id)); ?></p><?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ============ LIGHTBOX ============ -->
    <div class="lightbox" data-pdp-lightbox role="dialog" aria-modal="true" aria-label="Visualizador de imagens" aria-hidden="true">
        <button type="button" class="lightbox__btn lightbox__close" aria-label="Fechar visualizador"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 6l12 12M18 6L6 18" stroke-linecap="round"/></svg></button>
        <button type="button" class="lightbox__btn lightbox__prev" aria-label="Imagem anterior"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M15 6l-6 6 6 6" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
        <button type="button" class="lightbox__btn lightbox__next" aria-label="Próxima imagem"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M9 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
        <div class="lightbox__stage"><div class="lightbox__img-wrap" aria-live="polite"></div></div>
        <span class="lightbox__counter" aria-live="polite"></span>
    </div>

<?php
endwhile;
get_footer();
