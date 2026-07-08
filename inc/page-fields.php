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
 * Páginas cujo conteúdo é 100% em painéis Meta Box (sem editor de blocos),
 * para a edição ficar igual ao padrão Impl Master. (Política usa o editor.)
 */
function nuvvo_pages_sem_editor(): array
{
    return ['home', 'a-nuvvo', 'contato', 'catalogo', 'inspire-se', 'blog'];
}

// Remove o editor (área de blocos) ao editar essas páginas — só os painéis de seção aparecem.
add_action('admin_init', function () {
    if (empty($_GET['post'])) {
        return;
    }
    $slug = get_post_field('post_name', (int) $_GET['post']);
    if (in_array($slug, nuvvo_pages_sem_editor(), true)) {
        remove_post_type_support('page', 'editor');
    }
});

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
