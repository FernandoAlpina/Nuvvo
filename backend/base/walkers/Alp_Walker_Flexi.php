<?php
class Alp_Walker_Flexi extends Walker_Nav_Menu
{
  use Alp_Renderable;
  private array $filhos;

  public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    if ($depth < 1) return;

    $titulo = $item->title;
    $url = $item->url;
    $parent = intval($item->menu_item_parent);
    $target = $item->target === "_blank" ? "_blank" : "_self";
    $classes = $this->get_visibility_classes((int) $item->ID);

    $this->filhos[$parent][] = (object) compact('titulo', 'url', 'target', 'classes');
  }

  public function end_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    if ($depth > 0) return;
    $filhos = $this->filhos[$item->ID] ?? false;

    $titulo = $item->title;
    $url = $item->url;

    $classes = (bool) get_post_meta($item->db_id, '_destaque', true) ? 'f-header__item--destaque' : '';
    $classes .= $this->get_visibility_classes((int) $item->db_id, $classes !== '');

    $target =  $item->target === "_blank" ? "_blank" : "_self";
    $ocultar_submenu_mobile = (bool) get_post_meta($item->db_id, '_ocultar_submenu_mobile', true);

    $part_args = compact('filhos', 'titulo', 'url', 'classes', 'target', 'ocultar_submenu_mobile');
    $output .= $this->html('frontend/views/header/item-header', $part_args);
  }

  public function start_lvl(&$output, $depth = 0, $args = null): void {}

  public function end_lvl(&$output, $depth = 0, $args = null): void {}

  public function render(): void {}

  private function get_visibility_classes(int $item_id, bool $prepend_space = false): string
  {
    $somente_mobile = (bool) get_post_meta($item_id, '_mostrar_apenas_mobile', true);
    $somente_desktop = (bool) get_post_meta($item_id, '_mostrar_apenas_desktop', true);

    if ($somente_mobile && !$somente_desktop) {
      return ($prepend_space ? ' ' : '') . 'hide@md';
    }

    if ($somente_desktop && !$somente_mobile) {
      return ($prepend_space ? ' ' : '') . 'hide block@md';
    }

    return '';
  }
}
