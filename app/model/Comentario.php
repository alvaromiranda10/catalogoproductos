<?php 

class Comentarios
{
    private $ID_COMENTARIO;
    private $resena;
    private $rankeo;
    private $fecha;
    private $activo;
    private $mail;

    public function __construct($resena, $rankeo, $fecha, $activo, $mail){

        $this->resena = $resena;
        $this->rankeo = $rankeo;
        $this->fecha = $fecha;
        $this->activo = $activo;
        $this->mail = $mail;
    }

    
}

?> 