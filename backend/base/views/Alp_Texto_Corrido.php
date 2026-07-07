<?php

/**
 * Classe responsável pelo template de Texto Corrido.
 * Serve de molde para novos projetos.
 * 
 * @author Alpina Digital
 * @package Alpina V4
 */
class Alp_Texto_Corrido extends Alp_Page
{
  /**
   * Setup da página Texto Corrido.
   * @return void
   */
  public function setup(): void
  {
    $this->template = new Alp_Page_Template('template-texto-corrido.php', 'texto-corrido');
    $this->create_metaboxes();
  }

  /**
   * Cria metaboxes para a página.
   * @return void
   */
  public function create_metaboxes(): void
  {
    $this->template->create_metaboxes(false)
      //BANNER
      ->add_metabox_box('banner', 'Banner no Topo')
      ->add_metabox_field_biu('Texto 1', 'texto_destaque', 4)
      ->add_metabox_field_biu('Texto 2', 'titulo', 5)
      ->add_metabox_field_image('Imagem de Fundo', 'imagem', 1, 3)
      ->render();
  }

  /**
   * Renderiza a página.
   * @return void
   */
  public function render(): void
  {
    $this
      // ->add_render($this->render_banner_topo())
      ->add_render($this->render_section_conteudo())
      ->echo_render();
  }

  /**
   * Renderiza a seção de conteúdo.
   * @return string HTML renderizado.
   */
  public function render_section_conteudo(): string
  {
    $titulo = get_the_title($this->id);
    $content = get_post_field('post_content', $this->id);
    $content = apply_filters('the_content', $content);

    return $this->html('frontend/base/texto-corrido/section-conteudo.php', ['titulo' => $titulo, 'texto' => $content]);
  }
}

add_action('after_setup_theme', [new Alp_Texto_Corrido(), 'setup']);
