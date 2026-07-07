<?php

/**
 * Cria páginas de configurações no tema.
 * As páginas aparecerão como subpáginas do menu 'Configurações' padrão do WordPress.
 * @see Alp_Settings para usos das configurações
 */
class Alp_Settings_Pages extends Alp_Settings
{
  /**
   * Adiciona subpáginas ao menu de 'Configurações' padrão do WordPress.
   * Organize nessa função as páginas que precisarão ser criadas.
   */
  public static function adicionar_paginas(): void
  {
    add_menu_page(
      'Opções',
      'Opções do Tema',
      'edit_posts',
      'alp-settings',
      fn() => '',
      'dashicons-admin-generic',
      60
    );

    add_submenu_page(
      'alp-settings',
      'Contatos e Redes Sociais',
      'Contatos e Redes Sociais',
      'edit_posts',
      'redes-sociais',
      fn() => self::pagina_wrapper("Redes Sociais", "redes-sociais", "redes_sociais_options"),
      6
    );
    add_submenu_page(
      'alp-settings',
      'Formulários',
      'Formulários',
      'edit_posts',
      'config-forms',
      fn() => self::pagina_wrapper("Formulários", "config-forms", "forms_options"),
      7
    );
  }

  /**
   * A página principal é vazia, então redireciona para a primeira subpágina.
   */
  public static function redirecionar_para_primeira_subpagina()
  {
    global $pagenow;
    if ($pagenow == 'admin.php' && isset($_GET['page']) && $_GET['page'] == 'alp-settings') {
      wp_redirect(admin_url('admin.php?page=redes-sociais'));
      exit;
    }
  }

  /**
   * Ocultar o item principal da página principal, que é vazia.
   */
  public static function esconder_menu_principal()
  {
    echo '<style>#toplevel_page_alp-settings .wp-first-item { display: none; }</style>';
  }

  /**
   * Nível de permissão para acessar as Settings
   */
  public static function nivel_permissao($capability)
  {
    return 'edit_posts';
  }

  /**
   * Registra os campos de cada uma das páginas.
   * @return void
   */
  public static function registrar_campos(): void
  {
    self::registrar_campos_redes_sociais();
    self::registrar_campos_formularios();
  }

  /**
   * Wrapper de uma página em Settings.
   */
  private static function pagina_wrapper($pagina_titulo, $pagina_slug, $option_group): void
  {
?>
    <div class="wrap">
      <h1>Configurações de <?= $pagina_titulo; ?></h1>
      <form method="post" action="options.php">
        <?php
        settings_fields($option_group);
        do_settings_sections($pagina_slug);
        submit_button();
        ?>
      </form>
    </div>
    <?php
  }

  /**
   * Seções e campos de textos para a subpágina de Redes Sociais e Contatos.
   * Altere as seções e/ou campos caso seja preciso mexer nessa página.
   */
  private static function registrar_campos_redes_sociais(): void
  {
    add_settings_section(
      'contatos_section',
      'Contatos',
      '__return_false',
      'redes-sociais'
    );
    add_settings_section(
      'redes_sociais_section',
      'Redes Sociais',
      '__return_false',
      'redes-sociais'
    );

    self::exibir_campo_texto('Telefone 1', 'redes-sociais', 'contatos_section', 'redes_sociais_options', self::$prefixo . 'telefone1', false, 'tel');
    self::exibir_campo_texto('Telefone 1 é WhatsApp?', 'redes-sociais', 'contatos_section', 'redes_sociais_options', self::$prefixo . 'telefone1_whats', false, 'checkbox');
    self::exibir_campo_texto('Telefone 2', 'redes-sociais', 'contatos_section', 'redes_sociais_options', self::$prefixo . 'telefone2', false, 'tel');
    self::exibir_campo_texto('Telefone 2 é WhatsApp?', 'redes-sociais', 'contatos_section', 'redes_sociais_options', self::$prefixo . 'telefone2_whats', false, 'checkbox');
    self::exibir_campo_texto('E-mail', 'redes-sociais', 'contatos_section', 'redes_sociais_options', self::$prefixo . 'email', false, 'email');

    self::exibir_campo_texto('Endereço', 'redes-sociais', 'contatos_section', 'redes_sociais_options', self::$prefixo . 'endereco', true);
    self::exibir_campo_texto('Código de Compartilhamento do Google Maps', 'redes-sociais', 'contatos_section', 'redes_sociais_options', self::$prefixo . 'endereco_maps', true);

    self::exibir_campo_texto('CNPJ', 'redes-sociais', 'contatos_section', 'redes_sociais_options', self::$prefixo . 'cnpj', false);

    self::exibir_campo_texto('Facebook', 'redes-sociais', 'redes_sociais_section', 'redes_sociais_options', self::$prefixo . 'facebook');
    self::exibir_campo_texto('Instagram', 'redes-sociais', 'redes_sociais_section', 'redes_sociais_options', self::$prefixo . 'instagram');
    self::exibir_campo_texto('LinkedIn', 'redes-sociais', 'redes_sociais_section', 'redes_sociais_options', self::$prefixo . 'linkedin');
    self::exibir_campo_texto('YouTube', 'redes-sociais', 'redes_sociais_section', 'redes_sociais_options', self::$prefixo . 'youtube');
  }

