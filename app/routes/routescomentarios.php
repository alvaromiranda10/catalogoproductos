<?php

use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Slim\App;

require __DIR__ . '/../dao/ComnetarioDAO.php';

return function(App $app){

$app->group('/comentarios', function(RouteCollectorProxy $group)
{
    // code here...
});

};