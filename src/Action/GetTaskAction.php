<?php

namespace sergey144010\tasks\Action;


use sergey144010\tasks\RepositoryInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequest;

class GetTaskAction
{
    /**
     * @param ServerRequest $request
     * @return JsonResponse
     */
    public function __invoke($request)
    {
        $uuid = $request->getAttribute('uuid');
        /** @var RepositoryInterface $repository */
        $repository = $request->getAttribute('repository');

        $task = $repository->getTask($uuid);

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