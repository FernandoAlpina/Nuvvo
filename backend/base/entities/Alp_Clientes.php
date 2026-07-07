<?php
class Alp_Clientes
{
  use Alp_Entitable, Alp_Renderable;

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
      ->create_post_type('Cliente', 'Clientes', 'cliente', false, 'businessperson', true, true);

    self::create_metaboxes();
  }

  /**
   * Estabelece os metaboxes de Cliente.
   * @return void
   */
  public static function create_metaboxes(): void
  {
    self::$entity
      ->create_metaboxes()
      ->add_metabox_box('', 'Clientes')
      ->add_metabox_field_image('Logo', 'logo', 1, 12)
      ->render();
  }

  /**
   * Recebe um array com os valores dos campos do Cliente.
   * @return array Valores dos campos.
   */
  public function get_post_metas_values(string $id = '', array|false $autoimage = []): array
  {
    $autoimage_defaults = [
      'metafields' => [
        'logo' => 'src',
      ],
    ];

    $autoimage = array_merge($autoimage_defaults, $autoimage ?: []);

    $args = $this->get_metaboxes()->get_post_metas_values($id, '_main', $autoimage);

    $logo = $args['logo'];

    $args = array_merge($args, compact('logo'));

    return $args;
  }

  public function render_card_cliente(int $id, $css_classes = ''): string
  {
    $logo = get_post_meta($id, 'cliente_logo', true);

    if (!$logo) {
      $logo_data = get_post_meta($id, '_main', true);
      if (is_array($logo_data) && isset($logo_data['logo'])) {
        $logo = $logo_data['logo'];
      }
    }

    $logo_orientation = 'landscape';

    if (is_numeric($logo)) {
      $logo_metadata = wp_get_attachment_metadata((int) $logo);

      if (is_array($logo_metadata)) {
        $logo_width = (int) ($logo_metadata['width'] ?? 0);
        $logo_height = (int) ($logo_metadata['height'] ?? 0);

        if ($logo_width > 0 && $logo_height > 0) {
          if ($logo_height > $logo_width) {
            $logo_orientation = 'portrait';
          } elseif ($logo_height === $logo_width) {
            $logo_orientation = 'square';
          }
        }
      }

      $logo = wp_get_attachment_image_url((int) $logo, 'full') ?: '';
    }

    $args = [
      'logo' => $logo,
      'logo_orientation' => $logo_orientation,
    ];

    $args = array_merge($args, compact('css_classes'));
    return $this->html('frontend/views/avulsos/clientes/card-cliente', $args);
  }

  public function render_clientes($swiper_class = 'clientes', $titulo = 'Clientes', $subtitulo = 'A palavra de quem confia na Implemaster'): string
  {
    $query_args = [
      'post_type' => 'cliente',
      'posts_per_page' => -1,
      'orderby' => 'menu_order',
      'order' => 'ASC'
    ];

    $query = new WP_Query($query_args);
    $cards = '';

    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();

        $cards .= $this->render_card_cliente(get_the_ID(), 'swiper-slide');
      }

      wp_reset_postdata();

      return $this->html('frontend/views/avulsos/clientes/section-clientes', [
        'cards' => $cards,
        'titulo' => $titulo,
        'subtitulo' => $subtitulo,
        'swiper_class' => $swiper_class,
        'darker' => true,
        'css_classes' => 'padding-y-lg padding-y-xxl@md'
      ]);
    }

    return '';
  }

  /**
   * Renderiza a página.
   * @return void
   */
  public function render(): void {}
}

/**
 * Hooks
 */
add_action('after_setup_theme', ['Alp_Clientes', 'setup']);
