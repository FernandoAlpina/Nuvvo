<?php
class Alp_FAQ
{
  use Alp_Entitable;

  /**
   * Faz o setup de CPT, taxonomia e metaboxes.
   */
  public static function setup(): void
  {
    self::$entity = (new Alp_Entity())
      ->create_post_type('FAQ', 'FAQ', 'faq', false, 'editor-help', false, false, ['supports' => ['title', 'editor']])
      ->create_taxonomy('Categoria de FAQ', 'faq_cat');
  }

  public static function get_categorias_faq(): array
  {
    $categorias = get_terms([
      'taxonomy' => 'faq_cat',
      'hide_empty' => true
    ]);

    return $categorias;
  }

  public static function get_faqs_por_categoria(WP_Term $categoria): WP_Query
  {
    $busca = $_REQUEST['buscar_duvidas'] ?? '';

    $args = [
      'post_type' => 'faq',
      'tax_query' => [
        [
          'taxonomy' => 'faq_cat',
          'terms' => $categoria->term_id,
          'include_children' => false
        ]
      ],
      's' => $busca
    ];

    return new WP_Query($args);
  }

  /**
   * Não vai se aplicar nesse momento.
   */
  private static function create_metaboxes(): void {}
  private function get_post_metas_values(): void {}
}

/**
 * Hooks
 */
add_action('after_setup_theme', ['Alp_FAQ', 'setup']);
