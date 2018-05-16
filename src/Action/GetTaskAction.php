<?php

namespace sergey144010\tasks\Action;


use sergey144010\tasks\RepositoryInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequest;
use Zend\ServiceManager\ServiceManager;

class GetTaskAction
{
    /**
     * @param ServerRequest $request
     * @param ServiceManager $serviceManager
     * @return JsonResponse
     */
    public function __invoke($request, $serviceManager)
    {
        /** @var RepositoryInterface $repository */
        $repository = $serviceManager->get('repository');

        $uuid = $request->getAttribute('uuid');

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