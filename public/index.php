<?php
use DI\Container;
use Slim\Routing\RouteCollectorProxy;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/dao/UsuarioDAO.php';
require __DIR__ . '/../app/dao/MarcaDAO.php';

// Create Container
$container = new Container();
AppFactory::setContainer($container);

// Set view in Container
$container->set('view', function() {
    return Twig::create('../app/views',
        ['cache' => false]);
});

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add Twig-View Middleware
$app->add(TwigMiddleware::createFromContainer($app));


session_start();



// RUTAS GRUPALES

// -------------RUTAS USUARIOS------------
$app->group('/usuarios', function(RouteCollectorProxy $group){
    $group->get('/listado', function(RequestInterface $request, ResponseInterface $response)
    {
        
        // SESSION INICIO
        $udao = new UsuarioDAO;
        $autorizacion = $udao->estadoSesion();
        if($autorizacion== false)
        {
            return $response->withHeader('Location','/ingreso')->withStatus(302);
        }
        //SESSION FIN

        $data = $udao->read();
        return $this->get('view')->render($response, 'listado.twig',
            array(  'usuarios'=> $data,
                    'sessionEmail' =>$_SESSION['email']));
        
    });
    
    $group->get('/delete/{id}', function(RequestInterface $request, ResponseInterface $response, $args)
    {
        // SESSION INICIO
        $udao = new UsuarioDAO;
        $autorizacion = $udao->estadoSesion();
        if($autorizacion== false)
        {
            return $response->withHeader('Location','/ingreso')->withStatus(302);
        }
        //SESSION FIN
        
        $resultado = $udao->delete($args['id']);
        return $response->withHeader('Location','/usuarios/listado')->withStatus(302);

    });

    $group->post('/insert', function(RequestInterface $request, ResponseInterface $response, $args)
    {
        // SESSION INICIO
        $udao = new UsuarioDAO;
        $autorizacion = $udao->estadoSesion();
        if($autorizacion== false)
        {
            return $response->withHeader('Location','/ingreso')->withStatus(302);
        }
        
        $data = $request->getParsedBody();
        $user = new Usuario();
        $nombre = $user->setNombre($data['nombre']);
        $email = $user->setMail($data['email']);
        $contrasena = $user->setContrasena($data['contrasena']);
        $rol = $user->setRol($data['rol']);
        $resultado = $udao->insert($user);
        
        return $response->withHeader('Location','/usuarios/listado')->withStatus(302);
        
    });
    
    $group->post('/update', function(RequestInterface $request, ResponseInterface $response, $args)
    {
        // SESSION INICIO
        $udao = new UsuarioDAO;
        $autorizacion = $udao->estadoSesion();
        if($autorizacion== false)
        {
            return $response->withHeader('Location','/ingreso')->withStatus(302);
        }
        //SESSION FIN

        $data = $request->getParsedBody();
        $user = new Usuario();
        $user->setID_USUARIO($data['ID_USUARIO']);
        $user->setNombre($data['nombre']);
        $user->setMail($data['email']);
        $user->setContrasena($data['contrasena']);
        $user->setRol($data['rol']);
        $resultado = $udao->update($user);
        var_dump($resultado);
        return $response->withHeader('Location','/usuarios/listado')->withStatus(302);
        
    });
});

// -------------RUTAS MARCAS------------
$app->group('/marcas', function(RouteCollectorProxy $group){
    $group->get('/listado', function(RequestInterface $request, ResponseInterface $response)
    {
        
        // SESSION INICIO
        $udao = new UsuarioDAO;
        $autorizacion = $udao->estadoSesion();
        if($autorizacion== false)
        {
            return $response->withHeader('Location','/ingreso')->withStatus(302);
        }
        //SESSION FIN
        
        $mdao = new MarcaDAO;
        $data = $mdao->read();
        return $this->get('view')->render($response, 'listadoMarca.twig',
        array(  'marcas'=> $data,
        'sessionEmail' =>$_SESSION['email']));
        
    });
    
    $group->get('/delete/{id}', function(RequestInterface $request, ResponseInterface $response, $args)
    {
        // SESSION INICIO
        $udao = new UsuarioDAO;
        $autorizacion = $udao->estadoSesion();
        if($autorizacion== false)
        {
            return $response->withHeader('Location','/ingreso')->withStatus(302);
        }
        //SESSION FIN
        
        $mdao = new MarcaDAO;
        $resultado = $mdao->delete($args['id']);
        return $response->withHeader('Location','/marcas/listado')->withStatus(302);
        
    });
    
    $group->post('/insert', function(RequestInterface $request, ResponseInterface $response, $args)
    {
        // SESSION INICIO
        $udao = new UsuarioDAO;
        $autorizacion = $udao->estadoSesion();
        if($autorizacion== false)
        {
            return $response->withHeader('Location','/ingreso')->withStatus(302);
        }
        //SESSION FIN
        
        $data = $request->getParsedBody();
        $marca = new Marca;
        $marca->setNombre($data['nombre']);
        $marca->setEstado($data['estado']);
        $mdao = new MarcaDAO;
        $mdao->insert($marca);
        
        return $response->withHeader('Location','/marcas/listado')->withStatus(302);
        
        
    });
    
    $group->post('/update', function(RequestInterface $request, ResponseInterface $response, $args)
    {
        // SESSION INICIO
        $udao = new UsuarioDAO;
        $autorizacion = $udao->estadoSesion();
        if($autorizacion== false)
        {
            return $response->withHeader('Location','/ingreso')->withStatus(302);
        }
        //SESSION FIN
        
        $data = $request->getParsedBody();
        $marca = new Marca();
        $marca->setID_MARCA($data['ID_MARCA']);
        $marca->setNombre($data['nombre']);
        $marca->setEstado($data['estado']);
        
        $mdao = new MarcaDAO;
        $mdao->update($marca);
        return $response->withHeader('Location','/marcas/listado')->withStatus(302);
        
    });
});

// -------------RUTAS CATEGORIAS------------
$app->group('/categorias', function(RouteCollectorProxy $group){
    $group->get('/listado', function(RequestInterface $request, ResponseInterface $response)
    {
        
    });
    
    $group->get('/delete/{id}', function(RequestInterface $request, ResponseInterface $response, $args)
    {
        
    });
    
    $group->post('/insert', function(RequestInterface $request, ResponseInterface $response, $args)
    {
        
        
    });
    
    $group->post('/update', function(RequestInterface $request, ResponseInterface $response, $args)
    {
        
    });
});

//  RUTAS

$app->get('/ingreso', function (RequestInterface $request, ResponseInterface $response, $args) {
    
    // SESSION INICIO
    $udao = new UsuarioDAO;
    $autorizacion = $udao->estadoSesion();
    if($autorizacion == false)
    {
        return $this->get('view')->render($response, 'ingreso.twig');
    }
    // SESSION FIN

    return $response->withHeader('Location','/usuarios/listado')->withStatus(302);
    
});

// RUTAS ACCIONES 

$app->post('/ingresar-usuario', function (RequestInterface $request, ResponseInterface $response){
    $data = $request->getParsedBody();
    $udao = new UsuarioDAO;
    $resultado =$udao->getUser($data['email'], $data['contrasena']);
    if($resultado > 0)
    {
        return $response->withHeader('Location','/usuarios/listado')->withStatus(302);
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