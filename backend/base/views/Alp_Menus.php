<?php

/**
 * Classe destinada a facilitar a montagem de menus.
 */
class Alp_Menus
{
  protected static array $walkers = [];

  /**
   * Registra os menus a serem utilizados no tema e seta um array com os objetos dos walkers.
   */
  public static function setup(): void
  {
    register_nav_menus(
      [
        'menu-principal' => 'Menu Principal',
        'footer-solucoes' => 'Rodapé - Soluções',
        'footer-institucional' => 'Rodapé - Institucional',
        'footer-cabines' => 'Rodapé - Cabines',
        'footer-menu' => 'Rodapé - Menu',
        'footer-politicas' => 'Rodapé - Políticas',
      ]
    );

    /**
     * Seta ao array de objetos de Walkers
     */
    self::$walkers = [
      'linear' => new Alp_Walker_Linear(),
      'flexi' => new Alp_Walker_Flexi(),
      'mega' => new Alp_Walker_Mega(),
    ];

    add_action('wp_nav_menu_item_custom_fields', ['Alp_Menus', 'adicionar_destaque'], 10, 4);
    add_action('wp_update_nav_menu_item', ['Alp_Menus', 'salvar_destaque'], 10, 3);
    add_filter('nav_menu_css_class', ['Alp_Menus', 'add_class_destaque'], 10, 4);
  }

  /**
   * Retorna um menu linear, de nível único, pronto para impressão.
   * @param string $localizacao Localização do menu no tema, como registrado.
   * @param string|array $ul_class Classes CSS da tag <ul> que contém o menu.
   * @param string|array $li_class Classes CSS para as tags <li> dos itens do menu.
   * @param string|array $a_class Classes CSS para as tags <a> dos itens do menu.
   * @param array $args Argumentos adicionais de wp_nav_menu.
   * @return string Retorna uma string com a estrutura HTML do menu montada.
   */
  public static function linear(string $localizacao, string|array $ul_class = '', string|array $li_class = '', string|array $a_class = '', $args = []): string
  {
    if (is_array($ul_class))
      $ul_class = implode(" ", $ul_class);
    if (is_array($li_class))
      $li_class = implode(" ", $li_class);

    if ($li_class) {
      self::$walkers['linear']->set_li_class($li_class);
    }

    $default_args = [
      'menu_class' => $ul_class,
      'menu_id' => $localizacao,
      'container' => '',
      'theme_location' => $localizacao,
      'echo' => false,
      'walker' => self::$walkers['linear'],
    ];

    $args = array_merge($default_args, $args);

    $nav = wp_nav_menu($args);

    if (is_array($a_class))
      $a_class = implode(" ", $a_class);

    if ($a_class) {
      $nav = preg_replace("%(<a.*?)>%", "$1 class=\"{$a_class}\">", $nav);
    }

    return $nav;
  }

  /**
   * Retorna um menu flexi, de dois níveis, pronto para impressão.
   * @param string $localizacao Localização do menu no tema, como registrado.
   * @param string|array $ul_class Classes CSS da tag <ul> que contém o menu.
   * @param array $args Argumentos adicionais de wp_nav_menu.
   * @return string Retorna uma string com a estrutura HTML do menu montada.
   */
  public static function flexi(string $localizacao, string|array $ul_class = '', $args = []): string
  {
    return self::flexi_or_mega($localizacao, $ul_class, $args, 'flexi');
  }

  /**
   * Retorna um menu mega, de dois níveis, pronto para impressão.
   * @param string $localizacao Localização do menu no tema, como registrado.
   * @param string|array $ul_class Classes CSS da tag <ul> que contém o menu.
   * @param array $args Argumentos adicionais de wp_nav_menu.
   * @return string Retorna uma string com a estrutura HTML do menu montada.
   */
  public static function mega(string $localizacao, string|array $ul_class = '', $args = []): string
  {
    return self::flexi_or_mega($localizacao, $ul_class, $args, 'mega');
  }

  private static function flexi_or_mega(string $localizacao, string|array $ul_class = '', array $args = [], string $tipo = 'flexi')
  {
    if (is_array($ul_class))
      $ul_class = implode(" ", $ul_class);

    $default_args = [
      'menu_class' => $ul_class,
      'menu_id' => $localizacao,
      'container' => '',
      'theme_location' => $localizacao,
      'echo' => false,
      'walker' => self::$walkers[$tipo],
    ];

    $args = array_merge($default_args, $args);
    $nav = wp_nav_menu($args);

    return $nav;
  }

