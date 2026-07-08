<?php
/**
 * Campos editáveis da página "A Nuvvo" (mostrados só nessa página, pelo slug).
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_filter('rwmb_meta_boxes', function ($mb) {
    $mb[] = [
        'id'         => 'nuvvo_pg_anuvvo',
        'title'      => 'Conteúdo — A Nuvvo',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['a-nuvvo']],
        'fields'     => [
            [
                'name'    => 'Essência (texto de história)',
                'id'      => 'nuvvo_anuvvo_essencia',
                'type'    => 'wysiwyg',
                'options' => ['media_buttons' => false, 'teeny' => true, 'textarea_rows' => 8],
            ],
            [
                'name'          => 'Trajetória (linha do tempo)',
                'id'            => 'nuvvo_anuvvo_timeline',
                'type'          => 'group',
                'clone'         => true,
                'sort_clone'    => true,
                'collapsible'   => true,
                'default_state' => 'collapsed',
                'group_title'   => '{ano} — {titulo}',
                'add_button'    => '+ Marco',
                'fields'        => [
                    ['name' => 'Ano', 'id' => 'ano', 'type' => 'text', 'columns' => 3],
                    ['name' => 'Título', 'id' => 'titulo', 'type' => 'text', 'columns' => 6],
                    ['name' => 'Destaque', 'id' => 'destaque', 'type' => 'switch', 'columns' => 3],
                    ['name' => 'Descrição', 'id' => 'desc', 'type' => 'textarea', 'rows' => 2, 'columns' => 12],
                ],
            ],
            ['name' => 'Missão', 'id' => 'nuvvo_anuvvo_missao', 'type' => 'textarea', 'rows' => 2],
            ['name' => 'Visão', 'id' => 'nuvvo_anuvvo_visao', 'type' => 'textarea', 'rows' => 2],
            ['name' => 'Valores', 'id' => 'nuvvo_anuvvo_valores', 'type' => 'text', 'clone' => true, 'sort_clone' => true, 'add_button' => '+ Valor'],
        ],
    ];
    return $mb;
});
