<?php

namespace sergey144010\tasks\TaskSpares;

use Ramsey\Uuid\Uuid;

class Identity
{
    private $identity;

    public function __construct($uuid = null)
    {
        if(isset($uuid)){
            $this->identity = $uuid;
        }else{
            $this->identity = (string)Uuid::uuid4();
        };
    }

    public function get()
    {
        return $this->identity;
    }
}