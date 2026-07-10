<?php
/**
 * Entidade Produto (CPT `produto`) + taxonomia `categoria_produto`
 * (hierárquica: categorias e subcategorias).
 *
 * Cobre os requisitos da PDP: hero, designer (vazio => Nuvvo Signature),
 * storytelling, galeria com proporção por item, dimensões + configurador de
 * módulos (com imagem), downloads (PDF/SKP), produtos relacionados.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

class Nuvvo_Produto
{
    use Alp_Entitable;

    public function __construct($id = 0)
    {
        $this->id = $id;
    }

    public static function setup(): void
    {
        self::$entity = (new Alp_Entity())
            ->create_post_type('Produto', 'Produtos', 'produto', false, 'store', true, true, [
                'has_archive' => false,
                'supports'    => ['title', 'thumbnail', 'page-attributes'],
            ])
            // Categoria (pais: Sofás/Poltronas/Bancos/Camas) e subcategoria (termos-filho).
            ->create_taxonomy('Categoria', 'categoria_produto', [
                'hierarchical' => true,
                'rewrite'      => ['slug' => 'catalogo', 'hierarchical' => true, 'with_front' => false],
            ]);

        self::create_metaboxes();
    }

    public static function create_metaboxes(): void
    {
        self::$entity->create_metaboxes()

            /* ---- Hero / dados principais ---- */
            ->add_metabox_box('', 'DADOS DO PRODUTO')
            ->add_metabox_field_cpt('Designer', 'designer', 'designer', 1, 6, ['desc' => 'Vazio = exibe a versão "Nuvvo Signature".'])
            ->add_metabox_field_switch('Selo "Nuvvo Signature"', 'signature', 6)
            ->add_metabox_field_switch('Selo designer', 'selo_designer', 6)
            ->add_metabox_field_text('Texto do selo designer', 'selo_tag', 6, [
                'desc'        => 'Rótulo do badge quando o "Selo designer" está ligado (o nome ainda pode mudar). Se vazio, usa "Designer".',
                'placeholder' => 'Ex.: Assinado, Autoral…',
            ])
            ->add_metabox_field_textarea('Lede (resumo do topo)', 'lede', 12, ['rows' => 3])
            ->add_metabox_field_text('Chips (destaques)', 'chips', 12, ['clone' => true, 'sort_clone' => true, 'desc' => 'Um por item. Ex.: "4 medidas disponíveis".'])
            ->add_metabox_field_image('Imagens do topo (hero)', 'hero_imagens', 6, 12, 'Recomendado: 1200×1500px (retrato) ou 1600×1200px (paisagem), JPG.')
            ->add_metabox_field_switch('Produto "em breve" (card sem PDP)', 'em_breve', 6)
            ->add_metabox_field_switch('Destacar na Home', 'destaque_home', 6)

            /* ---- Storytelling ---- */
            ->add_metabox_box('', 'STORYTELLING')
            ->add_metabox_field_biu('Texto', 'story_texto', 12)

            /* ---- Galeria editorial (proporção por item) ---- */
            ->add_metabox_box('', 'GALERIA EDITORIAL')
            ->add_metabox_group('Imagens', 'galeria', 'Imagem {#}', -1, 12, ['default_state' => 'expanded'])
            ->add_metabox_field_image('Imagem', 'imagem', 1, 6, 'Recomendado: 1200×1500px. A proporção real vem do arquivo; escolha a posição no grid ao lado.')
            ->add_metabox_field_select('Proporção', 'proporcao', [
                ''      => 'Padrão (1x1)',
                'first' => 'Destaque grande (2x2)',
                'wide'  => 'Larga (2 colunas)',
                'tall'  => 'Alta (vertical)',
            ], 6)
            ->close_metabox_group()

            /* ---- Dimensões e configurador de módulos ---- */
            ->add_metabox_box('', 'DIMENSÕES E CONFIGURADOR')
            ->add_metabox_field_image('Desenho técnico (imagem/SVG)', 'desenho', 1, 12, 'Recomendado: PNG/SVG com fundo transparente, ~1000×750px.')
            ->add_metabox_group('Dimensões gerais', 'dimensoes', '{rotulo}', -1, 12)
            ->add_metabox_field_text('Rótulo', 'rotulo', 6)
            ->add_metabox_field_text('Valor', 'valor', 6)
            ->close_metabox_group()
            ->add_metabox_group('Módulos (configurador)', 'modulos', '{label}', -1, 12)
            ->add_metabox_field_text('Rótulo (ex.: 190 cm)', 'label', 4)
            ->add_metabox_field_number('Largura (cm)', 'largura', 4, 0, 9999, 1)
            ->add_metabox_field_image('Imagem', 'imagem', 1, 4, 'Recomendado: 1200×900px.')
            ->add_metabox_field_textarea('Descrição', 'descricao', 12, ['rows' => 2])
            ->close_metabox_group()
            ->add_metabox_field_biu('Extras (ex.: mesa lateral opcional)', 'extras', 12)

            /* ---- Downloads ---- */
            ->add_metabox_box('', 'DOWNLOADS')
            ->add_metabox_field_file('Ficha técnica (PDF)', 'ficha_pdf', 1, 6)
            ->add_metabox_field_file('Bloco SketchUp (.skp)', 'bloco_skp', 1, 6, 'Se vazio, o botão fica como "em breve".')

            /* ---- Relacionados ---- */
            ->add_metabox_box('', 'PRODUTOS RELACIONADOS')
            ->add_metabox_field_cpt('Peças relacionadas', 'relacionados', 'produto', 12, 12, ['desc' => 'Se vazio, a seção não aparece.'])

            ->render();

        // Imagem por categoria (term meta) — usada nos cards de categoria.
        self::$entity->create_taxonomy_metaboxes('categoria_produto')
            ->add_metabox_box('', 'IMAGEM DA CATEGORIA')
            ->add_metabox_field_image('Imagem', 'imagem', 1, 12, 'Recomendado: 800×600px. Aparece nos cards de categoria (Home e Catálogo).')
            ->render();
    }

    public function get_post_metas_values(string $prefix = '', array|false $autoimage = []): array
    {
        return $this->get_metaboxes()->get_post_metas_values($this->id, $prefix, $autoimage);
    }
}

add_action('after_setup_theme', ['Nuvvo_Produto', 'setup']);
