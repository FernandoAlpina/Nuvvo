<?php
/**
 * Entidade Inspiração (CPT `inspiracao`) — galeria irregular "Inspire-se".
 * Cada item tem categoria(s) e uma posição no grid (padrão/wide/tall) que
 * mapeia para a classe CSS do site.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

class Nuvvo_Inspiracao
{
    use Alp_Entitable;

    public function __construct($id = 0)
    {
        $this->id = $id;
    }

    public static function setup(): void
    {
        self::$entity = (new Alp_Entity())
            ->create_post_type('Inspiração', 'Inspirações', 'inspiracao', true, 'format-gallery', true, false, [
                'has_archive'        => false,
                'exclude_from_search' => true,
                'supports'           => ['title', 'page-attributes'],
            ])
            // categoria de ambiente (não hierárquica; um item pode ter várias)
            ->create_taxonomy('Categoria de inspiração', 'categoria_inspiracao', [
                'hierarchical' => false,
                'rewrite'      => ['slug' => 'inspiracao-categoria', 'with_front' => false],
            ]);

        self::create_metaboxes();
    }

    public static function create_metaboxes(): void
    {
        self::$entity->create_metaboxes()
            ->add_metabox_box('', 'IMAGEM')
            ->add_metabox_field_image('Imagem', 'imagem', 1, 6)
            ->add_metabox_field_image('Imagem grande (lightbox, opcional)', 'imagem_full', 1, 6)
            ->add_metabox_field_text('Texto alternativo (alt)', 'alt', 12, ['desc' => 'Descrição da imagem para acessibilidade.'])
            ->add_metabox_field_select('Posição no grid', 'proporcao', [
                ''     => 'Padrão (1 coluna)',
                'wide' => 'Horizontal (2 colunas)',
                'tall' => 'Vertical (2 linhas)',
            ], 12)
            ->render();
    }

    public function get_post_metas_values(string $prefix = '', array|false $autoimage = []): array
    {
        return $this->get_metaboxes()->get_post_metas_values($this->id, $prefix, $autoimage);
    }
}

add_action('after_setup_theme', ['Nuvvo_Inspiracao', 'setup']);
