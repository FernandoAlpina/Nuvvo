<?php
/**
 * Fallback genérico do tema.
 *
 * Os templates reais vivem em template-*.php, single-*.php, taxonomy-*.php etc.,
 * cada um delegando para uma classe view (backend/project/views/*) que renderiza
 * os partials em frontend/views/. Este arquivo é só a rede de segurança do WP.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main id="main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article <?php post_class('wrap section'); ?>>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
    <?php endwhile; endif; ?>
</main>
<?php
get_footer();
