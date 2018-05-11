<?php

namespace sergey144010\tasks;


use sergey144010\tasks\TaskSpares\Name;
use sergey144010\tasks\TaskSpares\Identity;
use sergey144010\tasks\TaskSpares\Priority;
use sergey144010\tasks\TaskSpares\Status;

class Task implements TaskInterface
{
    private $name;
    private $identity;
    private $priority;
    private $status;

    private $tags = [];

    public function __construct(Name $name, Identity $identity, Priority $priority, Status $status)
    {
        $this->name = $name->get();
        $this->identity = $identity->get();
        $this->priority = $priority->get();
        $this->status = $status->get();
    }

    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }

    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}