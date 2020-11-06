<?php
require __DIR__ . '/../model/Comentario.php';
require_once __DIR__ . '/../BD/Conexion.php';

class ComentarioDAO
{
    private $DB;
    private $comentario;

    public function __construct()
    {
        $this->DB = new Conexion();
        $this->comentario = new Comentario();

    }

}