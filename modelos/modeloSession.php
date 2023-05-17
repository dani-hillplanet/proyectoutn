<?php
namespace modelo;

require(__DIR__ . '/modelo.php' );

use modelo\Modelo as mdl;

class ModeloSession extends mdl{

    private $conn_db;

    function __construct(){
        parent::__construct();
        $this->conn_db = $this->conn();
        $this->crearTablas();
    }

    private function crearTablas(){

        $prep = "CREATE TABLE IF NOT EXISTS usuarios(ID int(11) AUTO_INCREMENT, ";

        foreach(OPCIONES['db']['tablas']['usuarios']['campos'] as $key => $campo){

            $prep .= $key . " " . $campo['tipo'] . "(" . $campo['long'] . ") ". $campo['null'] . ", ";
            
        }

        $prep .= "PRIMARY KEY (ID) )";
        
        $stmt = $this->conn_db->prepare( $prep );

        $stmt->execute();
    }

    public function setUsuario($data){

        $prep = "INSERT INTO usuarios (nombre, email, pass) VALUES (:nombre, :email, :pass)";

        $stmt = $this->conn_db->prepare( $prep );

        $stmt->bindParam( ':nombre', $data['nombre'], \PDO::PARAM_STR );
        $stmt->bindParam( ':email', $data['email'], \PDO::PARAM_STR );
        $stmt->bindParam( ':pass', $data['pass'], \PDO::PARAM_STR );

        if( $this->executeConeccion( $stmt )){
            return $this->conn_db->lastInsertId();
        }else{
            return false;
        }

    }

    public function getUsuario( $data ){

        $prep = "SELECT * FROM usuarios WHERE";

        $counter = 1;

        foreach($data as $k => $d){

            if(count( $data ) == $counter ){

                $and = "";

            }else{

                $and = " AND";

            }

            $prep .= " $k = '$d'" . $and;

            $counter ++;
        }
        
        $stmt = $this->conn_db->prepare( $prep );
        
        if( $stmt->execute() ){

            return $stmt->fetch();
            
        }else{

            return false;

        }
        
    }

    public function deleteUsuario($id){

        $prep = "DELETE FROM usuarios WHERE ID = :id";

        $stmt = $this->conn_db->prepare( $prep );

        $stmt->bindParam( ':id', $id );

        return $this->executeConeccion($stmt);

    }

    public function updateUsuario($data){

        $prep = "UPDATE usuarios SET";
        
        foreach($data as $k=>$d){
            
            switch($k){
                case 'nombre':
                    $prep .= ' nombre = :nombre,';
                break;
                case 'email':
                    $prep .= ' email = :email,';
                break;
                
                case 'pass':
                    $prep .= ' pass = :pass,';
                break;
            }

        }

        $prep = rtrim($prep, ",");

        $prep .= " WHERE ID = :ID";
        
        $stmt = $this->conn_db->prepare( $prep );

        if(isset($data["nombre"])){
            $stmt->bindParam( ':nombre', $data['nombre'], \PDO::PARAM_STR );
        }
        if(isset($data["email"])){
            $stmt->bindParam( ':email', $data['email'], \PDO::PARAM_STR );
        }
        if(isset($data["pass"])){
            $stmt->bindParam( ':pass', $data['pass'], \PDO::PARAM_STR );
        }

        $stmt->bindParam( ':ID', $data['ID'], \PDO::PARAM_STR );


        return $this->executeConeccion($stmt);

    }

    public function getContrasena($ID){

        $stmt = $this->conn();

        $prep = "SELECT pass FROM usuarios WHERE ID = :ID";

        $stmt = $this->conn_db->prepare( $prep );

        $stmt->bindParam( ':ID', $ID, \PDO::PARAM_INT );

        

        if( $stmt->execute() ){

            return $stmt->fetch();
            
        }else{

            return false;

        }
    }
}

new ModeloSession();