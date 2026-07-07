<?php

/**
 * Retorna o caminho para um arquivo dentro do diretório de imagens em /assets.
 * @return string Caminho absoluto para uma imagem.
 */
function get_media_src($image): string
{
  return get_stylesheet_directory_uri() . '/assets/imgs/' . $image;
}

/**
 * Retorna o caminho para um arquivo dentro do diretório de fotos em /assets.
 * @return string Caminho absoluto para uma imagem.
 */
function get_photo_src($image): string
{
  return get_stylesheet_directory_uri() . '/assets/imgs/photos/' . $image;
}

/**
 * Retorna o caminho para um arquivo dentro do diretório de ícones em /assets.
 * @return string Caminho absoluto para uma imagem.
 */
function get_icon_src($image): string
{
  return get_stylesheet_directory_uri() . '/assets/svg/icons/' . $image;
}

/**
 * Retorna um array associativo com todos ícones SVG em uma pasta específica de /assets/svg/.
 * @param string|null $caminho Caminho da pasta interna.
 * @return array|false Array associativo dos ícones ou false se pasta não encontrada.
 */
function get_all_icons($caminho = NULL): array|false
{
  $glob = __DIR__ . '/../../assets/svg/';
  if (!empty($caminho)) {
    $caminho = preg_replace("%$/*%uis", "", $caminho);
    $glob .= $caminho;
  }
  $glob .= "/*.svg";

  $icones = [];
  foreach (glob($glob) as $icone) {
    $icones[basename($icone)] = basename($icone);
  }
  return $icones;
}

/**
 * Imprime o conteúdo de um arquivo SVG
 * @param string $svg Caminho relativo do arquivo dentro da pasta /assets/svg/.
 * @param string|array $classes Classes CSS a serem adicionadas ao SVG. Use em conjunto com o $fill_currentColor=true para ajustar a cor do ícone.
 * @param boolean $fill_currentColor Se true, adota o valor "currentColor" para os parâmetros fill. Será aplicado em todos os fills encontrados, use com cautela.
 * @param array $sizes Array de largura e altura para o SVG. Utilize -1 na largura ou altura para que o SVG se mantenha proporcional à outra dimensão.
 * @param string $fill_or_stroke É possível trocar o 'fill' por 'stroke' para o uso com o terceiro argumento, se o seu vetor for com strokes ao invés de um fill.
 * @return string|false Marcação completa do SVG ou false se o arquivo não for encontrado.
 */
