<?php
/**
 * Entidade Designer (CPT `designer`).
 * Reutilizada na PDP (bio curta), em "A Nuvvo" (bio longa) e na autoria do blog.
 * A ausência de designer num produto aciona a variante "Nuvvo Signature".
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

class Nuvvo_Designer
{
    use Alp_Entitable;

    public function __construct($id = 0)
    {
        $this->id = $id;
    }

    public static function setup(): void
    {
        self::$entity = (new Alp_Entity())
            ->create_post_type('Designer', 'Designers', 'designer', false, 'admin-users', true, true, [
                'has_archive' => false,
                'supports'    => ['title', 'thumbnail'],
            ]);

        self::create_metaboxes();
    }

    public static function create_metaboxes(): void
    {
        self::$entity->create_metaboxes()
            ->add_metabox_box('', 'DADOS DO DESIGNER')
            ->add_metabox_field_text('Cargo', 'cargo', 6, ['desc' => 'Ex.: Designer de Mobiliário'])
            ->add_metabox_field_image('Foto (proporção 4:5)', 'foto', 1, 6, 'Recomendado: 600×750px (4:5).')
            ->add_metabox_field_biu('Bio curta (usada na página do produto)', 'bio_curta', 12)
            ->add_metabox_field_biu('Bio longa (usada em "A Nuvvo")', 'bio_longa', 12)
            ->render();
    }

    public function get_post_metas_values(string $prefix = '', array|false $autoimage = []): array
    {
        return $this->get_metaboxes()->get_post_metas_values($this->id, $prefix, $autoimage);
    }
}

add_action('after_setup_theme', ['Nuvvo_Designer', 'setup']);
