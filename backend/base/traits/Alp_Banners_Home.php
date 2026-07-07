<?php

/**
 * Trait para Banners da Home com imagens, vídeos e paginação com temporizador.
 */
trait Alp_Banners_Home
{
  /**
   * Renderiza a seção de Banners
   * @param int $posts Quantidade de posts a serem exibidos.
   * @param int $tempo Tempo de duração de cada banner.
   * @return string HTML da seção.
   */
  private function render_section_banners(int $posts = 8, int $tempo = 5000): string
  {
    $query = new WP_Query([
      'post_type' => 'banner',
      'posts_per_page' => $posts,
    ]);

    if (!$query->have_posts()) return '';

    $conteudo = '';
    while ($query->have_posts()) {
      $query->the_post();
      $conteudo .= $this->render_item_banner(get_the_ID(), $tempo);
    }

    return $this->html('frontend/views/pages/home/section-banners-home', compact('conteudo'));
  }

  /**
   * Renderiza um item de Banner.
   * @param int $id ID do banner.
   * @param int $tempo Tempo de duração do banner.
   * @return string HTML do item.
   */
  private function render_item_banner(int $id, int $tempo = 5000): string
  {
    $banner = new Alp_Banner($id);

    if ($banner->get_usar_video()) {
      $imagem_desktop = null;
      $imagem_mobile = null;
      $video = $banner->get_video();
      $tempo = $banner->get_duracao_video();
    } else {
      $video = null;
      $imagem_desktop = $banner->get_imagem_desktop();
      $imagem_mobile = $banner->get_imagem_mobile();
    }

    $titulo = $banner->get_titulo();
    $texto  = $banner->get_texto();
    $cta1   = $banner->get_cta(1);
    $cta2   = $banner->get_cta(2);

    $args = compact('imagem_desktop', 'imagem_mobile', 'video', 'titulo', 'texto', 'tempo', 'cta1', 'cta2');

    return $this->html('frontend/views/pages/home/item-banner-home', $args);
  }
}
