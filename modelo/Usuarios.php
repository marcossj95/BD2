<?php
require_once 'config/Conectar.php';
class Usuarios {
    
    public $login;
    public $apellido;
    public $nombre;
    public $fecha;
    public $correo;
    public $contrasena;
    
    function __construct() {
        $this->db = new Conectar();
    }
    // le pasado un array datos y los inserta en la base de datos correspodiente
    public function registrar($datos){
        try{
            $query = $this->db->conexion()->prepare("INSERT INTO usuarios "
                    . "(login,apellido,nombre,fecha,correo,pass) VALUES('$datos->login', "
                    . "'$datos->apellido' , '$datos->nombre', now(), "
                    . "'$datos->correo', '$datos->contrasena')");         
            $query->execute();
            return true;
        }catch(PDOException $e){
            return false;
        }       
    }
    
    //Dado un nombre del usuario devuelve su id, ej cuando nos logeamos que
    //devuelva la id asociada para mostrar los datos de ese usuario
    public function getId($login,$contrasena){
        try{
            $query = $this->db->conexion()->query("SELECT id FROM usuarios WHERE "
                    . "login = '$login' AND pass = '$contrasena'");
            //echo $id;               
            $this->id = $query->fetch()['id'];

            return $this->id;
        }
        catch(Exception $e){
            die($e->getMessage());
        }
        
    }

    // le pasa la id y lista los datos de ese usuario con la id asociada
    public function listar($id){
        try{

            $stm = $this->db->conexion()->prepare("SELECT * FROM usuarios WHERE id = '$id'");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
        catch(Exception $e)		{
            die($e->getMessage());
        }
        
    }
    
    // actualiza la base de datos donde la id coicida con la id de la tabla de usuarios
    // $usuarios es un array con los datos del usuario
    public function editar($id,$datos){
        try{
            
            $stm = $this->db->conexion()->prepare("UPDATE usuarios SET login = "
                    . "apellido = '$datos->apellido', "
                    . "nombre = '$datos->nombre', correo = '$datos->correo'  "
                    . "WHERE id = '{$id}'");
            $stm->execute();

            
        } catch (Exception $e){
            die($e->getMessage());
        }
        
    }
    
    public function cambiar_contrasena($id, $contrasena){
        try{            
            $stm = $this->db->conexion()->prepare("UPDATE usuarios SET pass = "
                    . "'$contrasena'  WHERE id = '{$id}'");
            $stm->execute();

            
        } catch (Exception $e){
            die($e->getMessage());
        }
        
    }


    //elimina aun usuario dada la id pasada por parámetro
    public function eliminar($id){
        try{
            $stm = $this->db->conexion()->prepare("DELETE FROM usuarios WHERE "
                    . "id = '{$id}'");
            $stm->execute();
        } catch (Exception $e){
            die($e->getMessage());
        }
    }
    
    public function datosRepetidos($login,$correo){
        $extraer_datos = $this->db->conexion()->prepare("SELECT login, correo "
                . "FROM usuarios WHERE login = '$login' OR correo = '$correo'");  
        $extraer_datos->execute();
        
        while($datos = $extraer_datos->fetch()){                
            if($login == $datos['login'] || $correo == $datos['correo']){
                return true;
            }
        }
        return false;
    }
    
    public function devuelve_nombre($id){
        $extraer_datos = $this->db->conexion()->prepare("SELECT nombre "
                . "FROM usuarios WHERE id = '{$id}'");  
        $extraer_datos->execute();
        return $extraer_datos->fetch()['nombre'];
    }


    
}
