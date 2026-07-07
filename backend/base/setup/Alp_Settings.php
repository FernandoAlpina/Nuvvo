<?php

/**
 * Classe de Configurações do Tema.
 * @see Alp_Settings_Pages Para a montagem das páginas de configurações. 
 */
class Alp_Settings
{
  protected static string $prefixo = 'alp_settings_';

  /**
   * Retorna a option do WordPress utilizando o prefixo estabelecido na classe.
   * @return string
   */
  public static function get_option(string $option): string
  {
    return get_option(self::$prefixo . $option);
  }

  /**
   * Retorna uma option com fallback por idioma (WPML).
   * Ex.: cf7_contato_es -> cf7_contato
   */
  public static function get_option_i18n(string $option): string
  {
    $language = '';

    if (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE) {
      $language = (string) ICL_LANGUAGE_CODE;
    } elseif (function_exists('apply_filters')) {
      $language = (string) apply_filters('wpml_current_language', null);
    }

    $language = strtolower(trim($language));

    if ($language) {
      $localized = get_option(self::$prefixo . $option . '_' . $language);
      if ($localized) {
        return $localized;
      }
    }

    return self::get_option($option);
  }

  /**
   * Retorna uma opção do Meta Box Settings Page.
   * @param string $settings_page Nome da settings page (ex: 'marcas')
   * @param string $field_id ID do campo
   * @return mixed Valor do campo ou vazio se não existir
   */
  public static function get_metabox_option(string $settings_page, string $field_id): mixed
  {
    $options = get_option($settings_page, []);
    return $options[$field_id] ?? '';
  }

  /**
   * Pega o conteúdo form da página de configurações.
   * @param string $nome Nome do formulário.
   * @param string $id ID do formulário no HTML.
   * @return string Conteúdo do formulário para imprimir ou manipular.
   */
  public static function get_form(string $nome, string $id = ''): ?string
  {

    $shortcode = self::get_option_i18n("cf7_" . $nome);
    if (!$shortcode) return null;

    $content = do_shortcode($shortcode);

    if ($id) $content = preg_replace("%<form%", "<form id=\"{$id}\"", $content);

    return $content;
  }

  /**
   * Retorna um objeto de numérico telefônico (WhatsApp ou tradicional).
   * @param int $sufixo O sufixo no cadastro (primeiro número, segundo, etc).
   * 
   * @return stdClass{url:string,texto:string}
   */
  public static function get_telefone(int $sufixo = 1): stdClass
  {
    $telefone_formatado = self::get_option("telefone{$sufixo}");
    $whatsapp = self::get_option("telefone{$sufixo}_whats");

    $codigo_pais = !preg_match("%^\+%", $telefone_formatado) ? 55 : false;

    $texto_entrada = self::get_option('mensagem_padrao');
    if (!$texto_entrada) $texto_entrada = "Oi, tudo bem?";

    $telefone = new stdClass();
    $telefone->url = $whatsapp ? get_whats_api_url($telefone_formatado, $codigo_pais, $texto_entrada) : get_tel_url($telefone_formatado, $codigo_pais);
    $telefone->texto = $telefone_formatado;

    return $telefone;
  }

  /**
   * Retorna um objeto de e-mail.
   * @param string $sufixo Sufixo opcional do e-mail no cadastro.
   * 
   * @return stdClass{url:string,texto:string}
   */
  public static function get_email(string $sufixo = ''): stdClass
  {
    $option = "email";
    if ($sufixo) $option = $option . '_' . $sufixo;

    $valor = self::get_option($option);

    $email = new stdClass();
    $email->url = "mailto:{$valor}";
    $email->texto = $valor;

    return $email;
  }

  /**
   * Retorna a URL do Maps através do código de incorporação cadastrado.
   * @param string $sufixo
   * @return string
   */
  public static function get_maps_url(string $sufixo = ''): string
  {
    if ($sufixo) $sufixo .= "_";

    if (!$maps = self::get_option("endereco_{$sufixo}maps")) return '';

    $maps = preg_replace("%<iframe.*?src=\"(.*?)\".*%", "$1", $maps);
    return $maps;
  }

  /**
   * Imprime um modal.
   */
  public static function print_modal($id_modal = 'modal-footer'): string
  {
    $args = compact('id_modal');
    ob_start();
    get_template_part("frontend/base/modal/modal-iframe", NULL, $args);
    return ob_get_clean();
  }

  /**
   * Remove tags HTML específicas de uma string
   * @param string $string String a ser usada.
   * @param array<int|string,string> $tags_to_remove String a ser usada.
   * @return string HTML sem as tags.
   */
  private static function remove_specific_tags(string $string, array $tags_to_remove)
  {
    return preg_replace('/<\/?(' . implode('|', $tags_to_remove) . ')(\s+[^>]*|)>/', '', $string);
  }
}

/**
 * Para impressão correta dos forms
 */
add_filter('wpcf7_autop_or_not', '__return_false');
