<?php

namespace sergey144010\tasks\Action;


use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;
use sergey144010\tasks\RepositoryInterface;
use Zend\Diactoros\Response\HtmlResponse;

class IndexAction
{
    private $twig;
    private $request;
    private $repository;

    public function __construct(ServerRequestInterface $request, Environment $twig, RepositoryInterface $repository)
    {
        $this->request = $request;
        $this->twig = $twig;
        $this->repository = $repository;
    }

    public function create()
    {
        $tasks = $this->repository->getTasks();
        $view = $this->twig->render('index.html.twig', [
            'tasks' => $tasks
        ]);
        $response = new HtmlResponse($view);
        return $response;
    }
}