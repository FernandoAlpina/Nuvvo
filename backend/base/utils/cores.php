<?php

/**
 * Classifica uma cor como escura, média ou clara.
 * @param string $hex Código hexadecimal da cor
 * @return string Vai retornar "escura", "média" ou "clara".
 */
function classifica_tom_cor($hex)
{
  $hex = ltrim($hex, '#');

  if (strlen($hex) === 3) {
    $hex = explode('', $hex);
    $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
  }

  list($r, $g, $b) = sscanf($hex, "%02x%02x%02x");

  $luminosity = (0.299 * $r) + (0.587 * $g) + (0.114 * $b);

  if ($luminosity < 128) return "escura";
  if ($luminosity >= 128 && $luminosity < 192) return "média";
  return "clara";
}

/**
 * Calcula a cor média de uma imagem a partir de uma URL.
 *
 * Esta função faz o download do conteúdo da imagem a partir da URL fornecida,
 * cria uma imagem a partir desse conteúdo e calcula a cor média da imagem.
 * A cor média é retornada no formato hexadecimal (por exemplo, "#aabbcc").
 *
 * @param string $url A URL da imagem a ser processada.
 * @return string|false A cor média da imagem no formato hexadecimal, ou false se ocorrer um erro.
 */
function cor_media_imagem($url): string|false
{
  $conteudo = file_get_contents($url);
  if (!$conteudo) return false;

  $image = imagecreatefromstring($conteudo);
  if (!$image) return false;

  $largura = imagesx($image);
  $altura = imagesy($image);
  $pixels = $largura * $altura;

  $total_r = 0;
  $total_g = 0;
  $total_b = 0;

  for ($x = 0; $x < $largura; $x++) {
    for ($y = 0; $y < $altura; $y++) {
      $rgb = imagecolorat($image, $x, $y);
      $red = ($rgb >> 16) & 0xFF;
      $green = ($rgb >> 8) & 0xFF;
      $blue = $rgb & 0xFF;

      $total_r += $red;
      $total_g += $green;
      $total_b += $blue;
    }
  }

  $media_r = round($total_r / $pixels);
  $media_g = round($total_g / $pixels);
  $media_b = round($total_b / $pixels);

  $media = sprintf("#%02x%02x%02x", $media_r, $media_g, $media_b);

  imagedestroy($image);

  return $media;
}

/**
 * Ajusta a luminosidade de uma cor hexadecimal para um determinado valor.
 * 
 * @param string $hex Código hexadecimal da cor
 * @param int $luminosidade O valor de luminosidade desejado (0 a 255).
 * @param bool $maior_que Se true, só faz o ajuste se a luminosidade atual for acima do valor desejado.
 * @param bool $menor_que Se true, Só faz o ajuste se a luminosidade atual for abaixo desse valor.
 * @return string Código hexadecimal da cor ajustada
 */
function ajusta_luminosidade_cor(string $hex, int $luminosidade = 128, bool $maior_que = false, bool $menor_que = false): string
{
  $novo_hex = ltrim($hex, '#');

  list($r, $g, $b) = sscanf($novo_hex, "%02x%02x%02x");

  $luminosidade_atual = (0.299 * $r) + (0.587 * $g) + (0.114 * $b);

  if ($maior_que && $luminosidade_atual <= $luminosidade) return $hex;
  if ($menor_que && $luminosidade_atual >= $luminosidade) return $hex;

  $fator_ajuste = $luminosidade / $luminosidade_atual;

  $r *= $fator_ajuste;
  $g *= $fator_ajuste;
  $b *= $fator_ajuste;

  $r = max(0, min(255, $r));
  $g = max(0, min(255, $g));
  $b = max(0, min(255, $b));

  $hex_ajustado = sprintf("#%02x%02x%02x", $r, $g, $b);

  return $hex_ajustado;
}

/**
 * Recebe um código hex e retorna um array no formato rgb.
 * @param string $hex Código hexadecimal da cor
 * @return array<int> Array com os valores de R, G e B
 */
function hex2rgb_array($hex): array
{
  $hex = str_replace("#", "", $hex);

  if (strlen($hex) == 3) {
    $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
    $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
    $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
  } else {
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
  }

  return [$r, $g, $b];
}

/**
 * A função transforma a cor hexadecimal aplicando opacidade e/ou tonalidade.
 * @param string $hex Código hexadecimal da cor.
 * @param float $opacity Opacidade da cor (0 a 1).
 * @param int $adjust Ajuste de tonalidade (0 a 255).
 * @return string Código rgba da cor.
 */
function hex2rgba_adjust($hex, $opacity = 1, $adjust = 0): string
{
  list($r, $g, $b) = hex2rgb_array($hex);
  $r = min(255, max(0, $r + $adjust));
  $g = min(255, max(0, $g + $adjust));
  $b = min(255, max(0, $b + $adjust));

  return "rgba(" . $r . "," . $g . "," . $b . "," . $opacity . ")";
}
