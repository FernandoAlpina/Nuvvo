<?php

/**
 * Classe base abstrata de Configurações Gerais do Footer.
 */
abstract class Alp_Footer
{
  public static string $prefixo = 'footer_';

  public static function setup(): void
  {
    add_filter('mb_settings_pages', [static::class, 'registrar_pagina']);
    add_filter('rwmb_meta_boxes', [static::class, 'registrar_campos']);
  }

  /**
   * Registra a pagina de configuracoes.
   */
  abstract public static function registrar_pagina(array $settings_pages): array;

  /**
   * Registra os campos Meta Box.
   */
  abstract public static function registrar_campos(array $meta_boxes): array;
}