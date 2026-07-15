<?php
/**
 * Template da página (page-politica-privacidade). F1.3: hero e corpo editáveis (Meta Box) com fallback no texto atual.
 * @package Nuvvo (Alpina V4)
 */
if (!defined('ABSPATH')) { exit; }
get_header();
?>

    <!-- ============ HERO ============ -->
    <section class="policy-hero" aria-label="Política de Privacidade">
      <div class="wrap">
        <h1 class="policy-hero__title"><?php echo esc_html(nuvvo_pgf('nuvvo_politica_hero_titulo', 'Política de Privacidade')); ?></h1>
        <p class="policy-hero__updated"><?php echo esc_html(nuvvo_pgf('nuvvo_politica_hero_atualizacao', 'Última atualização: 26 de maio de 2026')); ?></p>
      </div>
    </section>

    <!-- ============ LAYOUT PRINCIPAL ============ -->
    <div class="wrap">
      <div class="policy-layout">

        <!-- SUMÁRIO desktop sticky -->
        <aside class="policy-layout__toc">
          <nav class="toc-nav" aria-label="Sumário da política de privacidade">
            <p class="toc-nav__title">Sumário</p>
            <ol class="toc-nav__list">
              <li><a class="toc-nav__link" href="#introducao">1. Introdução</a></li>
              <li><a class="toc-nav__link" href="#dados-coletados">2. Dados que coletamos</a></li>
              <li><a class="toc-nav__link" href="#finalidade">3. Finalidade do tratamento</a></li>
              <li><a class="toc-nav__link" href="#compartilhamento">4. Compartilhamento de dados</a></li>
              <li><a class="toc-nav__link" href="#cookies">5. Cookies e tecnologias similares</a></li>
              <li><a class="toc-nav__link" href="#retencao">6. Retenção de dados</a></li>
              <li><a class="toc-nav__link" href="#direitos">7. Seus direitos como titular</a></li>
              <li><a class="toc-nav__link" href="#seguranca">8. Segurança dos dados</a></li>
              <li><a class="toc-nav__link" href="#encarregado">9. Encarregado de Dados (DPO)</a></li>
              <li><a class="toc-nav__link" href="#alteracoes">10. Alterações nesta política</a></li>
              <li><a class="toc-nav__link" href="#contato">11. Contato</a></li>
            </ol>
          </nav>
        </aside>

        <!-- SUMÁRIO mobile accordion -->
        <details class="policy-layout__toc-mobile toc-nav toc-nav--mobile">
          <summary>Sumário</summary>
          <ol class="toc-nav__list">
            <li><a class="toc-nav__link" href="#introducao">1. Introdução</a></li>
            <li><a class="toc-nav__link" href="#dados-coletados">2. Dados que coletamos</a></li>
            <li><a class="toc-nav__link" href="#finalidade">3. Finalidade do tratamento</a></li>
            <li><a class="toc-nav__link" href="#compartilhamento">4. Compartilhamento de dados</a></li>
            <li><a class="toc-nav__link" href="#cookies">5. Cookies e tecnologias similares</a></li>
            <li><a class="toc-nav__link" href="#retencao">6. Retenção de dados</a></li>
            <li><a class="toc-nav__link" href="#direitos">7. Seus direitos como titular</a></li>
            <li><a class="toc-nav__link" href="#seguranca">8. Segurança dos dados</a></li>
            <li><a class="toc-nav__link" href="#encarregado">9. Encarregado de Dados (DPO)</a></li>
            <li><a class="toc-nav__link" href="#alteracoes">10. Alterações nesta política</a></li>
            <li><a class="toc-nav__link" href="#contato">11. Contato</a></li>
          </ol>
        </details>

        <!-- CORPO -->
        <div class="policy-body">

          <?php
          // Corpo editável (Meta Box wysiwyg) com fallback no texto atual.
          $pol_corpo = function_exists('rwmb_meta') ? rwmb_meta('nuvvo_politica_corpo', [], get_the_ID()) : '';
          if ($pol_corpo) :
              echo wp_kses_post($pol_corpo);
          else : ?>

          <section id="introducao">
            <h2><span class="policy-body__num">01</span>Introdução</h2>
            <p>A Nuvvo Design, marca da empresa <strong>Sofa News Indústria e Comércio Ltda</strong>, com sede na Rua Teresa Lívia Rodigheri, 662, Loteamento Villa Bella, CEP 99150-000, Marau/RS, valoriza a privacidade de seus visitantes e clientes. Esta Política de Privacidade descreve como coletamos, utilizamos, armazenamos e protegemos suas informações pessoais, em conformidade com a Lei Geral de Proteção de Dados Pessoais (LGPD Lei nº 13.709/2018).</p>
            <p>Ao acessar nosso site <strong>nuvvodesign.com.br</strong> ou entrar em contato conosco por qualquer canal, você concorda com as práticas descritas neste documento.</p>
          </section>

          <section id="dados-coletados">
            <h2><span class="policy-body__num">02</span>Dados que coletamos</h2>
            <p>Coletamos diferentes categorias de dados pessoais, sempre de forma transparente e com finalidade legítima:</p>

            <h3>2.1. Dados fornecidos voluntariamente por você</h3>
            <ul>
              <li>Nome completo</li>
              <li>E-mail (quando aplicável)</li>
              <li>Telefone / WhatsApp</li>
              <li>Informações sobre projetos, preferências e necessidades enviadas durante o contato</li>
            </ul>

            <h3>2.2. Dados coletados automaticamente</h3>
            <ul>
              <li>Endereço IP</li>
              <li>Tipo de navegador e dispositivo</li>
              <li>Páginas visitadas e tempo de permanência</li>
              <li>Origem do acesso (referrer)</li>
              <li>Cookies e tecnologias similares (ver seção sobre cookies abaixo)</li>
            </ul>

            <h3>2.3. Dados de comunicação via WhatsApp</h3>
            <p>Quando você inicia uma conversa conosco via WhatsApp, recebemos as informações que você compartilha durante o atendimento. O WhatsApp possui sua própria política de privacidade, que recomendamos consultar.</p>
          </section>

          <section id="finalidade">
            <h2><span class="policy-body__num">03</span>Finalidade do tratamento</h2>
            <p>Utilizamos seus dados pessoais para:</p>
            <ul>
              <li>Responder a contatos, dúvidas e solicitações de orçamento</li>
              <li>Apresentar produtos, projetos e propostas comerciais</li>
              <li>Melhorar a experiência de navegação no site</li>
              <li>Cumprir obrigações legais e regulatórias</li>
              <li>Realizar análises estatísticas anônimas sobre o uso do site</li>
              <li>Enviar comunicações sobre lançamentos e novidades (somente com seu consentimento prévio)</li>
            </ul>
          </section>

          <section id="compartilhamento">
            <h2><span class="policy-body__num">04</span>Compartilhamento de dados</h2>
            <p>A Nuvvo Design não vende, aluga ou comercializa seus dados pessoais. Compartilhamos informações apenas nas seguintes hipóteses:</p>
            <ul>
              <li><strong>Prestadores de serviço</strong>: empresas que nos apoiam em hospedagem, e-mail, atendimento e análise de dados, sob acordos de confidencialidade.</li>
              <li><strong>Obrigação legal</strong>: quando exigido por lei, ordem judicial ou autoridade competente.</li>
              <li><strong>Parceiros estratégicos</strong>: somente com seu consentimento expresso e prévio.</li>
            </ul>
          </section>

          <section id="cookies">
            <h2><span class="policy-body__num">05</span>Cookies e tecnologias similares</h2>
            <p>Nosso site utiliza cookies para melhorar sua experiência de navegação. Cookies são pequenos arquivos armazenados no seu dispositivo que nos ajudam a entender como você utiliza o site.</p>

            <h3>5.1. Tipos de cookies utilizados</h3>
            <ul>
              <li><strong>Essenciais</strong>: necessários para o funcionamento básico do site (sempre ativos).</li>
              <li><strong>Funcionais</strong>: lembram suas preferências (ex: idioma, fontes).</li>
              <li><strong>Analíticos</strong>: ajudam a entender como os visitantes interagem com o site (ex: Google Analytics).</li>
              <li><strong>Marketing</strong>: utilizados para exibir conteúdo relevante (somente com consentimento).</li>
            </ul>

            <h3>5.2. Gerenciamento de cookies</h3>
            <p>Você pode aceitar, recusar ou personalizar o uso de cookies a qualquer momento através do nosso banner de cookies ou nas configurações do seu navegador. Para alterar suas preferências a qualquer momento, <a href="#gerenciar-cookies" data-reopen-cookies>clique aqui</a>.</p>
          </section>

          <section id="retencao">
            <h2><span class="policy-body__num">06</span>Retenção de dados</h2>
            <p>Mantemos seus dados pessoais apenas pelo tempo necessário para cumprir as finalidades descritas nesta política ou para atender a obrigações legais.</p>
            <p>Após esse período, os dados são excluídos ou anonimizados de forma segura.</p>
          </section>

          <section id="direitos">
            <h2><span class="policy-body__num">07</span>Seus direitos como titular</h2>
            <p>Conforme a LGPD, você tem direito a:</p>
            <ul>
              <li>Confirmar a existência de tratamento dos seus dados</li>
              <li>Acessar os dados que mantemos sobre você</li>
              <li>Corrigir dados incompletos, inexatos ou desatualizados</li>
              <li>Solicitar a anonimização, bloqueio ou eliminação de dados desnecessários</li>
              <li>Solicitar a portabilidade dos seus dados a outro fornecedor</li>
              <li>Eliminar dados tratados com base no seu consentimento</li>
              <li>Obter informação sobre com quem compartilhamos seus dados</li>
              <li>Revogar seu consentimento a qualquer momento</li>
            </ul>
            <p>Para exercer qualquer um destes direitos, entre em contato pelo e-mail <span class="tbd">[E-MAIL A DEFINIR]</span> ou pelo WhatsApp (54) 9 9948-5915.</p>
          </section>

          <section id="seguranca">
            <h2><span class="policy-body__num">08</span>Segurança dos dados</h2>
            <p>Adotamos medidas técnicas e organizacionais para proteger seus dados pessoais contra acessos não autorizados, perda, alteração ou destruição. Entre as medidas implementadas estão:</p>
            <ul>
              <li>Criptografia de dados em trânsito (HTTPS)</li>
              <li>Controle de acesso restrito a pessoas autorizadas</li>
              <li>Backups regulares</li>
              <li>Treinamento contínuo da equipe sobre proteção de dados</li>
            </ul>
            <p>Apesar de todos os esforços, nenhuma transmissão pela internet é 100% segura. Recomendamos que você também adote boas práticas, como senhas fortes e cuidado com phishing.</p>
          </section>

          <section id="encarregado">
            <h2><span class="policy-body__num">09</span>Encarregado de Dados (DPO)</h2>
            <p>Nosso Encarregado pelo Tratamento de Dados Pessoais (DPO) é o canal oficial para receber comunicações sobre proteção de dados.</p>
            <dl class="policy-body__dl">
              <dt>Nome</dt>
              <dd><span class="tbd">[NOME A DEFINIR]</span></dd>
              <dt>E-mail</dt>
              <dd><span class="tbd">[E-MAIL A DEFINIR]</span></dd>
              <dt>Telefone</dt>
              <dd>(54) 9 9948-5915</dd>
            </dl>
          </section>

          <section id="alteracoes">
            <h2><span class="policy-body__num">10</span>Alterações nesta política</h2>
            <p>Esta Política de Privacidade pode ser atualizada periodicamente para refletir mudanças em nossas práticas ou em legislações aplicáveis. A versão mais recente sempre estará disponível nesta página, com a data de atualização indicada no topo.</p>
            <p>Recomendamos que você revise esta política periodicamente.</p>
          </section>

          <section id="contato">
            <h2><span class="policy-body__num">11</span>Contato</h2>
            <p>Para qualquer dúvida sobre esta Política de Privacidade ou sobre o tratamento de seus dados pessoais, entre em contato:</p>
            <ul>
              <li><strong>WhatsApp</strong>: (54) 9 9948-5915</li>
              <li><strong>E-mail</strong>: <span class="tbd">[E-MAIL A DEFINIR]</span></li>
              <li><strong>Endereço</strong>: Rua Teresa Lívia Rodigheri, 662, Loteamento Villa Bella, Marau/RS, CEP 99150-000</li>
            </ul>
          </section>
          <?php endif; ?>

          <!-- ============ BLOCO GERENCIAR COOKIES ============ -->
          <aside class="manage-cookies" id="gerenciar-cookies">
            <h3 class="manage-cookies__title">Gerenciar preferências de cookies</h3>
            <p class="manage-cookies__text">Você pode revisar e atualizar suas preferências de cookies a qualquer momento.</p>
            <button type="button" class="btn btn--primary" data-reopen-cookies>
              Abrir preferências de cookies
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>
          </aside>

        </div>
      </div>
    </div>

<?php
get_footer();
