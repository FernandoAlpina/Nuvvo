<?php
class Implemaster_Itens_Inclusos
{
  use Alp_Entitable;

  public function __construct($id = 0)
  {
    $this->id = $id;
  }

  /**
   * Faz o setup da Entidade.
   * @hooked action 'after_setup_theme'
   */
  public static function setup(): void
  {
    self::$entity = (new Alp_Entity())
      ->create_post_type('Itens inclusos', 'Itens inclusos', 'itens_inclusos', false, 'editor-ul', true, true);

    self::create_metaboxes();
  }

  /**
   * Estabelece os metaboxes de Itens Inclusos.
   * @return void
   */
  public static function create_metaboxes(): void
  {
    self::$entity
      ->create_metaboxes()

      ->add_metabox_box('', 'Itens de série')
      ->add_metabox_group('Itens de série', 'itens_serie', '{item_serie_titulo}', -1, 12)
      ->add_metabox_field_text('Título', 'item_serie_titulo', 6)
      ->add_metabox_field_image('Ícone', 'item_serie_icone', 1, 4)
      ->close_metabox_group()
      
      ->add_metabox_box('', 'Opcionais')
      ->add_metabox_group('Opcionais', 'opcionais', '{opcional_titulo}', -1, 12)
      ->add_metabox_field_text('Título', 'opcional_titulo', 6)
      ->add_metabox_field_image('Ícone', 'opcional_icone', 1, 4)
      ->close_metabox_group()
      

      ->render();
  }

  /**
   * Retorna os valores dos campos.
   * @return array
   */
  public function get_post_metas_values(): array
  {
    $values = $this->get_metaboxes()->get_post_metas_values($this->id, '_main');
    return $values;
  }
}

/**
 * Hooks
 */
add_action('after_setup_theme', ['Implemaster_Itens_Inclusos', 'setup']);
