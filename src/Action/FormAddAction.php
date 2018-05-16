<?php

namespace sergey144010\tasks\Action;


use Twig\Environment;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequest;
use Zend\ServiceManager\ServiceManager;

class FormAddAction
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
        /** @var Environment $twig */
        $twig = $serviceManager->get('twig');

        $view = $twig->render('FormAddTask.html.twig');
        $response = new HtmlResponse($view);
        return $response;
    }
}