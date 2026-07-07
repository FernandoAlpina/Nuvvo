<?php

/**
 * Esta função gera URL da API do WhatsApp.
 * @param string $numero Número do telefone.
 * @param int|string|bool $codigo_pais Código do país a ser colocado no número. Padrão = 55, Brasil. Falso se não for necessário por já estar no número.
 * @param string $texto_entrada Texto de início da conversa do WhatsApp.
 * @return string URL já formatada para iniciar a conversa.
 */
function get_whats_api_url(int|string $numero, int|string|bool $codigo_pais = 55, $texto_entrada = 'Oi, tudo bem?'): string
{
    $numero = get_sanitized_phone($numero, $codigo_pais);
    $texto_entrada = htmlentities($texto_entrada);

    return "https://api.whatsapp.com/send?phone={$numero}&text={$texto_entrada}";
}

/**
 * Esta função gera URL de telefone
 * @param string $numero Número do telefone.
 * @param int|string|bool $codigo_pais Código do país a ser colocado no número. Padrão = 55, Brasil. Falso se não for necessário por já estar no número.
 * @return string URL já formatada iniciada pelo protocolo tel.
 */
function get_tel_url(int|string $numero, int|string|bool $codigo_pais = 55): string
{
    $numero = get_sanitized_phone($numero, $codigo_pais);
    return "tel:{$numero}";
}

/**
 * Retorna um número de telefone sem os caracteres especiais.
 * @param int|string $numero Número do telefone.
 * @param int|string|bool $codigo_pais Código do país a ser colocado no número. Padrão = 55, Brasil. Falso se não for necessário por já estar no número.
 * @return string Número de telefone sem caracteres especiais.
 */
function get_sanitized_phone(int|string $numero, int|string|bool $codigo_pais = 55): string
{
    $numero = preg_replace("/[^0-9]/", "", $numero);
    if ($codigo_pais) $codigo_pais = preg_replace("/[^0-9]/", "", $codigo_pais);
    else $codigo_pais = "";

    return $codigo_pais . $numero;
}
