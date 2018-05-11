<?php

namespace sergey144010\tasks\Action;


use Psr\Http\Message\ServerRequestInterface;
use sergey144010\tasks\RepositoryInterface;
use Twig\Environment;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

class GetListTaskAction
{
    private $request;
    private $repository;
    private $twig;

    public function __construct(ServerRequestInterface $request, Environment $twig ,RepositoryInterface $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
        $this->twig = $twig;
    }

    public function create()
    {
        $tasks = $this->repository->getTasks();
        $response = new JsonResponse($tasks);
        return $response;
    }
}