<?php
/**
 * Seção "Big Numbers" — lê os números do painel Nuvvo (reusado na Home e em A Nuvvo).
 * Fallback: valores originais do site estático.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

$nuvvo_home_id = (int) get_option('page_on_front');
$nums = ($nuvvo_home_id && function_exists('rwmb_meta')) ? (array) rwmb_meta('nuvvo_home_big_numbers', [], $nuvvo_home_id) : [];

if (!$nums) {
    $nums = [
        ['prefixo' => '+', 'valor' => '25', 'sufixo' => 'anos', 'decimais' => '0', 'duracao' => '1600', 'label' => 'de experiência técnica no mercado de mobiliário.'],
        ['prefixo' => '+', 'valor' => '3000', 'sufixo' => '', 'decimais' => '0', 'duracao' => '2000', 'label' => 'ambientes transformados com o nosso mobiliário.'],
        ['prefixo' => '', 'valor' => '97.83', 'sufixo' => '%', 'decimais' => '2', 'duracao' => '2200', 'label' => 'de satisfação (NPS) que reflete nossa dedicação ao cliente.'],
        ['prefixo' => '+', 'valor' => '3000', 'sufixo' => '', 'decimais' => '0', 'duracao' => '2000', 'label' => 'opções de acabamentos em tecidos, texturas e cores para personalizar cada peça.'],
    ];
}
?>
<section class="big-numbers noise-bg" aria-label="Nossos números">
    <div class="wrap">
        <div class="big-numbers__grid">
            <?php foreach ($nums as $i => $n) :
                $prefixo = $n['prefixo'] ?? '';
                $valor   = $n['valor'] ?? '';
                $sufixo  = $n['sufixo'] ?? '';
                $dec     = (int) ($n['decimais'] ?? 0);
                $dur     = $n['duracao'] ?? '1800';
                $label   = $n['label'] ?? '';
                if ($valor === '') { continue; }
                $delay = $i > 0 ? ' reveal--delay-' . min($i, 4) : '';
                ?>
                <div class="big-numbers__item reveal<?php echo $delay; ?>">
                    <div class="big-numbers__num">
                        <?php if ($prefixo !== '') : ?><span class="prefix"><?php echo esc_html($prefixo); ?></span><?php endif; ?>
                        <span data-counter="<?php echo esc_attr($valor); ?>"<?php echo $dec > 0 ? ' data-decimals="' . esc_attr($dec) . '"' : ''; ?> data-duration="<?php echo esc_attr($dur); ?>">0</span>
                        <?php if ($sufixo !== '') : ?><span class="unit"><?php echo esc_html($sufixo); ?></span><?php endif; ?>
                    </div>
                    <?php if ($label !== '') : ?><p class="big-numbers__label"><?php echo esc_html($label); ?></p><?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
