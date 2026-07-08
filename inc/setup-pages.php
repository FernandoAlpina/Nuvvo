<?php
/**
 * Auto-provisiona o site no WordPress (uma única vez):
 *  - força reconhecimento de rewrite (LiteSpeed honra .htaccess, mas o WP
 *    às vezes retorna got_url_rewrite() = false)
 *  - permalinks limpos /%postname%/
 *  - cria/publica as Páginas com os slugs certos (page-{slug}.php do tema)
 *  - regrava as regras de rewrite (.htaccess)
 *
 * Idempotente, guardado por opção. Alvo PHP 8.0.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

// LiteSpeed suporta .htaccess rewrite; força o WP a usar permalinks limpos.
add_filter('got_rewrite', '__return_true');
add_filter('got_url_rewrite', '__return_true');

add_action('init', function () {
    if (get_option('nuvvo_pages_v3')) {
        return;
    }

    // 1) Permalinks limpos.
    if (get_option('permalink_structure') !== '/%postname%/') {
        update_option('permalink_structure', '/%postname%/');
        global $wp_rewrite;
        if ($wp_rewrite) {
            $wp_rewrite->set_permalink_structure('/%postname%/');
            $wp_rewrite->init();
        }
    }

    // 2) Páginas do site (cria se faltar; publica se estiver em rascunho).
    $pages = [
        ['title' => 'A Nuvvo',                 'slug' => 'a-nuvvo'],
        ['title' => 'Catálogo',                'slug' => 'catalogo'],
        ['title' => 'Inspire-se',              'slug' => 'inspire-se'],
        ['title' => 'Contato',                 'slug' => 'contato'],
        ['title' => 'Política de Privacidade', 'slug' => 'politica-de-privacidade'],
        ['title' => 'Blog',                    'slug' => 'blog'],
    ];

    foreach ($pages as $p) {
        $existing = get_page_by_path($p['slug']);
        if ($existing) {
            if ($existing->post_status !== 'publish') {
                wp_update_post(['ID' => $existing->ID, 'post_status' => 'publish']);
            }
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

    update_option('nuvvo_pages_v3', 1);
}, 20);
