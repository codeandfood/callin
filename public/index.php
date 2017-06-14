<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
spl_autoload_register(function ($classname) {
    require ("../classes/" . $classname . ".php");
});

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "54.71.106.211";
$config['db']['user']   = "root";
$config['db']['pass']   = "root";
$config['db']['dbname'] = "callin";


$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$app->get('/hello/{name}', function (Request $request, Response $response) {

	$this->logger->addInfo("Hello call");
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/service', function (Request $request, Response $response) {
    $this->logger->addInfo("Service list");
    $service = new Service($this);
    $servicesList = $service->getServices();

    return $response->withJson($servicesList);
});

$app->get('/city', function (Request $request, Response $response) {
    $this->logger->addInfo("City list");
    $service = new Service($this);
    $servicesList = $service->getCities();

    return $response->withJson($servicesList);
});

$app->get('/area', function (Request $request, Response $response) {
    $this->logger->addInfo("Area list");
    $service = new Service($this);
    $servicesList = $service->getAreas();

    return $response->withJson($servicesList);
});

$app->get('/mnumber', function (Request $request, Response $response) {
    $this->logger->addInfo("Mobile numbers list");
    $service = new Service($this);
    $servicesList = $service->getMobileNumbers();

    return $response->withJson($servicesList);
});

$app->run();