<?php
/**
 * Campos editáveis da página "Catálogo (hub)" (slug "catalogo").
 *
 * Observação: os cards de categoria são dinâmicos (get_terms de
 * `categoria_produto`, parent=0). A imagem/nome de cada card vem do termo da
 * categoria (Produtos → Categorias → "Imagem da categoria"), não desta box.
 * As imagens de "Ambientes assinados" vêm do tipo de conteúdo Inspirações.
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

            ['type' => 'heading', 'name' => 'Coleções (cards)'],
            [
                'type' => 'custom_html',
                'id'   => 'nuvvo_catalogo_cards_nota',
                'std'  => '<p style="margin:0;padding:10px 12px;background:#f6f7f7;border-left:3px solid #7A6B5C;">As imagens e nomes dos cards vêm das <strong>Categorias de produto</strong>. Para trocá-las: <em>Produtos → Categorias</em> → editar a categoria → campo <strong>Imagem da categoria</strong>.</p>',
            ],

            ['type' => 'heading', 'name' => 'Diferenciais'],
            ['name' => 'Eyebrow (rótulo)', 'id' => 'nuvvo_catalogo_dif_eyebrow', 'type' => 'text', 'columns' => 4, 'placeholder' => 'Diferenciais'],
            ['name' => 'Título da seção', 'id' => 'nuvvo_catalogo_dif_titulo', 'type' => 'text', 'columns' => 8, 'placeholder' => 'A assinatura técnica da Nuvvo'],
            [
                'name'          => 'Cards de diferenciais',
                'id'            => 'nuvvo_catalogo_diferenciais',
                'type'          => 'group',
                'clone'         => true,
                'sort_clone'    => true,
                'collapsible'   => true,
                'default_state' => 'collapsed',
                'group_title'   => '{titulo}',
                'add_button'    => '+ Diferencial',
                'desc'          => 'Se vazio, exibe os diferenciais padrão do tema. O ícone é definido pela ordem.',
                'fields'        => [
                    ['name' => 'Título', 'id' => 'titulo', 'type' => 'text', 'columns' => 4],
                    ['name' => 'Texto', 'id' => 'texto', 'type' => 'textarea', 'rows' => 2, 'columns' => 8],
                ],
            ],

            ['type' => 'heading', 'name' => 'Personalização (banner)'],
            ['name' => 'Eyebrow (rótulo)', 'id' => 'nuvvo_catalogo_pers_eyebrow', 'type' => 'text', 'columns' => 4, 'placeholder' => 'Personalização'],
            ['name' => 'Título', 'id' => 'nuvvo_catalogo_pers_titulo', 'type' => 'text', 'columns' => 8, 'placeholder' => 'Curadoria especializada'],
            ['name' => 'Texto', 'id' => 'nuvvo_catalogo_pers_texto', 'type' => 'textarea', 'rows' => 3],
            ['name' => 'Texto do botão', 'id' => 'nuvvo_catalogo_pers_btn', 'type' => 'text', 'columns' => 6, 'placeholder' => 'Falar com consultor Nuvvo'],
            ['name' => 'Mensagem do WhatsApp', 'id' => 'nuvvo_catalogo_pers_msg', 'type' => 'text', 'columns' => 6],

            ['type' => 'heading', 'name' => 'Ambientes assinados (prévia)'],
            ['name' => 'Eyebrow (rótulo)', 'id' => 'nuvvo_catalogo_insp_eyebrow', 'type' => 'text', 'columns' => 4, 'placeholder' => 'Inspire-se'],
            ['name' => 'Título', 'id' => 'nuvvo_catalogo_insp_titulo', 'type' => 'text', 'columns' => 8, 'placeholder' => 'Ambientes assinados'],
            [
                'type' => 'custom_html',
                'id'   => 'nuvvo_catalogo_insp_nota',
                'std'  => '<p style="margin:0;padding:10px 12px;background:#f6f7f7;border-left:3px solid #7A6B5C;">As imagens deste carrossel vêm do tipo de conteúdo <strong>Inspirações</strong> (as mais recentes). Enquanto não houver inspirações cadastradas, usa imagens padrão do tema.</p>',
            ],

            ['type' => 'heading', 'name' => 'Suporte técnico (profissionais)'],
            ['name' => 'Eyebrow (rótulo)', 'id' => 'nuvvo_catalogo_sup_eyebrow', 'type' => 'text', 'columns' => 4, 'placeholder' => 'Para profissionais'],
            ['name' => 'Título', 'id' => 'nuvvo_catalogo_sup_titulo', 'type' => 'text', 'columns' => 8, 'placeholder' => 'Suporte técnico para o seu projeto'],
            ['name' => 'Lede (texto de apoio)', 'id' => 'nuvvo_catalogo_sup_lede', 'type' => 'textarea', 'rows' => 3],
            [
                'name'          => 'Itens de suporte',
                'id'            => 'nuvvo_catalogo_sup_items',
                'type'          => 'group',
                'clone'         => true,
                'sort_clone'    => true,
                'collapsible'   => true,
                'default_state' => 'collapsed',
                'group_title'   => '{titulo}',
                'add_button'    => '+ Item',
                'desc'          => 'Se vazio, exibe os 3 itens padrão. O ícone é definido pela ordem.',
                'fields'        => [
                    ['name' => 'Título', 'id' => 'titulo', 'type' => 'text', 'columns' => 6],
                    ['name' => 'Texto', 'id' => 'texto', 'type' => 'textarea', 'rows' => 2, 'columns' => 6],
                    ['name' => 'Link (opcional)', 'id' => 'link', 'type' => 'url', 'columns' => 6, 'desc' => 'Ex.: 3D Warehouse. Sem link, o item fica só informativo.'],
                    ['name' => 'Texto do link', 'id' => 'link_label', 'type' => 'text', 'columns' => 6, 'placeholder' => 'Ver no 3D Warehouse'],
                ],
            ],
            ['name' => 'Texto do botão', 'id' => 'nuvvo_catalogo_sup_btn', 'type' => 'text', 'columns' => 6, 'placeholder' => 'Sou arquiteto · quero acesso aos materiais técnicos'],
            ['name' => 'Mensagem do WhatsApp', 'id' => 'nuvvo_catalogo_sup_msg', 'type' => 'text', 'columns' => 6],

            ['type' => 'heading', 'name' => 'CTA final'],
            ['name' => 'Título', 'id' => 'nuvvo_catalogo_cta_titulo', 'type' => 'text'],
            ['name' => 'Lede', 'id' => 'nuvvo_catalogo_cta_lede', 'type' => 'textarea', 'rows' => 2],
            ['name' => 'Texto do botão (label)', 'id' => 'nuvvo_catalogo_cta_label', 'type' => 'text', 'columns' => 6],
            ['name' => 'Mensagem do WhatsApp', 'id' => 'nuvvo_catalogo_cta_msg', 'type' => 'text', 'columns' => 6],
        ],
    ];
    return $mb;
});
