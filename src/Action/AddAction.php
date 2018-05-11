<?php

namespace sergey144010\tasks\Action;


use Psr\Http\Message\ServerRequestInterface;
use sergey144010\tasks\Helper;
use sergey144010\tasks\RepositoryInterface;
use sergey144010\tasks\Task;
use sergey144010\tasks\TaskSpares\Identity;
use sergey144010\tasks\TaskSpares\Name;
use sergey144010\tasks\TaskSpares\Priority;
use sergey144010\tasks\TaskSpares\Status;
use Twig\Environment;
use Zend\Diactoros\Response\HtmlResponse;

class AddAction
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
        if(isset($this->request->getQueryParams()['uuid'])){
           $uuid = $this->request->getQueryParams()['uuid'];
        };
        $name = $this->request->getQueryParams()['name'];
        $priority = $this->request->getQueryParams()['priority'];
        $status = $this->request->getQueryParams()['status'];

        if(isset($uuid)){
            $task = new  Task(new Name($name), new Identity($uuid), new Priority($priority), new Status($status));
            if($this->repository->hasTask($uuid)){
                $this->repository->deleteTask($uuid);
            };
        }else{
            $task = new  Task(new Name($name), new Identity(), new Priority($priority), new Status($status));
        };

        if(isset($this->request->getQueryParams()['tags'])){
            $task->setTags(Helper::prepareTags($this->request->getQueryParams()['tags']));
        };

        $this->repository->saveTask($task);
        $view = $this->twig->render('SuccessAddTask.html.twig');
        $response = new HtmlResponse($view);
        return $response;
    }
}