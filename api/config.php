<?php
$iat = time();
$access_token_expiration = $iat + 3600; // O token expira em 1 hora
$refresh_token_expiration = $iat + (15 * 24 * 60 * 60); // 15 dias em segundos
