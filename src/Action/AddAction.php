<?php

namespace sergey144010\tasks\Action;


use sergey144010\tasks\Helper;
use sergey144010\tasks\Task;
use sergey144010\tasks\TaskSpares\Identity;
use sergey144010\tasks\TaskSpares\Name;
use sergey144010\tasks\TaskSpares\Priority;
use sergey144010\tasks\TaskSpares\Status;
use Twig\Environment;
use sergey144010\tasks\RepositoryInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequest;

class AddAction
{
    /**
     * @param ServerRequest $request
     * @return HtmlResponse
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke($request)
    {
        /** @var RepositoryInterface $repository */
        $repository = $request->getAttribute('repository');
        /** @var Environment $twig */
        $twig = $request->getAttribute('twig');

        if(isset($request->getQueryParams()['uuid'])){
           $uuid = $request->getQueryParams()['uuid'];
        };
        $name = $request->getQueryParams()['name'];
        $priority = $request->getQueryParams()['priority'];
        $status = $request->getQueryParams()['status'];

        if(isset($uuid)){
            $task = new  Task(new Name($name), new Identity($uuid), new Priority($priority), new Status($status));
            if($repository->hasTask($uuid)){
                $repository->deleteTask($uuid);
            };
        }else{
            $task = new  Task(new Name($name), new Identity(), new Priority($priority), new Status($status));
        };

        if(isset($request->getQueryParams()['tags'])){
            $task->setTags(Helper::prepareTags($request->getQueryParams()['tags']));
        };

        $repository->saveTask($task);
        $view = $twig->render('SuccessAddTask.html.twig');
        $response = new HtmlResponse($view);
        return $response;
    }
}