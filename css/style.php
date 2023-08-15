<?php

require_once ('../vendor/passcard/config.php');

$response = $twig->load('style.twig')->render();

header("Content-type: text/css; charset=utf-8", true);
header("X-Content-Type-Options: nosniff");

echo $response;
