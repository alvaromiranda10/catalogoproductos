<?php

    class Categoria
    {
        private $ID_CATEGORIA;
        private $nombre;
        private $estado;

        
        
    public function getID_CATEGORIA()
    { 
 		return $this->IDCATEGORIA; 
	} 

    public function setID_CATEGORIA($IDCATEGORIA)
    {  
		$this->IDCATEGORIA = $IDCATEGORIA; 
	} 

    public function getNombre()
    { 
 		return $this->nombre; 
	} 

    public function setNombre($nombre)
    {  
		$this->nombre = $nombre; 
	} 

    public function getEstado()
    { 
 		return $this->estado; 
	} 

    public function setEstado($estado)
    {  
		$this->estado = $estado; 
	} 
    
}