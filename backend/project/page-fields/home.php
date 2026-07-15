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
                    ['name' => 'Imagem', 'id' => 'imagem', 'type' => 'single_image', 'columns' => 6, 'desc' => 'Recomendado: 1920×1080px (paisagem), JPG.'],
                    ['name' => 'Texto alternativo', 'id' => 'alt', 'type' => 'text', 'columns' => 6],
                ],
            ],
            ['name' => 'Vídeo de fundo (MP4) — opcional', 'id' => 'nuvvo_home_hero_video', 'type' => 'video', 'max_file_uploads' => 1, 'desc' => 'Se preenchido, o banner mostra este vídeo no lugar dos slides. Use MP4 leve; toca em loop, mudo.'],
            ['name' => 'Imagem de capa do vídeo (poster)', 'id' => 'nuvvo_home_hero_video_poster', 'type' => 'single_image', 'desc' => 'Aparece enquanto o vídeo carrega. Recomendado: 1920×1080px.'],
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

    // Vídeo institucional (Home).
    $mb[] = [
        'id'         => 'nuvvo_pg_home_video',
        'title'      => 'Vídeo institucional',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['home']],
        'fields'     => [
            ['name' => 'Exibir a seção de vídeo', 'id' => 'nuvvo_home_video_exibir', 'type' => 'switch', 'std' => 1, 'desc' => 'Desligue para ocultar a seção inteira na Home.'],
            ['name' => 'Eyebrow (rótulo)', 'id' => 'nuvvo_home_video_eyebrow', 'type' => 'text', 'columns' => 6, 'placeholder' => 'Conheça por dentro'],
            ['name' => 'Título', 'id' => 'nuvvo_home_video_titulo', 'type' => 'text', 'columns' => 6, 'placeholder' => 'Bastidores e processo'],
            ['name' => 'Link do vídeo (YouTube ou Vimeo)', 'id' => 'nuvvo_home_video_url', 'type' => 'url', 'desc' => 'Cole o link normal do YouTube ou Vimeo. Tem prioridade sobre o arquivo abaixo. Deixe vazio para manter o estado "em breve".'],
            ['name' => 'Ou envie um arquivo de vídeo (MP4)', 'id' => 'nuvvo_home_video_mp4', 'type' => 'video', 'max_file_uploads' => 1, 'desc' => 'Use apenas se não tiver link do YouTube/Vimeo. Arquivos grandes deixam o carregamento mais lento.'],
            ['name' => 'Imagem de capa (poster)', 'id' => 'nuvvo_home_video_poster', 'type' => 'single_image', 'desc' => 'Recomendado: 1600×900px (16:9). Se vazio, usa uma imagem padrão do tema.'],
        ],
    ];

    // Big Numbers (editados na Home; reusados também em A Nuvvo).
    $mb[] = [
        'id'         => 'nuvvo_pg_home_numeros',
        'title'      => 'Big Numbers',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['home']],
        'fields'     => [
            [
                'name'          => 'Números em destaque',
                'id'            => 'nuvvo_home_big_numbers',
                'type'          => 'group',
                'clone'         => true,
                'sort_clone'    => true,
                'collapsible'   => true,
                'default_state' => 'collapsed',
                'group_title'   => '{label}',
                'add_button'    => '+ Número',
                'fields'        => [
                    ['name' => 'Prefixo', 'id' => 'prefixo', 'type' => 'text', 'columns' => 2, 'placeholder' => '+'],
                    ['name' => 'Valor', 'id' => 'valor', 'type' => 'text', 'columns' => 3, 'placeholder' => '3000'],
                    ['name' => 'Sufixo / unidade', 'id' => 'sufixo', 'type' => 'text', 'columns' => 3, 'placeholder' => 'anos, %'],
                    ['name' => 'Casas decimais', 'id' => 'decimais', 'type' => 'number', 'columns' => 2, 'std' => 0],
                    ['name' => 'Duração (ms)', 'id' => 'duracao', 'type' => 'number', 'columns' => 2, 'std' => 1800],
                    ['name' => 'Legenda', 'id' => 'label', 'type' => 'textarea', 'rows' => 2, 'columns' => 12],
                ],
            ],
        ],
    ];

    return $mb;
});

/**
 * Ordena os painéis (Meta Box) da Home na MESMA sequência das seções da página:
 * Hero → Big Numbers → Vídeo → Seções (Catálogo/Destaque/Pilares/News/Depoimentos/CTA).
 * Aplica só na edição da página "home" e sobrepõe qualquer ordem salva por arrastar.
 */
add_filter('get_user_option_meta-box-order_page', function ($order) {
    $post_id = isset($_GET['post']) ? (int) $_GET['post'] : (isset($_POST['post_ID']) ? (int) $_POST['post_ID'] : 0);
    if (!$post_id || get_post_field('post_name', $post_id) !== 'home') {
        return $order;
    }
    if (!is_array($order)) {
        $order = [];
    }
    $order['normal'] = 'nuvvo_pg_home_hero,nuvvo_pg_home_numeros,nuvvo_pg_home_video,nuvvo_pg_home_secoes';
    return $order;
});
