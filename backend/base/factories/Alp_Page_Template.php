<?php
class Alp_Page_Template
{
  public string $name = '';
  public string $prefix = '';
  public Alp_Metabox $metaboxes;

  public function __construct($name, $prefix = '')
  {
    if (!preg_match('%template-%', $name)) $name = 'template-' . $name;
    if (!preg_match('%\.php%', $name)) $name .= '.php';

    $this->name = $name;

    if (!$prefix) {
      $prefix = preg_replace("%^.*?template-(.*?)\.php$%", "$1", $name);
      $prefix = preg_replace('%-%', '_', $prefix);
      $prefix = preg_replace('%[\W]%', '', $prefix);
    }

    $this->prefix = $prefix;
  }

  /**
   * Cria as metaboxes do template.
   * @param bool $remove_editor Se vai remover o editor da página
   * 
   * @return Alp_Metabox Objeto de metaboxes.
   */
  public function create_metaboxes($remove_editor = true): Alp_Metabox
  {
    return $this->metaboxes = Alp_Metabox::create_for_template_page($this->prefix, $this->name, $remove_editor);
  }

  /**
   * Entrega os IDs das páginas que usam esse template específico.
   * @param bool $singular Se deseja o ID apenas da primeira página encontrada, presumindo que apenas uma página usa esse template.
   * 
   * @return int|array Se singular é true, entrega o ID da página ou 0 se não encontrar. Se singular é false, um array com os IDs das páginas ou vazio. 
   */
  public function get_template_ids(bool $singular = true): int|array
  {
    $query = new WP_Query([
      'post_type'   => 'page',
      'meta_query' => [
        [
          'key' => '_wp_page_template',
          'value' => $this->name
        ]
      ],
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'orderby' => 'name',
      'order' => 'ASC',
      'fields' => 'ids'
    ]);

    if (!$query->have_posts()) return $singular ? 0 : [];

    $paginas = $query->get_posts();

    return $singular ? reset($paginas) : $paginas;
  }

  /**
   * Entrega o ID de uma página que usa esse template específico. Presume-se que só uma página usa o template, ou só te interessa a primeira.
   * @return int O ID da página ou 0 se não encontrar.
   */
  public function get_template_id(): int
  {
    return $this->get_template_ids(true);
  }

  /**
   * Retorna o nome do template.
   * @return string nome do template.
   */
  public function get_name(): string
  {
    return $this->name;
  }

  /**
   * Retorna o prefixo do template.
   * @return string prefixo do template.
   */
  public function get_prefix(): string
  {
    return $this->prefix;
  }
}
