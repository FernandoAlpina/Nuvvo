<?php
/**
 * Campos editáveis da Home (página inicial estática, slug "home").
 * Aparecem ao editar a Página "Home" no wp-admin.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_filter('rwmb_meta_boxes', function ($mb) {
    $mb[] = [
        'id'         => 'nuvvo_pg_home_hero',
        'title'      => 'Seção Banner (Hero)',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['home']],
        'fields'     => [
            [
                'name'          => 'Slides do banner',
                'id'            => 'nuvvo_home_hero_slides',
                'type'          => 'group',
                'clone'         => true,
                'sort_clone'    => true,
                'collapsible'   => true,
                'default_state' => 'collapsed',
                'group_title'   => 'Slide {#}',
                'add_button'    => '+ Slide',
                'fields'        => [
                    ['name' => 'Imagem', 'id' => 'imagem', 'type' => 'single_image', 'columns' => 6],
                    ['name' => 'Texto alternativo', 'id' => 'alt', 'type' => 'text', 'columns' => 6],
                ],
            ],
            ['name' => 'Título', 'id' => 'nuvvo_home_hero_titulo', 'type' => 'text'],
            ['name' => 'Subtítulo', 'id' => 'nuvvo_home_hero_sub', 'type' => 'textarea', 'rows' => 2],
            ['name' => 'Texto do botão (CTA)', 'id' => 'nuvvo_home_hero_cta', 'type' => 'text', 'columns' => 6],
            ['name' => 'Mensagem do WhatsApp (CTA)', 'id' => 'nuvvo_home_hero_cta_msg', 'type' => 'text', 'columns' => 6],
        ],
    ];
    return $mb;
});
