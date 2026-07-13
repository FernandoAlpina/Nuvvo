<?php
/**
 * Enfileiramento de assets do tema Nuvvo.
 *
 * Preserva a cascata do site estático: tokens -> base -> components -> [css por template].
 * Mantém as libs externas do projeto original (Swiper 11, Lenis) e o Google Fonts.
 * Os scripts próprios continuam vanilla (sem jQuery/CodyFrame).
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', function () {
    $uri = get_template_directory_uri();
    $dir = get_template_directory();

    // Versão por filemtime (cache-busting automático).
    $ver = function ($rel) use ($dir) {
        $path = $dir . $rel;
        return file_exists($path) ? (string) filemtime($path) : NUVVO_VERSION;
    };

    /* -------- Google Fonts (placeholders das fontes pagas Bloom/Arquitecta) -------- */
    wp_enqueue_style(
        'nuvvo-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;1,400&family=Raleway:wght@300;400;500;600&family=DM+Sans:wght@400;500;600&display=swap',
        [],
        null
    );

    /* -------- CSS núcleo (todas as páginas), com cascata via deps -------- */
    wp_enqueue_style('nuvvo-tokens', $uri . '/styles/tokens.css', [], $ver('/styles/tokens.css'));
    wp_enqueue_style('nuvvo-base', $uri . '/styles/base.css', ['nuvvo-tokens'], $ver('/styles/base.css'));
    wp_enqueue_style('nuvvo-components', $uri . '/styles/components.css', ['nuvvo-base'], $ver('/styles/components.css'));

    /* -------- CSS por template (carrega depois do components) -------- */
    $page_css = null;
    if (is_front_page()) {
        $page_css = 'sections';
    } elseif (is_page('a-nuvvo')) {
        $page_css = 'a-nuvvo';
    } elseif (is_page('catalogo')) {
        $page_css = 'catalogo-hub';
    } elseif (is_tax('categoria_produto') || is_post_type_archive('produto')) {
        $page_css = 'catalogo-listagem';
    } elseif (is_singular('produto')) {
        $page_css = 'pdp';
    } elseif (is_page('inspire-se')) {
        $page_css = 'inspire-se';
    } elseif (is_page('blog') || is_home()) {
        $page_css = 'blog-listagem';
    } elseif (is_singular('post')) {
        $page_css = 'blog-post';
    } elseif (is_page('contato')) {
        $page_css = 'contato';
    } elseif (is_page('politica-de-privacidade')) {
        $page_css = 'politica-privacidade';
    }
    if ($page_css) {
        wp_enqueue_style("nuvvo-$page_css", $uri . "/styles/$page_css.css", ['nuvvo-components'], $ver("/styles/$page_css.css"));
    }

    /* -------- Swiper (só nas páginas com carrossel) -------- */
    $needs_swiper = is_front_page()
        || is_page('a-nuvvo')
        || is_page('catalogo');

    if ($needs_swiper) {
        wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11');
        wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11', true);
    }

    /* -------- Lenis (smooth scroll, global) -------- */
    wp_enqueue_script('lenis', 'https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.42/bundled/lenis.min.js', [], '1.0.42', true);

    /* -------- JS globais (vanilla) -------- */
    wp_enqueue_script('nuvvo-main', $uri . '/scripts/main.js', ['lenis'], $ver('/scripts/main.js'), true);
    wp_enqueue_script('nuvvo-animations', $uri . '/scripts/animations.js', [], $ver('/scripts/animations.js'), true);
    wp_enqueue_script('nuvvo-cookies', $uri . '/scripts/cookie-banner.js', [], $ver('/scripts/cookie-banner.js'), true);

    if ($needs_swiper) {
        wp_enqueue_script('nuvvo-carousels', $uri . '/scripts/carousels.js', ['swiper', 'nuvvo-main'], $ver('/scripts/carousels.js'), true);
    }

    /* -------- JS por template -------- */
    if (is_singular('produto')) {
        wp_enqueue_script('nuvvo-pdp', $uri . '/scripts/pdp.js', ['nuvvo-main'], $ver('/scripts/pdp.js'), true);
    }
    if (is_tax('categoria_produto')) {
        wp_enqueue_script('nuvvo-catalogo-listagem', $uri . '/scripts/catalogo-listagem.js', ['nuvvo-main'], $ver('/scripts/catalogo-listagem.js'), true);
    }
    if (is_page('contato')) {
        wp_enqueue_script('nuvvo-contato', $uri . '/scripts/contato.js', ['nuvvo-main'], $ver('/scripts/contato.js'), true);
    }
    if (is_page('inspire-se')) {
        wp_enqueue_script('nuvvo-inspire-se', $uri . '/scripts/inspire-se.js', ['nuvvo-main'], $ver('/scripts/inspire-se.js'), true);
    }
    if (is_page('catalogo')) {
        wp_enqueue_script('nuvvo-catalogo-hub', $uri . '/scripts/catalogo-hub.js', ['swiper', 'nuvvo-main'], $ver('/scripts/catalogo-hub.js'), true);
    }
    if (is_page('blog') || is_home()) {
        wp_enqueue_script('nuvvo-blog-listagem', $uri . '/scripts/blog-listagem.js', ['nuvvo-main'], $ver('/scripts/blog-listagem.js'), true);
    }

    /* -------- Dados PHP -> JS -------- */
    wp_localize_script('nuvvo-main', 'NUVVO', [
        'homeUrl'  => home_url('/'),
        'themeUri' => $uri,
        'whatsapp' => '5554999485915',
    ]);
});

/**
 * Carrega os scripts com defer (mantém o comportamento do site estático).
 */
add_filter('script_loader_tag', function ($tag, $handle) {
    $defer = ['lenis', 'swiper', 'nuvvo-main', 'nuvvo-animations', 'nuvvo-cookies', 'nuvvo-carousels', 'nuvvo-pdp', 'nuvvo-catalogo-listagem', 'nuvvo-contato', 'nuvvo-inspire-se', 'nuvvo-catalogo-hub', 'nuvvo-blog-listagem'];
    if (in_array($handle, $defer, true) && strpos($tag, ' defer') === false) {
        $tag = str_replace(' src=', ' defer src=', $tag);
    }
    return $tag;
}, 10, 2);
