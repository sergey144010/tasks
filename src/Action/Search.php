<?php

namespace sergey144010\tasks\Action;


use Twig\Environment;
use sergey144010\tasks\TaskRepository;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequest;

class Search
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
        $text = $request->getQueryParams()['search'];
        /** @var TaskRepository $repository */
        $repository = $request->getAttribute('repository');
        /** @var Environment $twig */
        $twig = $request->getAttribute('twig');
        /**
         *  need validation here
         */
        $tasks = $repository->search($text);
        $view = $twig->render('delete.html.twig', [
            'tasks' => $tasks
        ]);
        $response = new HtmlResponse($view);
        return $response;
    }
}