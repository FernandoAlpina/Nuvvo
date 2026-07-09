<?php
/**
 * SEO baseline: meta description, Open Graph, canonical e Schema.org.
 * Desativa-se automaticamente se um plugin de SEO (Yoast/RankMath/SEOPress) estiver ativo.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

/** Há um plugin de SEO cuidando das meta tags? */
function nuvvo_seo_plugin_ativo(): bool
{
    return defined('WPSEO_VERSION')            // Yoast
        || class_exists('RankMath')            // RankMath
        || defined('SEOPRESS_VERSION')         // SEOPress
        || defined('AIOSEO_VERSION');          // All in One SEO
}

/** Descrição da página atual (com fallback global). */
function nuvvo_seo_description(): string
{
    $desc = '';
    if (is_singular('produto')) {
        $desc = (string) rwmb_meta('produto_lede', [], get_the_ID());
    } elseif (is_singular('post')) {
        $desc = get_the_excerpt();
    } elseif (is_singular()) {
        $desc = get_the_excerpt();
    }
    $desc = trim(wp_strip_all_tags((string) $desc));
    if ($desc === '') {
        $desc = nuvvo_opt('nuvvo_seo_desc', 'Mobiliário de alta decoração — sofás, poltronas, bancos e camas com design autoral, personalização e produção artesanal.');
    }
    return wp_trim_words($desc, 40, '…');
}

/** Imagem de compartilhamento (Open Graph). */
function nuvvo_seo_image(): string
{
    if (is_singular() && has_post_thumbnail()) {
        return (string) get_the_post_thumbnail_url(get_the_ID(), 'full');
    }
    $id = function_exists('rwmb_meta') ? rwmb_meta('nuvvo_og_image', ['object_type' => 'setting'], 'nuvvo_opcoes') : '';
    if (is_array($id)) { $id = reset($id); }
    if ($id) {
        $url = wp_get_attachment_image_url((int) $id, 'full');
        if ($url) { return $url; }
    }
    return get_template_directory_uri() . '/assets/img/logo-cream.png';
}

/** Imprime as meta tags no <head>. */
add_action('wp_head', function () {
    if (nuvvo_seo_plugin_ativo()) {
        return;
    }

    $desc  = nuvvo_seo_description();
    $title = wp_get_document_title();
    $url   = is_singular() ? get_permalink() : home_url(add_query_arg([], $GLOBALS['wp']->request ?? ''));
    if (!$url) { $url = home_url('/'); }
    $image = nuvvo_seo_image();
    $sitename = get_bloginfo('name');

    echo "\n<!-- Nuvvo SEO -->\n";
    printf('<meta name="description" content="%s">' . "\n", esc_attr($desc));
    printf('<link rel="canonical" href="%s">' . "\n", esc_url($url));
    printf('<meta property="og:type" content="%s">' . "\n", is_singular('produto') ? 'product' : (is_singular('post') ? 'article' : 'website'));
    printf('<meta property="og:locale" content="pt_BR">' . "\n");
    printf('<meta property="og:site_name" content="%s">' . "\n", esc_attr($sitename));
    printf('<meta property="og:title" content="%s">' . "\n", esc_attr($title));
    printf('<meta property="og:description" content="%s">' . "\n", esc_attr($desc));
    printf('<meta property="og:url" content="%s">' . "\n", esc_url($url));
    printf('<meta property="og:image" content="%s">' . "\n", esc_url($image));
    printf('<meta name="twitter:card" content="summary_large_image">' . "\n");
}, 5);

/** Schema.org Organization (global, no rodapé do <head>). */
add_action('wp_head', function () {
    if (nuvvo_seo_plugin_ativo()) {
        return;
    }
    $org = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Organization',
        'name'        => get_bloginfo('name'),
        'url'         => home_url('/'),
        'logo'        => get_template_directory_uri() . '/assets/img/logo-cream.png',
        'description' => nuvvo_opt('nuvvo_seo_desc', 'Mobiliário de alta decoração — design autoral.'),
    ];
    $tel = nuvvo_wa_number();
    if ($tel) { $org['telephone'] = '+' . $tel; }
    $end = nuvvo_opt('nuvvo_endereco', '');
    if ($end) { $org['address'] = ['@type' => 'PostalAddress', 'streetAddress' => trim(preg_replace('/\s+/', ' ', $end))]; }
    $sameas = array_values(array_filter([
        nuvvo_opt('nuvvo_instagram', ''),
        nuvvo_opt('nuvvo_facebook', ''),
    ]));
    if ($sameas) { $org['sameAs'] = $sameas; }

    echo '<script type="application/ld+json">' . wp_json_encode($org, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}, 20);
