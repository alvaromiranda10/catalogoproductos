<?php
require __DIR__ . '/../model/Categoria.php';
require_once __DIR__ . '/../BD/Conexion.php';

class CategoriaDAO
{

    private $DB;
    private $categoria;

    public function __construct()
    {
        $this->DB = new Conexion();
        $this->marca = new Categoria();

    }

    public function read()
    {
        try 
        {
            $stmt = $this->DB->prepare("SELECT * FROM categoria");
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
                
        } catch (PDOException $e) 
        {
            return $e->getMessage();
        }
    }
    

    
    public function insert($categoria)
    {
        try
        {
            $stmt = $this->DB->prepare("INSERT INTO categoria ( nombre, estado) VALUES ( ?, ?)");
            $stmt->bindValue(1, $categoria->getNombre());
            $stmt->bindValue(2, $categoria->getEstado());
            $stmt->execute();
            $resultado = $stmt->rowCount();
            
            if ($resultado >0) {
                return $resultado;
                
            } else {
                return $resultado;
            }
        } catch (PDOException $e) 
        {
            return $e->getMessage();
        }
        
    }
    
    public function delete($id_categoria)
    {

        try 
        {
            $stmt = $this->DB->prepare("DELETE FROM categoria WHERE id_categoria = ?");
            $stmt->bindParam(1, $id_categoria);
            $stmt->execute();
            $resultado = $stmt->rowCount();

            if ($resultado >0) {
                return $resultado;

            } else {
                return $resultado;
            }
        } catch (PDOException $e) 
        {
            return $e->getMessage();
        }
        
    }

    public function update($categoria)
    {
        try
        {
            $stmt = $this->DB->prepare("UPDATE categoria SET nombre = ?, estado = ?  WHERE id_categoria = ?");
            $stmt->bindValue(1, $categoria->getNombre());
            $stmt->bindValue(2, $categoria->getEstado());
            $stmt->bindValue(3, $categoria->getID_CATEGORIA());
            $stmt->execute();

        }catch(PDOException $e)
        {
            return $e->getMessage();
        }
       
    }

}