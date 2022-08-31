<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Slim\App;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__. '/../config/db.php';
$config = ['settings' => [
    'addContentLengthHeader' => false,
]];
$app = new \Slim\App($config);
$app->get('/', function ($request, $response) {
    return $response->getBody()->write('Welcome Admin');
});


$app->get('/{name}', function (Request $request, Response $response,array $args) {
    $response->getBody()->write("Hello ".$args['name']);
    return $response;
});

require __DIR__. '/../routes/friends.php';

$app->run();
