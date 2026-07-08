<?php
/**
 * Auto-provisiona o site no WordPress (uma única vez):
 *  - ativa permalinks /%postname%/ (necessário para /a-nuvvo/, /catalogo/ etc.)
 *  - cria as Páginas com os slugs certos (usam page-{slug}.php do tema)
 *  - regrava as regras de rewrite (.htaccess no LiteSpeed)
 *
 * Idempotente e guardado por opção. Alvo PHP 8.0.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', function () {
    if (get_option('nuvvo_pages_v1')) {
        return;
    }

    // 1) Permalinks bonitos.
    if (get_option('permalink_structure') === '') {
        update_option('permalink_structure', '/%postname%/');
        global $wp_rewrite;
        if ($wp_rewrite) {
            $wp_rewrite->init();
        }
    }

    // 2) Páginas do site (o template page-{slug}.php é detectado pelo slug).
    $pages = [
        ['title' => 'A Nuvvo',                 'slug' => 'a-nuvvo'],
        ['title' => 'Catálogo',                'slug' => 'catalogo'],
        ['title' => 'Inspire-se',              'slug' => 'inspire-se'],
        ['title' => 'Contato',                 'slug' => 'contato'],
        ['title' => 'Política de Privacidade', 'slug' => 'politica-de-privacidade'],
        ['title' => 'Blog',                    'slug' => 'blog'],
    ];

    foreach ($pages as $p) {
        if (get_page_by_path($p['slug'])) {
            continue;
        }
        wp_insert_post([
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_title'   => $p['title'],
            'post_name'    => $p['slug'],
            'post_content' => '',
        ]);
    }

    // 3) Regrava regras de rewrite (.htaccess).
    flush_rewrite_rules(true);

    update_option('nuvvo_pages_v1', 1);
}, 20);
