<?php

/**
 * Classe que deve ser estendida para criação de novas páginas.
 * @author Alpina Digital
 * @package Alpina V4
 * @since 4.0
 */
abstract class Alp_Page
{
  use Alp_Renderable;

  protected Alp_Page_Template $template;
  protected int $id;

  abstract function setup(): void;
  abstract function create_metaboxes(): void;

  /**
   * Construtor da classe.
   * @param bool $queried_id Se deve pegar o ID através do queried object ou através do template.
   */
  public function __construct($queried_id = true)
  {
    $this->setup();

    if ($queried_id) $this->id = get_queried_object_id();
    else $this->id = $this->template->get_template_id();
  }

  /**
   * Recebe o ID da página.
   */
  public function get_id()
  {
    return $this->id;
  }

  /**
   * Define o ID da página.
   */
  public function set_id(int $id = 0): void
  {
    if ($id) $this->id = $id;
    else {
      wp_reset_query();
      $this->id = get_queried_object_id();
    }
  }

  /**
   * Retorna os valores dos metas de um post usando a estrutura do próprio Alp_Metabox.
   * @param string $subprefix Subprefix específico para buscar os metas.
   * @param array|false $autoimage Array com a configuração para a Alp_Metabox_AutoImage. Ou false para não utilizar o recurso.
   * 
   * @return array Array com os valores dos metas.
   * @see Alp_Metabox_AutoImage para ver as chaves e valores que podem ser passados no array
   */
  public function get_post_metas_values(string $subprefix = '', array|false $autoimage = []): array
  {
    if (!$this->template || !$this->template->metaboxes) return [];
    return $this->template->metaboxes->get_post_metas_values($this->id, $subprefix, $autoimage);
  }
}
