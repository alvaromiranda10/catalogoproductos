<?php
require __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../BD/Conexion.php';

    class UsuarioDAO
    {

        private $DB;
        private $usuario;

        public function __construct()
        {
            $this->DB = new Conexion();
            $this->usuario = new Usuario();

        }
        
        public function read()
        {
            try 
            {
                $stmt = $this->DB->prepare("SELECT * FROM USUARIO");
                $stmt->execute();
                $results = $stmt->fetchAll();
                return $results;

            } catch (PDOException $e) 
            {
                return $e->getMessage();
            }
            
        }

        
        public function insert($Usuario)
        {
            try
            {
                $stmt = $this->DB->prepare("INSERT INTO usuario (ID_USUARIO, nombre, mail, contrasena, rol, estado) VALUES (NULL, ?, ?, ?, ?, '')");
                $stmt->bindValue(1, $Usuario->getNombre());
                $stmt->bindValue(2, $Usuario->getMail());
                $stmt->bindValue(3, $Usuario->getContrasena());
                $stmt->bindValue(4, $Usuario->getRol());
                $stmt->execute(); 
             
            }catch(PDOException $e) 
            {
                return $e->getMessage();
                
            }

        }

        public function delete($id_usuario)
        {
            try 
            {
                $stmt = $this->DB->prepare("DELETE FROM usuario WHERE ID_USUARIO = ?");
                $stmt->bindParam(1, $id_usuario);
                $stmt->execute();
                $resultado = $stmt->rowCount();

                if ($resultado >0) {
                    return $resultado;
    
                } else {
                    return $resultado;
                }

            } catch (PDOException $e) 
            {
                return $e->getMessage();
            }
        }

        public function update($Usuario)
        {
            try 
            {
                $stmt = $this->DB->prepare("UPDATE usuario SET nombre=?, mail=?, contrasena=?, rol=? WHERE ID_USUARIO = ? ");
                $stmt->bindValue(1, $Usuario->getNombre());
                $stmt->bindValue(2, $Usuario->getMail());
                $stmt->bindValue(3, $Usuario->getContrasena());
                $stmt->bindValue(4, $Usuario->getRol());
                $stmt->bindValue(5, $Usuario->getID_USUARIO());
                $stmt->execute(); 

            } catch (PDOException $e) 
            {
                return $e->getMessage();
            }
        }


        
        // LOGICA DEL NEGOCIO

        public function getUser($email, $contrasena)
        {
            $this->usuario->setMail($email);
            $this->usuario->setContrasena($contrasena);

            try 
            {
                $stmt = $this->DB->prepare("SELECT * from usuario WHERE mail = ? AND contrasena = ?");
                $stmt->bindValue(1,$this->usuario->getMail());
                $stmt->bindValue(2,$this->usuario->getContrasena());
                $stmt->execute();
                $resultado = $stmt->rowCount();

                if ($resultado >0) {
                    $this->getSesion($email);
                    return $resultado;
    
                } else {
                    return $resultado;
                }

            } catch (PDOException $e) 
            {
                return $e->getMessage();
            }
            
        }


        public function getSesion($email)
        {
            
            $_SESSION['estado'] = uniqid();
            $_SESSION['email'] = $email;

            try 
            {
                $stmt = $this->DB->prepare("UPDATE usuario SET estado= ? WHERE mail = ?");
                $stmt->bindValue(1,$_SESSION['estado']);
                $stmt->bindValue(2,$email);
                $stmt->execute();

            } catch (PDOException $e) 
            {
                return $e->getMessage();
            }
            
        }

        public function estadoSesion()
        {
            $estadoSesion= false;
            if(isset($_SESSION['estado']))
            {
                
            try 
            {
                $codigo = $_SESSION['estado'];
                $stmt = $this->DB->prepare("SELECT * FROM usuario WHERE estado = ?");
                $stmt->bindValue(1,$codigo);
                $stmt->execute();
                $resultado = $stmt->rowCount();

                if ($resultado >0) {
                    $estadoSesion = true;
                    return $estadoSesion;
    
                } else {
                    $estadoSesion = false;
                    return $estadoSesion;
                }


            } catch (PDOException $e) 
            {
                return $e->getMessage();
            }

            }else
            {

                $estadoSesion = false;
                return $estadoSesion;
            }

        }

        public function deleteSesion()
        {
            $estadoSesion= false;
            $codigo = $_SESSION['estado'];
            try 
            {
                $stmt = $this->DB->prepare("UPDATE usuario SET estado = '' WHERE estado = ?");
                $stmt->bindValue(1,$codigo);
                $stmt->execute();
                $resultado = $stmt->rowCount();

                if ($resultado >0) {
                    session_destroy();
                    $estadoSesion = true;
                    return $estadoSesion;
    
                } else {
                    $estadoSesion = false;
                    return $estadoSesion;
                }
                
            } catch (PDOException $e)
            {
                return $e->getMessage();
            }

        }

        
    }
