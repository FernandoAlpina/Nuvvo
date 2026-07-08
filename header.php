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
// Home: header transparente sobre o hero. Demais páginas: header fixo (claro).
$nuvvo_static_header = !is_front_page();
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
            <a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo" aria-label="Nuvvo Design — Página inicial">
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
                        <ul class="dropdown" role="menu">
                            <li><a class="dropdown__link" href="<?php echo esc_url(home_url('/catalogo/sofas/')); ?>">Sofás</a></li>
                            <li><a class="dropdown__link" href="<?php echo esc_url(home_url('/catalogo/poltronas/')); ?>">Poltronas</a></li>
                            <li><a class="dropdown__link" href="<?php echo esc_url(home_url('/catalogo/bancos/')); ?>">Bancos</a></li>
                            <li><a class="dropdown__link" href="<?php echo esc_url(home_url('/catalogo/camas/')); ?>">Camas</a></li>
                        </ul>
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
