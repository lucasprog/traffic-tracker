<?php

namespace System\Services\Route;

interface RouteResolverInterface
{

    public function matchRoute(): void;

    public function getRoute(): array;

    public function getParameters(): array;

    public function resolve(): void;
    
}
