<?php
/**
 * Funções do tema Nuvvo.
 *
 * Fase F0: renderização do site através do WordPress mantendo o front-end
 * aprovado (design system próprio + JS vanilla). O framework Alpina V4
 * (backend/base) é carregado incrementalmente conforme as seções viram
 * editáveis (Meta Box) nas fases seguintes.
 *
 * Alvo: PHP 8.0 (servidor de dev roda 8.0.30).
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('NUVVO_VERSION')) {
    define('NUVVO_VERSION', '1.0.0');
}

/**
 * Suporte do tema.
 */
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);

    register_nav_menus([
        'primary'              => 'Menu principal',
        'footer_catalogo'      => 'Rodapé — Catálogo',
        'footer_institucional' => 'Rodapé — Institucional',
    ]);

    // Tamanhos de imagem alinhados ao design (usados nas fases de conteúdo).
    add_image_size('nuvvo_card', 800, 1000, true);   // cards de produto (4:5)
    add_image_size('nuvvo_hero', 1920, 1280, true);  // hero/banners
    add_image_size('nuvvo_gallery', 900, 900, false);
});

/**
 * Blog: usa o editor clássico (TinyMCE, com "Adicionar mídia") nos posts,
 * no lugar do editor de blocos (Gutenberg) — como no padrão pedido.
 */
add_filter('use_block_editor_for_post_type', function ($use_block_editor, $post_type) {
    if ($post_type === 'post') {
        return false;
    }
    return $use_block_editor;
}, 10, 2);

/**
 * Framework Alpina V4 (subconjunto) + entidades do projeto (CPTs, taxonomias, campos).
 */
require_once get_template_directory() . '/inc/framework.php';

/**
 * Opções globais (painel "Nuvvo") + helpers de contato/WhatsApp.
 */
require_once get_template_directory() . '/inc/settings.php';

/**
 * SEO baseline (meta/OG/canonical/Schema) — desativa se houver plugin de SEO.
 */
require_once get_template_directory() . '/inc/seo.php';

/**
 * Vídeo institucional (helpers de embed YouTube/Vimeo + resolução da fonte).
 */
require_once get_template_directory() . '/inc/video.php';

/**
 * Helpers de exibição do produto (selo/badge).
 */
require_once get_template_directory() . '/inc/produto.php';

/**
 * Enfileiramento de CSS/JS (assets próprios do Nuvvo).
 */
require_once get_template_directory() . '/inc/enqueue.php';

/**
 * Auto-provisiona as Páginas do site (uma vez).
 */
require_once get_template_directory() . '/inc/setup-pages.php';

/**
 * Seed de conteúdo aprovado nos campos das páginas (uma vez, só campos vazios).
 */
require_once get_template_directory() . '/inc/seed-content.php';

/**
 * Seed do produto "Sofá Pecan" + designer (uma vez; imagens vêm da Biblioteca).
 */
require_once get_template_directory() . '/inc/seed-produtos.php';
