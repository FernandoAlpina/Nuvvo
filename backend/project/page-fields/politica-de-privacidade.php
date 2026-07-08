<?php
/**
 * Campos editáveis da página "Política de Privacidade" (slug "politica-de-privacidade").
 * Mostrados só nessa página (via MB Include Exclude, pelo slug).
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_filter('rwmb_meta_boxes', function ($mb) {
    $mb[] = [
        'id'         => 'nuvvo_pg_politica',
        'title'      => 'Conteúdo — Política de Privacidade',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['politica-de-privacidade']],
        'fields'     => [
            ['type' => 'heading', 'name' => 'Hero'],
            [
                'name'    => 'Título',
                'id'      => 'nuvvo_politica_hero_titulo',
                'type'    => 'text',
                'columns' => 6,
            ],
            [
                'name'    => 'Última atualização',
                'id'      => 'nuvvo_politica_hero_atualizacao',
                'type'    => 'text',
                'columns' => 6,
                'desc'    => 'Ex.: "Última atualização: 26 de maio de 2026".',
            ],

            ['type' => 'heading', 'name' => 'Corpo da política'],
            [
                'name'    => 'Texto completo da política',
                'id'      => 'nuvvo_politica_corpo',
                'type'    => 'wysiwyg',
                'options' => ['media_buttons' => false, 'teeny' => false, 'textarea_rows' => 24],
                'desc'    => 'Use títulos (H2/H3), listas e links normalmente. Para que o Sumário (à esquerda) navegue até cada seção, mantenha os IDs das seções (ex.: introducao, dados-coletados) no editor de código/HTML. O botão "Abrir preferências de cookies" fica fora deste campo e é sempre exibido. Se este campo ficar vazio, o texto padrão atual é mantido.',
            ],
        ],
    ];
    return $mb;
});
