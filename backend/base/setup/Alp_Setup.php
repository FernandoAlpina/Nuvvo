<?php

/**
 * Classe responsável pelas configurações de fábrica da Alpina.
 * @author Alpina
 * @since Alpina V4
 * @version 4.0
 */
class Alp_Setup
{

  /**
   * Adiciona os suportes para o tema.
   *
   * Esta função é responsável por adicionar diversos suportes ao tema, como links automáticos de feed, 
   * tag de título, miniaturas de post, suporte a HTML5 e logo customizado.
   *
   * @hooked action 'after_setup_theme'
   * @return void
   */
  public static function add_theme_supports(): void
  {
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    add_theme_support('html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption'
    ));

    add_theme_support('custom-logo', [
      'width' => 150,
      'height' => 40,
      'flex-height' => true,
      'flex-width' => true,
      'unlink-homepage-logo' => true
    ]);
  }

  /**
   * Esconde o botão de selecionar widgets - Dashboard
   * @hooked action 'admin_head'
   * @return void
   */
  public static function hide_widget_button(): void
  {
    if (wp_get_current_user()->user_login === 'alpina')
      return;
?>
    <style type="text/css">
      #screen-meta-links,
      #dashboard_php_nag,
      #dashboard_site_health,
      #dashboard_right_now,
      #dashboard_quick_press,
      #dashboard_primary,
      #wp_mail_smtp_reports_widget_lite {
        display: none !important;
      }
    </style>;
    <?php
  }

  /**
   * Cria um widget de Bem-Vindo à Alpina na Dashboard.
   * @hooked action 'wp_dashboard_setup'
   * @return void
   */
  public static function dashboard_bem_vindo_alpina(): void
  {
    global $wp_meta_boxes;
    wp_add_dashboard_widget('custom_help_widget', 'Bem-vindo | Alpina Digital Branding', function () {
    ?>
      <div class="container" style="background-color: #000;width: 100%;height: 400px; text-align:center;">
        <a href="https://alpina.digital/" target="_blank" rel="noopener">
          <img src="https://alpina.digital/wp-content/themes/alpina_theme/assets/imgs/logo-alpina.svg" class="logotipo"
            style="margin: 65px 0 0 0"><br>
          <h2 style="font-size: 20px;font-weight: 900;color: white">Alpina</h2>
        </a><br><br>
        <h4 style="font-size: 16px;font-weight: 400;color: white">Em caso de dúvida ou solicitações de mudanças no site,<br>
          acesse nossa central de chamados.</h4><br><br>
        <h4 style="font-size: 16px;font-weight: 400;color: white">Login</h4><a href="https://alpinaweb.tomticket.com/"
          target="_blank" rel="noopener"><button>Entrar</button></a><br>
        <h4><a href="https://alpinaweb.tomticket.com/helpdesk/novasenha" target="_blank" rel="noopener">Esqueceu sua
            senha?</a></h4><br>
      </div>
    <?php
    });
  }

  /**
   * Coloca a logo da Alpina para aparecer na tela de login.
   * @return void
   */
  public static function alpina_login_logo(): void
  {
    ?>
    <style type="text/css">
      .login h1 a {
        background-image: url(http://alpinaweb.com.br/imagens/logotipo-alpinaweb.png) !important;
        background-size: 110px 80px;
        width: 110px;
        height: 80px;
        margin: 0 auto;
      }
    </style>
  <?php
  }

  /**
   * Esconde os itens de ajuda no painel de administração.
   * @return void
   */
  public static function hide_help(): void
  {
  ?>
    <style type="text/css">
      #contextual-help-link-wrap,
      .updated.fade,
      .update-nag {
        display: none !important;
      }
    </style>
  <?php
  }

  /**
   * Remove o painel de boas-vindas do WordPress.
   * @return void
   */
  public static function remove_welcome_panel()
  {
    remove_action('welcome_panel', 'wp_welcome_panel');
    $user_id = get_current_user_id();
    if (0 !== get_user_meta($user_id, 'show_welcome_panel', true)) {
      update_user_meta($user_id, 'show_welcome_panel', 0);
    }
  }

  /**
   * Insere a classe 'js' no HTML para suporte ao Codyframe.
   * @return void
   */
  public static function codyframe_js_support(): void
  {
  ?>
    <script>
      document.getElementsByTagName("html")[0].className += " js";
    </script>
<?php
  }

  /**
   * Desabilita o wp-embed.
   * @hooked action 'wp_footer'
   * @return void
   */
  public static function my_deregister_scripts(): void
  {
    wp_deregister_script('wp-embed');
  }

  /**
   * Adiciona as informações do Suporte Alpina na barra de administração.
   * @hooked action 'wp_before_admin_bar_render'
   * @return void
   */
  public static function wp_admin_bar_new_item(): void
  {
    global $wp_admin_bar;
    $wp_admin_bar->add_menu(array(
      'id' => 'wp-admin-bar-new-item',
      'title' => 'Suporte Alpina',
      'href' => 'https://alpinaweb.tomticket.com/'
    ));
  }

  /**
   * Remove os admin notices para usuários que não são administradores.
   * @hooked action 'admin_print_scripts'
   * @return void
   */
  public static function pr_disable_admin_notices(): void
  {
    global $wp_filter;
    if (!current_user_can('administrator')) {
      unset($wp_filter['admin_notices']);
    }
  }

  /**
   * Adiciona o tipo SVG à lista de tipos de arquivos permitidos para upload.
   * @param array $file_types Lista de tipos de arquivos permitidos para upload.
   * @hooked action 'upload_mimes'
   * @return array Lista de tipos de arquivos permitidos para upload.
   */
  public static function add_file_types_to_uploads(array $file_types): array
  {
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes);

    return $file_types;
  }

  /**
   * Adiciona a capacidade de editar temas para o perfil de editor.
   * @hooked action 'admin_init'
   * @return void
   */
  public static function add_custom_menu_capability(): void
  {
    $role = get_role('editor');
    if (!$role->has_cap('edit_theme_options')) {
      $role->add_cap('edit_theme_options');
    }
  }

  /**
   * Remove os submenus para editores na página de Aparência.
   * @hooked action 'admin_menu'
   * @return void
   */
  public static function remove_appearance_submenus_for_editors(): void
  {
    if (!current_user_can('administrator')) {
      remove_submenu_page('themes.php', 'customize.php?return=' . urlencode($_SERVER['REQUEST_URI'])); // Remove Personalizar
      remove_submenu_page('themes.php', 'widgets.php');   // Remove Widgets
      remove_submenu_page('themes.php', 'themes.php');    // Remove Temas
    }
  }

  /**
   * Se o usuário não for administrador, redireciona para a tela inicial ao tentar acessar páginas de aparência.
   * @hooked action 'admin_init'
   * @return void
   */
  public static function redirect_editors_from_appearance_pages(): void
  {
    global $pagenow;
    if (!current_user_can('administrator')) {
      if ($pagenow == 'customize.php?return=' . urlencode($_SERVER['REQUEST_URI']) || $pagenow == 'widgets.php' || $pagenow == 'themes.php') {
        wp_redirect(admin_url());
        exit;
      }
    }
  }

  /**
   * Remove o botão de personalizar do menu do admin bar para editores.
   * @hooked action 'wp_before_admin_bar_render'
   * @return void
   */
  public static function remove_customize_admin_bar_for_editors(): void
  {
    if (!current_user_can('administrator')) {
      global $wp_admin_bar;
      $wp_admin_bar->remove_node('customize');
    }
  }

  /**
   * Remove o menu de comentários do painel de administração.
   * @hooked action 'admin_menu'
   * @return void
   */
  public static function remove_comments_menu(): void
  {
    remove_menu_page('edit-comments.php');
  }

  /**
   * Remove o menu de comentários da barra de administração.
   * @hooked action 'wp_before_admin_bar_render'
   * @return void
   */
  public static function remove_comments_admin_bar(): void
  {
    if (is_admin_bar_showing()) {
      remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
  }

  /**
   * Remove o title dos itens de menu.
   * @param string $menu Item de menu.
   * @hooked filter 'wp_nav_menu'
   * @hooked filter 'wp_page_menu'
   * @hooked filter 'wp_list_categories'
   * @return string Item de menu sem title.
   */
  public static function my_menu_notitle(string $menu): string
  {
    return $menu = preg_replace('/ title=\"(.*?)\"/', '', $menu);
  }

  /**
   * Remove a versão do WordPress do rodapé.
   * @hooked filter 'update_footer'
   * @return string Vazia.
   */
  public static function change_footer_version(): string
  {
    return ' ';
  }

  /**
   * Altera o link da página de login.
   * @hooked filter 'login_headerurl'
   * @return string URL do site da Alpina.
   */
  public static function loginpage_custom_link(): string
  {
    return 'alpina.digital';
  }

  /**
   * Remove o texto do rodapé no painel de administração.
   * @hooked filter 'admin_footer_text'
   * @return void Imprime Texto da Alpina.
   */
  public static function open_source(): void
  {
    echo 'Alpina Digital Branding';
  }

  /**
   * Corrige o HTML quebrado.
   * @param string $content Conteúdo a ser corrigido.
   * @hooked filter 'the_content'
   * @return string Conteúdo corrigido.
   */
  public static function fix_broken_html($content)
  {
    return balanceTags($content, true);
  }

  /**
   * Remove os arrays das taxonomias em query strings, implodindo em uma string com vírgulas.
   * @param $query A query string atual.
   * @hooked filter 'request'
   */
  public static function query_string_com_virgulas($query)
  {
    foreach (get_taxonomies(array(), 'objects') as $tax) {

      if ($tax->query_var && !empty($query[$tax->query_var])) {
        if (is_array($query[$tax->query_var])) {
          $query[$tax->query_var] = implode(',', $query[$tax->query_var]);
        }
      }
    }
    return $query;
  }

  /**
   * Remove algumas actions.
   * @hooked action 'after_setup_theme'
   * @return void
   */
  public static function remove_actions(): void
  {
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('wpcf7_swv_create_schema', 'wpcf7_swv_add_select_enum_rules', 20, 2);
    add_filter('show_admin_bar', '__return_false');
  }


  /**
   * Carrega estilos personalizados para o painel administrativo.
   * @hooked action 'admin_enqueue_scripts'
   * @return void
   */
  public static function enqueue_admin_styles(): void
  {
    wp_enqueue_style(
      'admin-custom-styles',
      get_template_directory_uri() . '/assets/css/admin.css',
      array(),
      '1.0.0'
    );
  }

  /**
   * Traduz o texto do botão de salvamento das Settings Pages do Meta Box.
   *
   * @param array<int, array<string, mixed>> $settings_pages
   * @return array<int, array<string, mixed>>
   */
  public static function traduzir_botao_settings_pages(array $settings_pages): array
  {
    foreach ($settings_pages as $index => $page) {
      if (!is_array($page)) {
        continue;
      }

      if (!empty($page['submit_button'])) {
        continue;
      }

      $settings_pages[$index]['submit_button'] = 'Salvar configurações';
    }

    return $settings_pages;
  }
}

