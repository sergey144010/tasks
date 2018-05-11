<?php

namespace sergey144010\tasks\Action;


use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;
use Zend\Diactoros\Response\HtmlResponse;

class FormAddAction
{
    private $twig;
    private $request;

    public function __construct(ServerRequestInterface $request, Environment $twig)
    {
        $this->request = $request;
        $this->twig = $twig;
    }

    public function create()
    {
        $view = $this->twig->render('FormAddTask.html.twig');
        $response = new HtmlResponse($view);
        return $response;
    }
}