  /**
   * Seções e campos de textos para a subpágina de Formulários
   * Altere as seções e/ou campos caso seja preciso mexer nessa página.
   */
  private static function registrar_campos_formularios(): void
  {
    add_settings_section(
      'forms_section',
      'Formulários (shortcodes)',
      '__return_false',
      'config-forms'
    );

    // self::exibir_campo_texto('Newsletter', 'config-forms', 'forms_section', 'forms_options', self::$prefixo . 'cf7_newsletter');
    // self::exibir_campo_texto('Página Fale Conosco', 'config-forms', 'forms_section', 'forms_options', self::$prefixo . 'cf7_fale_conosco');
    self::exibir_campo_texto('Contato (fallback)', 'config-forms', 'forms_section', 'forms_options',  self::$prefixo . 'cf7_contato');
    self::exibir_campo_texto('Contato (PT)', 'config-forms', 'forms_section', 'forms_options',  self::$prefixo . 'cf7_contato_pt');
    self::exibir_campo_texto('Contato (EN)', 'config-forms', 'forms_section', 'forms_options',  self::$prefixo . 'cf7_contato_en');
    self::exibir_campo_texto('Contato (ES)', 'config-forms', 'forms_section', 'forms_options',  self::$prefixo . 'cf7_contato_es');
    self::exibir_campo_texto('Banco de Talentos (fallback)', 'config-forms', 'forms_section', 'forms_options', self::$prefixo . 'cf7_banco_talentos');
    self::exibir_campo_texto('Banco de Talentos (PT)', 'config-forms', 'forms_section', 'forms_options', self::$prefixo . 'cf7_banco_talentos_pt');
    self::exibir_campo_texto('Banco de Talentos (EN)', 'config-forms', 'forms_section', 'forms_options', self::$prefixo . 'cf7_banco_talentos_en');
    self::exibir_campo_texto('Banco de Talentos (ES)', 'config-forms', 'forms_section', 'forms_options', self::$prefixo . 'cf7_banco_talentos_es');

    self::exibir_campo_texto('Vagas (fallback)', 'config-forms', 'forms_section', 'forms_options', self::$prefixo . 'cf7_vagas');
    self::exibir_campo_texto('Vagas (PT)', 'config-forms', 'forms_section', 'forms_options', self::$prefixo . 'cf7_vagas_pt');
    self::exibir_campo_texto('Vagas (EN)', 'config-forms', 'forms_section', 'forms_options', self::$prefixo . 'cf7_vagas_en');
    self::exibir_campo_texto('Vagas (ES)', 'config-forms', 'forms_section', 'forms_options', self::$prefixo . 'cf7_vagas_es');
  }

  /**
   * Insere um campo de texto.
   * @param string $nome Nome do campo, como será exibido na Label
   * @param string $page Página em que o campo será inserido.
   * @param string $secao Seção em que o campo será inserido. (Sem o sufixo _section).
   * @param string $slug Valor do atributo name do input.
   * @param bool $textarea Se vai ser um textarea ao invés de input.
   * @param string $input_type Type do input, por padrão é 'text'.
   */
  private static function exibir_campo_texto(string $nome, string $page, string $secao, string $options, ?string $slug = NULL, bool $textarea = false, string $input_type = 'text'): void
  {
    if ($slug)
      $slug = sanitize_title($slug);
    else
      $slug = sanitize_title($nome);

    add_settings_field(
      $slug,
      $nome,
      function () use ($slug, $textarea, $input_type) {
        $val = esc_attr(get_option($slug));
        if ($textarea) {
    ?>
        <textarea class="regular-text" name="<?= $slug; ?>" id="<?= $slug; ?>" rows="3"><?= $val; ?></textarea>
      <?php
        } else {
          $checked = ($input_type === 'checkbox' || $input_type === 'radio') && $val === 'yes' ? 'checked' : '';
          if ($input_type === 'checkbox' || $input_type === 'radio')
            $val = 'yes';
      ?>
        <input class="regular-text" type="<?= $input_type; ?>" id="<?= $slug; ?>" name="<?= $slug; ?>" value="<?= $val; ?>"
          <?= $checked; ?>>
<?php
        }
      },
      $page,
      $secao,
    );

    register_setting($options, $slug);
  }
}

/**
 * Actions
 */
add_action('admin_menu', ['Alp_Settings_Pages', 'adicionar_paginas']);
add_action('admin_init', ['Alp_Settings_Pages', 'registrar_campos']);
add_action('admin_head', ['Alp_Settings_Pages', 'esconder_menu_principal']);
add_action('admin_init', ['Alp_Settings_Pages', 'redirecionar_para_primeira_subpagina']);

/**
 * Filters
 */
add_filter('option_page_capability_redes_sociais_options', ['Alp_Settings_Pages', 'nivel_permissao']);
add_filter('option_page_capability_forms_options', ['Alp_Settings_Pages', 'nivel_permissao']);
