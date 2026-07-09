<?php
/**
 * Vídeo institucional: helpers para converter links (YouTube/Vimeo) em embeds
 * e resolver a fonte do vídeo (link ou arquivo MP4) de cada página.
 *
 * @package Nuvvo (Alpina V4)
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Converte um link de YouTube/Vimeo em uma URL embutível (iframe).
 * Se já for embutível ou desconhecida, devolve como veio.
 * Usa youtube-nocookie por padrão (mais amigável à LGPD).
 */
function nuvvo_video_embed_url(string $url): string
{
    $url = trim($url);
    if ($url === '') {
        return '';
    }

    // YouTube: watch?v=ID, youtu.be/ID, /embed/ID, /shorts/ID, /live/ID, /v/ID
    if (preg_match('~(?:youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/|v/)|youtu\.be/)([A-Za-z0-9_-]{11})~i', $url, $m)) {
        return 'https://www.youtube-nocookie.com/embed/' . $m[1] . '?rel=0';
    }

    // Vimeo: vimeo.com/ID, player.vimeo.com/video/ID e não-listados (hash /ID/HASH ou ?h=HASH)
    if (preg_match('~vimeo\.com/(?:video/)?(\d+)(?:/([A-Za-z0-9]+))?~i', $url, $m)) {
        $embed = 'https://player.vimeo.com/video/' . $m[1];
        $hash  = $m[2] ?? '';
        if ($hash === '' && preg_match('~[?&]h=([A-Za-z0-9]+)~i', $url, $hm)) {
            $hash = $hm[1];
        }
        if ($hash !== '') {
            $embed .= '?h=' . $hash;
        }
        return $embed;
    }

    // Desconhecida: assume que o próprio link já é embutível.
    return $url;
}

/**
 * Extrai a URL de um arquivo a partir do valor de um campo de mídia do Meta Box
 * (aceita array de arrays com 'url'/'src', array de IDs ou ID escalar).
 */
function nuvvo_attachment_url_from_meta($value): string
{
    if (empty($value)) {
        return '';
    }
    if (is_array($value)) {
        $first = reset($value);
        if (is_array($first)) {
            if (!empty($first['url'])) {
                return (string) $first['url'];
            }
            if (!empty($first['src'])) {
                return (string) $first['src'];
            }
            if (!empty($first['ID'])) {
                $url = wp_get_attachment_url((int) $first['ID']);
                return $url ? (string) $url : '';
            }
            return '';
        }
        $value = $first; // array de IDs -> primeiro ID
    }
    if (is_numeric($value)) {
        $url = wp_get_attachment_url((int) $value);
        return $url ? (string) $url : '';
    }
    return is_string($value) ? $value : '';
}

/**
 * Resolve a fonte do vídeo de uma página: prioriza o link (YouTube/Vimeo);
 * na ausência dele, usa o arquivo MP4 enviado.
 *
 * @return array{src:string,type:string} type = 'iframe' | 'mp4' | ''
 */
function nuvvo_video_source(string $url_field, string $mp4_field, int $post_id): array
{
    if (!$post_id || !function_exists('rwmb_meta')) {
        return ['src' => '', 'type' => ''];
    }

    // 1) Link externo (YouTube/Vimeo) — prioridade.
    $raw_url = rwmb_meta($url_field, [], $post_id);
    if (is_array($raw_url)) {
        $raw_url = reset($raw_url);
    }
    $raw_url = is_string($raw_url) ? trim($raw_url) : '';
    if ($raw_url !== '') {
        $embed = nuvvo_video_embed_url($raw_url);
        if ($embed !== '') {
            return ['src' => $embed, 'type' => 'iframe'];
        }
    }

    // 2) Arquivo MP4 enviado.
    $mp4_url = nuvvo_attachment_url_from_meta(rwmb_meta($mp4_field, [], $post_id));
    if ($mp4_url !== '') {
        return ['src' => $mp4_url, 'type' => 'mp4'];
    }

    return ['src' => '', 'type' => ''];
}
