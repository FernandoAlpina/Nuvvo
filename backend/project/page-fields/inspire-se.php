<?php
/**
 * Campos editáveis da página "Inspire-se" (slug "inspire-se").
 * A galeria é dinâmica (CPT `inspiracao`); aqui só o Hero é editável.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_filter('rwmb_meta_boxes', function ($mb) {
    $mb[] = [
        'id'         => 'nuvvo_pg_inspirese',
        'title'      => 'Conteúdo — Inspire-se',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['inspire-se']],
        'fields'     => [
            ['type' => 'heading', 'name' => 'Hero'],
            ['name' => 'Eyebrow', 'id' => 'nuvvo_inspirese_hero_eyebrow', 'type' => 'text', 'columns' => 4],
            ['name' => 'Título', 'id' => 'nuvvo_inspirese_hero_titulo', 'type' => 'text', 'columns' => 8],
            ['name' => 'Subtítulo', 'id' => 'nuvvo_inspirese_hero_sub', 'type' => 'textarea', 'rows' => 2],
        ],
    ];
    return $mb;
});
