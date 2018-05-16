<?php

namespace sergey144010\tasks\Action;


use Twig\Environment;
use sergey144010\tasks\RepositoryInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequest;
use Zend\ServiceManager\ServiceManager;

class DeleteAction
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

        $repository->deleteTask($uuid);

        $tasks = $repository->getTasks();
        $view = $twig->render('delete.html.twig', [
            'tasks' => $tasks
        ]);
        $response = new HtmlResponse($view);
        return $response;
    }
}