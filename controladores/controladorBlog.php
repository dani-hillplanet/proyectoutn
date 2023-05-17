<?php 
namespace controlador;

require_once "controlador.php";

require_once "./interfaces/vistaInterface.php";

use controlador\Controlador as ctrl;

use blogInterface\BlogInterface as inter;

class controladorBlog extends ctrl implements inter{
    

    public function getNoticia( $data ){
        
        if(isset($data["titulo"])){
            $data_filtrado["titulo"] = $data["titulo"];
        }

        if(isset($data["contenido"])){
            $data_filtrado["contenido"] = $data["contenido"];
        }

        if(isset($data["ID"])){
            $data_filtrado["ID"] = intval( $data["ID"] );
        }

        
        if(isset($data["owner_id"])){
            $data_filtrado["owner_id"] = intval( $data["ID"] );
        }

        if(count($data_filtrado) > 0){

            return ( new \modelo\ModeloSession() )->getNoticia( $data_filtrado );

        }else{
            return false;
        }

    }

    public function setNoticia($data){
        
        $mensaje = array();

        $error_counter = 0 ; 

        if( isset( $data['nombre'] ) && $data["nombre"] != "" ){

            $datas['nombre'] = filter_var( $data['nombre'], FILTER_SANITIZE_STRING );

        }else{

            $mensaje['nombre'] = "Debes ingresar un nombre.";

            $error_counter ++;

        }

        if( isset( $data['email'] ) && $data["email"] != "" ){

            $datas['email'] = filter_var( $data['email'], FILTER_SANITIZE_EMAIL );

            
        }else{

            $mensaje['email'] = "Debes ingresar un email.";

            $error_counter ++; 

        }  
        
        if( isset( $data['pass'] ) && $data["pass"] != "" ){

            $datas['pass'] = filter_var( $data['pass'], FILTER_SANITIZE_STRING );
            
        }else{

            $mensaje['pass'] = "Debes ingresar una contraseña.";

            $error_counter ++;

        }
       
        if( isset( $data['pass2'] ) && $data["pass2"] != "" ){

            if( $data['pass2'] != $data['pass'] ){

                $mensaje['pass2'] = "Las contraseñas no coinciden.";

                $error_counter ++;

            }
            
        }else{
            
            $mensaje['pass2'] = "Debes ingresar nuevamente la contraseña.";

            $error_counter ++;
            
        }
        
        if( $error_counter > 0 ){

            $this->devolverJson( array( "mensaje" => $mensaje , "estado" => false ) );

        }else{

            $modeloSession = new \modelo\ModeloSession();

            $buscar_usuario = $modeloSession->getNoticia( $datas );
            
            if( ! $buscar_usuario ){

                $set_usuario = $modeloSession->setNoticia( $datas );

                if( $set_usuario ){

                    $_SESSION["validarIngreso"] = "ok";
                    $_SESSION["user_id"] = $set_usuario;

                    $this->devolverJson( array( "mensaje" => "El usuario con nombre {$datas['nombre']} ha sido dado de alta.", "estado" => true ) );

                }else{

                    $this->devolverJson( array( "mensaje" => "Hubo un error en la base de datos: " . $set_usuario , "estado" => false ) );
                
                }
            }else{

                $this->devolverJson( array( "mensaje" => "Ya existe un usuario con estos datos." , "estado" => false ) );

            }
        
        }

    }

    public function updateNoticia($data, $data_actual){
        
        $mensaje = array();

        $error_counter = 0 ; 

        $modeloSession = new \modelo\ModeloSession();

        $contrasena = $modeloSession->getContrasena($data["ID"]);
        
        if( $data["pass"] != $contrasena["pass"] ){

            $mensaje["pass"] = "La contraseña no es igual a la actual."; 

            $this->devolverJson( array( "mensaje" => $mensaje , "estado" => false ) );

        }

        if( isset( $data['nombre'] ) && $data["nombre"] != ""  ){

            if( $data_actual["nombre"] != $data["nombre"] ){

                $datas['nombre'] = filter_var( $data['nombre'], FILTER_SANITIZE_STRING );

            }

        }else{

            $mensaje['nombre'] = "Debes ingresar un nombre.";

            $error_counter ++;

        }

        if( isset( $data['email'] ) && $data["email"] != "" ){

            if( $data_actual["email"] != $data["email"] ){

                $datas['email'] = filter_var( $data['email'], FILTER_SANITIZE_EMAIL );

            }
            
        }else{

            $mensaje['email'] = "Debes ingresar un email.";

            $error_counter ++; 

        }  
       
        $datas['ID'] = filter_var( $data['ID'], FILTER_SANITIZE_NUMBER_INT );

        if( $error_counter > 0 ){

            $this->devolverJson( array( "mensaje" => $mensaje , "estado" => false ) );

        }else{

            $modeloSession = new \modelo\ModeloSession();
            
            return $modeloSession->updateNoticia( $datas ) ;
            
        }
    }
    
    public function deleteNoticia($id){

        $modeloSession = new \modelo\ModeloSession();

        return $modeloSession->deleteNoticia($id);

    }
}