/**
 * Actions
 */
add_action('after_setup_theme', ['Alp_Setup', 'add_theme_supports']);
add_action('admin_head', ['Alp_Setup', 'hide_widget_button']);
add_action('wp_dashboard_setup', ['Alp_Setup', 'dashboard_bem_vindo_alpina']);
add_action('login_head', ['Alp_Setup', 'alpina_login_logo']);
add_action('admin_head', ['Alp_Setup', 'hide_help']);
add_action('load-index.php', ['Alp_Setup', 'remove_welcome_panel']);
add_action('wp_print_scripts', ['Alp_Setup', 'codyframe_js_support']);
add_action('wp_footer', ['Alp_Setup', 'my_deregister_scripts']);
add_action('wp_before_admin_bar_render', ['Alp_Setup', 'wp_admin_bar_new_item']);
add_action('admin_print_scripts', ['Alp_Setup', 'pr_disable_admin_notices']);
add_action('upload_mimes', ['Alp_Setup', 'add_file_types_to_uploads']);
add_action('admin_init', ['Alp_Setup', 'add_custom_menu_capability']);
add_action('admin_menu', ['Alp_Setup', 'remove_appearance_submenus_for_editors'], 999);
add_action('admin_init', ['Alp_Setup', 'redirect_editors_from_appearance_pages']);
add_action('wp_before_admin_bar_render', ['Alp_Setup', 'remove_customize_admin_bar_for_editors']);
add_action('admin_menu', ['Alp_Setup', 'remove_comments_menu']);
add_action('init', ['Alp_Setup', 'remove_comments_admin_bar']);
add_action('after_setup_theme', ['Alp_Setup', 'remove_actions']);
add_action('admin_enqueue_scripts', ['Alp_Setup', 'enqueue_admin_styles']);

/**
 * Filters
 */
add_filter('wp_nav_menu', ['Alp_Setup', 'my_menu_notitle']);
add_filter('wp_page_menu', ['Alp_Setup', 'my_menu_notitle']);
add_filter('wp_list_categories', ['Alp_Setup', 'my_menu_notitle']);
add_filter('update_footer', ['Alp_Setup', 'change_footer_version'], 9999);
add_filter('login_headerurl', ['Alp_Setup', 'loginpage_custom_link']);
add_filter('admin_footer_text', ['Alp_Setup', 'open_source']);
add_filter('the_content', ['Alp_Setup', 'fix_broken_html']);
add_filter('request', ['Alp_Setup', 'query_string_com_virgulas'], 1);
add_filter('mb_settings_pages', ['Alp_Setup', 'traduzir_botao_settings_pages'], 999);
