<?php
/**
 * Migração única: remove travessões (— em-dash, – en-dash) do conteúdo já
 * gravado no banco (postmeta do tema, opções e descrições de termos),
 * juntando os trechos com um espaço simples.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', function () {
    if (get_option('nuvvo_no_travessao_v1')) {
        return;
    }

    global $wpdb;

    // Remove — / – (com espaços ao redor) e junta com um espaço. Recursivo p/ grupos.
    $clean = function ($v) use (&$clean) {
        if (is_array($v)) {
            $out = [];
            foreach ($v as $k => $vv) {
                $out[$k] = $clean($vv);
            }
            return $out;
        }
        if (is_string($v)) {
            return preg_replace('/ *[\x{2014}\x{2013}] */u', ' ', $v);
        }
        return $v;
    };

    $meta_changed = 0;
    $rows = $wpdb->get_results(
        "SELECT DISTINCT post_id, meta_key FROM {$wpdb->postmeta}
         WHERE (meta_value LIKE '%\xE2\x80\x94%' OR meta_value LIKE '%\xE2\x80\x93%')
           AND (meta_key LIKE 'nuvvo\\_%' OR meta_key LIKE 'produto\\_%' OR meta_key LIKE 'designer\\_%')"
    );
    foreach ($rows as $r) {
        $val = get_post_meta((int) $r->post_id, $r->meta_key, true);
        $new = $clean($val);
        if ($new !== $val) {
            update_post_meta((int) $r->post_id, $r->meta_key, $new);
            $meta_changed++;
        }
    }

    // Opções globais do tema.
    $opts = get_option('nuvvo_opcoes', []);
    if (is_array($opts)) {
        $new = $clean($opts);
        if ($new !== $opts) {
            update_option('nuvvo_opcoes', $new);
        }
    }

    // Descrições de termos (categorias do blog etc.).
    $terms = $wpdb->get_results(
        "SELECT term_id, taxonomy, description FROM {$wpdb->term_taxonomy}
         WHERE description LIKE '%\xE2\x80\x94%' OR description LIKE '%\xE2\x80\x93%'"
    );
    foreach ($terms as $t) {
        wp_update_term((int) $t->term_id, $t->taxonomy, ['description' => $clean($t->description)]);
    }

    update_option('nuvvo_no_travessao_v1', current_time('mysql'));
    error_log('[Nuvvo] travessoes removidos do banco: postmeta=' . $meta_changed . ' termos=' . count($terms));
});
