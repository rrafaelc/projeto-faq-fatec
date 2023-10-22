<?php
$issuedat_claim = time();
$notbefore_claim = $issuedat_claim + 10; // O token não é válido antes de 10 segundos
$expire_claim = $issuedat_claim + 3600; // O token expira em 1 hora
$refresh_token_expiration = time() + (15 * 24 * 60 * 60); // 15 dias em segundos
