<?php

namespace App\Cores;

class Application
{
    public array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function run()
    {
    }
}
