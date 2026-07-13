<?php
/**
 * Campos editáveis da página "Blog" (slug "blog").
 * Apenas o HERO é editável; a listagem é dinâmica (posts nativos).
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_filter('rwmb_meta_boxes', function ($mb) {
    $mb[] = [
        'id'         => 'nuvvo_pg_blog',
        'title'      => 'Conteúdo — Blog',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['blog']],
        'fields'     => [
            ['type' => 'heading', 'name' => 'Hero'],
            ['name' => 'Eyebrow', 'id' => 'nuvvo_blog_hero_eyebrow', 'type' => 'text', 'columns' => 4],
            ['name' => 'Título', 'id' => 'nuvvo_blog_hero_titulo', 'type' => 'text', 'columns' => 8],
            ['name' => 'Subtítulo', 'id' => 'nuvvo_blog_hero_sub', 'type' => 'textarea', 'rows' => 2],

            ['type' => 'heading', 'name' => 'Banner de categoria'],
            ['name' => 'Título do banner "Todos"', 'id' => 'nuvvo_blog_todos_titulo', 'type' => 'text', 'columns' => 4, 'placeholder' => 'Todos'],
            ['name' => 'Descrição do banner "Todos"', 'id' => 'nuvvo_blog_todos_texto', 'type' => 'textarea', 'rows' => 2, 'columns' => 8, 'desc' => 'Texto exibido quando nenhuma categoria está selecionada.'],
            [
                'type' => 'custom_html',
                'id'   => 'nuvvo_blog_cats_nota',
                'std'  => '<p style="margin:0;padding:10px 12px;background:#f6f7f7;border-left:3px solid #7A6B5C;">Os <strong>chips</strong> e as <strong>descrições do banner</strong> de cada categoria vêm de <strong>Posts → Categorias</strong> (nome + campo "Descrição"). Edite lá para alterar.</p>',
            ],
        ],
    ];
    return $mb;
});
