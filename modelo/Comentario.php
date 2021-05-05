<?php
require_once 'config/Conectar.php';
class Comentario {
    public $comentario;
    public $id_vino;
    public $id_usuario;
    public $fecha;
    public $fecha2;
            
    function __construct() {
        $this->db = new Conectar();
    }
    
    public function guardar_comentario($comentarios){
        try{
            $query = $this->db->conexion()->prepare("INSERT INTO comentarios "
                    . "(comentario,tiempo,id_vino,id_usuario) "
                    . "VALUES ('$comentarios->comentario', now(),"
                    . "'$comentarios->id_vino', '$comentarios->id_usuario')");            
            $query->execute();
            return true;
        }catch(PDOException $e){
            return false;
        }   
    }
    
    public function listar_comentario($id_vino){
        try{
            $stm = $this->db->conexion()->prepare("SELECT * FROM comentarios "
                    . "WHERE id_vino = '$id_vino'");
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
        catch(Exception $e)		{
            die($e->getMessage());
        }
    }
    
    public function listar_comentario_por_tiempo($datos){
        try{
            $stm = $this->db->conexion()->prepare("SELECT comentario,tiempo FROM "
                    . "comentarios WHERE tiempo BETWEEN '$datos->fecha' "
                    . "AND '$datos->fecha2' AND id_usuario = '$datos->id_usuario'");
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
}
