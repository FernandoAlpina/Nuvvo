<?php
trait Alp_Renderable
{
  /**
   * Armazena o conteúdo a ser renderizado.
   */
  private $render = '';

  /**
   * Pega a template parte e injeta variáveis dentro, retornando o HTML.
   * 
   * @param string $template_part Caminho completo para a template part
   * @param array $args Argumentos
   * 
   * @return string HTML daquela parte.
   */
  public function html(string $template_part, array $args = []): string
  {
    if (preg_match('%.php$%uis', $template_part)) {
      $template_part = preg_replace("%\.php$%", "", $template_part);
    }

    ob_start();
    get_template_part($template_part, NULL, $args);
    return ob_get_clean();
  }

  /**
   * Adiciona conteúdo HTML para ser renderizado.
   * @param string $html HTML a ser adicionado.
   * 
   * @return self para encadeamento.
   */
  public function add_render(string $html = ''): self
  {
    $this->render .= $html;
    return $this;
  }

  /**
   * Imprime tudo que foi colocado no render.
   * @return void
   */
  public function echo_render(): void
  {
    echo $this->render;
  }

  /**
   * Pega tudo que estiver para ser renderizado.
   * @return string
   */
  public function get_render(): string
  {
    return $this->render;
  }

  /**
   * Limpa tudo que está pra ser renderizado.
   * @return string
   */
  public function clear_render(): void
  {
    $this->render = '';
  }

  /**
   * A classe da view deve aplicar um método render com todas as partes de template a serem impressas.
   * Encadeie todos os add_render e finalize com echo_render.
   * @return void Não deve retornar valor.
   */
  abstract function render(): void;
}
