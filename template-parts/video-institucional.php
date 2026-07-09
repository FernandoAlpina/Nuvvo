<?php
/**
 * Seção de vídeo institucional (compartilhada por Home e A Nuvvo).
 * Mantém o markup/classes do site aprovado; o player é injetado por scripts/main.js
 * ao clicar (lazy-load, LGPD-friendly).
 *
 * Espera $args:
 *   - exibir  (bool)   liga/desliga a seção inteira
 *   - eyebrow (string) rótulo acima do título
 *   - titulo  (string) título da seção
 *   - src     (string) URL final (embed do YouTube/Vimeo ou arquivo MP4); vazio = "em breve"
 *   - type    (string) 'iframe' | 'mp4'
 *   - poster  (string) URL da imagem de capa
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

$v = wp_parse_args($args ?? [], [
    'exibir'  => true,
    'eyebrow' => 'Conheça por dentro',
    'titulo'  => 'Bastidores e processo',
    'src'     => '',
    'type'    => 'iframe',
    'poster'  => '',
]);

if (!$v['exibir']) {
    return;
}

$has_video = ($v['src'] !== '');
$poster    = $v['poster'] !== '' ? $v['poster'] : (get_template_directory_uri() . '/assets/img/hero-1.png');
$type      = in_array($v['type'], ['iframe', 'mp4'], true) ? $v['type'] : 'iframe';
?>

    <!-- ============ VÍDEO INSTITUCIONAL ============ -->
    <section class="section video-section" data-video-available="true" aria-label="Vídeo institucional">
      <div class="wrap">
        <?php if ($v['eyebrow'] !== '' || $v['titulo'] !== '') : ?>
        <header class="reveal" style="text-align:center; margin-bottom: var(--space-5);">
          <?php if ($v['eyebrow'] !== '') : ?>
          <span class="eyebrow" style="justify-content:center;"><?php echo esc_html($v['eyebrow']); ?></span>
          <?php endif; ?>
          <?php if ($v['titulo'] !== '') : ?>
          <h2 class="section-title section-title--center"><?php echo esc_html($v['titulo']); ?></h2>
          <?php endif; ?>
        </header>
        <?php endif; ?>

        <button
          type="button"
          class="video-block reveal reveal--delay-1"
          data-video-src="<?php echo $has_video ? esc_url($v['src']) : ''; ?>"
          data-video-type="<?php echo esc_attr($type); ?>"
          data-video-poster="<?php echo esc_url($poster); ?>"
          aria-label="<?php echo $has_video ? esc_attr('Assistir vídeo institucional da Nuvvo Design') : esc_attr('Vídeo institucional em breve'); ?>">
          <img class="video-block__poster" src="<?php echo esc_url($poster); ?>" alt="" aria-hidden="true">
          <span class="video-block__play" aria-hidden="true"></span>
          <span class="video-block__label"><?php echo $has_video ? 'Assistir vídeo' : 'Vídeo institucional em breve'; ?></span>
        </button>
      </div>
    </section>
