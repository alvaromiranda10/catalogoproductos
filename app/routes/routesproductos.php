<?php

use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Slim\App;

require __DIR__ . '/../dao/ProductoDAO.php';

return function(App $app){

$app->group('/productos', function(RouteCollectorProxy $group)
{
    $group->get('', function(RequestInterface $request, ResponseInterface $response)
    {
        if(verifySesion() ===false){
            return $response->withHeader('Location','/ingreso')->withStatus(302);
        }

        $pdao = new ProductoDAO; 
        $data = $pdao->read();
        return $this->get('view')->render($response, 'productos.html', $data);

    });

    $group->post('/insert', function (RequestInterface $request, ResponseInterface $response) {

        if(verifySesion() ===false){
            return $response->withHeader('Location','/ingreso')->withStatus(302);
        }

        $directory = $this->get('upload_directory');
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['url_imagen'];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile($directory, $uploadedFile);
            
            //query insert
            $data = $request->getParsedBody();
            $producto = new Producto;
            $producto->setNombre($data['nombre']);
            $producto->setDescripcion($data['descripcion']);
            $producto->setSubcategoriaid($data['subcategoria_id']);
            $producto->setMarcaid($data['marca_id']);
            $producto->setModelo($data['modelo']);
            $producto->setPrecio($data['precio']);
            $producto->setEstado($data['estado']);
            $producto->setUrlimagen($filename);
            $pdao = new ProductoDAO;
            $pdao->insert($producto);

            return $response->withHeader('Location','/productos')->withStatus(302);
        }

    });

    $group->get('/delete/{id}', function(RequestInterface $request, ResponseInterface $response, $args){
        
        if(verifySesion() ===false){
            return $response->withHeader('Location','/ingreso')->withStatus(302);
        }

        $directory = $this->get('upload_directory');

        $pdao = new ProductoDAO;

        $urlImagen = $pdao->getUrlimagen($directory, $args['id']);

        if(file_exists($urlImagen)){
            
            $pdao->delete($urlImagen, $args['id']);
            return $response->withHeader('Location','/productos')
                            ->withStatus(308);
        }else{
            return $response->withHeader('Without','error')
                            ->withHeader('Location','/productos')
                            ->withStatus(308);
        }
    });

    $group->post('/update', function(RequestInterface $request, ResponseInterface $response){
        
        if(verifySesion() ===false){
            return $response->withHeader('Location','/ingreso')->withStatus(302);
        }

        $directory = $this->get('upload_directory');

        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['url_imagen'];
        $filename= '';
        
        $data = $request->getParsedBody();
        $producto  = new Producto;
        $producto->setIdproducto($data['id_producto']);
        $producto->setNombre($data['nombre']);
        $producto->setDescripcion($data['descripcion']);
        $producto->setMarcaid($data['marca_id']);
        $producto->setModelo($data['modelo']);
        $producto->setSubcategoriaid($data['subcategoria_id']);
        $producto->setPrecio($data['precio']);
        $producto->setEstado($data['estado']);
        $pdao = new ProductoDAO;
        
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $urlImagen = $pdao->getUrlimagen($directory, $data['id_producto']);
            unlink($urlImagen);
            
            $filename = moveUploadedFile($directory, $uploadedFile);
            $producto->setUrlimagen($filename);
            
            $pdao->update($producto);
            
            return $response->withHeader('Location','/productos')->withStatus(302);

        }else
        {   
            $producto->setUrlimagen($filename);
            
            $pdao->update($producto);

            return $response->withHeader('Location','/productos')->withStatus(302);
        }




    });


    
});

    function moveUploadedFile(string $directory, UploadedFileInterface $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
        return $filename;
    }

    function verifySesion()
    {
        $udao = new UsuarioDAO;
        $autorizacion = $udao->estadoSesion();
        return $autorizacion;
    };
};