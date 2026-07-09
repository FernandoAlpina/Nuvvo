<?php
/**
 * Campos editáveis da página "Contato" (slug "contato").
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_filter('rwmb_meta_boxes', function ($mb) {
    $mb[] = [
        'id'         => 'nuvvo_pg_contato',
        'title'      => 'Conteúdo — Contato',
        'post_types' => ['page'],
        'include'    => ['relation' => 'OR', 'slug' => ['contato']],
        'fields'     => [
            ['type' => 'heading', 'name' => 'Hero'],
            ['name' => 'Eyebrow', 'id' => 'nuvvo_contato_hero_eyebrow', 'type' => 'text', 'columns' => 4],
            ['name' => 'Título', 'id' => 'nuvvo_contato_hero_titulo', 'type' => 'text', 'columns' => 8],
            ['name' => 'Subtítulo', 'id' => 'nuvvo_contato_hero_sub', 'type' => 'textarea', 'rows' => 2],
            ['name' => 'Imagem do hero', 'id' => 'nuvvo_contato_hero_img', 'type' => 'single_image', 'columns' => 6, 'desc' => 'Recomendado: 800×1000px (retrato).'],
            ['name' => 'Mensagem do WhatsApp (CTA)', 'id' => 'nuvvo_contato_cta_msg', 'type' => 'text', 'columns' => 6],

            ['type' => 'heading', 'name' => 'Studio'],
            ['name' => 'Eyebrow', 'id' => 'nuvvo_contato_studio_eyebrow', 'type' => 'text', 'columns' => 4],
            ['name' => 'Título', 'id' => 'nuvvo_contato_studio_titulo', 'type' => 'text', 'columns' => 8],
            ['name' => 'Descrição', 'id' => 'nuvvo_contato_studio_lede', 'type' => 'textarea', 'rows' => 3],
            ['name' => 'Galeria do studio', 'id' => 'nuvvo_contato_studio_galeria', 'type' => 'image_advanced', 'max_file_uploads' => 6, 'desc' => 'Recomendado: 800×1000px. A 1ª imagem ocupa o bloco maior.'],
            ['name' => 'Link "Como chegar" (Google Maps)', 'id' => 'nuvvo_contato_maps_link', 'type' => 'url', 'columns' => 6],
            ['name' => 'URL do mapa (embed)', 'id' => 'nuvvo_contato_map_embed', 'type' => 'text', 'columns' => 6, 'desc' => 'Usado quando NÃO há chave da Google Maps API (mapa padrão).'],
            ['name' => 'Latitude (mapa estilizado)', 'id' => 'nuvvo_contato_map_lat', 'type' => 'text', 'columns' => 6, 'desc' => 'Ex.: -28.4503. Usado com a chave da API (mapa nas cores da marca).'],
            ['name' => 'Longitude (mapa estilizado)', 'id' => 'nuvvo_contato_map_lng', 'type' => 'text', 'columns' => 6, 'desc' => 'Ex.: -52.1989.'],

            ['type' => 'heading', 'name' => 'Redes sociais'],
            ['name' => 'Título', 'id' => 'nuvvo_contato_social_titulo', 'type' => 'text'],
            ['name' => 'Subtítulo', 'id' => 'nuvvo_contato_social_sub', 'type' => 'textarea', 'rows' => 2],
        ],
    ];
    return $mb;
});
