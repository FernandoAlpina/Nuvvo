<?php

/**
 * Classe para a entidade de Menu Acesso Rápido.
 */
class Alp_Menu_Acesso_Rapido
{
      public static string $prefixo = 'dados_';

      public static function setup(): void
      {
            add_filter('mb_settings_pages', [self::class, 'registrar_pagina']);
            add_filter('rwmb_meta_boxes', [self::class, 'registrar_campos']);
      }

      /**
       * Registra a pagina.
       */
      public static function registrar_pagina(array $settings_pages): array
      {
            $settings_pages[] = [
                  'id' => 'dados',
                  'option_name' => 'dados',
                  'menu_title' => 'Menu de Acesso Rápido',
                  'menu_slug' => 'menu-lateral',
                  'parent' => 'alp-settings',
                  'position' => 8,
            ];

            return $settings_pages;
      }

      /**
       * Registra os campos Meta Box.
       */
      public static function registrar_campos(array $meta_boxes): array
      {
            $prefix = self::$prefixo;

            $meta_boxes[] = [
                  'id' => 'general',
                  'title' => 'Menu de Acesso Rápido',
                  'context' => 'normal',
                  'settings_pages' => 'dados',
                  'tab' => 'general',
                  'fields' => [
                        [
                              'id' => $prefix . 'items',
                              'type' => 'group',
                              'clone' => true,
                              'sort_clone' => true,
                              'collapsible' => true,
                              'group_title' => 'Item {#} - {label}',
                              'fields' => array_merge([
                                    [
                                          'name' => 'Imagem',
                                          'id' => 'image',
                                          'type' => 'image_advanced',
                                          'max_file_uploads' => 1,
                                          'max_status' => false,
                                          'columns' => 6,
                                    ],
                                    [
                                          'name' => 'Onde abrir o link?',
                                          'type' => 'select',
                                          'id' => 'target',
                                          'columns' => 6,
                                          'options' => [
                                                '_self' => 'Mesma aba',
                                                '_blank' => 'Outra aba',
                                          ]
                                    ],
                              ], self::fields_languages())
                        ]
                  ],
            ];

            return $meta_boxes;
      }

      /**
       * Campos multilíngues (label e URL, pagina_destino, linha_produto).
       */
      private static function fields_languages(): array
      {
            $fields = [
                  [
                        'type' => 'text',
                        'name' => 'Label',
                        'id' => 'label',
                        'columns' => 6,
                  ],
                  [
                        'type' => 'url',
                        'name' => 'URL',
                        'id' => 'url',
                        'columns' => 6,
                  ],
            ];

            if (!function_exists('icl_register_string'))
                  return $fields;


            $langs = getAllLanguages();
            $ids_para_traduzir = ['label', 'url', 'pagina_destino', 'linha_produto'];

            foreach ($langs as $lang) {
                  $code = preg_replace("%^(\w{2}).*$%", "$1", $lang['view_code']);
                  if ($code === 'PT')
                        continue;
                  $code_lower = mb_strtolower($code);

                  foreach ($fields as $field) {
                        if (!in_array($field['id'], $ids_para_traduzir))
                              continue;

                        $novo = $field;
                        $novo['name'] .= " ($code)";
                        $novo['id'] .= "_{$code_lower}";
                        $fields[] = $novo;
                  }
            }

            return $fields;
      }
}

// Hook
add_action('after_setup_theme', ['Alp_Menu_Acesso_Rapido', 'setup']);