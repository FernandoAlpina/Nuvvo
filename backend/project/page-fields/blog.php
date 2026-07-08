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
        ],
    ];
    return $mb;
});
