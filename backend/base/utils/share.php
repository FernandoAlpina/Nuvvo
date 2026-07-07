<?php

/**
 * Funções utilitárias de compartilhamento.
 */

/**
 * Gera URL de compartilhamento para o LinkedIn.
 * @param string $url URL a ser compartilhada.
 * @return string URL pronta do LinkedIn.
 */
function get_share_url_linkedin(string $url): string
{
  return 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($url);
}

/**
 * Gera URL de compartilhamento para o Facebook.
 * @param string $url URL a ser compartilhada.
 * @return string URL pronta do Facebook.
 */
function get_share_url_facebook(string $url): string
{
  return 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url);
}

/**
 * Gera URL de compartilhamento para o X (antigo Twitter).
 * @param string $url URL a ser compartilhada.
 * @param string $texto Texto opcional a acompanhar a URL.
 * @return string URL pronta do X.
 */
function get_share_url_x(string $url, string $texto = ''): string
{
  $tweet = 'https://twitter.com/intent/tweet?url=' . urlencode($url);
  if (!empty($texto)) {
    $tweet .= '&text=' . urlencode($texto);
  }
  return $tweet;
}

/**
 * Gera URL de compartilhamento para o WhatsApp.
 * @param string $url URL a ser compartilhada.
 * @param string $texto Texto opcional.
 * @return string URL pronta do WhatsApp.
 */
function get_share_url_whatsapp(string $url, string $texto = ''): string
{
  $mensagem = $texto ? $texto . ' - ' . $url : $url;
  return 'https://api.whatsapp.com/send?text=' . urlencode($mensagem);
}
