<?php
/**
 * Seed (uma vez) do produto "Sofá Pecan" + designer "Deivid de Almeida",
 * a partir da ficha aprovada. Referencia imagens já existentes na Biblioteca
 * de Mídia pelo slug (nome do arquivo sem extensão).
 *
 * Só cria o que não existe; não sobrescreve produtos já cadastrados.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', function () {
    $flag = 'nuvvo_seed_produtos_v1';
    if (get_option($flag)) {
        return;
    }

    // Attachment ID por slug (nome do arquivo sem extensão).
    $att = function (string $slug): int {
        $a = get_posts([
            'post_type'      => 'attachment',
            'post_status'    => 'inherit',
            'name'           => $slug,
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'no_found_rows'  => true,
        ]);
        return $a ? (int) $a[0] : 0;
    };

    $img_prod  = $att('prod-pecan');
    $img_hero1 = $att('hero-1');
    // Se as imagens principais ainda não estão na biblioteca, tenta no próximo load.
    if (!$img_prod && !$img_hero1) {
        return;
    }

    /* -------------------- Designer: Deivid de Almeida -------------------- */
    $designer = get_page_by_path('deivid-de-almeida', OBJECT, 'designer');
    $did = $designer ? (int) $designer->ID : 0;
    if (!$did) {
        $did = wp_insert_post([
            'post_type'   => 'designer',
            'post_status' => 'publish',
            'post_title'  => 'Deivid de Almeida',
            'post_name'   => 'deivid-de-almeida',
        ]);
        if (!is_wp_error($did) && $did) {
            $foto = $att('designer-deivid');
            if ($foto) {
                set_post_thumbnail($did, $foto);
                add_post_meta($did, 'designer_foto', $foto);
            }
            update_post_meta($did, 'designer_cargo', 'Designer de Mobiliário');
            update_post_meta($did, 'designer_bio_curta', '<p>Parceiro estratégico da Nuvvo Design, com <em>expertise técnica lapidada</em> em mais de duas décadas na indústria moveleira. Sua filosofia traduz comportamento humano em mobiliário com foco em <em>ergonomia, conforto tátil e perfeição técnica</em>.</p>');
            update_post_meta($did, 'designer_bio_longa', '<p>Atuante na <em>indústria moveleira desde os anos 2000</em>, Deivid de Almeida construiu uma <strong>expertise técnica lapidada em um processo constante de evolução e refinamento</strong>. Cada peça que assina carrega o repertório de mais de duas décadas de prática.</p><p>Seu trabalho parte de uma obsessão silenciosa: <strong>traduzir comportamento humano em mobiliário</strong>. <em>Ergonomia</em>, <em>conforto tátil</em> e <em>perfeição técnica</em> deixam de ser exigências para se tornarem ponto de partida.</p>');
        } else {
            $did = 0;
        }
    }

    /* -------------------- Produto: Sofá Pecan -------------------- */
    $existing = get_page_by_path('pecan', OBJECT, 'produto');
    if ($existing) {
        // Já existe não sobrescreve. Marca a flag e sai.
        update_option($flag, current_time('mysql'));
        return;
    }

    $ppid = wp_insert_post([
        'post_type'   => 'produto',
        'post_status' => 'publish',
        'post_title'  => 'Sofá Pecan',
        'post_name'   => 'pecan',
    ]);
    if (is_wp_error($ppid) || !$ppid) {
        return; // tenta de novo no próximo load
    }

    // Categoria: Sofás
    $sofas = get_term_by('slug', 'sofas', 'categoria_produto');
    if ($sofas && !is_wp_error($sofas)) {
        wp_set_object_terms($ppid, [(int) $sofas->term_id], 'categoria_produto');
    }

    // Imagem destacada (card/listagens): packshot; fallback hero-1.
    $thumb = $img_prod ?: $img_hero1;
    if ($thumb) {
        set_post_thumbnail($ppid, $thumb);
    }

    // Designer (relação armazenada como linha única de post meta)
    if ($did) {
        add_post_meta($ppid, 'produto_designer', (int) $did);
    }

    // Textos
    update_post_meta($ppid, 'produto_lede', 'Inspirado na versatilidade da Noz Pecan, capaz de se integrar a diferentes contextos com naturalidade pensado para se adaptar com equilíbrio a múltiplos ambientes e composições.');
    update_post_meta($ppid, 'produto_chips', ['4 medidas disponíveis', 'Personalizável em tecidos', 'Mesa lateral opcional']);
    update_post_meta($ppid, 'produto_story_texto', 'Inspirado na versatilidade da <em>Noz Pecan</em>, capaz de se integrar a diferentes contextos com naturalidade o Sofá Pecan foi pensado para se adaptar com equilíbrio a múltiplos ambientes e composições.');

    // Hero (image_advanced -> uma linha de meta por imagem)
    delete_post_meta($ppid, 'produto_hero_imagens');
    foreach ([$img_hero1, $att('gallery-5')] as $hid) {
        if ($hid) {
            add_post_meta($ppid, 'produto_hero_imagens', (int) $hid);
        }
    }

    // Galeria (grupo: imagem [array de IDs] + proporção)
    $galeria = [];
    foreach ([['hero-2', 'first'], ['gallery-1', ''], ['gallery-4', ''], ['gallery-6', 'wide'], ['prod-pecan', '']] as $g) {
        $gid = $att($g[0]);
        if ($gid) {
            $galeria[] = ['imagem' => [(int) $gid], 'proporcao' => $g[1]];
        }
    }
    if ($galeria) {
        update_post_meta($ppid, 'produto_galeria', $galeria);
    }

    // Dimensões gerais
    update_post_meta($ppid, 'produto_dimensoes', [
        ['rotulo' => 'Profundidade', 'valor' => '100 cm'],
        ['rotulo' => 'Altura total', 'valor' => '80 cm'],
        ['rotulo' => 'Altura do assento', 'valor' => '45 cm'],
    ]);

    // Módulos (configurador) 4 medidas
    update_post_meta($ppid, 'produto_modulos', [
        ['label' => '190 cm', 'largura' => 190, 'imagem' => [], 'descricao' => 'Módulo de 190 cm ideal para ambientes mais compactos.'],
        ['label' => '210 cm', 'largura' => 210, 'imagem' => [], 'descricao' => 'Módulo de 210 cm equilíbrio entre presença e circulação.'],
        ['label' => '230 cm', 'largura' => 230, 'imagem' => [], 'descricao' => 'Módulo de 230 cm conforto amplo para o living.'],
        ['label' => '250 cm', 'largura' => 250, 'imagem' => [], 'descricao' => 'Módulo de 250 cm máxima presença e lugares.'],
    ]);

    // Extras
    update_post_meta($ppid, 'produto_extras', '<h4>Mesa lateral · opcional</h4><p>31 cm (A) × 57 cm (C) × 25 cm (L) · espessura 0,2 cm.<br>Disponível em madeira natural ou mármore.</p>');

    // Destacar na Home
    update_post_meta($ppid, 'produto_destaque_home', '1');

    update_option($flag, current_time('mysql'));
    error_log('[Nuvvo seed produtos] Pecan=' . $ppid . ' Designer=' . $did . ' thumb=' . $thumb);
});
