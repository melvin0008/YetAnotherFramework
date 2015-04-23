<?php

// framework/index.php
 
require_once __DIR__.'/../vendor/autoload.php';
 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

$routes = include __DIR__.'/../app/routes.php';
 
$request = Request::createFromGlobals();
$response = new Response();
$context = new Routing\RequestContext();
$context->fromRequest($request);


$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

function render_template($request)
{
	extract($request->attributes->all(), EXTR_SKIP);
	ob_start();
    include sprintf(__DIR__.'/../app/%s.php', $_route);
    $response->setContent(ob_get_clean());
    return $response;
}


try{
    $request->attributes->add($matcher->match($request->getPathInfo()));
    $response = call_user_func($request->attributes->get('_controller'), $request);
} 
catch(Routing\Exception\ResourceNotFoundException $e)
{
    $response->setStatusCode(404);
    $response->setContent('Not Found');
}
catch(Exception $e)
{
	$response->setStatusCode(500);
    $response->setContent('An exception occurred');
}
 
$response->send();