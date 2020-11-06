<?php
require __DIR__ . '/../model/Subcategoria.php';
require_once __DIR__ . '/../BD/Conexion.php';

class SubcategoriaDAO
{

    private $DB;
    private $subcategeoria;

    public function __construct()
    {
        $this->DB = new Conexion();
        $this->subcategeoria = new Subcategoria();

    }

    public function read($id_categoria)
    {
        try 
        {
            $stmt = $this->DB->prepare("SELECT * FROM subcategoria WHERE categoria_id = ?");
            $stmt->bindValue(1, $id_categoria);
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
                
        } catch (PDOException $e) 
        {
            return $e->getMessage();
        }

    }

    public function insert($subcategoria)
    {
        try
        {
            $stmt = $this->DB->prepare("INSERT INTO subcategoria ( nombre, CATEGORIA_ID, estado) VALUES ( ?, ?, ?)");
            $stmt->bindValue(1, $subcategoria->getNombre());
            $stmt->bindValue(2, $subcategoria->getCATEGORIA_ID());
            $stmt->bindValue(3, $subcategoria->getEstado());
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

    public function delete($id_subcategoria)
    {
        try 
        {
            $stmt = $this->DB->prepare("DELETE FROM subcategoria WHERE id_subcategoria = ?");
            $stmt->bindParam(1, $id_subcategoria);
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

    public function update($subcategoria)
    {
        try
        {
            $stmt = $this->DB->prepare("UPDATE subcategoria SET nombre = ?, estado = ?  WHERE id_subcategoria = ?");
            $stmt->bindValue(1, $subcategoria->getNombre());
            $stmt->bindValue(2, $subcategoria->getEstado());
            $stmt->bindValue(3, $subcategoria->getID_SUBCATEGORIA());
            $stmt->execute();

        }catch(PDOException $e)
        {
            return $e->getMessage();
        }

    }
}