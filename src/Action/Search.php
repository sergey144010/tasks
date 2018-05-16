<?php

namespace sergey144010\tasks\Action;


use Twig\Environment;
use sergey144010\tasks\TaskRepository;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequest;
use Zend\Filter\StaticFilter;
use Zend\ServiceManager\ServiceManager;

class Search
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
        /** @var TaskRepository $repository */
        $repository = $serviceManager->get('repository');
        /** @var Environment $twig */
        $twig = $serviceManager->get('twig');

        $text = $request->getQueryParams()['search'];

        /** @var \Zend\Log\Logger $logger */
        #$logger = $serviceManager->get('logger');
        #$logger->log(\Zend\Log\Logger::DEBUG, $text);

        $text = StaticFilter::execute(
            $text,
            'HtmlEntities',
            ['quotestyle' => ENT_QUOTES]
        );
        $text = StaticFilter::execute(
            $text,
            'StripTags'
        );
        $tasks = $repository->search($text);
        $view = $twig->render('delete.html.twig', [
            'tasks' => $tasks
        ]);
        $response = new HtmlResponse($view);
        return $response;
    }
}