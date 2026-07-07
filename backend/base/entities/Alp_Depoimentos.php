<?php
class Alp_Depoimentos
{
  use Alp_Entitable, Alp_Renderable;

  private function get_current_language(): string
  {
    if (function_exists('getCurrentLanguage')) {
      return strtolower((string) getCurrentLanguage());
    }

    if (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE) {
      return strtolower((string) ICL_LANGUAGE_CODE);
    }

    return '';
  }

  private function translate_testimonial_copy(string $value, string $language): string
  {
    if (!$value) {
      return $value;
    }

    $map_es = [
      'Produtor Rural' => 'Productor rural',
      'Cafeicultor' => 'Productor de cafe',
      '"A cabine trouxe mais conforto e melhorou muito a qualidade do serviço. É completa, com som e ar-condicionado. A vedação e a acústica são excelentes."' => '"La cabina aporto mas confort y mejoro mucho la calidad del trabajo. Es completa, con sonido y aire acondicionado. El sellado y la acustica son excelentes."',
      '"O ar-condicionado ajuda muito, o isolamento é ótimo e a visibilidade é excelente. A gente trabalha com mais tranquilidade, sem calor e com menos ruído."' => '"El aire acondicionado ayuda mucho, el aislamiento es excelente y la visibilidad es muy buena. Trabajamos con mas tranquilidad, sin calor y con menos ruido."',
    ];

    $map_en = [
      'Produtor Rural' => 'Rural producer',
      'Cafeicultor' => 'Coffee grower',
    ];

    if ($language === 'es') {
      return $map_es[$value] ?? $value;
    }

    if ($language === 'en') {
      return $map_en[$value] ?? $value;
    }

    return $value;
  }

  public function __construct($id = 0) {
    $this->id = $id;
  }

  /**
   * Faz o setup da Entidade.
   * @hooked action 'after_setup_theme'
   */
  public static function setup(): void
  {
    self::$entity = (new Alp_Entity())
      ->create_post_type('Depoimento', 'Depoimentos', 'depoimento', false, 'format-quote', true, false);

    self::create_metaboxes();
  }

  /**
   * Estabelece os metaboxes de Projeto.
   * @return void
   */
  public static function create_metaboxes(): void
  {
    self::$entity
      ->create_metaboxes()
      ->add_metabox_box('', 'Depoimento')
      ->add_metabox_field_text('Nome e sobrenome', 'nome', 6)
      ->add_metabox_field_text('Setor', 'setor', 6)
      ->add_metabox_field_biu('Texto', 'texto', 12)
      ->add_metabox_field_image('Imagem', 'imagem', 1, 12)
      ->render();
  }

  /**
   * Recebe um array com os valores dos campos do Banner.
   * @return array Valores dos campos.
   */
  public function get_post_metas_values(string $id = '', array|false $autoimage = []): array
  {
    $autoimage_defaults = [
      'metafields' => [
        'imagem' => 'src',
        'imagens' => 'src',
      ],
    ];

    $autoimage = array_merge($autoimage_defaults, $autoimage ?: []);

    $args = $this->get_metaboxes()->get_post_metas_values($id, '_main', $autoimage);

    $texto = $args['texto'];
    $nome = $args['nome'];
    $setor = $args['setor'];

    $args = array_merge($args, compact('texto', 'nome', 'setor'));

    return $args;
  }

  public function render_card_depoimento(int $id, $css_classes = ''): string
  {
    $language = $this->get_current_language();

    $nome = get_post_meta($id, 'depoimento_nome', true);
    $setor = get_post_meta($id, 'depoimento_setor', true);
    $texto = get_post_meta($id, 'depoimento_texto', true);

    $setor = $this->translate_testimonial_copy((string) $setor, $language);
    $texto = $this->translate_testimonial_copy((string) $texto, $language);

    $imagem = get_post_meta($id, 'depoimento_imagem', true);

    if (is_numeric($imagem)) {
      $imagem = wp_get_attachment_image_url((int) $imagem, 'full') ?: '';
    }

    $args = [
      'nome' => $nome,
      'setor' => $setor,
      'texto' => $texto,
      'imagem' => $imagem,
    ];

    $args = array_merge($args, compact('css_classes'));
    return $this->html('frontend/views/avulsos/depoimentos/card-depoimento', $args);
  }

  public function render_depoimentos($swiper_class = '', $titulo = 'Depoimentos', $subtitulo = 'A palavra de quem confia na Implemaster'): string
  {
    $query_args = [
      'post_type' => 'depoimento',
      'posts_per_page' => -1,
      'orderby' => 'menu_order',
      'order' => 'ASC'
    ];

    $query = new WP_Query($query_args);
    $cards = '';

    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();

        $cards .= $this->render_card_depoimento(get_the_ID(), 'swiper-slide');
      }

      wp_reset_postdata();

      return $this->html('frontend/views/avulsos/depoimentos/section-depoimentos.php', [
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
  public function render(): void
  {
  }

  
}

/**
 * Hooks
 */
add_action('after_setup_theme', ['Alp_Depoimentos', 'setup']);