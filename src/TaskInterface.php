<?php

namespace sergey144010\tasks;

interface TaskInterface
{
    public function getTags();
    public function getName();
    public function getIdentity();
    public function getPriority();
    public function getStatus();
}