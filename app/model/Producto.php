<?php

    class Producto{
        private $id_producto;
        private $nombre;
        private $descripcion;
        private $marca_id;
        private $modelo;
        private $url_imagen;
        private $precio;
        private $subcategoria_id;
        private $estado;
        
        public function getIdproducto() { 
             return $this->id_producto; 
        } 
    
        public function setIdproducto($id_producto) {  
            $this->id_producto = $id_producto; 
        } 
    
        public function getNombre() { 
             return $this->nombre; 
        } 
    
        public function setNombre($nombre) {  
            $this->nombre = $nombre; 
        } 
    
        public function getDescripcion() { 
             return $this->descripcion; 
        } 
    
        public function setDescripcion($descripcion) {  
            $this->descripcion = $descripcion; 
        } 
    
        public function getMarcaid() { 
             return $this->marca_id; 
        } 
    
        public function setMarcaid($marca_id) {  
            $this->marca_id = $marca_id; 
        } 
    
        public function getModelo() { 
             return $this->modelo; 
        } 
    
        public function setModelo($modelo) {  
            $this->modelo = $modelo; 
        } 
        
        public function getUrlimagen() { 
             return $this->url_imagen; 
        } 
    
        public function setUrlimagen($url_imagen) {  
            $this->url_imagen = $url_imagen; 
        } 
        
        public function getPrecio() { 
             return $this->precio; 
        } 
    
        public function setPrecio($precio) {  
            $this->precio = $precio; 
        } 
    
        public function getSubcategoriaid() { 
             return $this->subcategoria_id; 
        } 
    
        public function setSubcategoriaid($subcategoria_id) {  
            $this->subcategoria_id = $subcategoria_id; 
        } 
    
        public function getEstado() { 
             return $this->estado; 
        } 
    
        public function setEstado($estado) {  
            $this->estado = $estado; 
        } 


    }

?>