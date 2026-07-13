<?php
/**
 * Seed de conteúdo (uma vez): popula os campos das páginas Home, A Nuvvo e
 * Contato + as opções globais com o conteúdo aprovado do site, para que apareçam
 * já preenchidos no wp-admin.
 *
 * Seguro: só grava campos VAZIOS (não sobrescreve o que já foi editado) e roda
 * uma única vez (flag de opção). Não cadastra produtos/blog/depoimentos nem mídia.
 *
 * Mesmo mecanismo do inc/setup-pages.php.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Um valor de campo é "vazio" se for '', null, false, array vazio OU um array
 * cujos leaves são todos vazios (ex.: linha de clone em branco salva pelo editor).
 */
if (!function_exists('nuvvo_meta_is_empty')) {
    function nuvvo_meta_is_empty($v): bool
    {
        if ($v === '' || $v === null || $v === false) {
            return true;
        }
        if (is_array($v)) {
            foreach ($v as $item) {
                if (!nuvvo_meta_is_empty($item)) {
                    return false;
                }
            }
            return true;
        }
        return trim((string) $v) === '';
    }
}

add_action('init', function () {
    $flag = 'nuvvo_seed_content_v4';
    if (get_option($flag)) {
        return;
    }

    $home_id     = (int) get_option('page_on_front');
    $anuvvo_pg   = get_page_by_path('a-nuvvo');
    $contato_pg  = get_page_by_path('contato');
    $catalogo_pg = get_page_by_path('catalogo');
    if (!$home_id || !$anuvvo_pg || !$contato_pg || !$catalogo_pg) {
        return; // páginas ainda não provisionadas; tenta no próximo carregamento
    }
    $anuvvo_id   = (int) $anuvvo_pg->ID;
    $contato_id  = (int) $contato_pg->ID;
    $catalogo_id = (int) $catalogo_pg->ID;

    $count = 0;

    // Grava um meta de página só se estiver vazio.
    $set_meta = function (int $pid, string $key, $val) use (&$count) {
        if (nuvvo_meta_is_empty(get_post_meta($pid, $key, true))) {
            update_post_meta($pid, $key, $val);
            $count++;
        }
    };

    /* ---------------- Opções globais (Meta Box Settings Page) ---------------- */
    $settings = [
        'nuvvo_tagline'   => 'Mobiliário de alta decoração',
        'nuvvo_whatsapp'  => '5554999485915',
        'nuvvo_telefone'  => '(54) 9 9948-5915',
        'nuvvo_endereco'  => "Rua Teresa Lívia Rodigheri, 662\nLoteamento Villa Bella\nCEP 99150-000 — Marau, RS",
        'nuvvo_instagram' => 'https://www.instagram.com/nuvvo.design',
        'nuvvo_facebook'  => 'https://www.facebook.com/nuvvodesign',
        'nuvvo_blocos3d'  => 'https://3dwarehouse.sketchup.com/user/61f45a49-50d6-41a1-8202-89e4f458c8ea',
        'nuvvo_seo_desc'  => 'Mobiliário de alta decoração — sofás, poltronas, bancos e camas com design autoral, personalização e produção artesanal.',
    ];
    $opts = get_option('nuvvo_opcoes', []);
    if (!is_array($opts)) { $opts = []; }
    foreach ($settings as $k => $v) {
        if (nuvvo_meta_is_empty($opts[$k] ?? '')) {
            $opts[$k] = $v;
            $count++;
        }
    }
    update_option('nuvvo_opcoes', $opts);

    /* ---------------- HOME ---------------- */
    $home_fields = [
        'nuvvo_home_hero_titulo'     => 'Mobiliário personalizado de alta decoração',
        'nuvvo_home_hero_sub'        => 'Design autoral que traduz a harmonia entre o rigor da produção artesanal e a sofisticação do morar contemporâneo.',
        'nuvvo_home_hero_cta'        => 'Falar com especialista',
        'nuvvo_home_hero_cta_msg'    => 'Olá, gostaria de falar com um especialista da Nuvvo Design',
        'nuvvo_home_catalogo_sub'    => 'Explore peças desenvolvidas com alta marcenaria, produção artesanal e acabamento impecável.',
        'nuvvo_home_destaque_titulo' => 'Seleção em destaque',
        'nuvvo_home_news_titulo'     => 'Nuvvo News: dicas e tendências',
        'nuvvo_home_testi_sub'       => 'A experiência Nuvvo',
        'nuvvo_home_testi_titulo'    => 'A experiência Nuvvo',
        'nuvvo_home_cta_titulo'      => 'Vamos construir juntos espaços que inspiram?',
        'nuvvo_home_cta_lede'        => 'Deixe-se inspirar pela harmonia e conforto que o nosso design pode oferecer. Nossa equipe está pronta para te orientar.',
        'nuvvo_home_cta_btn'         => 'Falar com consultor',
        'nuvvo_home_cta_msg'         => 'Olá, gostaria de falar com um consultor da Nuvvo Design',
    ];
    foreach ($home_fields as $k => $v) { $set_meta($home_id, $k, $v); }

    $set_meta($home_id, 'nuvvo_home_pilares', [
        ['numero' => '01', 'titulo' => 'Design Exclusivo',              'texto' => 'Peças com identidade própria, assinadas e criadas para serem um convite ao bem estar, à contemplação e à celebração da vida.'],
        ['numero' => '02', 'titulo' => 'Capacidade de Personalização',  'texto' => 'Mais de 3.000 opções de cores e acabamentos, além de diversas medidas disponíveis para a especificação precisa do seu projeto.'],
        ['numero' => '03', 'titulo' => 'Acompanhamento Próximo',        'texto' => 'Atuamos lado a lado com o arquiteto em todas as etapas, da especificação técnica à entrega final.'],
    ]);

    // Big numbers: a linha de clone em branco salva pelo editor traz os defaults
    // (decimais/duracao), então checamos "vazio" pela ausência de qualquer 'valor'.
    $bn_val = [
        ['prefixo' => '+', 'valor' => '25',    'sufixo' => 'anos', 'decimais' => '0', 'duracao' => '1600', 'label' => 'de experiência técnica no mercado de mobiliário.'],
        ['prefixo' => '+', 'valor' => '3000',  'sufixo' => '',     'decimais' => '0', 'duracao' => '2000', 'label' => 'ambientes transformados com o nosso mobiliário.'],
        ['prefixo' => '',  'valor' => '97.83', 'sufixo' => '%',    'decimais' => '2', 'duracao' => '2200', 'label' => 'de satisfação (NPS) que reflete nossa dedicação ao cliente.'],
        ['prefixo' => '+', 'valor' => '3000',  'sufixo' => '',     'decimais' => '0', 'duracao' => '2000', 'label' => 'opções de acabamentos em tecidos, texturas e cores para personalizar cada peça.'],
    ];
    $bn_cur = get_post_meta($home_id, 'nuvvo_home_big_numbers', true);
    $bn_has = false;
    if (is_array($bn_cur)) {
        foreach ($bn_cur as $bn_row) {
            if (is_array($bn_row) && isset($bn_row['valor']) && trim((string) $bn_row['valor']) !== '') {
                $bn_has = true;
                break;
            }
        }
    }
    if (!$bn_has) {
        update_post_meta($home_id, 'nuvvo_home_big_numbers', $bn_val);
        $count++;
    }

    /* ---------------- A NUVVO ---------------- */
    $essencia = <<<'HTML'
<p>A trajetória de mais de <strong>25 anos de história</strong>, iniciada pela Sofá News em 2000, é a base sólida que nos move. Construímos uma reputação através do <strong>trabalho artesanal na alta decoração</strong>, com cada peça cuidadosamente desenvolvida a partir de <strong>matéria-prima selecionada</strong> e processos rigorosos.</p>

<p>Hoje, essa herança ganha novo capítulo: a Nuvvo Design apresenta um <strong>portfólio de mobiliário singular</strong>, com <em>design exclusivo</em> que traduz nossa visão contemporânea em peças autorais — pensadas para arquitetos e clientes que enxergam o ambiente como extensão da identidade.</p>

<p>Nossa cultura é feita de <strong>evolução contínua</strong>, <strong>zelo absoluto</strong> em cada acabamento e o compromisso com um <strong>relacionamento próximo e humano</strong> — porque entendemos que o melhor design nasce da escuta atenta.</p>
HTML;

    $designer_bio = <<<'HTML'
<p>Atuante na <em>indústria moveleira desde os anos 2000</em>, Deivid de Almeida construiu uma <strong>expertise técnica lapidada em um processo constante de evolução e refinamento</strong>. Cada peça que assina carrega o repertório de mais de duas décadas de prática.</p>

<p>Seu trabalho parte de uma obsessão silenciosa: <strong>traduzir comportamento humano em mobiliário</strong>. <em>Ergonomia</em>, <em>conforto tátil</em> e <em>perfeição técnica</em> deixam de ser exigências para se tornarem ponto de partida — porque é assim que o design se torna invisível e essencial ao mesmo tempo.</p>
HTML;

    $anuvvo_fields = [
        'nuvvo_anuvvo_hero_titulo'    => 'Uma jornada construída sobre a atenção aos detalhes',
        'nuvvo_anuvvo_hero_sub'       => 'A Nuvvo Design nasce para materializar a bagagem de duas décadas e meia de trabalho artesanal. Somos a evolução de uma trajetória dedicada à qualidade, seriedade e respeito em cada projeto executado.',
        'nuvvo_anuvvo_essencia'       => $essencia,
        'nuvvo_anuvvo_missao'         => 'Inspirar design que conecta pessoas e harmoniza ambientes exclusivos.',
        'nuvvo_anuvvo_visao'          => 'Ser referência em design de mobiliário residencial de alta decoração.',
        'nuvvo_anuvvo_designer_nome'  => 'Deivid de Almeida',
        'nuvvo_anuvvo_designer_cargo' => 'Designer assinado',
        'nuvvo_anuvvo_designer_bio'   => $designer_bio,
        'nuvvo_anuvvo_cta_titulo'     => 'Vamos construir juntos espaços que inspiram?',
        'nuvvo_anuvvo_cta_lede'       => 'Deixe-se inspirar pela harmonia e conforto que o nosso design pode oferecer. Nossa equipe está pronta para te orientar.',
        'nuvvo_anuvvo_cta_btn'        => 'Falar com consultor',
        'nuvvo_anuvvo_cta_msg'        => 'Olá, gostaria de falar com um consultor da Nuvvo Design',
    ];
    foreach ($anuvvo_fields as $k => $v) { $set_meta($anuvvo_id, $k, $v); }

    $set_meta($anuvvo_id, 'nuvvo_anuvvo_valores', ['Zelo', 'Comprometimento', 'Espírito de Equipe', 'Prestatividade', 'Confiança']);

    $set_meta($anuvvo_id, 'nuvvo_anuvvo_timeline', [
        ['ano' => '2000', 'titulo' => 'Fundação',                     'destaque' => '',  'desc' => 'O início de tudo, em um espaço de 80 m², movidos pela paixão e trabalho manual.'],
        ['ano' => '2009', 'titulo' => 'Primeira Ampliação',           'destaque' => '',  'desc' => 'O crescimento consistente nos levou a uma estrutura de 200 m².'],
        ['ano' => '2024', 'titulo' => 'Expansão Estratégica',         'destaque' => '',  'desc' => 'Consolidamos nosso parque fabril com 650 m², ampliando nossa capacidade produtiva.'],
        ['ano' => '2026', 'titulo' => 'O Nascimento da Nuvvo Design', 'destaque' => '1', 'desc' => 'O lançamento de uma marca focada no design autoral e no atendimento exclusivo ao mercado de alta decoração.'],
    ]);

    $set_meta($anuvvo_id, 'nuvvo_anuvvo_diferenciais', [
        ['icone' => 'star',    'titulo' => 'Design Exclusivo',                'texto' => 'Peças com identidade única, pensadas para expressar autenticidade em cada ambiente.',                                             'link' => 'https://wa.me/5554999485915?text=Ol%C3%A1%21%20Gostaria%20de%20saber%20mais%20sobre%20o%20Design%20Exclusivo%20da%20Nuvvo.', 'target' => '1'],
        ['icone' => 'sliders', 'titulo' => 'Personalização de acabamentos',  'texto' => 'Diversas opções de tecidos e medidas pré-definidas para adequar cada peça ao seu projeto.',                                        'link' => 'https://wa.me/5554999485915?text=Ol%C3%A1%21%20Tenho%20interesse%20na%20personaliza%C3%A7%C3%A3o%20%28medidas%20e%20acabamentos%29%20da%20Nuvvo.', 'target' => '1'],
        ['icone' => 'people',  'titulo' => 'Parceria com o arquiteto',       'texto' => 'Acompanhamento humano e próximo, garantindo suporte em todas as etapas: da especificação à entrega.',                             'link' => 'https://wa.me/5554999485915?text=Ol%C3%A1%21%20Sou%20arquiteto%28a%29%20e%20gostaria%20de%20falar%20com%20a%20equipe%20da%20Nuvvo.', 'target' => '1'],
        ['icone' => 'doc',     'titulo' => 'Praticidade na especificação',   'texto' => 'Disponibilizamos blocos 3D e fichas técnicas detalhadas para integrar nosso design ao seu projeto com precisão e agilidade.',       'link' => 'https://3dwarehouse.sketchup.com/user/61f45a49-50d6-41a1-8202-89e4f458c8ea', 'target' => '1'],
        ['icone' => 'craft',   'titulo' => 'Zelo e Produção Artesanal',      'texto' => 'Nossos estofados unem a precisão da engenharia de ponta ao cuidado rigoroso do trabalho manual, assegurando um acabamento impecável em cada processo.', 'link' => 'https://wa.me/5554999485915?text=Ol%C3%A1%21%20Gostaria%20de%20saber%20mais%20sobre%20a%20produ%C3%A7%C3%A3o%20artesanal%20da%20Nuvvo.', 'target' => '1'],
    ]);

    /* ---------------- CONTATO ---------------- */
    $contato_fields = [
        'nuvvo_contato_hero_eyebrow'   => 'Contato',
        'nuvvo_contato_hero_titulo'    => 'Vamos transformar seu ambiente?',
        'nuvvo_contato_hero_sub'       => 'Estamos à disposição para transformar o seu projeto de interiores com mobiliário de design autoral e acabamento impecável.',
        'nuvvo_contato_cta_msg'        => 'Olá, gostaria de falar com um especialista da Nuvvo Design',
        'nuvvo_contato_studio_eyebrow' => 'Studio Marau',
        'nuvvo_contato_studio_titulo'  => 'Visite nosso Studio',
        'nuvvo_contato_studio_lede'    => 'Recebemos profissionais e clientes em nosso espaço em Marau/RS. Agende uma visita para conhecer de perto a qualidade de nossa matéria-prima e os detalhes da nossa produção artesanal.',
        'nuvvo_contato_maps_link'      => 'https://maps.app.goo.gl/Xj9uriA4ccVWK1q89',
        'nuvvo_contato_map_embed'      => 'https://www.google.com/maps?q=Rua+Teresa+L%C3%ADvia+Rodigheri,+662,+Marau+-+RS&output=embed',
        'nuvvo_contato_map_lat'        => '-28.4503',
        'nuvvo_contato_map_lng'        => '-52.1989',
        'nuvvo_contato_social_titulo'  => 'Acompanhe nosso dia a dia',
        'nuvvo_contato_social_sub'     => 'Bastidores da nossa produção artesanal, novos lançamentos e ambientes assinados — direto no nosso Instagram.',
    ];
    foreach ($contato_fields as $k => $v) { $set_meta($contato_id, $k, $v); }

    /* ---------------- CATÁLOGO (hub) ---------------- */
    $catalogo_fields = [
        'nuvvo_catalogo_hero_eyebrow' => 'Catálogo',
        'nuvvo_catalogo_hero_titulo'  => 'Coleção',
        'nuvvo_catalogo_hero_sub'     => 'Mobiliário autoral concebido para projetos que pedem singularidade.',
        'nuvvo_catalogo_dif_eyebrow'  => 'Diferenciais',
        'nuvvo_catalogo_dif_titulo'   => 'A assinatura técnica da Nuvvo',
        'nuvvo_catalogo_pers_eyebrow' => 'Personalização',
        'nuvvo_catalogo_pers_titulo'  => 'Curadoria especializada',
        'nuvvo_catalogo_pers_texto'   => 'Cada peça de nossa coleção foi pensada para ser personalizada. Com diversas texturas e várias possibilidades em medidas, estamos prontos para adaptar o mobiliário Nuvvo à singularidade do seu ambiente.',
        'nuvvo_catalogo_pers_btn'     => 'Falar com consultor Nuvvo',
        'nuvvo_catalogo_pers_msg'     => 'Olá, gostaria de falar com um consultor Nuvvo',
        'nuvvo_catalogo_insp_eyebrow' => 'Inspire-se',
        'nuvvo_catalogo_insp_titulo'  => 'Ambientes assinados',
        'nuvvo_catalogo_sup_eyebrow'  => 'Para profissionais',
        'nuvvo_catalogo_sup_titulo'   => 'Suporte técnico para o seu projeto',
        'nuvvo_catalogo_sup_lede'     => 'A precisão é um dos pilares do nosso design. Oferecemos suporte completo para profissionais da arquitetura e design de interiores, disponibilizando blocos 3D, fichas técnicas detalhadas e consultoria personalizada para a especificação de cada peça.',
        'nuvvo_catalogo_sup_btn'      => 'Sou arquiteto · quero acesso aos materiais técnicos',
        'nuvvo_catalogo_sup_msg'      => 'Olá, sou arquiteto/designer e gostaria de receber materiais técnicos da Nuvvo',
        'nuvvo_catalogo_cta_titulo'   => 'Vamos transformar seu próximo projeto?',
        'nuvvo_catalogo_cta_lede'     => 'Compartilhe seu projeto conosco e nossa equipe traduzirá sua visão.',
        'nuvvo_catalogo_cta_label'    => 'Falar com especialista',
        'nuvvo_catalogo_cta_msg'      => 'Olá, gostaria de falar com um especialista da Nuvvo sobre um projeto',
    ];
    foreach ($catalogo_fields as $k => $v) { $set_meta($catalogo_id, $k, $v); }

    $set_meta($catalogo_id, 'nuvvo_catalogo_diferenciais', [
        ['titulo' => 'Design Exclusivo',         'texto' => 'Peças com identidade própria, criadas para projetos que recusam o genérico.'],
        ['titulo' => 'Curadoria de Acabamentos', 'texto' => 'Mais de 3.000 opções entre tecidos, texturas e cores, selecionadas com critério técnico e estético.'],
        ['titulo' => 'Qualidade Certificada',    'texto' => 'Espumas certificadas, madeiras nobres e processos rigorosamente controlados.'],
        ['titulo' => 'Excelência Artesanal',     'texto' => 'Cada peça é produzida com cuidado manual e atenção a cada detalhe do acabamento.'],
        ['titulo' => 'Suporte ao Arquiteto',     'texto' => 'Acompanhamento técnico próximo, com blocos 3D e fichas detalhadas para especificação precisa.'],
    ]);

    $set_meta($catalogo_id, 'nuvvo_catalogo_sup_items', [
        ['titulo' => 'Blocos 3D / 3D Warehouse', 'texto' => 'Modelos 3D prontos para integrar ao seu projeto de arquitetura.', 'link' => 'https://3dwarehouse.sketchup.com/user/61f45a49-50d6-41a1-8202-89e4f458c8ea', 'link_label' => 'Ver no 3D Warehouse'],
        ['titulo' => 'Fichas técnicas',          'texto' => 'Especificações detalhadas em PDF para download imediato.',           'link' => '', 'link_label' => ''],
        ['titulo' => 'Consultoria dedicada',     'texto' => 'Atendimento humano e próximo para especificações personalizadas.',    'link' => '', 'link_label' => ''],
    ]);

    update_option($flag, current_time('mysql'));
    error_log('[Nuvvo seed] conteúdo aplicado (' . $count . ' campos vazios preenchidos). Home=' . $home_id . ' ANuvvo=' . $anuvvo_id . ' Contato=' . $contato_id . ' Catalogo=' . $catalogo_id);
}, 99);
