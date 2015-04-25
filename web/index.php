<?php

// framework/index.php
 
require_once __DIR__.'/../vendor/autoload.php';
 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use Hyypia\Framework;

$request = Request::createFromGlobals();
$routes = include __DIR__.'/../app/routes.php';
$response = new Response();

$context = new Routing\RequestContext();
$context->fromRequest($request);

$resolver = new HttpKernel\Controller\ControllerResolver();
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

$framework = new Framework($matcher,$resolver);
$response = $framework->handle($request);

$response->send();