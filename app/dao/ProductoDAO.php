<?php
require __DIR__ . '/../model/Producto.php';
require_once __DIR__ . '/../BD/Conexion.php';

class ProductoDAO
{
    private $DB;

    public function __construct()
    {
        $this->DB = new Conexion();
    }

    public function read()
    {
        $subcategorias = $this->getSubcatgoriasCategorias();
        $marcas = $this->getMarcas();
        try
        {
            $stmt = $this->DB->prepare("SELECT p.id_producto ,  p.nombre, p.descripcion, p.marca_id, m.nombre as nombremarca, p.modelo, 
                                        p.subcategoria_id , s.nombre as nombresubcategoria, s.categoria_id , c.nombre as nombrecategoria,
                                        p.url_imagen, p.estado, p.precio
                                        FROM producto p, subcategoria s, categoria c, marca m
                                        WHERE p.marca_id = m.id_marca
                                        AND p.subcategoria_id = s.id_subcategoria
                                        AND s.categoria_id = c.id_categoria ");
            $stmt->execute();
            $productos = $stmt->fetchAll();

            return array("subcategorias" => $subcategorias,
                        "marcas" => $marcas,
                        "productos" => $productos);

        }catch(PDOException $e)
        {
            return  $e->getMessage();
        }
    }

    // BEGIN - function for READ of thee class Producto DAO
        public function getSubcatgoriasCategorias()
        {
            try
            {
                $stmt = $this->DB->prepare("select s.id_subcategoria, s.nombre, c.nombre as nombrecategoria
                                            from subcategoria s, categoria c
                                            where s.categoria_id = c.id_categoria
                                            ORDER BY c.nombre ASC");
                $stmt->execute();
                $results = $stmt->fetchAll();

                return $results;

            }catch(PDOException $e)
            {
                return  $e->getMessage();
            }
        }

        public function getMarcas()
        {
            try
            {
                $stmt = $this->DB->prepare("select id_marca, nombre
                                            from marca
                                            ORDER BY nombre ASC");
                $stmt->execute();
                $results = $stmt->fetchAll();

                return $results;

            }catch(PDOException $e)
            {
                return  $e->getMessage();
            }
        }
    // END - function for READ of thee class Producto DAO

    public function insert($producto)
    {
        try
        {
            $stmt = $this->DB->prepare("INSERT INTO producto ( nombre, descripcion, marca_id, modelo, subcategoria_id, url_imagen, estado, precio)
                                        VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindValue(1, $producto->getNombre());
            $stmt->bindValue(2, $producto->getDescripcion());
            $stmt->bindValue(3, $producto->getMarcaid());
            $stmt->bindValue(4, $producto->getModelo());
            $stmt->bindValue(5, $producto->getSubcategoriaid());
            $stmt->bindValue(6, $producto->getUrlimagen());
            $stmt->bindValue(7, $producto->getEstado());
            $stmt->bindValue(8, $producto->getPrecio());
            $stmt->execute();
            
        } catch (PDOException $e) 
        {
            return $e->getMessage();
        }
        
    }

    public function delete( $directory, $id_producto )
    {
        try 
        {
            $stmt = $this->DB->prepare("DELETE FROM producto WHERE id_producto = ?");
            $stmt->bindParam(1, $id_producto);
            $stmt->execute();
            unlink($directory);
            
        } catch (PDOException $e) 
        {
            return $e->getMessage();
        }
        
    }

    // BEGIN - function  for DELETE of the class ProductoDAO
        public function getUrlimagen($directory,$id_producto)
        {
            try 
            {
                $stmt = $this->DB->prepare("SELECT url_imagen FROM producto WHERE id_producto = ?");
                $stmt->bindParam(1, $id_producto);
                $stmt->execute();

                $result = $stmt->fetch();

                return $directory . DIRECTORY_SEPARATOR . $result['url_imagen'];
                
            } catch (PDOException $e) 
            {
                return $e->getMessage();
            }

        }
    // END - 

    public function update($producto)
    {
        $sql= '';

        try
        {
            if($producto->getUrlimagen() === ''){
                $sql = "UPDATE producto 
                SET nombre=:nombre, descripcion=:descripcion, marca_id=:marcaid, modelo=:modelo, 
                subcategoria_id=:subcategoriaid, estado=:estado, precio=:precio  
                WHERE id_producto = :idproducto";
                $stmt = $this->DB->prepare($sql);

            }else
            {
                $sql = "UPDATE producto 
                SET nombre=:nombre, descripcion=:descripcion, marca_id=:marcaid, modelo=:modelo, 
                subcategoria_id=:subcategoriaid, estado=:estado, url_imagen=:urlimagen, precio=:precio  
                WHERE id_producto = :idproducto";
                $stmt = $this->DB->prepare($sql);
                $stmt->bindValue(':urlimagen', $producto->getUrlimagen());

            }
        
            $stmt->bindValue(':nombre', $producto->getNombre());
            $stmt->bindValue(':descripcion', $producto->getDescripcion());
            $stmt->bindValue(':marcaid', $producto->getMarcaid());
            $stmt->bindValue(':modelo', $producto->getModelo());
            $stmt->bindValue(':subcategoriaid', $producto->getSubcategoriaid());
            $stmt->bindValue(':estado', $producto->getEstado());
            $stmt->bindValue(':precio', $producto->getPrecio());
            $stmt->bindValue(':idproducto', $producto->getIdproducto());
            $stmt->execute();

        }catch(PDOException $e)
        {
            return $e->getMessage();
        }
        
    }

}