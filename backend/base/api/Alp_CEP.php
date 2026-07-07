<?php

require_once __DIR__ . '/Alp_API.php';

/**
 * Classe responsável por consulta de CEP com fallback em múltiplas APIs.
 */
class Alp_CEP extends Alp_API
{
  /**
   * Consulta um CEP em múltiplos serviços (BrasilAPI, ViaCEP, etc).
   * 
   * @param string $cep CEP a ser consultado (pode ter formatação).
   * @return array|WP_Error Retorna array com dados do endereço ou WP_Error se falhar em todos.
   */
  public static function consultar_cep(string $cep)
  {
    // Remove não dígitos
    $cep_limpo = preg_replace('/\D/', '', $cep);

    if (strlen($cep_limpo) !== 8) {
      return new WP_Error('invalid_cep', 'CEP inválido.');
    }

    $errors = [];
    $not_found_count = 0;

    // Lista de callbacks dos serviços
    $services = ['try_brasilapi', 'try_viacep', 'try_opencep'];

    foreach ($services as $service) {
      $resultado = self::$service($cep_limpo);

      if (!is_wp_error($resultado)) {
        return $resultado;
      }

      // Analisa o tipo de erro
      $code = $resultado->get_error_code();
      if ($code === 'not_found') {
        $not_found_count++;
      }
      $errors[] = $resultado->get_error_message();
    }

    // Se pelo menos um serviço confirmou que NÃO EXISTE (404), assumimos que o CEP está errado.
    // Se todos deram erro de API (timeout, 500, etc), então o serviço está indisponível.
    if ($not_found_count > 0) {
      return new WP_Error('cep_not_found', 'CEP não encontrado.');
    }

    return new WP_Error('service_unavailable', 'Erro ao buscar CEP. Tente novamente.');
  }

  /**
   * Tenta consultar na BrasilAPI.
   */
  private static function try_brasilapi(string $cep)
  {
    $url = "https://brasilapi.com.br/api/cep/v2/{$cep}";
    $response = wp_remote_get($url, ['timeout' => 4]);

    if (is_wp_error($response))
      return $response; // Erro de conexão

    $code = wp_remote_retrieve_response_code($response);

    if ($code === 404) {
      return new WP_Error('not_found', 'BrasilAPI: 404 Not Found');
    }

    if ($code !== 200) {
      return new WP_Error('api_error', 'BrasilAPI: Erro ' . $code);
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    // BrasilAPI v2 geralmente retorna erro no status code.
    // Se por acaso voltar 200 mas vazio ou com errors (comportamento raro/antigo)
    if (empty($body) || isset($body['errors'])) {
      return new WP_Error('not_found', 'BrasilAPI: Body inválido');
    }

    return [
      'cep' => $body['cep'],
      'state' => $body['state'],
      'city' => $body['city'],
      'neighborhood' => $body['neighborhood'] ?? '',
      'street' => $body['street'] ?? '',
      'service' => 'brasilapi'
    ];
  }

  /**
   * Tenta consultar na ViaCEP.
   */
  private static function try_viacep(string $cep)
  {
    $url = "https://viacep.com.br/ws/{$cep}/json/";
    $response = wp_remote_get($url, ['timeout' => 4]);

    if (is_wp_error($response))
      return $response;

    $code = wp_remote_retrieve_response_code($response);

    if ($code === 404)
      return new WP_Error('not_found', 'ViaCEP: 404');

    if ($code !== 200)
      return new WP_Error('api_error', 'ViaCEP: Erro ' . $code);

    $body = json_decode(wp_remote_retrieve_body($response), true);
    // ViaCEP retorna {"erro": true} com status 200 para CEP inexistente
    if (empty($body) || isset($body['erro'])) {
      return new WP_Error('not_found', 'ViaCEP: CEP não encontrado');
    }

    return [
      'cep' => str_replace('-', '', $body['cep']),
      'state' => $body['uf'],
      'city' => $body['localidade'],
      'neighborhood' => $body['bairro'] ?? '',
      'street' => $body['logradouro'] ?? '',
      'service' => 'viacep'
    ];
  }

  /**
   * Tenta consultar na OpenCEP.
   */
  private static function try_opencep(string $cep)
  {
    $url = "https://opencep.com/v1/{$cep}";
    $response = wp_remote_get($url, ['timeout' => 4]);

    if (is_wp_error($response))
      return $response;

    $code = wp_remote_retrieve_response_code($response);

    if ($code === 404)
      return new WP_Error('not_found', 'OpenCEP: 404');

    if ($code !== 200)
      return new WP_Error('api_error', 'OpenCEP: Erro ' . $code);

    $body = json_decode(wp_remote_retrieve_body($response), true);
    if (empty($body) || isset($body['error']))
      return new WP_Error('not_found', 'OpenCEP: CEP não encontrado');

    return [
      'cep' => str_replace('-', '', $body['cep']),
      'state' => $body['uf'],
      'city' => $body['localidade'],
      'neighborhood' => $body['bairro'] ?? '',
      'street' => $body['logradouro'] ?? '',
      'service' => 'opencep'
    ];
  }
}
