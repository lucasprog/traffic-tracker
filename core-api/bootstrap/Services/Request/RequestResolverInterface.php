<?php

namespace System\Services\Request;

interface RequestResolverInterface
{
    public function data(): array;

    public function currentRoute(): string;

    public function methodRequest(): string;

    public function onlyAPI(): void;
}