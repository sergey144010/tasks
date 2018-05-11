<?php

namespace sergey144010\tasks;


abstract class Repository implements RepositoryInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        if(!isset($this->pdo)){
            $this->pdo = $pdo;
        }
    }
}