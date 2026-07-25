<?php

namespace System\Services;

use System\Services\Route\RouteResolverInterface;
use System\Services\Route\RouteResolver;
use System\Services\Request\RequestResolver;

class ApplicationHandle {

    protected RouteResolverInterface $route;

    public function __construct()
    {
        $request = new RequestResolver();
        $this->route = new RouteResolver($request);        
    
    }
    
    public function handle()
    {
       
        //Identify the current route and identify if the route existe
        $this->route->matchRoute();
        
        //Resolve route, exist access method, non-exist throw 404
        $this->route->resolve();
        
    }

}