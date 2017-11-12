<?php

namespace PlatformBundle\Helpers;

class Test
{
    private $state;

    public function __construct()
    {
        $this->state = 'initial';
    }

    public function getState()
    {
        echo $this->state;
    }

}