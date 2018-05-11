<?php

namespace sergey144010\tasks\Action;


use Psr\Http\Message\ServerRequestInterface;
use sergey144010\tasks\RepositoryInterface;
use Twig\Environment;
use Zend\Diactoros\Response\HtmlResponse;

class DeleteAction
{
    private $request;
    private $twig;
    private $repository;

    public function __construct(ServerRequestInterface $request, Environment $twig, RepositoryInterface $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
        $this->twig = $twig;
    }

    public function create()
    {
        $uuid = $this->request->getAttribute('uuid');
        $this->repository->deleteTask($uuid);

        $tasks = $this->repository->getTasks();
        $view = $this->twig->render('delete.html.twig', [
            'tasks' => $tasks
        ]);
        $response = new HtmlResponse($view);
        return $response;
    }
}