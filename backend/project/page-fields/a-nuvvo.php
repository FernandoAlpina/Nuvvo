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

    /* ---------- Topo (Hero) ---------- */
    $mb[] = [
        'id'         => 'nuvvo_pg_anuvvo_hero',
        'title'      => 'Topo (Hero)',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['a-nuvvo']],
        'fields'     => [
            ['name' => 'Imagem de fundo', 'id' => 'nuvvo_anuvvo_hero_img', 'type' => 'single_image', 'desc' => 'Recomendado: 1920×1280px (paisagem).'],
            ['name' => 'Eyebrow (rótulo)', 'id' => 'nuvvo_anuvvo_hero_eyebrow', 'type' => 'text', 'placeholder' => 'Ex.: Sobre nós'],
            ['name' => 'Título', 'id' => 'nuvvo_anuvvo_hero_titulo', 'type' => 'text'],
            ['name' => 'Subtítulo', 'id' => 'nuvvo_anuvvo_hero_sub', 'type' => 'textarea', 'rows' => 3],
        ],
    ];

    /* ---------- Diferenciais (carrossel) ---------- */
    $mb[] = [
        'id'         => 'nuvvo_pg_anuvvo_diferenciais',
        'title'      => 'Diferenciais (carrossel)',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['a-nuvvo']],
        'fields'     => [
            [
                'name'          => 'Cards de diferenciais',
                'id'            => 'nuvvo_anuvvo_diferenciais',
                'type'          => 'group',
                'clone'         => true,
                'sort_clone'    => true,
                'collapsible'   => true,
                'default_state' => 'collapsed',
                'group_title'   => '{titulo}',
                'add_button'    => '+ Diferencial',
                'fields'        => [
                    [
                        'name'    => 'Ícone',
                        'id'      => 'icone',
                        'type'    => 'select',
                        'columns' => 4,
                        'std'     => 'star',
                        'options' => [
                            'star'    => 'Estrela (Design exclusivo)',
                            'sliders' => 'Controles (Personalização)',
                            'people'  => 'Pessoas (Parceria)',
                            'doc'     => 'Documento (Especificação)',
                            'craft'   => 'Ateliê (Artesanal)',
                        ],
                    ],
                    ['name' => 'Título', 'id' => 'titulo', 'type' => 'text', 'columns' => 8],
                    ['name' => 'Texto', 'id' => 'texto', 'type' => 'textarea', 'rows' => 3, 'columns' => 12],
                    ['name' => 'Link (opcional)', 'id' => 'link', 'type' => 'url', 'columns' => 8, 'desc' => 'Com link o card vira botão; sem link, fica estático.'],
                    ['name' => 'Abrir em nova aba', 'id' => 'target', 'type' => 'switch', 'columns' => 4, 'std' => 1],
                ],
            ],
        ],
    ];

    /* ---------- Designer ---------- */
    $mb[] = [
        'id'         => 'nuvvo_pg_anuvvo_designer',
        'title'      => 'Designer',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['a-nuvvo']],
        'fields'     => [
            ['name' => 'Nome', 'id' => 'nuvvo_anuvvo_designer_nome', 'type' => 'text', 'columns' => 6],
            ['name' => 'Cargo / rótulo', 'id' => 'nuvvo_anuvvo_designer_cargo', 'type' => 'text', 'columns' => 6, 'placeholder' => 'Designer assinado'],
            ['name' => 'Foto', 'id' => 'nuvvo_anuvvo_designer_foto', 'type' => 'single_image', 'desc' => 'Recomendado: 600×750px (4:5).'],
            [
                'name'    => 'Bio',
                'id'      => 'nuvvo_anuvvo_designer_bio',
                'type'    => 'wysiwyg',
                'options' => ['media_buttons' => false, 'teeny' => true, 'textarea_rows' => 8],
            ],
        ],
    ];

    /* ---------- Chamada final (CTA) ---------- */
    $mb[] = [
        'id'         => 'nuvvo_pg_anuvvo_cta',
        'title'      => 'Chamada final (CTA)',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['a-nuvvo']],
        'fields'     => [
            ['name' => 'Título', 'id' => 'nuvvo_anuvvo_cta_titulo', 'type' => 'text'],
            ['name' => 'Texto (lede)', 'id' => 'nuvvo_anuvvo_cta_lede', 'type' => 'textarea', 'rows' => 3],
            ['name' => 'Texto do botão', 'id' => 'nuvvo_anuvvo_cta_btn', 'type' => 'text', 'columns' => 6],
            ['name' => 'Mensagem do WhatsApp', 'id' => 'nuvvo_anuvvo_cta_msg', 'type' => 'text', 'columns' => 6],
        ],
    ];

    return $mb;
});
