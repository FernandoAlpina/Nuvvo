<?php
/**
 * Helpers de exibição do CPT `produto`.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Resolve o texto do selo/badge (.card-prod__tag) de um produto.
 * Regra: um selo por vez, com prioridade do "Selo designer" sobre o "Nuvvo Signature".
 *
 * @return string Texto do badge ('' quando nenhum selo está ativo).
 */
function nuvvo_produto_selo(int $post_id): string
{
    if (!$post_id || !function_exists('rwmb_meta')) {
        return '';
    }
    if (rwmb_meta('produto_selo_designer', [], $post_id)) {
        $tag = trim((string) rwmb_meta('produto_selo_tag', [], $post_id));
        return $tag !== '' ? $tag : 'Designer';
    }
    if (rwmb_meta('produto_signature', [], $post_id)) {
        return 'Nuvvo Signature';
    }
    return '';
}
