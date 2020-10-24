<?php

    class Marca{
        private $ID_MARCA;
        private $nombre;
        private $estado;

        public function getID_MARCA()
        {
            return $this->ID_MARCA;
        }

        public function setID_MARCA($ID_MARCA) {
            $this->ID_MARCA = $ID_MARCA;
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }

        public function getEstado() {
            return $this->estado;
        }

        public function setEstado($estado) {
            $this->estado = $estado;
        }

    }
?>