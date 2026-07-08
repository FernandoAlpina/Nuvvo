<?php
/**
 * Carregador do framework Alpina V4 (subconjunto usado pelo tema Nuvvo).
 *
 * Carrega SÓ o necessário para entidades/campos Meta Box e renderização por views.
 * NÃO carrega o Alp_Scripts (CodyFrame), Alp_Menus (locais do Impl) nem as
 * Settings Pages/entidades base do Impl — o Nuvvo tem enqueue e nav próprios.
 *
 * Alvo PHP 8.0.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

$base = get_template_directory() . '/backend/base';

/* Utils (funções puras) */
require_once $base . '/utils/media.php';
require_once $base . '/utils/misc.php';
require_once $base . '/utils/telefone.php';
require_once $base . '/utils/share.php';
require_once $base . '/utils/cores.php';

/* Traits */
require_once $base . '/traits/Alp_Metabox_Fields.php';
require_once $base . '/traits/Alp_Metabox_Specifics.php';
require_once $base . '/traits/Alp_Renderable.php';
require_once $base . '/traits/Alp_Entitable.php';

/* Helpers */
require_once $base . '/helpers/Alp_Metabox_AutoImage.php';

/* Factories */
require_once $base . '/factories/Alp_Entity.php';
require_once $base . '/factories/Alp_Metabox.php';
require_once $base . '/factories/Alp_Page_Template.php';
require_once $base . '/factories/Alp_Page.php';

/* ---- Camada do projeto: entidades (CPTs + taxonomias + campos) ---- */
$project = get_template_directory() . '/backend/project';
require_once $project . '/entities/Nuvvo_Designer.php';
require_once $project . '/entities/Nuvvo_Produto.php';
require_once $project . '/entities/Nuvvo_Inspiracao.php';

/* Campos editáveis por página (Meta Box condicionado por slug) */
require_once get_template_directory() . '/inc/page-fields.php';
