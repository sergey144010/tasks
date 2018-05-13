<?php

namespace sergey144010\tasks\Action;


use Twig\Environment;
use sergey144010\tasks\RepositoryInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequest;

class DeleteAction
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
        $uuid = $request->getAttribute('uuid');
        /** @var RepositoryInterface $repository */
        $repository = $request->getAttribute('repository');
        /** @var Environment $twig */
        $twig = $request->getAttribute('twig');

        $repository->deleteTask($uuid);

        $tasks = $repository->getTasks();
        $view = $twig->render('delete.html.twig', [
            'tasks' => $tasks
        ]);
        $response = new HtmlResponse($view);
        return $response;
    }
}