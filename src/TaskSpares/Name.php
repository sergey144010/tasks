<?php

namespace sergey144010\tasks\TaskSpares;


class Name
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function get()
    {
        return $this->name;
    }
}