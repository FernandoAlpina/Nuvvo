<?php
/**
 * Rodapé do tema Nuvvo: fecha o <main>, footer, WhatsApp flutuante e wp_footer.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

$nuvvo_uri = get_template_directory_uri();
?>
    </main><!-- #main -->

    <!-- ============ FOOTER ============ -->
    <footer class="site-footer" role="contentinfo">
        <div class="wrap">
            <div class="footer__grid">

                <div>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo" aria-label="Nuvvo Design — Página inicial" style="margin-bottom: var(--space-2); display: inline-block;">
                        <img src="<?php echo esc_url($nuvvo_uri); ?>/assets/img/logo-cream.png" alt="Nuvvo Design" class="logo-img" width="120">
                    </a>
                    <p class="footer__brand-tag">Mobiliário de alta decoração</p>
                    <a href="tel:+5554999485915" class="footer__phone">(54) 9 9948-5915</a>
                    <address class="footer__address">
                        Rua Teresa Lívia Rodigheri, 662<br>
                        Loteamento Villa Bella<br>
                        CEP 99150-000 — Marau, RS
                    </address>
                </div>

                <div>
                    <h4 class="footer__col-title">Catálogo</h4>
                    <ul class="footer__list">
                        <li><a href="<?php echo esc_url(home_url('/catalogo/sofas/')); ?>">Sofás</a></li>
                        <li><a href="<?php echo esc_url(home_url('/catalogo/poltronas/')); ?>">Poltronas</a></li>
                        <li><a href="<?php echo esc_url(home_url('/catalogo/bancos/')); ?>">Bancos</a></li>
                        <li><a href="<?php echo esc_url(home_url('/catalogo/camas/')); ?>">Camas</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer__col-title">Institucional</h4>
                    <ul class="footer__list">
                        <li><a href="<?php echo esc_url(home_url('/a-nuvvo/')); ?>">A Nuvvo</a></li>
                        <li><a href="<?php echo esc_url(home_url('/inspire-se/')); ?>">Inspire-se</a></li>
                        <li><a href="<?php echo esc_url(home_url('/blog/')); ?>">Blog</a></li>
                        <li><a href="<?php echo esc_url(home_url('/contato/')); ?>">Contato</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer__col-title">Redes sociais</h4>
                    <div class="footer__social">
                        <a href="https://www.instagram.com/nuvvo.design" target="_blank" rel="noopener" aria-label="Instagram da Nuvvo Design">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg>
                        </a>
                        <a href="https://www.facebook.com/nuvvodesign" target="_blank" rel="noopener" aria-label="Facebook da Nuvvo Design">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        </a>
                    </div>
                </div>

            </div>

            <div class="footer__bottom">
                <span>© <span data-year><?php echo esc_html(date('Y')); ?></span> Nuvvo Design by Sofá News</span>
                <a href="<?php echo esc_url(home_url('/politica-de-privacidade/')); ?>">Política de Privacidade</a>
            </div>
        </div>
    </footer>

    <!-- ============ WHATSAPP FLUTUANTE ============ -->
    <a class="wa-float"
       href="https://wa.me/5554999485915?text=Ol%C3%A1%2C%20gostaria%20de%20conhecer%20a%20Nuvvo%20Design"
       target="_blank" rel="noopener"
       aria-label="Falar com a Nuvvo no WhatsApp">
        <svg class="wa-float__icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm0 18.15h-.01c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.18 8.18 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.25 8.23zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.13-.16.24-.64.8-.79.97-.14.16-.29.18-.54.06-.25-.12-1.05-.39-1.99-1.23-.74-.66-1.23-1.48-1.38-1.72-.14-.25-.01-.38.11-.5.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43h-.48c-.16 0-.43.06-.66.31s-.86.85-.86 2.07c0 1.22.89 2.4 1.01 2.56.12.17 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.11-.22-.17-.47-.29z"/>
        </svg>
        <span class="wa-float__text">Fale conosco</span>
    </a>

    <?php wp_footer(); ?>
</body>
</html>
