<?php

namespace App\Dtos;

class Document
{
    public $name;
    public $route;

    /**
     * @param string $name
     * @param string $route
     */
    public function __construct(string $name, string $route)
    {
        $this->name = $name;
        $this->route = $route;
    }
}