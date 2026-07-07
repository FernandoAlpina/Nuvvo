<?php
class Alp_API
{
  /**
   * Carrega dados de uma API.
   * @param string $api_url URL completa da API, com endpoint.
   * @return array Resposta da API
   */
  public static function obter_dados(string $api_url): array
  {
    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) return [];

    $body = wp_remote_retrieve_body($response);
    if (!$body) return [];

    $decode = json_decode($body, true);
    if (empty($decode)) return [];

    return $decode;
  }
}
