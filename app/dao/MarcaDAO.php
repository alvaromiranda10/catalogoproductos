<?php
require __DIR__ . '/../model/Marca.php';
require_once __DIR__ . '/../BD/Conexion.php';

class MarcaDAO
{

    private $DB;
    private $marca;

    public function __construct()
    {
        $this->DB = new Conexion();
        $this->marca = new Marca();

    }

    public function read()
    {
        try 
        {
            $stmt = $this->DB->prepare("SELECT * FROM marca");
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
                
        } catch (PDOException $e) 
        {
            return $e->getMessage();
        }
    }
    

    public function delete($id_marca)
    {
        try 
        {
            $stmt = $this->DB->prepare("DELETE FROM marca WHERE ID_MARCA = ?");
            $stmt->bindParam(1, $id_marca);
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

    public function insert($marca)
    {
        try
        {
            $stmt = $this->DB->prepare("INSERT INTO marca (ID_MARCA, nombre, estado) VALUES (NULL, ?, ?)");
            $stmt->bindValue(1, $marca->getNombre());
            $stmt->bindValue(2, $marca->getEstado());
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

    public function update($marca)
    {
        try
        {
            $stmt = $this->DB->prepare("UPDATE marca SET nombre = ?, estado = ?  WHERE ID_MARCA = ?");
            $stmt->bindValue(1, $marca->getNombre());
            $stmt->bindValue(2, $marca->getEstado());
            $stmt->bindValue(3, $marca->getID_MARCA());
            $stmt->execute();

        }catch(PDOException $e)
        {
            return $e->getMessage();
        }
        
    }

}