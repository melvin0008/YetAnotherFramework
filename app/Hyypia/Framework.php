<?php

// app/hyypia/framework.php
 
namespace Hyypia;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

/**
* Framework
*/
class Framework
{
    
    protected $matcher;
    protected $resolver;
    public function __construct(UrlMatcher $matcher, ControllerResolver $resolver )
    {
        $this->matcher = $matcher;
        $this->resolver = $resolver;
    }
    public function handle(Request $request)
    {
        try{
            $request->attributes->add($this->matcher->match($request->getPathInfo()));     
            $controller = $this->resolver->getController($request);
            $arguments = $this->resolver->getArguments($request, $controller);
            return call_user_func($controller, $arguments);
        } 
        catch(Routing\Exception\ResourceNotFoundException $e)
        {
            return new Response('Not Found',400);
        }
        catch(Exception $e)
        {
            return new Response('An exception occurred',500);
        }
    }
}

