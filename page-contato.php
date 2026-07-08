<?php
/**
 * Template da página (page-contato). Fase F0: markup estático portado; vira editável (Meta Box) depois.
 * @package Nuvvo (Alpina V4)
 */
if (!defined('ABSPATH')) { exit; }
get_header();
?>

    <!-- ============ 1. HERO ============ -->
    <section class="contact-hero" aria-label="Apresentação Contato">
      <div class="wrap contact-hero__grid">

        <div class="contact-hero__content">
          <span class="eyebrow">Contato</span>
          <h1 class="contact-hero__title">Vamos transformar seu ambiente?</h1>
          <p class="contact-hero__sub">Estamos à disposição para transformar o seu projeto de interiores com mobiliário de design autoral e acabamento impecável.</p>

          <div class="contact-hero__cta">
            <a href="https://wa.me/5554999485915?text=Ol%C3%A1%2C%20gostaria%20de%20falar%20com%20um%20especialista%20da%20Nuvvo%20Design"
               class="btn btn--primary"
               target="_blank" rel="noopener noreferrer"
               aria-label="Iniciar conversa via WhatsApp com a Nuvvo Design">
              Quero falar com um especialista
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
          </div>
        </div>

        <div class="contact-hero__media">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery-3.png"
               alt="Ambiente Nuvvo Design — sofá modular em varanda com vegetação"
               loading="eager" fetchpriority="high"
               data-parallax="0.08"
               width="800" height="1000">
        </div>

      </div>
    </section>

    <!-- ============ 2. FALE COM ESPECIALISTAS (CTA gigante taupe) ============ -->
    <section class="contact-cta" aria-label="Fale com nossos especialistas">
      <div class="wrap contact-cta__inner">

        <span class="contact-cta__eyebrow reveal">Atendimento exclusivo</span>
        <h2 class="contact-cta__title reveal reveal--delay-1">Fale com nossos especialistas</h2>
        <p class="contact-cta__text reveal reveal--delay-2">Para orçamentos, dúvidas sobre medidas ou especificações técnicas, nossa equipe está pronta para atendê-lo com exclusividade via&nbsp;WhatsApp.</p>

        <a href="https://wa.me/5554999485915?text=Ol%C3%A1%2C%20gostaria%20de%20falar%20com%20um%20especialista%20da%20Nuvvo%20Design"
           class="btn btn--cream reveal reveal--delay-3"
           target="_blank" rel="noopener noreferrer"
           aria-label="Iniciar conversa via WhatsApp com a Nuvvo Design">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm0 18.15h-.01c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.18 8.18 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.25 8.23zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.13-.16.24-.64.8-.79.97-.14.16-.29.18-.54.06-.25-.12-1.05-.39-1.99-1.23-.74-.66-1.23-1.48-1.38-1.72-.14-.25-.01-.38.11-.5.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43h-.48c-.16 0-.43.06-.66.31s-.86.85-.86 2.07c0 1.22.89 2.4 1.01 2.56.12.17 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.11-.22-.17-.47-.29z"/>
          </svg>
          Quero falar com um especialista
        </a>

        <!-- Canais alternativos discretos -->
        <div class="contact-cards reveal reveal--delay-4">

          <a class="contact-card"
             href="https://wa.me/5554999485915"
             target="_blank" rel="noopener noreferrer"
             aria-label="WhatsApp: (54) 9 9948-5915">
            <svg class="contact-card__icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm0 18.15h-.01c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.18 8.18 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.25 8.23zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.13-.16.24-.64.8-.79.97-.14.16-.29.18-.54.06-.25-.12-1.05-.39-1.99-1.23-.74-.66-1.23-1.48-1.38-1.72-.14-.25-.01-.38.11-.5.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43h-.48c-.16 0-.43.06-.66.31s-.86.85-.86 2.07c0 1.22.89 2.4 1.01 2.56.12.17 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.11-.22-.17-.47-.29z"/>
            </svg>
            <div>
              <span class="contact-card__label">WhatsApp</span>
              <span class="contact-card__value">(54) 9 9948-5915</span>
            </div>
          </a>

          <a class="contact-card"
             href="https://www.instagram.com/nuvvo.design"
             target="_blank" rel="noopener noreferrer"
             aria-label="Instagram @nuvvo.design">
            <svg class="contact-card__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
              <rect x="3" y="3" width="18" height="18" rx="5"/>
              <circle cx="12" cy="12" r="4"/>
              <circle cx="17.5" cy="6.5" r="1" fill="currentColor"/>
            </svg>
            <div>
              <span class="contact-card__label">Instagram</span>
              <span class="contact-card__value">@nuvvo.design</span>
            </div>
          </a>

          <a class="contact-card"
             href="tel:+5554999485915"
             aria-label="Ligar: (54) 9 9948-5915">
            <svg class="contact-card__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
              <path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.6A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1.2.3 2.3.6 3.4a2 2 0 0 1-.5 2L8 10.4a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2-.5c1.1.4 2.2.6 3.4.6a2 2 0 0 1 1.7 2z"/>
            </svg>
            <div>
              <span class="contact-card__label">Telefone</span>
              <span class="contact-card__value">(54) 9 9948-5915</span>
            </div>
          </a>

        </div>
      </div>
    </section>

    <!-- ============ 3. VISITE O STUDIO ============ -->
    <section class="section studio-section" aria-label="Visite nosso Studio">
      <div class="wrap">

        <div class="studio-grid">

          <!-- Galeria placeholder (até fotos do showroom Marau chegarem) -->
          <div class="studio-gallery reveal" aria-label="Galeria do Studio — em breve">

            <div class="studio-gallery__item">
              <svg viewBox="0 0 400 500" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <rect width="400" height="500" fill="#E8E3D6"/>
                <g opacity="0.45" fill="#9F8D7A">
                  <rect x="40" y="200" width="320" height="220" rx="6"/>
                  <rect x="40" y="100" width="320" height="80" rx="6"/>
                </g>
                <g opacity="0.6" fill="#7A6B5C">
                  <rect x="60" y="280" width="280" height="100" rx="4"/>
                </g>
              </svg>
              <span class="studio-gallery__item-label">[ Studio Nuvvo · em breve ]</span>
            </div>

            <div class="studio-gallery__item">
              <svg viewBox="0 0 200 200" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <rect width="200" height="200" fill="#9F8D7A"/>
                <g opacity="0.35" fill="#F0EDE4"><circle cx="100" cy="100" r="60"/></g>
              </svg>
            </div>

            <div class="studio-gallery__item">
              <svg viewBox="0 0 200 200" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <rect width="200" height="200" fill="#C4B6A5"/>
                <g opacity="0.55" fill="#1A1A1A"><rect x="40" y="100" width="120" height="40" rx="4"/></g>
              </svg>
            </div>

          </div>

          <!-- Endereço + ações -->
          <div class="studio-content reveal reveal--delay-1">
            <span class="eyebrow">Studio Marau</span>
            <h2 class="section-title">Visite nosso Studio</h2>
            <p class="lede">Recebemos profissionais e clientes em nosso espaço em Marau/RS. Agende uma visita para conhecer de perto a qualidade de nossa matéria-prima e os detalhes da nossa produção artesanal.</p>

            <div class="address-block" style="margin-top: var(--space-5);">
              <div class="address-block__line">
                <svg class="address-block__pin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                  <path d="M12 22s-7-7-7-13a7 7 0 0 1 14 0c0 6-7 13-7 13z"/>
                  <circle cx="12" cy="9" r="2.5"/>
                </svg>
                <address style="font-style: normal;">
                  Rua Teresa Lívia Rodigheri, 662<br>
                  Loteamento Villa Bella<br>
                  CEP 99150-000 — Marau, RS
                </address>
              </div>

              <div class="address-block__actions">
                <a href="https://maps.app.goo.gl/Xj9uriA4ccVWK1q89"
                   class="btn btn--primary"
                   target="_blank" rel="noopener noreferrer"
                   aria-label="Abrir endereço no Google Maps (nova aba)">
                  Como chegar
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M7 17 17 7M10 7h7v7"/></svg>
                </a>

                <button type="button"
                        class="btn btn--secondary address-block__copy-btn"
                        data-copy-address="Rua Teresa Lívia Rodigheri, 662, Loteamento Villa Bella, Marau – RS, CEP 99150-000">
                  Copiar endereço
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <rect x="9" y="9" width="12" height="12" rx="2"/>
                    <path d="M5 15V5a2 2 0 0 1 2-2h10"/>
                  </svg>
                </button>

                <span class="address-block__copy-feedback" role="status" aria-live="polite">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" width="16" height="16">
                    <path d="M20 6 9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  Copiado
                </span>
              </div>
            </div>
          </div>

        </div>

        <!-- Mapa lazy load LGPD-friendly -->
        <div class="studio-section__map-wrapper reveal reveal--delay-2">
          <div class="map-block"
               data-map-src="https://www.google.com/maps?q=Rua+Teresa+L%C3%ADvia+Rodigheri,+662,+Marau+-+RS&output=embed">
            <div class="map-block__placeholder" role="button" tabindex="0"
                 aria-label="Carregar mapa interativo do Studio Nuvvo (Google Maps)">
              <span class="map-block__placeholder-text">
                Clique para carregar o mapa interativo<br>
                <small style="opacity:0.7; font-size: 0.6875rem;">Cookies do Google Maps serão ativados</small>
              </span>
              <span class="btn btn--primary" aria-hidden="true" style="pointer-events: none;">
                Carregar mapa
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
              </span>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- ============ 4. REDES SOCIAIS ============ -->
    <section class="section social-section" aria-label="Redes sociais">
      <div class="wrap">
        <span class="eyebrow" style="justify-content:center;">Acompanhe</span>
        <h2 class="section-title section-title--center">Acompanhe nosso dia a dia</h2>
        <p class="social-section__sub">Bastidores da nossa produção artesanal, novos lançamentos e ambientes assinados — direto no nosso Instagram.</p>

        <nav class="social-big" aria-label="Redes sociais da Nuvvo Design">

          <a href="https://www.instagram.com/nuvvo.design"
             class="social-big__link"
             target="_blank" rel="noopener noreferrer"
             aria-label="Instagram @nuvvo.design (nova aba)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
              <rect x="3" y="3" width="18" height="18" rx="5"/>
              <circle cx="12" cy="12" r="4"/>
              <circle cx="17.5" cy="6.5" r="1" fill="currentColor"/>
            </svg>
          </a>

          <a href="https://www.facebook.com/nuvvodesign"
             class="social-big__link"
             target="_blank" rel="noopener noreferrer"
             aria-label="Facebook Nuvvo Design (nova aba)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
              <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
            </svg>
          </a>

          <!-- Habilitar quando cliente fornecer outros perfis:
          <a href="https://linkedin.com/company/..." class="social-big__link" ...><svg>LinkedIn</svg></a>
          <a href="https://youtube.com/@..."        class="social-big__link" ...><svg>YouTube</svg></a>
          -->

        </nav>
      </div>
    </section>

<?php
get_footer();
