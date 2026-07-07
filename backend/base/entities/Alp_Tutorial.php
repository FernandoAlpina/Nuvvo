<?php
class Alp_Tutorial
{
  use Alp_Entitable;

  /**
   * Cria o post type e a metabox
   */
  public static function setup(): void
  {
    self::$entity = (new Alp_Entity())
      ->create_post_type(
        'Tutorial',
        'Tutoriais',
        'tutorial',
        false,
        'welcome-learn-more',
        false,
        false,
        ['menu_position' => 99, 'capability_type' => 'post', 'capabilities' => ['edit_posts' => 'manage_options'], 'map_meta_cap' => true]
      );

    self::create_metaboxes();
  }

  /**
   * Criar as metaboxes.
   * @return void
   */
  public static function create_metaboxes(): void
  {
    self::$entity
      ->create_metaboxes()
      ->add_metabox_box('', 'Informações do Tutorial')
      ->add_metabox_field('URL do vídeo', 'url', 'oembed')
      ->render();
  }

  /**
   * Exibe os tutoriais na Dashboard, usando widgets. 
   */
  public static function mostrar_dashboard()
  {
    $tutoriais = new WP_Query([
      'post_type' => self::$entity->get_post_type(),
      'posts_per_page' => -1
    ]);

    if (!$tutoriais->have_posts()) return;

    while ($tutoriais->have_posts()) {
      $tutoriais->the_post();
      $id = get_the_ID();
      $titulo = get_the_title();
      $video = get_post_meta($id, self::$entity->get_metaboxes()->get_prefix() . 'url', true);
      $embed = (new WP_oEmbed)->get_html($video, ['height' => 300]);

      wp_add_dashboard_widget("tutorial-{$id}", $titulo, function () use ($embed) {
        echo preg_replace("%width=\"(.*?)\"%", 'width="100%"', $embed);
      });
    }
  }

  private function get_post_metas_values(): void {}


  /**
   * Esconder do menu para não administradores.
   * @return void
   */
  public static function esconder_menu(): void
  {
    if (!current_user_can('manage_options')) {
      remove_menu_page('edit.php?post_type=tutorial');
    }
  }
}

/**
 * Hooks
 */
add_action('after_setup_theme', ['Alp_Tutorial', 'setup']);
add_action('wp_dashboard_setup', ['Alp_Tutorial', 'mostrar_dashboard']);
add_action('admin_menu', ['Alp_Tutorial', 'esconder_menu'], 99);
