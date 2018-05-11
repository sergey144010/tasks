<?php

namespace sergey144010\tasks\TaskSpares;


class Status
{
    private $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function get()
    {
        return $this->status;
    }
}