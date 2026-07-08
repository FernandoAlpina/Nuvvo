<?php
/**
 * Auto-provisiona as Páginas do site no WordPress (uma única vez).
 *
 * Cada página usa o template page-{slug}.php do tema (detectado pelo slug),
 * então não é preciso escolher template no admin. Idempotente: só cria o que falta.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_init', function () {
    if (get_option('nuvvo_pages_v1')) {
        return;
    }

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
            continue; // já existe
        }
        wp_insert_post([
            'post_type'   => 'page',
            'post_status' => 'publish',
            'post_title'  => $p['title'],
            'post_name'   => $p['slug'],
            'post_content' => '',
        ]);
    }

    update_option('nuvvo_pages_v1', 1);
});
