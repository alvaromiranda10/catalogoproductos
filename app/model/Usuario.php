<?php
    class Usuario
    {
        private $ID_USUARIO;
        private $nombre;
        private $mail;
        private $contrasena;
        private $rol;
        private $estado;

        public function __contruc($ID_USUARIO, $nombre, $mail, $contrasena, $rol, $estado){
            $this->ID_USUARIO = $ID_USUARIO;
            $this->nombre = $nombre;
            $this->mail = $mail;
            $this->contrasena = $contrasena;
            $this->rol = $rol;
            $this->estado = $estado;
        }
        
        public function getID_USUARIO(){
            return $this->ID_USUARIO;
        }
        public function setID_USUARIO($ID_USUARIO){
            $this->ID_USUARIO = $ID_USUARIO;
        }
        
        public function getNombre(){
            return $this->nombre;
        }

        public function setNombre($nombre){
            $this->nombre = $nombre;
        }

        public function getMail(){
            return $this->mail;
        }

        public function setMail($mail){
            $this->mail = $mail;
        }

        public function getContrasena(){
            return $this->contrasena;
        }

        public function setContrasena($contrasena){
            $this->contrasena = $contrasena;
        }

        public function getRol(){
            return $this->rol;
        }

        public function setRol($rol){
            $this->rol = $rol;
        }

        public function getEstado(){
            return $this->estado;
        }

        public function setEstado($estado){
            $this->estado = $estado;
        }
   
    }

?>