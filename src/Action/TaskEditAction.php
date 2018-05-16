<?php

namespace sergey144010\tasks\Action;


use Twig\Environment;
use sergey144010\tasks\RepositoryInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequest;
use Zend\ServiceManager\ServiceManager;

class TaskEditAction
{
    /**
     * @param ServerRequest $request
     * @param ServiceManager $serviceManager
     * @return HtmlResponse
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke($request, $serviceManager)
    {
        /** @var RepositoryInterface $repository */
        $repository = $serviceManager->get('repository');
        /** @var Environment $twig */
        $twig = $serviceManager->get('twig');

        $uuid = $request->getAttribute('uuid');

        $task = $repository->getTask($uuid);
        $tags = $task->getTags();
        $string = '';
        foreach ($tags as $key => $tag) {
            if($key == 0){
                $string .= $tag;
            }else{
                $string .= ', '.$tag;
            };
        };
        $view = $twig->render('FormAddTask.html.twig',
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