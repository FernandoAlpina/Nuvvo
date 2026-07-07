<?php
class Alp_Walker_Linear extends Walker_Nav_Menu
{
  private $li_class = '';

  public function set_li_class(array|string $css_classes): void
  {
    if (is_array($css_classes))
      $css_classes = implode(" ", $css_classes);
    $this->li_class = $css_classes;
  }

  /**
   * Início de um item do menu.
   * @param string $output Usado para acrescentar as informações a serem impressas.
   * @param WP_Post $item Objeto do item atual.
   * @param int $depth Nível atual do menu. (Esse menu não terá outros níveis).
   * @param stdClass $args Objeto com os argumentos do wp_nav_menu().
   * @param int $item_id Opcional. ID do item sendo iterado.
   * @return void
   */
  public function start_el(&$output, $item, $depth = 0, $args = null, $item_id = 0): void
  {
    $target = $item->target === "_blank" ? "_blank" : "_self";
    $item_classes = is_array($item->classes) ? array_filter($item->classes) : [];
    $walker_classes = array_filter(explode(' ', (string) $this->li_class));
    $classes = array_merge($item_classes, $walker_classes);
    $classes = apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth);
    $class_names = esc_attr(trim(implode(' ', array_unique(array_filter($classes)))));
    $url = !empty($item->url) ? $item->url : '#';
    $title = !empty($item->title) ? $item->title : '';

    ob_start();
?>
    <li class="<?= $class_names; ?>">
      <a href="<?= esc_url($url); ?>" target="<?= esc_attr($target); ?>">
        <?= esc_html($title); ?>
      </a>
  <?php
    $output .= ob_get_clean();
  }

  function end_el(&$output, $item, $depth = 0, $args = null)
  {
    $output .= "</li>";
  }
}
