<?php

namespace System\Services\Route;

use ReflectionClass;
use System\Services\Request\RequestResolverInterface;

class RouteResolver implements RouteResolverInterface
{

    protected RequestResolverInterface $request;
    protected array $routes = [];
    protected array $route;
    protected array $parameters = [];

    public function __construct(
        RequestResolverInterface $request
    )
    {
        $this->request = $request;
        $this->routes = config("routes");
    }

    public function matchRoute(): void
    {
        $currentRoute = $this->request->currentRoute();

        $this->route = array_find($this->routes, function($route) use ($currentRoute) {
            
            if( $route["route"] === $currentRoute ) {
                return true;    
            }

            $_route = array_filter(explode("/",$route["route"]));
            $_currentRoute = array_filter(explode("/",$currentRoute));

            if( count($_route) !== count($_currentRoute) ){
                return false;
            }

            return array_all($_currentRoute, function ($value, $key) use ($_route) {
                
                if( !str_starts_with($_route[$key], "{") && !str_ends_with($_route[$key], "}") )
                {
                    return $_route[$key] === $value;
                }

                return true;
            });
            
        }); 

        $this->matchParameters();
        
    }

    private function matchParameters(): void
    {
        $currentRoute = $this->request->currentRoute();

        $route = array_filter(explode("/",$this->route["route"]));
        $currentRoute = array_filter(explode("/",$currentRoute));

        foreach($route as $key => $_route){
            if( str_starts_with($_route, "{") && str_ends_with($_route, "}") )
            {
                $this->parameters[substr($_route,1,-1)] = $currentRoute[$key];
            }
        }

    }

    public function getRoute(): array
    {
        return $this->route;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }


    public function resolve(): void
    {
        //Identify if the system must run as API, if yes throw an error
        $this->request->onlyAPI();
                
        //If the route exist, it will access the controller and method of route.
        if( isset($this->route) ) {
            
            $controller = explode("@",$this->route["controller"])[0];
            $action     = explode("@",$this->route["controller"])[1];
            
            $reflector = new ReflectionClass($controller);            
            $absolutePathController = $reflector->getFileName();

            if( file_exists($absolutePathController) ) 
            {
                require_once $absolutePathController;
              
                $classControllerName = basename($controller);
              
                $instanceController = new $classControllerName();
                echo $instanceController->{$action}(...$this->parameters);
                exit();
            }
        }

        http_response_code(404);

    }
}