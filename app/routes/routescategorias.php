<?php

use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;
use Slim\App;

require __DIR__ . '/../dao/CategoriaDAO.php';

return function(App $app){
$app->group('/categorias', function(RouteCollectorProxy $group){
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

        $cdao = new CategoriaDAO;
            $data = $cdao->read();
            return $this->get('view')->render($response, 'listadoCategorias.twig',
            array(  'categorias'=> $data,
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

        $data = $request->getParsedBody();
        $categoria = new Categoria;
        $categoria->setNombre($data['nombre']);
        $categoria->setEstado($data['estado']);
        $cdao = new CategoriaDAO;
        $cdao->insert($categoria);
        
        return $response->withHeader('Location','/categorias')->withStatus(302);
        
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
        
        $cdao = new CategoriaDAO;
        $resultado = $cdao->delete($args['id']);
        return $response->withHeader('Location','/categorias')->withStatus(302);

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
        $categoria = new Categoria();
        $categoria->setID_CATEGORIA($data['ID_CATEGORIA']);
        $categoria->setNombre($data['nombre']);
        $categoria->setEstado($data['estado']);
        
        $cdao = new CategoriaDAO;
        $cdao->update($categoria);
        return $response->withHeader('Location','/categorias')->withStatus(302);
            

    });
});

};

?>