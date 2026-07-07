<?php

/**
 * Remove tags HTML específicas de uma string
 * @param string $string String a ser usada.
 * @param array<int|string,string> $tags_to_remove String a ser usada.
 * @return string HTML sem as tags.
 */
function remove_specific_tags($string, $tags_to_remove)
{
  return preg_replace('/<\/?(' . implode('|', $tags_to_remove) . ')(\s+[^>]*|)>/', '', $string);
}

/**
 * Retorna uma URL de embed do Google Maps baseada num endereço.
 * @param string $endereco Endereço a ser buscado.
 * @return string URL formatada para iframe.
 */
function get_maps_embed_url(string $endereco): string
{
  $endereco_limpo = strip_tags($endereco);
  $endereco_limpo = preg_replace('/\s+/', ' ', $endereco_limpo);
  return "https://www.google.com/maps?q=" . urlencode(trim($endereco_limpo)) . "&output=embed";
}

/**
 * Retorna uma URL de busca do Google Maps baseada num endereço.
 * @param string $endereco Endereço a ser buscado.
 * @return string URL de busca do Google Maps.
 */
function get_maps_search_url(string $endereco): string
{
  $endereco_limpo = strip_tags($endereco);
  $endereco_limpo = preg_replace('/\s+/', ' ', $endereco_limpo);
  return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode(trim($endereco_limpo));
}
