<?php

namespace sergey144010\tasks;


use Aura\Router\Map;
use Aura\Router\Route;
use sergey144010\tasks\Action\AddAction;
use sergey144010\tasks\Action\DeleteAction;
use sergey144010\tasks\Action\FormAddAction;
use sergey144010\tasks\Action\GetListTaskAction;
use sergey144010\tasks\Action\GetTaskAction;
use sergey144010\tasks\Action\IndexAction;
use sergey144010\tasks\Action\Search;
use sergey144010\tasks\Action\TaskEditAction;
use Zend\Diactoros\ServerRequest;

class MapAction
{
    private $map;
    /**
     * @var ServerRequest $request
     */
    private $request;

    public function __construct(Map $map)
    {
        $this->map = $map;
    }

    public function init()
    {
        $this->index();
        $this->delete();
        $this->save();
        $this->newTask();
        $this->get();
        $this->listTask();
        $this->edit();
        $this->search();
    }

    /**
     * @param ServerRequest $request
     * @return $this
     */
    public function withRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    public function index()
    {
        $path = $this->request->getUri()->getPath();
        if($path == '/' || $path == '/task' || $path == '/task/'){
            $route = new Route();
            $route->name('task.index');
            $route->path($path);
            $route->handler(IndexAction::class);
            $this->map->addRoute($route);
        }

        /*
        $this->map->get('task.root', '/', IndexAction::class);
        $this->map->get('task.index', '/task', IndexAction::class);
        $this->map->get('task.slash', '/task/', IndexAction::class);
        */
    }

    public function delete()
    {
        $this->map->get('task.delete', '/task/delete/{uuid}', DeleteAction::class)
            ->tokens(['uuid' => function($uuid){
                if(preg_match('/^((\w|\d)+-){4}(\w|\d)+$/i', $uuid)) {
                    return true;
                }else{
                    return false;
                }
        }]);
    }

    public function save()
    {
        $this->map->post('task.add', '/task/add', AddAction::class);
    }

    public function newTask()
    {
        $this->map->get('task.addTask', '/task/addTask', FormAddAction::class);
    }

    public function get()
    {
        $this->map->get('task.get', '/task/{uuid}', GetTaskAction::class)
            ->tokens(['uuid' => function($uuid){
                if(preg_match('/^((\w|\d)+-){4}(\w|\d)+$/i', $uuid)) {
                    return true;
                }else{
                    return false;
                }
        }]);
    }

    public function listTask()
    {
        $this->map->get('task.list', '/task/list', GetListTaskAction::class);
    }

    public function edit()
    {
        $this->map->get('task.edit', '/task/edit/{uuid}', TaskEditAction::class)
            ->tokens(['uuid' => function($uuid){
                if(preg_match('/^((\w|\d)+-){4}(\w|\d)+$/i', $uuid)) {
                    return true;
                }else{
                    return false;
                }
        }]);
    }

    public function search()
    {
        $this->map->post('task.search', '/task/search', Search::class);
    }
}