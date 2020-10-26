<?php

    class Subcategoria{
        private $ID_SUBCATEGORIA;
        private $nombre;
        private $CATEGORIA_ID;
        private $estado;
        
        public function getID_SUBCATEGORIA() { 
             return $this->ID_SUBCATEGORIA; 
        } 
    
        public function setID_SUBCATEGORIA($ID_SUBCATEGORIA) {  
            $this->ID_SUBCATEGORIA = $ID_SUBCATEGORIA; 
        } 
        
        public function getNombre() { 
             return $this->nombre; 
        } 
    
        public function setNombre($nombre) {  
            $this->nombre = $nombre; 
        } 

        public function getCATEGORIA_ID() { 
             return $this->CATEGORIA_ID; 
        } 
    
        public function setCATEGORIA_ID($CATEGORIA_ID) {  
            $this->CATEGORIA_ID = $CATEGORIA_ID; 
        } 

        public function getEstado() { 
             return $this->estado; 
        } 
    
        public function setEstado($estado) {  
            $this->estado = $estado; 
        } 
    }




?>