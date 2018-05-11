<?php

namespace sergey144010\tasks;


use Aura\Router\Map;
use sergey144010\tasks\Action\AddAction;
use sergey144010\tasks\Action\DeleteAction;
use sergey144010\tasks\Action\FormAddAction;
use sergey144010\tasks\Action\GetListTaskAction;
use sergey144010\tasks\Action\GetTaskAction;
use sergey144010\tasks\Action\IndexAction;
use sergey144010\tasks\Action\Search;
use sergey144010\tasks\Action\TaskEditAction;
use Twig\Environment;
use Zend\Diactoros\ServerRequest;

class MapAction
{
    private $map;
    private $request;
    private $repository;
    private $twig;

    public function __construct(Map $map, ServerRequest $request, RepositoryInterface $repository, Environment $twig)
    {
        $this->map = $map;
        $this->request = $request;
        $this->repository = $repository;
        $this->twig = $twig;
    }

    public function init()
    {
        $request = $this->request;
        $twig = $this->twig;
        $repository = $this->repository;

        $this->index($request, $twig, $repository);
        $this->delete($request, $twig, $repository);
        $this->save($request, $twig, $repository);
        $this->newTask($request, $twig, $repository);
        $this->get($request, $twig, $repository);
        $this->listTask($request, $twig, $repository);
        $this->edit($request, $twig, $repository);
        $this->search($request, $twig, $repository);

    }

    public function index($request, $twig, $repository)
    {
        $this->map->get('task.root', '/', function ($request) use ($twig, $repository){
            return (new IndexAction($request, $twig, $repository))->create();
        });
        $this->map->get('task.index', '/task', function ($request) use ($twig, $repository){
            return (new IndexAction($request, $twig, $repository))->create();
        });
        $this->map->get('task.indexslash', '/task/', function ($request) use ($twig, $repository){
            return (new IndexAction($request, $twig, $repository))->create();
        });
    }

    public function delete($request, $twig, $repository)
    {
        $this->map->get('task.delete', '/task/delete/{uuid}', function ($request) use ($twig, $repository){
            return (new DeleteAction($request, $twig, $repository))->create();
        })->tokens(['uuid' => function($uuid){
            if(preg_match('/^((\w|\d)+-){4}(\w|\d)+$/i', $uuid)) {
                return true;
            }else{
                return false;
            }
        }]);
    }

    public function save($request, $twig, $repository)
    {
        $this->map->post('task.add', '/task/add', function ($request) use ($twig, $repository){
            return (new AddAction($request, $twig, $repository))->create();
        });
    }

    public function newTask($request, $twig, $repository)
    {
        $this->map->get('task.addTask', '/task/addTask', function ($request) use ($twig){
            return (new FormAddAction($request, $twig))->create();
        });
    }

    public function get($request, $twig, $repository)
    {
        $this->map->get('task.get', '/task/{uuid}', function ($request) use ($repository){
            return (new GetTaskAction($request, $repository))->create();
        })->tokens(['uuid' => function($uuid){
            if(preg_match('/^((\w|\d)+-){4}(\w|\d)+$/i', $uuid)) {
                return true;
            }else{
                return false;
            }
        }]);
    }

    public function listTask($request, $twig, $repository)
    {
        $this->map->get('task.list', '/task/list', function($request) use ($twig, $repository){
            return (new GetListTaskAction($request, $twig, $repository))->create();
        });
    }

    public function edit($request, $twig, $repository)
    {
        $this->map->get('task.edit', '/task/edit/{uuid}', function($request) use ($twig, $repository){
            return (new TaskEditAction($request, $twig, $repository))->create();
        })->tokens(['uuid' => function($uuid){
            if(preg_match('/^((\w|\d)+-){4}(\w|\d)+$/i', $uuid)) {
                return true;
            }else{
                return false;
            }
        }]);
    }

    public function search($request, $twig, $repository)
    {
        $this->map->post('task.search', '/task/search/{text}', function($request) use ($twig, $repository){
            return (new Search($request, $twig, $repository))->create();
        })->tokens(['text'=>'[\w\d]+']);
    }
}