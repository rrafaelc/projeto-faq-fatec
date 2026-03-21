<?php

$turnstileSiteKey = '';
$turnstileSecretKey = '';

$fromServerSite = $_SERVER['TURNSTILE_SITE_KEY'] ?? '';
if (is_string($fromServerSite) && trim($fromServerSite) !== '') {
  $turnstileSiteKey = trim($fromServerSite);
} else {
  $fromGetenvSite = getenv('TURNSTILE_SITE_KEY');
  if (is_string($fromGetenvSite) && trim($fromGetenvSite) !== '') {
    $turnstileSiteKey = trim($fromGetenvSite);
  }
}

$fromServerSecret = $_SERVER['TURNSTILE_SECRET_KEY'] ?? '';
if (is_string($fromServerSecret) && trim($fromServerSecret) !== '') {
  $turnstileSecretKey = trim($fromServerSecret);
} else {
  $fromGetenvSecret = getenv('TURNSTILE_SECRET_KEY');
  if (is_string($fromGetenvSecret) && trim($fromGetenvSecret) !== '') {
    $turnstileSecretKey = trim($fromGetenvSecret);
  }
}

$envPath = dirname(__DIR__) . '/api/.env';
if (is_readable($envPath)) {
  $lines = @file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  if (is_array($lines)) {
    foreach ($lines as $line) {
      $line = trim($line);
      if ($line === '' || str_starts_with($line, '#')) {
        continue;
      }
      if ($turnstileSiteKey === '' && preg_match('/^TURNSTILE_SITE_KEY=(.*)$/', $line, $m)) {
        $turnstileSiteKey = trim($m[1], " \t\n\r\0\x0B\"'");
      }
      if ($turnstileSecretKey === '' && preg_match('/^TURNSTILE_SECRET_KEY=(.*)$/', $line, $m)) {
        $turnstileSecretKey = trim($m[1], " \t\n\r\0\x0B\"'");
      }
    }
  }
}

$turnstileEnforced = $turnstileSecretKey !== '';
$faqTurnstileMustConfigureSiteKey = $turnstileEnforced && $turnstileSiteKey === '';
