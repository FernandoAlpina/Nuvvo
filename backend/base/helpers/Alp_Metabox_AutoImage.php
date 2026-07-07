<?php

/**
 * Classe que avalia os valores de campos metabox e retorna a imagem correspondente.
 * Usada como auxiliar de Alp_Metabox.
 * @see Alp_Metabox
 * 
 * @author Alpina Digital
 * @package Alpina V4
 * @since 4.0
 * 
 */
class Alp_Metabox_AutoImage
{

  /**
   * @var bool $autoimage Se true, irá aplicar função de autoimagem, se false, vai simplesmente retorna os valores brutos de volta.
   */
  private bool $autoimage = true;

  /**
   * @var bool $groups Se deve avaliar os valores dentro de groups ou não.
   */
  private bool $groups = true;

  /**
   * @var array<string,string> $metafields Array onde a chave é o id do campo metabox (sem prefix ou subprefix) e o valor é o tipo de valor que deve retornar.
   * 
   * 'img': Retorna a imagem com a tag 'img'.
   *
   * 'src': Retorna a URL da imagem.
   * 
   * 'img+src': Retorna um array com a tag 'img' e a URL da imagem.
   *
   * 'svg': Retorna o conteúdo do SVG, se for um SVG. Ou img se não for.
   *
   * 'none': Retorna o valor com está cadastrado.
   */
  private array $metafields = ['imagem' => 'img', 'logo' => 'svg', 'icone' => 'svg'];

  /**
   * Classes CSS que serão aplicadas para o SVG.
   */
  private string $svg_class = '';

  /**
   * Classes CSS que serão aplicadas para a tag img.
   */
  private string $img_class = '';

  /**
   * Argumentos para a função get_svg_content, a partir do terceiro.
   */
  private array $svg_config = [];

  /**
   * Ao construir essa classe, passe um array onde as chaves são as propriedades desta própria classe e os valores são as configurações.
   * O que for passado nesse construtor irá sobrescrever os valores padrões da classe.
   * @param array<string,mixed> $configs Configurações.
   */
  public function __construct(array $configs)
  {
    foreach ($configs as $prop => $config) {
      if (property_exists($this, $prop)) $this->$prop = $config;
    }
  }

  /**
   * Realiza a avaliação dos valores dos campos metabox para entregar imagem (ou grupo de imagens) correspondente.
   * @param string $key Nome do campo metabox. (Sem prefix ou subprefix).
   * @param mixed $value Valor retornado pelo campo metabox.
   * @return string|array Entrega imagens no lugar dos valores brutos, caso seja possível efetuar a operação.
   */
  public function autoimage(string $key, mixed $value): string|array
  {
    if (!$this->autoimage) return $value;

    if (is_array($value) && is_array(reset($value))) {
      return $this->autoimage_group($value);
    }

    if (is_array($value) && count($value) === 1) {
      return $this->autoimage($key, reset($value));
    }

    if (is_array($value) && count($value) > 1) {
      $value = array_map(function ($v) use ($key) {
        return $this->autoimage($key, $v);
      }, $value);

      return $value;
    }

    if (!$value) $value = "";
    return $this->get_image_value($value, $key);
  }

  /**
   * Realiza a avaliação dos valores dos campos metabox dentro de groups para retornar a imagem correspondente.
   * @param array $value Valor do campo metabox.
   * @return string Entrega a imagem correspondente ao valor. (Ou o valor bruto, caso não seja possível efetuar a operação).
   */
  private function autoimage_group(array $value): string|array
  {
    if (!$this->groups) return $value;

    foreach ($value as $i => $group) {
      foreach ($group as $k => $v) {
        $value[$i][$k] = $this->autoimage($k, $v);
      }
    }

    return $value;
  }

  /**
   * Retorna a imagem no formato correto.
   * @param string|int $value Valor do campo metabox.
   * @param string $key Nome do campo metabox.
   * 
   * @return string|array<string,string> Retorna a imagem correspondente ao valor passado.
   */
  private function get_image_value(string|int $value, string $key): string|array
  {
    $pattern = implode("|", array_keys($this->metafields));
    if (!preg_match("%({$pattern})%", $key) || !is_numeric($value)) return $value;

    $type = $this->metafields[$key] ?? 'src';

    if ($type === 'none') return $value;

    $src = wp_get_attachment_image_url($value, 'full');

    if (!$src) return '';

    if ($type === 'src') return $src;

    if ($type === 'svg' && is_svg($src)) return get_svg_content($src, $this->svg_class, ...$this->svg_config);

    if ($type === 'img+src' || $type === 'src+img') return [
      'img' => wp_get_attachment_image($value, 'full', false, ['class' => $this->img_class]),
      'src' => $src
    ];

    return wp_get_attachment_image($value, 'full', false, ['class' => $this->img_class]);
  }
}
