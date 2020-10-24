<?php
require_once('config.php');

    class Conexion extends PDO
    {
        
        public function __construct()
        
        {
            try {
                
                parent::__construct("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

            } catch (PDOException $e) {
                echo "Conexion fallida: " . $e->getMessage();
            }
        }

    }

?>