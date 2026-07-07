<?php
class Alp_Paginacao
{
  protected ?int $inicio = 0;
  protected array $anteriores = [];
  protected ?int $atual = 0;
  protected array $seguintes = [];
  protected ?int $final = 0;
  protected int $paginas = 0;

  protected bool $pontos_antes = false;
  protected bool $pontos_depois = false;

  protected string $link_base = '';
  protected bool $usar_barras = false;

  /**
   * Constrói o objeto de acordo com um WP_Query.
   */
  function __construct(WP_Query $query, $usar_barras = false)
  {
    if ($usar_barras) {
      preg_match("%/page/(\d+)%", $_SERVER['REQUEST_URI'], $atual);
      $atual = $atual[1] ?? 1;
    } else {
      $atual = isset($_GET['pagina']) ? absint($_GET['pagina']) : 1;
    }

    $anteriores = [];
    $seguintes = [];

    $this->paginas = $query->max_num_pages;
    $final = $this->paginas;

    if ($atual > $final) return;

    for ($i = $atual - 1; $i > $atual - 3; $i--) {
      if ($i <= 1) break;
      $anteriores[] = $i;
    }
    $anteriores = array_reverse($anteriores);

    for ($i = $atual + 1; $i < $atual + 3; $i++) {
      if ($i >= $final) break;
      $seguintes[] = $i;
    }

    $pontos_antes = empty($anteriores) || $anteriores[0] - 1  === 1 ? false : true;
    $pontos_depois = empty($seguintes) || array_reverse($seguintes)[0] + 1  === $final ? false : true;

    $this->inicio = $atual > 1 ? 1 : NULL;
    $this->final = $atual < $final ? $final : NULL;

    $this->atual = $atual;
    $this->anteriores = $anteriores;
    $this->seguintes = $seguintes;

    $this->pontos_antes = $pontos_antes;
    $this->pontos_depois = $pontos_depois;
    $this->usar_barras = $usar_barras;

    $this->set_base_url();
  }

  /**
   * Retorna a primeira página ou NULL caso seja a página atual.
   * @return ?int Página inicial.
   */
  public function get_inicio(): int|null
  {
    return $this->inicio;
  }

  /**
   * Retorna um array das duas páginas anteriores.
   * 
   * Esse ara
   */
  public function get_anteriores(): array
  {
    return $this->anteriores;
  }

  /**
   * Retorna o número da página imediatamente anterior.
   * 
   * Esse ara
   */
  public function get_anterior(): int|null
  {
    if (!$this->inicio) return NULL;
    return $this->atual - 1;
  }

  /**
   * Retorna a página atual.
   * @return ?int Número da página.
   */
  public function get_atual(): int
  {
    return $this->atual;
  }

  /** */
  public function get_seguintes(): array
  {
    return $this->seguintes;
  }

  /** */
  public function get_seguinte(): int|null
  {
    if (!$this->final) return NULL;
    return $this->atual + 1;
  }

  /** */
  public function get_final(): int|null
  {
    return $this->final;
  }

  /** */
  public function get_pontos_antes(): bool
  {
    return $this->pontos_antes;
  }

  /** */
  public function get_numero_paginas(): int
  {
    return $this->paginas;
  }

  public function is_paginada(): bool
  {
    return $this->paginas > 1;
  }

  /**
   * Retorna a página atual.
   * @return ?int Número da página.
   */
  public function get_pontos_depois(): bool
  {
    return $this->pontos_depois;
  }

  /**
   * Retorna o link da página de acordo com um número de página.
   * @param int $numero Número da Página
   * @return string URL da página.
   */
  public function get_link_pagina(int|null $numero, $use_slashes = false): string
  {
    if (!$numero) return '#0';

    $qs = $_SERVER['QUERY_STRING'];

    if ($this->usar_barras) {
      return $this->link_base . "page/{$numero}/?" . $qs;
    }

    parse_str($qs, $query_array);
    $query_array['pagina'] = $numero;
    return add_query_arg($query_array, $this->link_base);
  }

  public function get_link_base()
  {
    return $this->link_base;
  }

  /**
   * Estabelece o URL base das páginas.
   */
  private function set_base_url()
  {
    $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    $uri = parse_url($uri)['path'];

    $link_base = $protocolo . "://" . $host . $uri;
    $link_base = preg_replace("%/page/(\d+)%", '', $link_base);

    $this->link_base = $link_base;
  }
}
