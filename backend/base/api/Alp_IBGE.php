<?php

require_once __DIR__ . '/Alp_API.php';

/**
 * Solução para puxar Cidades e Estados para formulários usando a API do IBGE
 */
class Alp_IBGE extends Alp_API
{
  /**
   * Retorna um array com todos os estados como cadastrados no IBGE.
   * @return array<int,string> Lista dos Estados do Brasil chaveados com o ID do IBGE.
   */
  public static function carregar_select_estados(): array
  {
    $options = [];
    $data = self::obter_dados('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome');

    if (empty($data) || !is_array($data))
      return [];

    foreach ($data as $item) {
      $options[$item['id']] = $item['nome'];
    }
    return $options;
  }

  /**
   * Retorna um array com todos os estados usando a sigla como chave.
   * @return array<string,string> Lista dos Estados do Brasil chaveados com a Sigla.
   */
  public static function carregar_select_estados_sigla(): array
  {
    $options = [];
    $data = self::obter_dados('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome');

    if (empty($data) || !is_array($data))
      return [];

    foreach ($data as $item) {
      $options[$item['sigla']] = $item['nome'];
    }
    return $options;
  }

  /**
   * Dado um Estado, retorna um array com todos os municípios como cadastradas no IBGE.
   * @param int $estado_id ID do Estado como cadastrado no IBGE.
   * @return array<int,string> Lista dos Municípios chaveados com o ID do IBGE.
   */
  public static function carregar_select_municipios(int $estado_id): array
  {
    $options = [];

    $data = self::obter_dados("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$estado_id}/municipios?orderBy=nome");

    if (empty($data) || !is_array($data))
      return [];

    foreach ($data as $item) {
      $options[$item['id']] = $item['nome'];
    }
    return $options;
  }

  /**
   * Obtém todas as cidades via AJAX dado que um id de Estado é passado via POST.
   * @return void
   */
  public static function ajax_obter_estados(): void
  {
    $estados = self::carregar_select_estados();
    wp_send_json_success($estados);
    wp_die();
  }

  /**
   * Obtém todas as cidades via AJAX dado que um id de Estado é passado via POST.
   * @return void
   */
  public static function ajax_obter_cidades(): void
  {
    if (!isset($_POST['estado_id'])) {
      wp_send_json_error('Estado não fornecido');
      wp_die();
    }

    $estado_id = intval($_POST['estado_id']);
    $cidades = self::carregar_select_municipios($estado_id);

    wp_send_json_success($cidades);
    wp_die();
  }

  /**
   * @param int|string $cidade_id ID do Município, segundo IBGE.
   * @return string O nome do município, ou $cidade_id se não for encontrado na base do IBGE.
   */
  public static function get_cidade(int|string $cidade_id): string
  {
    if (empty($cidade_id))
      return '';
    $data = self::obter_dados("https://servicodados.ibge.gov.br/api/v1/localidades/municipios/{$cidade_id}");

    if (!$data)
      return $cidade_id;
    return $data['nome'];
  }

  /**
   * @param int|string $estado_id ID do Estado, segundo IBGE.
   * @param bool $sigla True se desejar usar apenas a sigla do Estado em vez do nome completo.
   * @return string A sigla ou nome do estado, ou $estado_id se não for encontrado na base do IBGE.
   */
  public static function get_estado(int|string $estado_id, bool $sigla = false): string
  {
    if (!$estado_id)
      return '';
    $data = self::obter_dados("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$estado_id}");

    if (!$data)
      return $estado_id;

    if ($sigla)
      return $data['sigla'];
    else
      return $data['nome'];
  }

