<?php
/**
 * Created by PhpStorm.
 * User: Мария
 * Date: 12.05.2018
 * Time: 0:38
 */

namespace sergey144010\tasks\Action;


use Psr\Http\Message\ServerRequestInterface;
use sergey144010\tasks\Helper;
use sergey144010\tasks\RepositoryInterface;
use sergey144010\tasks\Task;
use sergey144010\tasks\TaskRepository;
use sergey144010\tasks\TaskSpares\Identity;
use sergey144010\tasks\TaskSpares\Name;
use sergey144010\tasks\TaskSpares\Priority;
use sergey144010\tasks\TaskSpares\Status;
use Twig\Environment;
use Zend\Diactoros\Response\HtmlResponse;

class Search
{
    private $twig;
    private $request;
    /**
     * @var TaskRepository
     */
    private $repository;

    public function __construct(ServerRequestInterface $request, Environment $twig, RepositoryInterface $repository)
    {
        $this->request = $request;
        $this->twig = $twig;
        $this->repository = $repository;
    }

    public function create()
    {
        $text = $this->request->getAttribute('text');
        /**
         *  need validation here
         */
        $tasks = $this->repository->search($text);
        $view = $this->twig->render('delete.html.twig', [
            'tasks' => $tasks
        ]);
        $response = new HtmlResponse($view);
        return $response;
    }
}