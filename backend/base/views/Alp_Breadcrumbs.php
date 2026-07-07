<?php
class Alp_Breadcrumbs
{
  private static array $path = [];

  /**
   * Inicia a configuração dos argumentos dos Breadcrumbs.
   */
  public static function init()
  {
    self::set_home_path();
  }

  /**
   * Seta um caminho.
   * @param string $conteudo String com nome do item ou algum conteúdo HTML.
   * @param string|false|null $url URL que será acessada quando clicar no item, se existir.
   * @param string|array $classes_css Classes CSS que devem ser aplicadas no item.
   */
  public static function set_path(string $conteudo, string|false|null $url = false, string|array $classes_css = ''): void
  {
    self::$path[] = self::gerar_path($conteudo, $url, $classes_css);
  }

  /**
   * Imprime a caixa com os breadcrumbs.
   */
  public static function print_breadcrumbs(string|array $classes_css_nav = '', string|array $classes_css_wrapper = ''): string
  {
    $path = self::set_delimiters();

    if (is_array($classes_css_nav))
      $classes_css_nav = implode(" ", $classes_css_nav);
    if (is_array($classes_css_wrapper))
      $classes_css_wrapper = implode(" ", $classes_css_wrapper);

    $args = compact('path', 'classes_css_nav', 'classes_css_wrapper');

    ob_start();
    get_template_part('frontend/base/breadcrumbs/block-breadcrumbs', NULL, $args);
    return ob_get_clean();
  }

  /**
   * Gera o HTML de um caminho.
   * @param string $conteudo String com nome do item ou algum conteúdo HTML.
   * @param string|false|null $url URL que será acessada quando clicar no item, se existir.
   * @param string|array $classes_css Classes CSS que devem ser aplicadas no item.
   * @return string HTML do caminho.
   */
  private static function gerar_path(string $conteudo, string|false|null $url = false, string|array $classes_css = ''): string
  {
    if (is_array($classes_css))
      $classes_css = implode(" ", $classes_css);

    $url = esc_url($url);

    $args = compact('url', 'classes_css', 'conteudo');

    ob_start();
    get_template_part('frontend/base/breadcrumbs/item-breadcrumbs', NULL, $args);
    return ob_get_clean();
  }

  /**
   * Seta o caminho da HOME.
   */
  private static function set_home_path(): void
  {
    $url = get_home_url();
    self::set_path(self::get_home_svg(), $url);
  }

  /**
   * Seta os delimiters e entrega o path como string.
   */
  private static function set_delimiters(): string
  {
    $delimiter = self::gerar_path(self::get_delimiter_svg());
    $path = self::$path;

    $path = implode($delimiter, $path);
    return $path;
  }

  /**
   * Retorna o ícone do delimiter.
   * @return string SVG do delimiter.
   */
  private static function get_delimiter_svg(): string
  {
    ob_start();
    ?>
    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
      <g clip-path="url(#clip0_23567_3824)">
        <path
          d="M9.37058 7.52624C9.09913 7.78237 9.09913 8.19611 9.37058 8.45224L12.0712 11.0004L9.37058 13.5485C9.09913 13.8047 9.09913 14.2184 9.37058 14.4745C9.64203 14.7307 10.0805 14.7307 10.352 14.4745L13.5467 11.4601C13.8182 11.204 13.8182 10.7902 13.5467 10.5341L10.352 7.51967C10.0875 7.27011 9.64203 7.27011 9.37058 7.52624Z"
          fill="#7D787A" />
      </g>
      <defs>
        <clipPath id="clip0_23567_3824">
          <rect width="22" height="22" fill="white" />
        </clipPath>
      </defs>
    </svg>

    <?php
    return ob_get_clean();
  }

  /**
   * Retorna o ícone da home.
   * @return string SVG da home.
   */
  private static function get_home_svg(): string
  {
    ob_start();
    ?>
    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
      <g clip-path="url(#clip0_23567_3821)">
        <path
          d="M9.40436 16.5911V12.4632H12.5927V16.5911C12.5927 17.0452 12.9514 17.4167 13.3898 17.4167H15.7811C16.2195 17.4167 16.5782 17.0452 16.5782 16.5911V10.8121H17.9333C18.2999 10.8121 18.4753 10.3415 18.1963 10.0938L11.5326 3.87721C11.2297 3.59651 10.7674 3.59651 10.4645 3.87721L3.80079 10.0938C3.52977 10.3415 3.69716 10.8121 4.06383 10.8121H5.41889V16.5911C5.41889 17.0452 5.77758 17.4167 6.21598 17.4167H8.60727C9.04567 17.4167 9.40436 17.0452 9.40436 16.5911Z"
          fill="#7D787A" />
      </g>
      <defs>
        <clipPath id="clip0_23567_3821">
          <rect width="22" height="22" fill="white" />
        </clipPath>
      </defs>
    </svg>
    <?php
    return ob_get_clean();
  }
}

add_action('init', ['Alp_Breadcrumbs', 'init']);
