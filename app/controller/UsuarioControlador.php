<?php
    require '../dao/UsuarioDAO.php';
    require '../modelo/Usuario.php';

    class UsuarioControlador{
        private $UDAO;

        public function __construct() {
            $this->UDAO = new UsuarioDAO();
        }

        public function login(){
            $u = new Usuario();
            $this->UDAO->read($u);
            
        }

    }
    
?>