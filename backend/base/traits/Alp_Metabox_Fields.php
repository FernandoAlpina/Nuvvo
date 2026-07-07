<?php

/**
 * Métodos para alguns dos tipos de fields. Para ser incluido no Alp_Metabox.
 * @see Alp_Metabox::add_metabox_field()
 * 
 * @author Alpina Digital
 * @package Alpina V4
 * @since 4.0
 * 
 */
trait Alp_Metabox_Fields
{
  /**
   * Entrega um field de Metabox básico de texto
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args Mais argumentos para o field. (Sobrescrevem os anteriores se necessário.)
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_text(string $name, string $id, int $columns = 12, array $more_args = []): self
  {
    return $this->add_metabox_field($name, $id, 'text', $columns, $more_args);
  }

  /**
   * Entrega um field de Metabox básico de textarea
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args Mais argumentos para o field. (Sobrescrevem os anteriores se necessário.)
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_textarea(string $name, string $id, int $columns = 12, array $more_args = []): self
  {
    return $this->add_metabox_field($name, $id, 'textarea', $columns, $more_args);
  }

  /**
   * Entrega um field de Metabox básico de texto
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $columns Número do colunas do layout.
   * @param float $min O mínimo.
   * @param float $max O máximo.
   * @param float $step O step.
   * @param array<string,mixed> $more_args Mais argumentos para o field. (Sobrescrevem os anteriores se necessário.)
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_number(string $name, string $id, int $columns = 12, float $min = 0, float $max = 99999, float $step = 1, array $more_args = []): self
  {
    $args = [
      'min' => $min,
      'max' => $max,
      'step' => $step
    ];

    $args = array_merge($args, $more_args);

    return $this->add_metabox_field($name, $id, 'number', $columns, $args);
  }

  /**
   * Entrega um field de Metabox para imagens.
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $numero_imagens Número de imagens que poderão subir. Padrão será só uma.
   * @param int $columns Número do colunas do layout.
   * @param string $desc Descrição do field, por exemplo 'Tamanho sugerido: 320 x 500px'.
   * @param array<string,mixed> $more_args Mais argumentos para o field. (Sobrescrevem os anteriores se necessário.)
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_image(string $name, string $id, int $numero_imagens = 1, int $columns = 12, string $desc = '', array $more_args = []): self
  {
    $args = [
      'max_file_uploads' => $numero_imagens,
      'max_status' => $numero_imagens === 1 ? false : true,
      'desc' => $desc,
    ];

    $args = array_merge($args, $more_args);

    return $this->add_metabox_field($name, $id, 'image_advanced', $columns, $args);
  }

  /**
   * Entrega um field de Metabox para vídeo.
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $numero_videos Número de imagens que poderão subir. Padrão será só uma.
   * @param int $columns Número do colunas do layout.
   * @param string $desc Descrição do field, por exemplo 'Tamanho sugerido: 320 x 500px'.
   * @param array<string,mixed> $more_args Mais argumentos para o field. (Sobrescrevem os anteriores se necessário.)
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_video(string $name, string $id, int $numero_videos = 1, int $columns = 12, string $desc = '', array $more_args = []): self
  {
    $args = [
      'max_file_uploads' => $numero_videos,
      'max_status' => $numero_videos === 1 ? false : true,
      'desc' => $desc,
    ];

    $args = array_merge($args, $more_args);

    return $this->add_metabox_field($name, $id, 'video', $columns, $args);
  }

  /**
   * Entrega um field de Metabox para arquivos no geral.
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $numero_arquivos Número de arquivos que poderão subir. Padrão será só um.
   * @param int $columns Número do colunas do layout.
   * @param string $desc Descrição do field, por exemplo 'Arquivos sugeridos: pdf, docx'.
   * @param array<string,mixed> $more_args Mais argumentos para o field. (Sobrescrevem os anteriores se necessário.)
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_file(string $name, string $id, int $numero_arquivos = 1, int $columns = 12, string $desc = '', array $more_args = []): self
  {
    $args = [
      'max_file_uploads' => $numero_arquivos,
      'max_status' => $numero_arquivos === 1 ? false : true,
      'desc' => $desc,
    ];

    $args = array_merge($args, $more_args);

    return $this->add_metabox_field($name, $id, 'file_advanced', $columns, $args);
  }

  /**
   * Entrega um field de Metabox de oembed.
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args Mais argumentos para o field. (Sobrescrevem os anteriores se necessário.)
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_oembed(string $name, string $id, int $columns = 12, array $more_args = []): self
  {
    return $this->add_metabox_field($name, $id, 'oembed', $columns, $more_args);
  }

  /**
   * Entrega um field de Metabox básico de switch
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $columns Número do colunas do layout.
   * @param string $on_label Nome do label para o estado ligado.
   * @param string $off_label Nome do label para o estado desligado.
   * @param array<string,mixed> $more_args Mais argumentos para o field. (Sobrescrevem os anteriores se necessário.)
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_switch(string $name, string $id, int $columns = 12, string $on_label = 'Sim', string $off_label = 'Não', array $more_args = []): self
  {
    $args = [
      'on_label' => $on_label,
      'off_label' => $off_label
    ];

    $args = array_merge($args, $more_args);

    return $this->add_metabox_field($name, $id, 'switch', $columns, $args);
  }

  /**
   * Entrega um field de select. Deve ser a opção se você não quer select múltiplo.
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param array<string,mixed> $options Opções do select.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args Argumentos opcionais, irão sobrescrever os padrões.
   *
   * @return self para encadeamento.
   */
  public function add_metabox_field_select(string $name, string $id, array $options, int $columns = 12, array $more_args = []): self
  {
    $args = [
      'options' => $options,
    ];

    $args = array_merge($args, $more_args);

    return $this->add_metabox_field($name, $id, 'select', $columns, $args);
  }

