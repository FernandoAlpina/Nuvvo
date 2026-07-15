<?php
/**
 * Cabeçalho do tema Nuvvo: <head>, header/nav e abertura do <main>.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

$nuvvo_uri = get_template_directory_uri();
// Header transparente sobre o hero (como na Home) nas páginas com hero;
// header fixo/claro nas demais (post, produto, política, 404...).
$nuvvo_static_header = !(
    is_front_page()
    || is_home()
    || is_page(['a-nuvvo', 'catalogo', 'inspire-se', 'contato', 'blog'])
);
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F0EDE4">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url($nuvvo_uri); ?>/assets/img/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url($nuvvo_uri); ?>/assets/img/favicon.png">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <a class="skip-link" href="#main">Pular para o conteúdo</a>

    <!-- Barra de progresso de scroll (global) -->
    <div class="scroll-progress" aria-hidden="true"></div>

    <!-- ============ HEADER ============ -->
    <header class="site-header" role="banner"<?php echo $nuvvo_static_header ? ' data-static-header' : ''; ?>>
        <div class="wrap header__inner">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo" aria-label="Nuvvo Design Página inicial">
                <img src="<?php echo esc_url($nuvvo_uri); ?>/assets/img/logo-cream.png" alt="Nuvvo Design" class="logo-img" width="120">
                <span class="logo-text logo-text--scrolled" aria-hidden="true">nuvvo<span class="dot">.</span></span>
            </a>

            <button class="header__menu-toggle" aria-label="Abrir menu" aria-expanded="false" aria-controls="primary-nav">
                <span></span><span></span><span></span>
            </button>

            <nav id="primary-nav" class="header__nav" role="navigation" aria-label="Menu principal">
                <ul class="header__nav-list">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>" class="header__nav-link"<?php echo is_front_page() ? ' aria-current="page"' : ''; ?>>Home</a></li>

                    <li class="has-dropdown" aria-expanded="false">
                        <a href="<?php echo esc_url(home_url('/catalogo/')); ?>" class="header__nav-link">Catálogo</a>
                        <?php
                        // Mega-menu dinâmico: cards das categorias de produto (imagem editável por termo).
                        $nuvvo_cat_terms = get_terms(['taxonomy' => 'categoria_produto', 'parent' => 0, 'hide_empty' => false]);
                        if (is_wp_error($nuvvo_cat_terms)) { $nuvvo_cat_terms = []; }
                        ?>
                        <?php if ($nuvvo_cat_terms) : ?>
                        <ul class="dropdown dropdown--mega" role="menu">
                            <?php foreach ($nuvvo_cat_terms as $nuvvo_ct) :
                                $nuvvo_ct_link = get_term_link($nuvvo_ct);
                                if (is_wp_error($nuvvo_ct_link)) { continue; }
                                // Imagem do termo (term meta single image); fallback = SVG placeholder.
                                $nuvvo_ct_img = '';
                                if (function_exists('rwmb_meta')) {
                                    $nuvvo_imgs = rwmb_meta('categoria_produto_imagem', ['object_type' => 'term', 'size' => 'large'], $nuvvo_ct->term_id);
                                    if (is_array($nuvvo_imgs) && $nuvvo_imgs) {
                                        $nuvvo_first  = reset($nuvvo_imgs);
                                        $nuvvo_ct_img = is_array($nuvvo_first) ? ($nuvvo_first['url'] ?? '') : (wp_get_attachment_image_url((int) $nuvvo_first, 'large') ?: '');
                                    }
                                }
                                ?>
                            <li role="none">
                                <a href="<?php echo esc_url($nuvvo_ct_link); ?>" class="card-cat" role="menuitem">
                                    <div class="card-cat__media">
                                        <?php if ($nuvvo_ct_img) : ?>
                                        <img src="<?php echo esc_url($nuvvo_ct_img); ?>" alt="Coleção de <?php echo esc_attr($nuvvo_ct->name); ?> Nuvvo" loading="lazy" width="800" height="1000">
                                        <?php else : ?>
                                        <svg viewBox="0 0 400 500" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><rect width="400" height="500" fill="#7A6B5C"/><g opacity="0.4" fill="#F0EDE4"><rect x="120" y="180" width="160" height="220" rx="20"/><rect x="120" y="280" width="160" height="100" rx="8"/><rect x="100" y="260" width="30" height="160" rx="4"/><rect x="270" y="260" width="30" height="160" rx="4"/></g></svg>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-cat__label">
                                        <span class="card-cat__name"><?php echo esc_html($nuvvo_ct->name); ?></span>
                                        <span class="card-cat__arrow" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M7 17 17 7M10 7h7v7"/></svg></span>
                                    </div>
                                </a>
                            </li>
                            <?php endforeach; ?>
                            <li class="dropdown__item--all" role="none">
                                <a class="dropdown__link dropdown__link--all" href="<?php echo esc_url(home_url('/catalogo/')); ?>" role="menuitem">Ver catálogo</a>
                            </li>
                        </ul>
                        <?php else : ?>
                        <ul class="dropdown" role="menu">
                            <li><a class="dropdown__link" href="<?php echo esc_url(home_url('/catalogo/')); ?>" role="menuitem">Ver catálogo</a></li>
                        </ul>
                        <?php endif; ?>
                    </li>

                    <li><a href="<?php echo esc_url(home_url('/a-nuvvo/')); ?>" class="header__nav-link">A Nuvvo</a></li>
                    <li><a href="<?php echo esc_url(home_url('/inspire-se/')); ?>" class="header__nav-link">Inspire-se</a></li>
                    <li><a href="<?php echo esc_url(home_url('/blog/')); ?>" class="header__nav-link">Blog</a></li>
                    <li><a href="https://3dwarehouse.sketchup.com/user/61f45a49-50d6-41a1-8202-89e4f458c8ea" class="header__nav-link" target="_blank" rel="noopener">Blocos 3D</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contato/')); ?>" class="header__nav-link">Contato</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main id="main">
