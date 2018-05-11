<?php

use sergey144010\tasks\MapAction;
use sergey144010\tasks\TaskRepository;
use Zend\Diactoros\ServerRequestFactory;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

require __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../db/config.php';

$request = ServerRequestFactory::fromGlobals($_GET, $_POST);

$routerContainer = new Aura\Router\RouterContainer();
$map = $routerContainer->getMap();

$twigLoader = new FilesystemLoader(['../templates']);
$twig = new Environment($twigLoader);

try{
    $repository = new TaskRepository($pdo = new \PDO($config['dsn'], $config['user'], $config['pass']));
}catch (\PDOException $e){
    echo 'Check the connection settings for the database. File settings db/config.php. And create tables from db/create_tables.ini';
    exit;
}


(new MapAction($map, $request, $repository, $twig))->init();

$matcher = $routerContainer->getMatcher();

$route = $matcher->match($request);
if (!$route) {
    echo "No route found for the request";
    exit;
}

foreach ($route->attributes as $key => $val) {
    $request = $request->withAttribute($key, $val);
}

$callable = $route->handler;
/**
 * @var \Psr\Http\Message\ResponseInterface $response
 */
$response = $callable($request);

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}
http_response_code($response->getStatusCode());
echo $response->getBody();