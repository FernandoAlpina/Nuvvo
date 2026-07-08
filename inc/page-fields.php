<?php
/**
 * Carregador dos grupos de campos por página (Meta Box condicionado por slug).
 * Cada arquivo em backend/project/page-fields/ registra os campos de uma página,
 * exibidos só naquela página (via MB Include Exclude 'include' => ['slug' => [...]]).
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

foreach (glob(get_template_directory() . '/backend/project/page-fields/*.php') as $file) {
    require_once $file;
}

/**
 * Lê um campo da página atual com fallback (para texto simples).
 */
function nuvvo_pgf(string $id, string $default = ''): string
{
    if (!function_exists('rwmb_meta')) {
        return $default;
    }
    $v = rwmb_meta($id, [], get_the_ID());
    if (is_array($v)) {
        $v = reset($v);
    }
    $v = is_string($v) ? trim($v) : '';
    return $v !== '' ? $v : $default;
}
