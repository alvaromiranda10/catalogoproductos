<?php

use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;
use Slim\App;

require __DIR__ . '/../dao/MarcaDAO.php';

return function(App $app){
    $app->group('/marcas', function(RouteCollectorProxy $group){
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
            
            $mdao = new MarcaDAO;
            $data = $mdao->read();
            return $this->get('view')->render($response, 'listadoMarcas.twig',
            array(  'marcas'=> $data,
            'sessionEmail' =>$_SESSION['email']));
            
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
            
            return $response->withHeader('Location','/marcas')->withStatus(302);
            
            
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
            return $response->withHeader('Location','/marcas')->withStatus(302);
            
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
            return $response->withHeader('Location','/marcas')->withStatus(302);
            
        });
    });
};