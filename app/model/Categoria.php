<?php

    class Categoria
    {
        private $ID_CATEGORIA;
        private $nombre;
        private $activo;

        
        
    public function getIDCATEGORIA()
    { 
 		return $this->IDCATEGORIA; 
	} 

    public function setIDCATEGORIA($IDCATEGORIA)
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

    public function getActivo()
    { 
 		return $this->activo; 
	} 

    public function setActivo($activo)
    {  
		$this->activo = $activo; 
	} 
    
}