<?php

$getPath = explode("/projeto-faq-fatec/api", $_SERVER["REQUEST_URI"]);
$parts = explode("/", $getPath[1]);

print_r($parts);
