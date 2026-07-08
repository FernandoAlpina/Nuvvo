<?php
/**
 * Campos editáveis da página "Catálogo (hub)" (slug "catalogo").
 *
 * Observação: os cards de categoria são dinâmicos (get_terms de
 * `categoria_produto`, parent=0). A imagem de cada card vem do term meta
 * `categoria_produto_imagem` (registrado em Nuvvo_Produto), não desta box.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_filter('rwmb_meta_boxes', function ($mb) {
    $mb[] = [
        'id'         => 'nuvvo_pg_catalogo',
        'title'      => 'Conteúdo — Catálogo',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['catalogo']],
        'fields'     => [
            ['type' => 'heading', 'name' => 'Hero'],
            ['name' => 'Eyebrow', 'id' => 'nuvvo_catalogo_hero_eyebrow', 'type' => 'text', 'columns' => 4],
            ['name' => 'Título', 'id' => 'nuvvo_catalogo_hero_titulo', 'type' => 'text', 'columns' => 8],
            ['name' => 'Subtítulo', 'id' => 'nuvvo_catalogo_hero_sub', 'type' => 'textarea', 'rows' => 2],

            ['type' => 'heading', 'name' => 'Diferenciais'],
            [
                'name'          => 'Diferenciais (carrossel)',
                'id'            => 'nuvvo_catalogo_diferenciais',
                'type'          => 'group',
                'clone'         => true,
                'sort_clone'    => true,
                'collapsible'   => true,
                'default_state' => 'collapsed',
                'group_title'   => '{titulo}',
                'add_button'    => '+ Diferencial',
                'desc'          => 'Se vazio, exibe os diferenciais padrão do tema.',
                'fields'        => [
                    ['name' => 'Título', 'id' => 'titulo', 'type' => 'text', 'columns' => 4],
                    ['name' => 'Texto', 'id' => 'texto', 'type' => 'textarea', 'rows' => 2, 'columns' => 8],
                ],
            ],

            ['type' => 'heading', 'name' => 'CTA final'],
            ['name' => 'Título', 'id' => 'nuvvo_catalogo_cta_titulo', 'type' => 'text'],
            ['name' => 'Lede', 'id' => 'nuvvo_catalogo_cta_lede', 'type' => 'textarea', 'rows' => 2],
            ['name' => 'Texto do botão (label)', 'id' => 'nuvvo_catalogo_cta_label', 'type' => 'text', 'columns' => 6],
        ],
    ];
    return $mb;
});
