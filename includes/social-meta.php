<?php

if (!function_exists('faq_site_base_url')) {
  function faq_site_base_url(): string
  {
    $fromEnv = getenv('SITE_URL');
    $fromEnv = is_string($fromEnv) ? trim($fromEnv) : '';
    $fromEnv = rtrim($fromEnv, '/');
    if ($fromEnv !== '') {
      return $fromEnv;
    }

    $scheme = 'http';
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
      $scheme = 'https';
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
      $scheme = strtolower((string) $_SERVER['HTTP_X_FORWARDED_PROTO']);
    } elseif (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443) {
      $scheme = 'https';
    }

    $host = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'] ?? 'localhost';

    return $scheme . '://' . $host;
  }
}

$defaults = [
  'title' => 'Fatec Itapira FAQ',
  'description' => 'Dúvidas frequentes da Fatec de Itapira: matrícula, vestibular, SIGA, horários de aula, biblioteca, coordenação e muito mais.',
  'image' => '/img/logo.png',
];

$meta = array_merge($defaults, is_array($socialMeta ?? null) ? $socialMeta : []);

$base = faq_site_base_url();
$imagePath = $meta['image'];
if ($imagePath !== '' && $imagePath[0] !== '/') {
  $imagePath = '/' . $imagePath;
}
$ogImage = $base . $imagePath;

$scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '/');
if ($scriptDir === '/' || $scriptDir === '\\' || $scriptDir === '.') {
  $canonicalPath = '/';
} else {
  $canonicalPath = rtrim(str_replace('\\', '/', $scriptDir), '/') . '/';
}
$canonicalUrl = $base . $canonicalPath;

$pageTitle = $meta['title'];
$fullTitle = str_contains($pageTitle, 'FAQ') ? $pageTitle : $pageTitle . ' | Fatec Itapira FAQ';
?>
  <meta name="description" content="<?= htmlspecialchars($meta['description'], ENT_QUOTES, 'UTF-8') ?>" />
  <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>" />

  <meta property="og:type" content="website" />
  <meta property="og:locale" content="pt_BR" />
  <meta property="og:site_name" content="Fatec Itapira FAQ" />
  <meta property="og:title" content="<?= htmlspecialchars($fullTitle, ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:description" content="<?= htmlspecialchars($meta['description'], ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:image:alt" content="Fatec Itapira — FAQ" />

  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?= htmlspecialchars($fullTitle, ENT_QUOTES, 'UTF-8') ?>" />
  <meta name="twitter:description" content="<?= htmlspecialchars($meta['description'], ENT_QUOTES, 'UTF-8') ?>" />
  <meta name="twitter:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') ?>" />
