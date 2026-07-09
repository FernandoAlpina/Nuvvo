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

    /* ---------- Vídeo institucional ---------- */
    $mb[] = [
        'id'         => 'nuvvo_pg_anuvvo_video',
        'title'      => 'Vídeo institucional',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['a-nuvvo']],
        'fields'     => [
            ['name' => 'Exibir a seção de vídeo', 'id' => 'nuvvo_anuvvo_video_exibir', 'type' => 'switch', 'std' => 1, 'desc' => 'Desligue para ocultar a seção inteira nesta página.'],
            ['name' => 'Eyebrow (rótulo)', 'id' => 'nuvvo_anuvvo_video_eyebrow', 'type' => 'text', 'columns' => 6, 'placeholder' => 'Conheça por dentro'],
            ['name' => 'Título', 'id' => 'nuvvo_anuvvo_video_titulo', 'type' => 'text', 'columns' => 6, 'placeholder' => 'Bastidores e processo'],
            ['name' => 'Link do vídeo (YouTube ou Vimeo)', 'id' => 'nuvvo_anuvvo_video_url', 'type' => 'url', 'desc' => 'Cole o link normal do YouTube ou Vimeo. Tem prioridade sobre o arquivo abaixo. Deixe vazio para manter o estado "em breve".'],
            ['name' => 'Ou envie um arquivo de vídeo (MP4)', 'id' => 'nuvvo_anuvvo_video_mp4', 'type' => 'video', 'max_file_uploads' => 1, 'desc' => 'Use apenas se não tiver link do YouTube/Vimeo. Arquivos grandes deixam o carregamento mais lento.'],
            ['name' => 'Imagem de capa (poster)', 'id' => 'nuvvo_anuvvo_video_poster', 'type' => 'single_image', 'desc' => 'Recomendado: 1600×900px (16:9). Se vazio, usa uma imagem padrão do tema.'],
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
