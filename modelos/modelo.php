<?php

namespace modelo;

class Modelo{

    public function __construct(){
        
        try{
            
            $dbh = new \PDO("mysql:host=". OPCIONES['db']['port'] , OPCIONES['db']['usuario'], OPCIONES['db']['pass']);
            $dbh->exec("CREATE DATABASE IF NOT EXISTS ".OPCIONES['db']['name'].";
            CREATE USER IF NOT EXISTS '".OPCIONES['db']['usuario']."'@'".OPCIONES['db']['port']."' IDENTIFIED BY '".OPCIONES['db']['pass']."';
            GRANT ALL ON ".OPCIONES['db']['name'].".* TO '".OPCIONES['db']['usuario']."'@'".OPCIONES['db']['port']."';
            FLUSH PRIVILEGES;")
            or die(print_r($dbh->errorInfo(), true));
        
        }catch(PDOException $e) {
            die("DB ERROR: " . $e->getMessage());
        }

    }

    static protected function conn(){

        $dbh = false;

        try {

            $dsn = "mysql:host=".OPCIONES['db']['port'].";dbname=".OPCIONES['db']['name'];
            
            $dbh = new \PDO($dsn, OPCIONES['db']['usuario'], OPCIONES['db']['pass']);

            $dbh->exec("set names utf8");

            return $dbh;

        } catch (PDOException $e){

            echo $e->getMessage();

        }

        return $dbh;
    }
    
    static protected function executeConeccion($stmt){

       return $stmt->execute();
       
    }

}