  /**
   * Insere um novo campo no menu para marcar um item como destaque.
   * @param string $item_id ID do item do menu.
   * @param WP_Post $item Item do menu.
   * @param int $depth Profundidade do item.
   * @param stdClass $args Argumentos do menu.
   * 
   * @return void
   * @hooked action 'wp_nav_menu_item_custom_fields'
   */
  public static function adicionar_destaque(string $item_id, WP_Post $item, int $depth, ?stdClass $args): void
  {
    $destaque = get_post_meta($item_id, '_destaque', true);
    $somente_mobile = get_post_meta($item_id, '_mostrar_apenas_mobile', true);
    $somente_desktop = get_post_meta($item_id, '_mostrar_apenas_desktop', true);
    $ocultar_submenu_mobile = get_post_meta($item_id, '_ocultar_submenu_mobile', true);
    ?>
    <p class="field-item-destaque description description-wide">
      <label for="edit-menu-item-item-destaque-<?php echo $item_id; ?>">
        <input type="checkbox" id="edit-menu-item-item-destaque-<?php echo $item_id; ?>"
          name="menu-item-item-destaque[<?php echo $item_id; ?>]" value="1" <?php checked($destaque, 1); ?> />
        <?php _e('Item em destaque'); ?>
      </label>
    </p>

    <p class="field-item-visibility description description-wide">
      <strong><?php _e('Visibilidade do item'); ?></strong><br>
      <label for="edit-menu-item-only-mobile-<?php echo $item_id; ?>" style="margin-right: 12px;">
        <input type="checkbox" id="edit-menu-item-only-mobile-<?php echo $item_id; ?>"
          name="menu-item-only-mobile[<?php echo $item_id; ?>]" value="1" <?php checked($somente_mobile, 1); ?> />
        <?php _e('Mostrar apenas mobile'); ?>
      </label>
      <label for="edit-menu-item-only-desktop-<?php echo $item_id; ?>">
        <input type="checkbox" id="edit-menu-item-only-desktop-<?php echo $item_id; ?>"
          name="menu-item-only-desktop[<?php echo $item_id; ?>]" value="1" <?php checked($somente_desktop, 1); ?> />
        <?php _e('Mostrar apenas desktop'); ?>
      </label>
      <br>
      <small><?php _e('Se nenhuma opção for marcada, o item será exibido em ambos.'); ?></small>
    </p>

    <p class="field-item-hide-submenu-mobile description description-wide">
      <label for="edit-menu-item-hide-submenu-mobile-<?php echo $item_id; ?>">
        <input type="checkbox" id="edit-menu-item-hide-submenu-mobile-<?php echo $item_id; ?>"
          name="menu-item-hide-submenu-mobile[<?php echo $item_id; ?>]" value="1" <?php checked($ocultar_submenu_mobile, 1); ?> />
        <?php _e('Ocultar submenu no celular'); ?>
      </label><br>
      <small><?php _e('Se ativado, o item vira link direto no mobile (sem abrir o submenu).'); ?></small>
    </p>
    <?php
  }

  /**
   * Salva o destaque do item de menu.
   * 
   * @param int $menu_id O ID do menu.
   * @param int $menu_item_db_id O ID do item de menu no banco de dados.
   * @param array $menu_item_data Um array com os dados do item de menu.
   * 
   * @return void
   * @hooked action 'wp_update_nav_menu_item'
   */
  public static function salvar_destaque(int $menu_id, int $menu_item_db_id, array $menu_item_data): void
  {
    if (isset($_POST['menu-item-item-destaque'][$menu_item_db_id])) {
      update_post_meta($menu_item_db_id, '_destaque', 1);
    } else {
      delete_post_meta($menu_item_db_id, '_destaque');
    }

    $somente_mobile = isset($_POST['menu-item-only-mobile'][$menu_item_db_id]);
    $somente_desktop = isset($_POST['menu-item-only-desktop'][$menu_item_db_id]);

    // Se ambos estiverem selecionados, assume comportamento padrão (mostrar em ambos).
    if ($somente_mobile && $somente_desktop) {
      delete_post_meta($menu_item_db_id, '_mostrar_apenas_mobile');
      delete_post_meta($menu_item_db_id, '_mostrar_apenas_desktop');
      return;
    }

    if ($somente_mobile) {
      update_post_meta($menu_item_db_id, '_mostrar_apenas_mobile', 1);
      delete_post_meta($menu_item_db_id, '_mostrar_apenas_desktop');
    } elseif ($somente_desktop) {
      update_post_meta($menu_item_db_id, '_mostrar_apenas_desktop', 1);
      delete_post_meta($menu_item_db_id, '_mostrar_apenas_mobile');
    } else {
      delete_post_meta($menu_item_db_id, '_mostrar_apenas_mobile');
      delete_post_meta($menu_item_db_id, '_mostrar_apenas_desktop');
    }

    if (isset($_POST['menu-item-hide-submenu-mobile'][$menu_item_db_id])) {
      update_post_meta($menu_item_db_id, '_ocultar_submenu_mobile', 1);
    } else {
      delete_post_meta($menu_item_db_id, '_ocultar_submenu_mobile');
    }
  }

  /**
   * Adiciona a classe 'menu-item-destaque' ao item de menu que está marcado como destaque.
   * @param string[] $classes
   * @param WP_Post $item
   * @param stdClass $args
   * @param int $depth
   * 
   * @return array
   * @hooked filter 'nav_menu_css_class'
   */
  public static function add_class_destaque(array $classes, WP_Post $item, stdClass|array $args, int $depth): array
  {
    $destaque = get_post_meta($item->ID, '_destaque', true);
    $somente_mobile = get_post_meta($item->ID, '_mostrar_apenas_mobile', true);
    $somente_desktop = get_post_meta($item->ID, '_mostrar_apenas_desktop', true);

    if ($destaque) {
      $classes[] = 'menu-item-destaque';
    }

    if ($somente_mobile && !$somente_desktop) {
      $classes[] = 'hide@md';
    } elseif ($somente_desktop && !$somente_mobile) {
      $classes[] = 'hide';
      $classes[] = 'block@md';
    }

    return $classes;
  }
}

add_action('after_setup_theme', ['Alp_Menus', 'setup']);
