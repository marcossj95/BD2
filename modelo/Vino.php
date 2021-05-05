<?php
require_once 'config/Conectar.php';
class Vino {
    
    function __construct() {
          $this->db = new Conectar();
    }
    
    public function listar_vino($id_vino){
        $stm = $this->db->conexion()->prepare("SELECT nombre, descripcion "
                . "FROM vinos WHERE id = '$id_vino'");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);   
    }
    
    public function guardar_valoracion($valoracion,$num_votaciones,$id_vino){
        try{           
            $query = $this->db->conexion()->prepare("UPDATE vinos SET valoracion = "
                    . "'$valoracion', num_votaciones = '$num_votaciones'  WHERE "
                    . "id = '$id_vino'");            
            $query->execute();
            return true;
        }catch(PDOException $e){
            return false;
        }   
    }
    
    public function extraerValoracion($id_vino){
        try{
        $extraer_valoracion = $this->db->conexion()->prepare("SELECT valoracion,"
                . "num_votaciones "
                . "FROM vinos WHERE id = '$id_vino'");
        $extraer_valoracion->execute();
        
        return $extraer_valoracion->fetchAll(PDO::FETCH_OBJ);
        }
        catch(Exception $e)		{
            die($e->getMessage());
        }    
    }
    
}