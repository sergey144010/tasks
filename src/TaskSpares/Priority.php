<?php

namespace sergey144010\tasks\TaskSpares;


class Priority
{
    private $priority;

    public function __construct($priority)
    {
        $this->priority = $priority;
    }

    public function get()
    {
        return $this->priority;
    }
}