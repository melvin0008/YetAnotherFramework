<?php

require_once __DIR__.'/init.php';

$input = $request->get('name', 'World'); 
$response->setContent(sprintf('Hello %s', htmlspecialchars($input, ENT_QUOTES, 'UTF-8')));
$response->setStatusCode(200);
$response->headers->set('Content-Type', 'text/html');