function get_svg_content($svg, $classes = "", $fill_currentColor = false, $sizes = [], $fill_or_stroke = 'fill'): string
{
  if (is_numeric($svg)) {
    $svg_url = wp_get_attachment_url($svg);
    if (!$svg_url)
      return '';

    $svg_path = str_replace(home_url(), ABSPATH, $svg_url);
    if (!file_exists($svg_path))
      return '';
  } else if (preg_match("%^https?://%", $svg)) {
    $svg_path = str_replace(home_url(), ABSPATH, $svg);
    if (!file_exists($svg_path))
      return '';
  } else {
    if (empty($svg))
      return '';
    $svg_path = get_template_directory() . '/assets/svg/' . $svg;
    if (is_dir($svg_path) || !file_exists($svg_path))
      return '';
  }

  $svg_file = file_get_contents($svg_path);
  if (!$svg_file)
    return '';

  //Adicionando classes
  if (is_array($classes))
    $classes = implode(" ", $classes);

  if ($classes && preg_match("%<svg.*?class=[\"'].*?[\"'].*?>%uis", $svg_file)) {
    $svg_file = preg_replace("%class=[\"'](.*?)[\"']%uis", "class=\"$1 {$classes}\"", $svg_file);
  } elseif ($classes && !preg_match("%<svg.*?class=[\"'].*?[\"'].*?>%uis", $svg_file)) {
    $svg_file = preg_replace("%<svg%uis", "<svg class=\"{$classes}\" ", $svg_file);
  }

  //Alterando fill
  if ($fill_currentColor && in_array($fill_or_stroke, ['fill', 'stroke'])) {
    $svg_file = preg_replace("%{$fill_or_stroke}=[\"'].*?[\"']%uis", "{$fill_or_stroke}=\"currentColor\"", $svg_file);
  }

  //Alterando sizes
  if (!is_array($sizes) || count($sizes) !== 2)
    return $svg_file;
  $sizes = array_map("intval", $sizes);
  list($width, $height) = $sizes;

  if (!$width || !$height || ($height < 0 && $width < 0))
    return $svg_file;

  if ($width < 0 xor $height < 0) {
    preg_match("%<svg.*?width=[\"'](.*?)[\"'].*?>%uis", $svg_file, $o_width);
    preg_match("%<svg.*?height=[\"'](.*?)[\"'].*?>%uis", $svg_file, $o_height);

    $o_height = isset($o_height[1]) ? intval($o_height[1]) : false;
    $o_width = isset($o_width[1]) ? intval($o_width[1]) : false;

    if (!$o_width) {
      preg_match("%<svg.*?viewBox=[\"'](.*?)[\"'].*?>%uis", $svg_file, $o_width);
      if (!isset($o_width[1]))
        return $svg_file;

      $o_width = explode(" ", $o_width[1]);
      $o_width = intval($o_width[2]);
    }
    if (!$o_height) {
      preg_match("%<svg.*?viewBox=[\"'](.*?)[\"'].*?>%uis", $svg_file, $o_height);
      if (!isset($o_height[1]))
        return $svg_file;

      $o_height = explode(" ", $o_height[1]);
      $o_height = intval($o_height[3]);
    }

    if (!$o_height || !$o_width)
      return $svg_file;

    if ($width < 0) {
      $width = round(($height * $o_width) / $o_height);
    }
    if ($height < 0) {
      $height = round(($width * $o_height) / $o_width);
    }
  }

  if (preg_match("%<svg.*?width=[\"'].*?[\"'].*?>%uis", $svg_file)) {
    $svg_file = preg_replace("%(<svg.*?)width=[\"'].*?[\"'](.*?>)%uis", "$1width=\"{$width}\"$2", $svg_file);
  } else {
    $svg_file = preg_replace("%<svg%uis", "<svg width=\"{$width}\" ", $svg_file);
  }

  if (preg_match("%<svg.*?height=[\"'].*?[\"'].*?>%uis", $svg_file)) {
    $svg_file = preg_replace("%(<svg.*?)height=[\"'].*?[\"'](.*?>)%uis", "$1height=\"{$height}\"$2", $svg_file);
  } else {
    $svg_file = preg_replace("%<svg%uis", "<svg height=\"{$height}\" ", $svg_file);
  }

  return $svg_file;
}

/**
 * Obtém o ícone SVG correspondente ao endpoint fornecido.
 *
 * @param string $endpoint O endpoint para o qual o ícone SVG deve ser obtido.
 * @param string|null $classe (Opcional) Classe CSS a ser aplicada ao SVG.
 * @return string O conteúdo SVG do ícone correspondente ao endpoint ou o ícone padrão se não encontrado.
 */
function get_icon_by_endpoint($endpoint, $classe = null): string
{
  $svg_path = 'dashboard/' . $endpoint . '.svg';

  $svg = get_svg_content($svg_path, $classe);

  if ($svg) {
    return $svg;
  } else {
    return get_svg_content('dashboard/dashboard.svg', $classe, true, [24, 24], 'fill');
  }
}

/**
 * Checa se uma URL contém um SVG ou não.
 * @param string $url A URL a ser checada.
 * @return bool true se for um arquivo SVG, false se não for.
 */
function is_svg(string $url): bool
{
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_NOBODY, true);
  $response = curl_exec($ch);
  $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
  curl_close($ch);

  if ($content_type && strpos($content_type, 'image/svg+xml') !== false) {
    return true;
  }
  return false;
}

/**
 * Utilizando uma Meta Box com type 'oembed', retorna a URL para ser usada em um iframe.
 * @param $page_id ID da página a ser consultada.
 * @param $page_id ID do Meta Box.
 * @return string Atributo src do iframe.
 */
function get_mb_ombed_iframe_src($page_id, $metabox_id)
{
  $link = rwmb_meta($metabox_id, [], $page_id);
  return get_ombed_iframe_src($link);
}

/**
 * Extrai a URL de origem de um iframe embutido.
 * @param string $iframe O código HTML do iframe.
 * @return string|false A URL de origem do iframe ou false se não for encontrada.
 */
function get_ombed_iframe_src($iframe): string|false
{
  preg_match("%<iframe.*?src=\"(.*?)\"%", $iframe, $embed);

  $embed = $embed[1] ?? false;

  if (!$embed)
    return false;
  return $embed;
}
