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

    // Demais seções da Home (mesma página, slug "home").
    $mb[] = [
        'id'         => 'nuvvo_pg_home_secoes',
        'title'      => 'Seções da Home',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['home']],
        'fields'     => [

            ['type' => 'heading', 'name' => 'Catálogo'],
            ['name' => 'Título', 'id' => 'nuvvo_home_catalogo_titulo', 'type' => 'text', 'desc' => 'Se vazio, usa o título padrão do tema. Os cards são gerados a partir das categorias de produto.'],
            ['name' => 'Subtítulo (lede)', 'id' => 'nuvvo_home_catalogo_sub', 'type' => 'textarea', 'rows' => 2],

            ['type' => 'heading', 'name' => 'Produtos em destaque'],
            ['name' => 'Título', 'id' => 'nuvvo_home_destaque_titulo', 'type' => 'text', 'desc' => 'Os produtos vêm dos itens com "Destacar na Home" ativado.'],

            ['type' => 'heading', 'name' => 'A essência (pilares)'],
            [
                'name'          => 'Pilares',
                'id'            => 'nuvvo_home_pilares',
                'type'          => 'group',
                'clone'         => true,
                'sort_clone'    => true,
                'collapsible'   => true,
                'default_state' => 'collapsed',
                'group_title'   => '{numero} — {titulo}',
                'add_button'    => '+ Pilar',
                'desc'          => 'Se vazio, exibe os 3 pilares padrão do tema.',
                'fields'        => [
                    ['name' => 'Número', 'id' => 'numero', 'type' => 'text', 'columns' => 3],
                    ['name' => 'Título', 'id' => 'titulo', 'type' => 'text', 'columns' => 9],
                    ['name' => 'Texto', 'id' => 'texto', 'type' => 'textarea', 'rows' => 3, 'columns' => 12],
                ],
            ],

            ['type' => 'heading', 'name' => 'Nuvvo News'],
            ['name' => 'Título', 'id' => 'nuvvo_home_news_titulo', 'type' => 'text', 'desc' => 'Os cards vêm dos 3 posts mais recentes do blog.'],

            ['type' => 'heading', 'name' => 'Depoimentos'],
            ['name' => 'Subtítulo (eyebrow)', 'id' => 'nuvvo_home_testi_sub', 'type' => 'text', 'columns' => 6],
            ['name' => 'Título', 'id' => 'nuvvo_home_testi_titulo', 'type' => 'text', 'columns' => 6, 'desc' => 'Os itens vêm do tipo de conteúdo "Depoimentos".'],

            ['type' => 'heading', 'name' => 'CTA final'],
            ['name' => 'Título', 'id' => 'nuvvo_home_cta_titulo', 'type' => 'text'],
            ['name' => 'Lede', 'id' => 'nuvvo_home_cta_lede', 'type' => 'textarea', 'rows' => 2],
            ['name' => 'Texto do botão', 'id' => 'nuvvo_home_cta_btn', 'type' => 'text', 'columns' => 6],
            ['name' => 'Mensagem do WhatsApp', 'id' => 'nuvvo_home_cta_msg', 'type' => 'text', 'columns' => 6],
        ],
    ];

    return $mb;
});
