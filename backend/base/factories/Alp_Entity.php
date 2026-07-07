<?php

/**
 * Classe responsável pela geração de entidades (Post Types e Taxonomias).
 * Coordena também metaboxes.
 * @see Alp_Metabox
 * 
 * @author Alpina Digital
 * @package Alpina V4
 * @since 4.0
 * 
 */
class Alp_Entity
{
  protected string $post_type = '';
  protected array $taxonomies = [];
  protected Alp_Metabox $metaboxes;

  /**
   * Cria um post type.
   * @param string $singular Nome no singular.
   * @param string $plural Nome no plural.
   * @param ?string $id Identificador do post type. Por padrão é gerada uma slug do nome singular se for passado vazio.
   * @param bool $feminino Se o gênero do post type é feminino ou não.
   * @param string $dashicon Dashicon que vai utilizar
   * @param bool $public Se deve ser público.
   * @param bool $thumbnail Se deve ter suporte a thumbnails.
   * @param array $more_args Argumentos adicionais.
   * 
   * @return self para encadeamento.
   */
  public function create_post_type(string $singular, string $plural, ?string $id = null, bool $feminino = true, string $dashicon = 'post', bool $public = true, bool $thumbnail = false, array $more_args = []): self
  {
    if (!$id) $id = sanitize_title($singular);
    $this->post_type = $id;

    if ($thumbnail) $supports = ['title', 'thumbnail'];
    else $supports = ['title'];

    if ($public) $rewrite = ['slug' => $id, 'with_front' => false];
    else $rewrite = false;

    $args = [
      'labels'             => $this->create_labels_cpt($singular, $plural, $feminino),
      'public'             => $public,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'has_archive'        => false,
      'rewrite'            => $rewrite,
      'capability_type'    => 'post',
      'hierarchical'       => false,
      'menu_position'      => 24,
      'menu_icon'          => 'dashicons-' . $dashicon,
      'supports'           => $supports,
    ];

    $args = array_merge($args, $more_args);

    add_action('init', function () use ($id, $args) {
      register_post_type($id, $args);
    });

    return $this;
  }

  /**
   * Cria uma taxonomia associada ao post previamente criado.
   * @param string $nome Nome da taxonomia.
   * @param string $id ID da taxonomia.
   * @param array $more_args Argumentos adicionais.
   * @return self para encadeamento.
   */
  public function create_taxonomy(string $nome, string $id, array $more_args = []): self
  {
    $args = [
      'labels'            => ['name' => $nome],
      'hierarchical'      => true,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => false
    ];

    $args = array_merge($args, $more_args);

    add_action('init', function () use ($id, $args) {
      register_taxonomy($id, $this->post_type, $args);
    });

    $this->taxonomies[] = $id;

    return $this;
  }

  /**
   * Inicia a criação das metaboxes. Amplie esse método na classe-filha.
   * @return Alp_Metabox
   */
  public function create_metaboxes(): Alp_Metabox
  {
    return $this->metaboxes = Alp_Metabox::create_for_post_type($this->post_type, $this->post_type);
  }

  /**
   * Cria metaboxes para uma taxonomia específica desta entidade.
   * @param string $taxonomy A taxonomia que receberá os campos.
   * @param string|null $prefix Prefixo dos campos. Se null, usa o ID da taxonomia.
   * @return Alp_Metabox
   */
  public function create_taxonomy_metaboxes(string $taxonomy, ?string $prefix = null): Alp_Metabox
  {
    if (!$prefix) $prefix = $taxonomy;
    return Alp_Metabox::create_for_taxonomy($prefix, $taxonomy);
  }

  /**
   * Cria labels para um custom post type de forma mais ágil.
   * @param string $nameSingular Nome do post type no singular.
   * @param string $namePlural Nome do post type no plural.
   * @param bool $feminino Se o nome do post type é feminino.
   * @return array Array com as labels.
   */
  private function create_labels_cpt(string $singular, string $plural, bool $feminino = false): array
  {

    $adicionar_novo = 'Adicionar Nov' . ($feminino ? 'a ' : 'o ');
    $adicionar_novo_item =  'Adicionar Nov' . ($feminino ? 'a ' : 'o ');
    $novo =  'Nov' . ($feminino ? 'a ' : 'o ') . $singular;
    $todos = 'Tod' . ($feminino ? 'as ' : 'os ') . ($feminino ? 'as ' : 'os ') . $plural;
    $nenhum_encontrado =  'Nenhum' . ($feminino ? 'a ' : ' ')  . $singular . ' Encontrad' . ($feminino ? 'a' : 'o');
    $nenhum_lixeira =  'Nenhum' . ($feminino ? 'a ' : ' ') . $singular . ' na Lixeira';

    $labels = array(
      'name'               => $plural,
      'singular_name'      => $singular,
      'add_new'            => $adicionar_novo,
      'add_new_item'       => $adicionar_novo_item,
      'edit_item'          => 'Editar ' . $singular,
      'new_item'           => $novo,
      'all_items'          => $todos,
      'view_item'          => 'Ver ' . $singular,
      'search_items'       => 'Pesquisar ' . $singular,
      'not_found'          => $nenhum_encontrado,
      'not_found_in_trash' => $nenhum_lixeira,
      'parent_item_colon'  => '',
      'menu_name'          => $plural
    );

    return $labels;
  }

  /**
   * Retorna o post type da entidade.
   * @return string ID do post type.
   */
  public function get_post_type(): string
  {
    return $this->post_type;
  }

  /**
   * Retorna as taxonomias da entidade.
   * @return array Array com os IDs das taxonomias.
   */
  public function get_taxonomies(): array
  {
    return $this->taxonomies;
  }

  /**
   * Retorna as metaboxes da entidade.
   * @return Alp_Metabox Objeto com as metaboxes.
   */
  public function get_metaboxes(): Alp_Metabox
  {
    return $this->metaboxes;
  }
}