  /**
   * Entrega um field de post.
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param string $post_type O post type a acessar.
   * @param int $quantidade A quantidade de termos de taxonomia que quer pegar.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args Argumentos opcionais, irão sobrescrever os padrões.
   *
   * @return self para encadeamento.
   */
  public function add_metabox_field_cpt(string $name, string $id, string $post_type, int $quantidade = 99, int $columns = 12, array $more_args = []): self
  {
    $args = [
      'post_type' => $post_type,
      'field_type' => 'select_advanced',
      'placeholder' => $quantidade > 1 ? 'Selecione os itens' : 'Selecione o item',
      'multiple' => true,
      'ajax' => false,
      'query_args' => [
        'post_status' => 'publish',
        'posts_per_page' => -1,
      ],
      'js_options' => [
        'maximumSelectionLength' => $quantidade
      ],
    ];

    $args = array_merge($args, $more_args);

    if (empty($args['multiple'])) {
      unset($args['js_options']['maximumSelectionLength']);
    }

    return $this->add_metabox_field($name, $id, 'post', $columns, $args);
  }

  /**
   * Entrega um field de taxonomia, ou taxonomy_advanced.
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param string $taxonomy A taxonomia a acessar.
   * @param int $quantidade A quantidade de posts que quer pegar.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args Argumentos opcionais, irão sobrescrever os padrões.
   *
   * @return self para encadeamento.
   */
  public function add_metabox_field_tax(string $name, string $id, string $taxonomy, int $quantidade = 99, int $columns = 12, array $more_args = []): self
  {
    $args = [
      'taxonomy' => $taxonomy,
      'field_type' => 'select_advanced',
      'placeholder' => $quantidade > 1 ? 'Selecione os itens' : 'Selecione o item',
      'multiple' => true,
      'ajax' => false,
      'query_args' => [
        'hide_empty' => false
      ],
      'js_options' => [
        'maximumSelectionLength' => $quantidade
      ],
    ];

    $args = array_merge($args, $more_args);

    if (empty($args['multiple'])) {
      unset($args['js_options']['maximumSelectionLength']);
    }

    return $this->add_metabox_field($name, $id, 'taxonomy_advanced', $columns, $args);
  }

  /**
   * Entrega um field de select advanced, o que usa select2. Deve ser a opção se você quer select múltiplo.
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param array<string,mixed> $options Opções do select.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args Argumentos opcionais, irão sobrescrever os padrões.
   */
  public function add_metabox_field_select_advanced(string $name, string $id, array $options, int $columns = 12, array $more_args = [])
  {
    $args = [
      'options' => $options,
      'multiple' => true,
    ];

    $args = array_merge($args, $more_args);

    return $this->add_metabox_field($name, $id, 'select_advanced', $columns, $args);
  }

  /**
   * Entrega um field de Metabox básico de texto
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $columns Número do colunas do layout.
   * @param float $type Tipo do calendário, 'date', 'datetime' ou 'time.
   * @param array<string,mixed> $more_args Mais argumentos para o field. (Sobrescrevem os anteriores se necessário.)
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_datetime(string $name, string $id, int $columns = 12, string $type = 'datetime', array $more_args = []): self
  {
    $calendar = match ($type) {
      'date' => 'date',
      'datetime' => 'datetime',
      'time' => 'time',
      default => 'datetime',
    };

    $save_format = match ($type) {
      'date' => 'Y-m-d',
      'datetime' => 'Y-m-d H:i:s',
      'time' => 'H:i:s',
      default => 'Y-m-d H:i:s',
    };

    $args = [
      'js_options' => [
        'stepMinute' => 5,
        'showTimepicker' => true,
        'controlType' => 'select',
        'showButtonPanel' => false,
        'oneLine' => true,
        'dateFormat' => 'dd/mm/yy',
        'timeFormat' => 'hh:mm',
      ],
      'inline' => false,
      'timestamp' => false,
      'save_format' => $save_format,
    ];

    $args = array_merge($args, $more_args);

    return $this->add_metabox_field($name, $id, $calendar, $columns, $args);
  }

  /**
   * Entrega um field de Metabox básico de cor.
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args Mais argumentos para o field. (Sobrescrevem os anteriores se necessário.)
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_color(string $name, string $id, int $columns = 12, array $more_args = []): self
  {
    return $this->add_metabox_field($name, $id, 'color', $columns, $more_args);
  }

  /**
   * Entrega um field do tipo hidden
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param mixed $value Valor do campo.
   * @param array<string,mixed> $more_args Mais argumentos para o field. (Sobrescrevem os anteriores se necessário.)
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field_hidden(string $id, mixed $value, array $more_args = []): self
  {

    $args = [
      'id' => $id,
      'std' => $value
    ];

    $args = array_merge($args, $more_args);

    return $this->add_metabox_field('', $id, 'hidden', 12, $args);
  }

  /**
   * Adiciona um heading para dividir aquele Metabox.
   * @param string $name Name do heading.
   * @param ?string $desc Opcional, caso queira uma desc.
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_heading(string $name, ?string $desc = null): self
  {
    $path = &$this->get_fields_path();

    $path[] = [
      'name' => $name,
      'desc' => $desc,
      'type' => 'heading',
      'columns' => 12
    ];

    return $this;
  }

  /**
   * Adiciona um metabox de conteúdo HTML apenas para impressão.
   * @param string $content Conteúdo HTML desejado.
   * @param int $columns Número do colunas do layout.
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_content(string $content, int $columns = 12): self
  {
    $path = &$this->get_fields_path();

    $path[] = [
      'std' => $content,
      'type' => 'custom_html',
      'columns' => $columns
    ];

    return $this;
  }
}
