<?php
class Alp_Walker_Megamenu extends Walker_Nav_Menu
{
  private $items_lv1 = [];

  public function start_lvl(&$output, $depth = 0, $args = null)
  {
    $output .= NULL;
  }

  public function end_lvl(&$output, $depth = 0, $args = null)
  {
    $output .= NULL;
  }

  /**
   * Início de um item do menu.
   * @param string $output Usado para acrescentar as informações a serem impressas.
   * @param WP_Post $item Objeto do item atual.
   * @param int $depth Nível atual do menu.
   * @param stdClass $args Objeto com os argumentos do wp_nav_menu().
   * @param int $item_id Opcional. ID do item sendo iterado.
   * @return void
   */
  public function start_el(&$output, $item, $depth = 0, $args = null, $item_id = 0): void
  {
    if ($depth === 1) {
      $item->level2 = [];
      $this->items_lv1[] = $item;
    }
    if ($depth === 2) {
      $last = array_key_last($this->items_lv1);
      $this->items_lv1[$last]->level2[] = $item;
    }
  }

  function end_el(&$output, $item, $depth = 0, $args = null)
  {
    if ($depth > 0) return;

    $args = [
      'item' => $item,
      'level1' => $this->items_lv1,
    ];

    get_template_part('template-parts/header/mega-menu/item-menu', NULL, $args);

    $this->items_lv1 = [];
  }
}
