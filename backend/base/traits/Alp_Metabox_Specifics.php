<?php

/**
 * Métodos ainda mais específicos para Alp_Metabox.
 * Serão utilizados com os métodos de Alp_Metabox_Fields.
 * @see Alp_Metabox_Fields
 * 
 * @author Alpina Digital
 * @package Alpina V4
 * @since 4.0
 * 
 */
trait Alp_Metabox_Specifics
{
  /**
   * Entrega um field WYSIWYG de Metabox que tem bold, italic e underline.
   * @param string $name Name do field.
   * @param ?string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args Argumentos opcionais, irão sobrescrever os padrões.
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_biu(string $name, ?string $id = null, int $columns = 12, array $more_args = []): self
  {
    $args = [
      'options' => [
        'textarea_rows' => 4,
        'teeny' => true,
        'media_buttons' => false,
        'tinymce' => [
          'toolbar1' => 'bold italic underline'
        ],
        'quicktags' => false
      ],
    ];

    $args = array_merge($args, $more_args);

    return $this->add_metabox_field($name, $id, 'wysiwyg', $columns, $args);
  }

  /**
   * Entrega um field WYSIWYG de Metabox que tem bold, italic e underline e listas.
   * @param string $name Name do field.
   * @param ?string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args Argumentos opcionais, irão sobrescrever os padrões.
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_biu_list(string $name, ?string $id = null, int $columns = 12, array $more_args = []): self
  {
    $args = [
      'options' => [
        'textarea_rows' => 4,
        'teeny' => true,
        'media_buttons' => false,
        'tinymce' => [
          'toolbar1' => 'bold italic underline numlist bullist'
        ],
        'quicktags' => false
      ],
    ];

    $args = array_merge($args, $more_args);

    return $this->add_metabox_field($name, $id, 'wysiwyg', $columns, $args);
  }

  /**
   * Um select mais especialista, oferecendo as opções para o parâmetro target das tags HTML.
   * @param ?string $name Name do field.
   * @param ?string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args Argumentos opcionais, irão sobrescrever os padrões.
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_select_target(string $name = 'Onde abrir o link?', ?string $id = 'cta_target', int $columns = 12, array $more_args = []): self
  {
    $options = [
      '_self' => 'Mesma aba',
      '_blank' => 'Nova aba'
    ];

    return $this->add_metabox_field_select($name, $id, $options, $columns, $more_args);
  }

  /**
   * Um select mais especialista, oferecendo as opções para Cidades do Brasil, via API do IBGE.
   * @param ?string $name Name do field.
   * @param ?string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args Argumentos opcionais, irão sobrescrever os padrões.
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_select_cidades(string $name = 'Cidade', ?string $id = null, int $columns = 6, array $more_args = []): self
  {
    $post_id = $_GET['post'] ?? $_POST['post_ID'] ?? 0;

    if (isset($_POST[$this->prefix . $this->subprefix . 'estado'])) {
      $estado = (int) $_POST[$this->prefix . $this->subprefix . 'estado'];
    } else {
      $estado = (int) get_post_meta($post_id, $this->prefix . $this->subprefix . 'estado', true);
    }

    $options = Alp_IBGE::carregar_select_municipios($estado);

    return $this->add_metabox_field_select($name, $id, $options, $columns, $more_args);
  }

  /**
   * Um select mais especialista, oferecendo as opções para Estados do Brasil, via API do IBGE.
   * @param ?string $name Name do field.
   * @param ?string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args Argumentos opcionais, irão sobrescrever os padrões.
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_select_estado(string $name = 'Estado', ?string $id = null, int $columns = 6, array $more_args = []): self
  {
    $options = Alp_IBGE::carregar_select_estados();

    return $this->add_metabox_field_select($name, $id, $options, $columns, $more_args);
  }

  /**
   * Adiciona uma área em branco, sem nada, ocupando um número de colunas.
   * Usado para quebrar o layout.
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_blank(int $columns): self
  {
    return $this->add_metabox_content('', $columns);
  }
}
