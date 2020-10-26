<?php

use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;
use Slim\App;

return function(App $app){
$app->group('/usuarios', function(RouteCollectorProxy $group){
    $group->get('', function(RequestInterface $request, ResponseInterface $response)
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
        return $this->get('view')->render($response, 'listadoUsuarios.twig',
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
        return $response->withHeader('Location','/usuarios')->withStatus(302);

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
        
        return $response->withHeader('Location','/usuarios')->withStatus(302);
        
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
        return $response->withHeader('Location','/usuarios')->withStatus(302);
        
    });
});

};

?>