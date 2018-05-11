<?php

namespace sergey144010\tasks\Action;


use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;
use sergey144010\tasks\RepositoryInterface;
use Zend\Diactoros\Response\HtmlResponse;

class TaskEditAction
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
        $task = $this->repository->getTask($uuid);
        $tags = $task->getTags();
        $string = '';
        foreach ($tags as $key => $tag) {
            if($key == 0){
                $string .= $tag;
            }else{
                $string .= ', '.$tag;
            };
        };
        $view = $this->twig->render('FormAddTask.html.twig',
            [
                'uuid' => $task->getIdentity(),
                'name' => $task->getName(),
                'priority' => $task->getPriority(),
                'status' => $task->getStatus(),
                'tags' => $string
            ]
            );
        $response = new HtmlResponse($view);
        return $response;
    }
}