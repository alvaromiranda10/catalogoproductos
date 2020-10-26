<?php

use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;
use Slim\App;

require __DIR__ . '/../dao/SubcategoriaDAO.php';

return function(App $app){
$app->group('/subcategorias', function(RouteCollectorProxy $group){
    $group->get('/listado/{nombrecategoria}/{idcategoria}', function(RequestInterface $request, ResponseInterface $response, $args)
    {
        // SESSION INICIO
        $udao = new UsuarioDAO;
        $autorizacion = $udao->estadoSesion();
        if($autorizacion== false)
        {
            return $response->withHeader('Location','/ingreso')->withStatus(302);
        }
        //SESSION FIN

        $subcdao = new SubcategoriaDAO;
            $data = $subcdao->read($args['idcategoria']);
            return $this->get('view')->render($response, 'listadoSubcategorias.html',
            array('subcategorias'=> $data,
                'nombrecategoria' => $args['nombrecategoria'],
                'idcategoria' => $args['idcategoria'],
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
        $subcategoria = new Subcategoria;
        $subcategoria->setNombre($data['nombre']);
        $subcategoria->setCATEGORIA_ID($data['id_categoria']);
        $subcategoria->setEstado($data['estado']);
        $subcdao = new SubcategoriaDAO;
        $subcdao->insert($subcategoria);
        
        return $response->withHeader('Location',$_SERVER['HTTP_REFERER'])->withStatus(302);;
        
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
        
        $subcdao = new SubcategoriaDAO;
        $subcdao->delete($args['id']);
        return $response->withHeader('Location',$_SERVER['HTTP_REFERER'])->withStatus(302);;
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
        $subcategoria = new Subcategoria();
        $subcategoria->setID_SUBCATEGORIA($data['ID_SUBCATEGORIA']);
        $subcategoria->setNombre($data['nombre']);
        $subcategoria->setEstado($data['estado']);
        
        $subcdao = new SubcategoriaDAO;
        $subcdao->update($subcategoria);
        return $response->withHeader('Location',$_SERVER['HTTP_REFERER'])->withStatus(302);;
    });
});

};

?>