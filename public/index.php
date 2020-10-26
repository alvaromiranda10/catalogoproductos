<?php
use DI\Container;
use Slim\Routing\RouteCollectorProxy;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/dao/UsuarioDAO.php';

// Cargar variable de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ ."./../");
$dotenv->load();

// Create Container
$container = new Container();
AppFactory::setContainer($container);

// Set view in Container
$container->set('view', function() {
    return Twig::create(__DIR__ .'./../app/views',
        ['cache' => false]);
});

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add Twig-View Middleware
$app->add(TwigMiddleware::createFromContainer($app));


session_start();

// Register routes
$routesusuarios = require __DIR__ . '/../app/routes/routesusuarios.php';
$routesusuarios($app);
$routesmarcas = require __DIR__ . '/../app/routes/routesmarcas.php';
$routesmarcas($app);
$routescategorias = require __DIR__ . '/../app/routes/routescategorias.php';
$routescategorias($app);
$routessubcategorias = require __DIR__ . '/../app/routes/routesSubcategorias.php';
$routessubcategorias($app);

//  RUTAS PRINCIPAL

$app->get('/ingreso', function (RequestInterface $request, ResponseInterface $response, $args) {
    
    // SESSION INICIO
    $udao = new UsuarioDAO;
    $autorizacion = $udao->estadoSesion();
    if($autorizacion == false)
    {
        return $this->get('view')->render($response, 'ingreso.twig');
    }
    // SESSION FIN

    return $response->withHeader('Location','/usuarios')->withStatus(302);
    
});

// RUTAS ACCIONES 

$app->post('/ingresar-usuario', function (RequestInterface $request, ResponseInterface $response){
    $data = $request->getParsedBody();
    $udao = new UsuarioDAO;
    $resultado =$udao->getUser($data['email'], $data['contrasena']);
    if($resultado > 0)
    {
        return $response->withHeader('Location','/usuarios')->withStatus(302);
    }else
    {
        return $response->withStatus(403);
    }
});

$app->get('/salir', function(RequestInterface $request, ResponseInterface $response, $args){
    $udao = new UsuarioDAO;
    $resultado =$udao->deleteSesion();
    if($resultado == true)
    {
        return $response->withHeader('Location','/ingreso')->withStatus(302);
    }
});


$app->run();