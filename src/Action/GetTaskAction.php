<?php

namespace sergey144010\tasks\Action;


use Psr\Http\Message\ServerRequestInterface;
use sergey144010\tasks\RepositoryInterface;
use Zend\Diactoros\Response\JsonResponse;

class GetTaskAction
{
    private $request;
    private $repository;

    public function __construct(ServerRequestInterface $request, RepositoryInterface $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
    }

    public function create()
    {
        $uuid = $this->request->getAttribute('uuid');
        $task = $this->repository->getTask($uuid);
        $response = new JsonResponse([
            'uuid' => $task->getIdentity(),
            'name' => $task->getName(),
            'priority' => $task->getPriority(),
            'status' => $task->getStatus(),
            'tags' => $task->getTags()
        ]);
        return $response;
    }
}