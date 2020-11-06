<?php 

class Comentarios
{
    private $id_comentario;
    private $resena;
    private $rankeo;
    private $fecha;
    private $estado;
    private $mail;

    function getIdcomentario() { 
        return $this->id_comentario; 
   } 

   function setIdcomentario($idcomentario) {  
       $this->id_comentario = $idcomentario; 
   } 
   
   function getResena() { 
        return $this->resena; 
   } 
   
   function setResena($resena) {  
       $this->resena = $resena; 
   } 

   function getRankeo() { 
        return $this->rankeo; 
   } 
   
   function setRankeo($rankeo) {  
       $this->rankeo = $rankeo; 
   } 
   
   function getFecha() { 
        return $this->fecha; 
   } 
   
   function setFecha($fecha) {  
       $this->fecha = $fecha; 
   } 
   
   function getEstado() { 
        return $this->estado; 
   } 
   
   function setEstado($estado) {  
       $this->estado = $estado; 
   } 
   
   function getMail() { 
        return $this->mail; 
   } 
   
   function setMail($mail) {  
       $this->mail = $mail; 
   } 
   
}

?> 