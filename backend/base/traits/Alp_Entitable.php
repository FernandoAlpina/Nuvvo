<?php
trait Alp_Entitable
{
  /**
   * Utiliza a classe Alp_Entity para criar a entidade.
   */
  private static Alp_Entity $entity;

  /**
   * Post ID.
   */
  private int $id;

  public function __construct(int $id)
  {
    $this->id = $id;
  }

  /**
   * Recebe um objeto Alp_Metabox dos metaboxes do Banner.
   * @return Alp_Metabox
   */
  public function get_metaboxes(): Alp_Metabox
  {
    return self::$entity->get_metaboxes();
  }

  abstract static function setup(): void;
  abstract static function create_metaboxes(): void;
  abstract function get_post_metas_values();
}