  /**
   * Adiciona o script necessário para o metabox de cidades funcionar.
   * Utilize este método em conjunto com o hook 'admin_footer' em sua entidade.
   * @return void
   */
  public static function script_metabox_cidades($slug = 'projeto'): void
  {
    $screen = get_current_screen();
    ?>
    <script id="admin-post-<?= $slug; ?>">
      (function ($) {
        $('#<?= $slug; ?>_estado').on('change', function () {
          var estado_id = $(this).val();

          $.ajax({
            url: '<?= admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
              action: 'ibge_cidades',
              estado_id: estado_id
            },
            success: function (response) {
              if (!response.success) return console.log(response.data);

              const cidades = response.data;
              const $cidadeSelect = $('#<?= $slug; ?>_cidade');

              $cidadeSelect.empty();
              $.each(cidades, function (id, nome) {
                $cidadeSelect.append($('<option>', {
                  value: id,
                  text: nome
                }));
              });

              $cidadeSelect.trigger('change');
            },
            error: function (jqXHR, textStatus, errorThrown) {
              console.error('Erro AJAX:', textStatus, errorThrown);
            }
          });
        });

        <?php if ($screen && $screen->base === 'post' && $screen->post_type === $slug && $screen->action === 'add'): ?>
          $('#<?= $slug; ?>_estado').trigger('change');
        <?php endif; ?>

      })(jQuery);
    </script>
    <?php
  }

  /**
   * Busca cidades pelo termo de pesquisa.
   * Retorna máximo 10 resultados no formato: [{id, nome, estado}]
   * 
   * @hooked wp_ajax_ibge_buscar_cidades
   * @hooked wp_ajax_nopriv_ibge_buscar_cidades
   * @return void
   */
  public static function ajax_buscar_cidades(): void
  {
    $termo = isset($_REQUEST['termo']) ? sanitize_text_field($_REQUEST['termo']) : '';

    if (strlen($termo) < 2) {
      wp_send_json_success([]);
      wp_die();
    }

    // Buscar todos os municípios do Brasil
    $data = self::obter_dados('https://servicodados.ibge.gov.br/api/v1/localidades/municipios?orderBy=nome');

    if (empty($data) || !is_array($data)) {
      wp_send_json_success([]);
      wp_die();
    }

    // Normalizar termo para busca (remover acentos e lowercase)
    $termo_normalizado = self::normalizar_texto($termo);

    $resultados = [];
    foreach ($data as $cidade) {
      $nome_normalizado = self::normalizar_texto($cidade['nome']);

      if (strpos($nome_normalizado, $termo_normalizado) !== false) {
        $resultados[] = [
          'id' => $cidade['id'],
          'nome' => $cidade['nome'],
          'estado' => $cidade['microrregiao']['mesorregiao']['UF']['nome'],
          'uf' => $cidade['microrregiao']['mesorregiao']['UF']['sigla'],
          'label' => $cidade['nome'] . ', ' . $cidade['microrregiao']['mesorregiao']['UF']['nome'],
        ];

        // Limitar a 10 resultados
        if (count($resultados) >= 10)
          break;
      }
    }

    wp_send_json_success($resultados);
    wp_die();
  }

  /**
   * Normaliza texto removendo acentos e convertendo para minúsculas.
   * Usa a função nativa do WordPress remove_accents().
   * @param string $texto Texto a normalizar.
   * @return string Texto normalizado.
   */
  private static function normalizar_texto(string $texto): string
  {
    return mb_strtolower(remove_accents($texto), 'UTF-8');
  }
}

add_action('wp_ajax_ibge_estados', ['Alp_IBGE', 'ajax_obter_estados']);
add_action('wp_ajax_nopriv_ibge_estados', ['Alp_IBGE', 'ajax_obter_estados']);

add_action('wp_ajax_ibge_cidades', ['Alp_IBGE', 'ajax_obter_cidades']);
add_action('wp_ajax_nopriv_ibge_cidades', ['Alp_IBGE', 'ajax_obter_cidades']);

add_action('wp_ajax_ibge_buscar_cidades', ['Alp_IBGE', 'ajax_buscar_cidades']);
add_action('wp_ajax_nopriv_ibge_buscar_cidades', ['Alp_IBGE', 'ajax_buscar_cidades']);

