<?php
class Alp_Walker_Mega extends Walker_Nav_Menu
{
  private array $filhos;

  function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    if ($depth < 1)
      return;

    $parent = intval($item->menu_item_parent);
    $this->filhos[$parent][] = $item;
  }

  function end_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    if ($depth > 0)
      return;

    $filhos = $this->filhos[$item->ID] ?? [];
    $titulo = $item->title;


    $url = $item->url;
    $part_args = compact('filhos', 'titulo', 'url');

    ob_start();
    get_template_part('template-parts/header/mega/item-menu-lvl0', NULL, $part_args);
    $output .= ob_get_clean();
  }

  function start_lvl(&$output, $depth = 0, $args = null)
  {
    return;
  }

  function end_lvl(&$output, $depth = 0, $args = null)
  {
    return;
  }


}
