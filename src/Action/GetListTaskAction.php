<?php

namespace sergey144010\tasks\Action;


use sergey144010\tasks\RepositoryInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequest;

class GetListTaskAction
{
    /**
     * @param ServerRequest $request
     * @return JsonResponse
     */
    public function __invoke($request)
    {
        /** @var RepositoryInterface $repository */
        $repository = $request->getAttribute('repository');

        $tasks = $repository->getTasks();
        $response = new JsonResponse($tasks);
        return $response;
    }
}