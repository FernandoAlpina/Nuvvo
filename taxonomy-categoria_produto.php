<?php
/**
 * Listagem de catálogo por categoria (taxonomia `categoria_produto`).
 * Renderiza os produtos do termo como grid de cards (card-prod).
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$term = get_queried_object();
$wa   = '5554999485915';

// Subcategorias (termos-filho) para os chips de filtro
$children = [];
if ($term && !is_wp_error($term)) {
    $children = get_terms([
        'taxonomy'   => 'categoria_produto',
        'parent'     => $term->term_id,
        'hide_empty' => false,
    ]);
    if (is_wp_error($children)) {
        $children = [];
    }
}

// Produtos do termo (inclui filhos)
$q = new WP_Query([
    'post_type'      => 'produto',
    'posts_per_page' => -1,
    'orderby'        => ['menu_order' => 'ASC', 'title' => 'ASC'],
    'tax_query'      => [[
        'taxonomy'         => 'categoria_produto',
        'field'            => 'term_id',
        'terms'            => $term->term_id,
        'include_children' => true,
    ]],
]);
?>

<!-- ============ BREADCRUMB ============ -->
<nav class="breadcrumb-bar" aria-label="Você está aqui">
    <div class="wrap">
        <ol class="breadcrumb-bar__list">
            <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
            <li class="breadcrumb-bar__sep" aria-hidden="true">/</li>
            <li class="breadcrumb-bar__intermediate"><a href="<?php echo esc_url(home_url('/catalogo/')); ?>">Catálogo</a></li>
            <?php if ($term->parent) :
                $parent = get_term($term->parent, 'categoria_produto'); ?>
                <li class="breadcrumb-bar__sep breadcrumb-bar__intermediate" aria-hidden="true">/</li>
                <li class="breadcrumb-bar__intermediate"><a href="<?php echo esc_url(get_term_link($parent)); ?>"><?php echo esc_html($parent->name); ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-bar__sep" aria-hidden="true">/</li>
            <li class="breadcrumb-bar__current" aria-current="page"><?php echo esc_html($term->name); ?></li>
        </ol>
    </div>
</nav>

<!-- ============ HERO DA CATEGORIA ============ -->
<section class="category-hero" aria-label="<?php echo esc_attr($term->name); ?>">
    <div class="wrap category-hero__inner">
        <h1 class="category-hero__title"><?php echo esc_html($term->name); ?></h1>
        <?php if (!empty($term->description)) : ?>
            <p class="category-hero__sub"><?php echo esc_html($term->description); ?></p>
        <?php endif; ?>
    </div>
</section>

<!-- ============ FILTER BAR ============ -->
<div class="catalog-filter-bar" role="region" aria-label="Filtros">
    <div class="wrap catalog-filter-bar__inner">
        <div class="catalog-filter-bar__left">
            <?php if ($children) : ?>
            <div class="filter-chips" data-subcat-chips role="group" aria-label="Filtrar por subcategoria">
                <button type="button" class="filter-chip" data-filter="todos" aria-pressed="true">Todos</button>
                <?php foreach ($children as $child) : ?>
                    <button type="button" class="filter-chip" data-filter="<?php echo esc_attr($child->slug); ?>" aria-pressed="false"><?php echo esc_html($child->name); ?></button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="catalog-filter-bar__right">
            <span class="filter-results" data-results-count aria-live="polite"><?php echo (int) $q->found_posts; ?> produto<?php echo $q->found_posts === 1 ? '' : 's'; ?></span>
        </div>
    </div>
</div>

<!-- ============ GRID DE PRODUTOS ============ -->
<section class="section catalog-listing">
    <div class="wrap">
        <div class="catalog-grid" data-catalog-grid aria-live="polite">
            <?php if ($q->have_posts()) : while ($q->have_posts()) : $q->the_post();
                $ppid = get_the_ID();
                $signature = rwmb_meta('produto_signature', [], $ppid);
                $em_breve  = rwmb_meta('produto_em_breve', [], $ppid);
                $des       = (array) rwmb_meta('produto_designer', [], $ppid);
                $des_id    = $des ? (int) reset($des) : 0;

                // imagem: destaque ou 1ª do hero
                $img = get_the_post_thumbnail_url($ppid, 'nuvvo_card');
                if (!$img) {
                    $hero = (array) rwmb_meta('produto_hero_imagens', ['size' => 'nuvvo_card'], $ppid);
                    if ($hero) { $first = reset($hero); $img = is_array($first) ? ($first['url'] ?? '') : ''; }
                }

                // subcategoria(s) do produto dentro desta categoria (para o filtro)
                $subcats = [];
                $pterms  = get_the_terms($ppid, 'categoria_produto');
                if ($pterms && !is_wp_error($pterms)) {
                    foreach ($pterms as $pt) {
                        if ($pt->parent) { $subcats[] = $pt->slug; }
                    }
                }
                $data_sub = $subcats ? implode(',', $subcats) : 'todos';
                $link = $em_breve ? '#' : get_permalink($ppid);
                ?>
                <a href="<?php echo esc_url($link); ?>" class="card-prod" data-subcategory="<?php echo esc_attr($data_sub); ?>" data-name="<?php echo esc_attr(mb_strtolower(get_the_title())); ?>">
                    <div class="product-card-btn-wrap">
                        <?php if ($signature) : ?><span class="card-prod__tag">Nuvvo Signature</span><?php endif; ?>
                        <?php if ($img) : ?>
                            <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
                        <?php endif; ?>
                        <span class="product-card__overlay-btn">
                            Ver detalhes
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </span>
                    </div>
                    <h2 class="card-prod__title"><?php echo esc_html(get_the_title()); ?><?php echo $em_breve ? ' <em>[em breve]</em>' : ''; ?></h2>
                    <?php if ($des_id) : ?>
                        <p class="card-prod__designer">Designer <?php echo esc_html(get_the_title($des_id)); ?></p>
                    <?php elseif ($signature) : ?>
                        <p class="card-prod__designer">Nuvvo Signature</p>
                    <?php endif; ?>
                </a>
            <?php endwhile; wp_reset_postdata(); endif; ?>

            <!-- Empty state -->
            <div class="empty-state" data-empty-state hidden>
                <h3 class="empty-state__title">Nenhum produto encontrado.</h3>
                <p class="empty-state__text">Tente outro filtro ou converse com nossa equipe para conhecer todas as opções.</p>
                <div class="empty-state__actions">
                    <button type="button" class="btn btn--secondary" data-clear-filters>Limpar filtros</button>
                    <a href="https://wa.me/<?php echo $wa; ?>?text=<?php echo rawurlencode('Olá, busco um produto específico da Nuvvo'); ?>" class="btn btn--primary" target="_blank" rel="noopener noreferrer">
                        Falar com especialista
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
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

<!-- ============ CTA FINAL ============ -->
<section class="cta-final" aria-label="Vamos conversar">
    <div class="wrap cta-final__inner reveal">
        <h2 class="cta-final__title">Encontrou uma peça? Vamos conversar.</h2>
        <p class="cta-final__lede">Compartilhe seu projeto conosco e nossa equipe traduzirá sua&nbsp;visão.</p>
        <a href="https://wa.me/<?php echo $wa; ?>?text=<?php echo rawurlencode('Olá, vi um produto no catálogo Nuvvo e gostaria de falar com um especialista'); ?>" class="btn btn--cream" target="_blank" rel="noopener">
            Falar com especialista
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
    </div>
</section>

<?php
get_footer();
