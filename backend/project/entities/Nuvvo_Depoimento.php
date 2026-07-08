<?php
/**
 * Entidade Depoimento (CPT `depoimento`) — carrossel de depoimentos da Home.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

class Nuvvo_Depoimento
{
    use Alp_Entitable;

    public function __construct($id = 0)
    {
        $this->id = $id;
    }

    public static function setup(): void
    {
        self::$entity = (new Alp_Entity())
            ->create_post_type('Depoimento', 'Depoimentos', 'depoimento', false, 'format-quote', false, false, [
                'supports' => ['title', 'page-attributes'],
            ]);

        self::create_metaboxes();
    }

    public static function create_metaboxes(): void
    {
        self::$entity->create_metaboxes()
            ->add_metabox_box('', 'DEPOIMENTO')
            ->add_metabox_field_textarea('Texto do depoimento', 'texto', 12, ['rows' => 4])
            ->add_metabox_field_text('Nome', 'nome', 6, ['desc' => 'Se vazio, usa o título do post.'])
            ->add_metabox_field_text('Cargo / cidade', 'cargo', 6)
            ->add_metabox_field_image('Foto (opcional)', 'foto', 1, 6)
            ->render();
    }

    public function get_post_metas_values(string $prefix = '', array|false $autoimage = []): array
    {
        return $this->get_metaboxes()->get_post_metas_values($this->id, $prefix, $autoimage);
    }
}

add_action('after_setup_theme', ['Nuvvo_Depoimento', 'setup']);
