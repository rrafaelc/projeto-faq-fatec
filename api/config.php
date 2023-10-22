<?php
$iat = time();
$access_token_expiration = $iat + (15 * 60); // O token expira em 15 minutos
$refresh_token_expiration = $iat + (15 * 24 * 60 * 60); // 15 dias em segundos
