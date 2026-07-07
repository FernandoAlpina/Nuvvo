<?php
function getAllLanguages(): array
{
  $languages = apply_filters('wpml_active_languages', NULL);
  if (!$languages) return [];

  foreach ($languages as &$lang) {
    $explodedLangCode = explode('-', $lang['language_code'], 2);
    $coumpoundLanguageCode = count($explodedLangCode) == 2;

    $lang['view_code'] = strtoupper($lang['language_code']);
    if ($coumpoundLanguageCode) {
      $lang['view_code'] = strtoupper($explodedLangCode[0]);
    }

    $lang['active'] = ($lang['code'] == getCurrentLanguage());

    // Change England flag to US flag
    if ($lang['default_locale'] == 'en_US') {
      $langFlag = $lang['country_flag_url'];
      $splittedUrl = explode('/', $langFlag);
      $splittedUrl[count($splittedUrl) - 1] = 'us.svg';
      $lang['country_flag_url'] = implode('/', $splittedUrl);
    }
  }
  unset($lang);

  usort($languages, function ($a, $b) {
    if (preg_match('%PT%', $a['view_code'])) return -1;
    if (preg_match('%PT%', $b['view_code'])) return 1;
    return $a['view_code'] <=> $b['view_code'];
  });

  return $languages;
}

function getCurrentLanguage(): string
{
  return apply_filters('wpml_current_language', null) ?? '';
}
