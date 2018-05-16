<?php

namespace sergey144010\tasks\Action;


use sergey144010\tasks\RepositoryInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequest;
use Zend\ServiceManager\ServiceManager;

class GetListTaskAction
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

        $tasks = $repository->getTasks();
        $response = new JsonResponse($tasks);
        return $response;
    }
}