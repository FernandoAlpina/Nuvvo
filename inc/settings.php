<?php
/**
 * Opções globais do tema (Meta Box Settings Page) + helpers.
 * Conteúdo reutilizado em todas as páginas: contato, WhatsApp, redes, rodapé.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

/* ---------- Registro da página de opções ---------- */
add_filter('mb_settings_pages', function ($pages) {
    $pages[] = [
        'id'          => 'nuvvo_opcoes',
        'option_name' => 'nuvvo_opcoes',
        'menu_title'  => 'Nuvvo',
        'page_title'  => 'Configurações do site',
        'icon_url'    => 'dashicons-admin-customizer',
        'position'    => 2,
        'style'       => 'no-boxes',
        'columns'     => 1,
        'tabs'        => [
            'geral'   => 'Contato & Marca',
            'redes'   => 'Redes & Links',
            'numeros' => 'Big Numbers',
        ],
    ];
    return $pages;
});

add_filter('rwmb_meta_boxes', function ($mb) {
    $mb[] = [
        'id'             => 'nuvvo_opcoes_geral',
        'title'          => 'Contato & Marca',
        'settings_pages' => 'nuvvo_opcoes',
        'tab'            => 'geral',
        'fields'         => [
            ['name' => 'Tagline', 'id' => 'nuvvo_tagline', 'type' => 'text', 'placeholder' => 'Mobiliário de alta decoração'],
            ['name' => 'WhatsApp (só números, com DDI/DDD)', 'id' => 'nuvvo_whatsapp', 'type' => 'text', 'placeholder' => '5554999485915'],
            ['name' => 'Telefone (exibição)', 'id' => 'nuvvo_telefone', 'type' => 'text', 'placeholder' => '(54) 9 9948-5915'],
            ['name' => 'Endereço', 'id' => 'nuvvo_endereco', 'type' => 'textarea', 'rows' => 3],
        ],
    ];
    $mb[] = [
        'id'             => 'nuvvo_opcoes_redes',
        'title'          => 'Redes & Links',
        'settings_pages' => 'nuvvo_opcoes',
        'tab'            => 'redes',
        'fields'         => [
            ['name' => 'Instagram (URL)', 'id' => 'nuvvo_instagram', 'type' => 'url', 'placeholder' => 'https://www.instagram.com/nuvvo.design'],
            ['name' => 'Facebook (URL)', 'id' => 'nuvvo_facebook', 'type' => 'url', 'placeholder' => 'https://www.facebook.com/nuvvodesign'],
            ['name' => 'Link "Blocos 3D" (URL externa)', 'id' => 'nuvvo_blocos3d', 'type' => 'url'],
        ],
    ];
    $mb[] = [
        'id'             => 'nuvvo_opcoes_numeros',
        'title'          => 'Big Numbers (Home e A Nuvvo)',
        'settings_pages' => 'nuvvo_opcoes',
        'tab'            => 'numeros',
        'fields'         => [
            [
                'name'          => 'Números em destaque',
                'id'            => 'nuvvo_big_numbers',
                'type'          => 'group',
                'clone'         => true,
                'sort_clone'    => true,
                'collapsible'   => true,
                'default_state' => 'collapsed',
                'group_title'   => '{label}',
                'add_button'    => '+ Número',
                'fields'        => [
                    ['name' => 'Prefixo', 'id' => 'prefixo', 'type' => 'text', 'columns' => 2, 'placeholder' => '+'],
                    ['name' => 'Valor', 'id' => 'valor', 'type' => 'text', 'columns' => 3, 'placeholder' => '3000'],
                    ['name' => 'Sufixo / unidade', 'id' => 'sufixo', 'type' => 'text', 'columns' => 3, 'placeholder' => 'anos, %'],
                    ['name' => 'Casas decimais', 'id' => 'decimais', 'type' => 'number', 'columns' => 2, 'std' => 0],
                    ['name' => 'Duração (ms)', 'id' => 'duracao', 'type' => 'number', 'columns' => 2, 'std' => 1800],
                    ['name' => 'Legenda', 'id' => 'label', 'type' => 'textarea', 'rows' => 2, 'columns' => 12],
                ],
            ],
        ],
    ];
    return $mb;
});

/* ---------- Helpers de leitura ---------- */

/**
 * Lê uma opção global com fallback.
 */
function nuvvo_opt(string $field, string $default = ''): string
{
    if (!function_exists('rwmb_meta')) {
        return $default;
    }
    $v = rwmb_meta($field, ['object_type' => 'setting'], 'nuvvo_opcoes');
    if (is_array($v)) {
        $v = reset($v);
    }
    $v = is_string($v) ? trim($v) : '';
    return $v !== '' ? $v : $default;
}

/**
 * Número de WhatsApp (só dígitos).
 */
function nuvvo_wa_number(): string
{
    return preg_replace('/\D/', '', nuvvo_opt('nuvvo_whatsapp', '5554999485915'));
}

/**
 * Monta um link de WhatsApp com mensagem pré-preenchida.
 */
function nuvvo_wa_link(string $mensagem = ''): string
{
    $url = 'https://wa.me/' . nuvvo_wa_number();
    if ($mensagem !== '') {
        $url .= '?text=' . rawurlencode($mensagem);
    }
    return $url;
}
