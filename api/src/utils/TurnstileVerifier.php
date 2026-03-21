<?php

declare(strict_types=1);

class TurnstileVerifier
{
  private const VERIFY_URL = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

  public static function isEnforced(array $config): bool
  {
    $secret = $config['turnstile_secret_key'] ?? '';
    return $secret !== '';
  }

  public static function tokenFromPayload(array $data): string
  {
    if (!empty($data['captchaToken']) && is_string($data['captchaToken'])) {
      return trim($data['captchaToken']);
    }
    return '';
  }

  public static function verify(array $config, string $responseToken, ?string $remoteIp = null): bool
  {
    if (!self::isEnforced($config)) {
      return true;
    }
    if ($responseToken === '') {
      return false;
    }

    $secret = $config['turnstile_secret_key'] ?? '';
    $body = [
      'secret' => $secret,
      'response' => $responseToken,
    ];
    if ($remoteIp !== null && $remoteIp !== '') {
      $body['remoteip'] = $remoteIp;
    }

    $opts = [
      'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => http_build_query($body),
        'timeout' => 10,
      ],
    ];

    $raw = @file_get_contents(self::VERIFY_URL, false, stream_context_create($opts));
    if ($raw === false) {
      return false;
    }

    $data = json_decode($raw, true);
    return is_array($data) && ($data['success'] ?? false) === true;
  }

  public static function clientIp(): string
  {
    $xff = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
    if (is_string($xff) && $xff !== '') {
      $first = trim(explode(',', $xff)[0]);
      if ($first !== '') {
        return $first;
      }
    }
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    return is_string($ip) ? $ip : '';
  }
}
