<?php 
namespace controlador;

require_once "controlador.php";

use controlador\Controlador as ctrl;

class controladorSession extends ctrl{
    

    public function getUsuario( $data ){
        
        $data_filtrado = array();

        if( isset( $data["nombre"] ) ){

            $data_filtrado["nombre"] = $data["nombre"];

        }

        if( isset( $data["email"] ) ){

            $data_filtrado["email"] = $data["email"];

        }

        if( isset( $data["pass"] ) ){

            $data_filtrado["pass"] = $this->encryptPassword( $data["pass"] );

        }

        if( isset( $data["ID"] ) ){

            $data_filtrado["ID"] = intval( $data["ID"] );

        }

        if( count( $data_filtrado ) > 0){

            return ( new \modelo\ModeloSession() )->getUsuario( $data_filtrado );

        }else{
            return false;
        }

    }

    public function setUsuario($data){
        
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

            $datas['pass'] = $this->encryptPassword( filter_var( $data['pass'], FILTER_SANITIZE_STRING ) );
            
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

            $buscar_usuario = $modeloSession->getUsuario( $datas );
            
            if( ! $buscar_usuario ){

                $set_usuario = $modeloSession->setUsuario( $datas );

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

    public function updateUsuario($data, $data_actual){
        
        $mensaje = array();

        $error_counter = 0 ; 

        $modeloSession = new \modelo\ModeloSession();

        $contrasena = $modeloSession->getContrasena( $data["ID"] );
        
        $contrasena_post = $this->encryptPassword( $data["pass"] );

        if( $contrasena_post != $contrasena["pass"] ){

            $mensaje["pass"] = "La contraseña no es correcta."; 

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
            
            return $modeloSession->updateUsuario( $datas ) ;
            
        }
    }
    
    public function deleteUsuario($id){

        $modeloSession = new \modelo\ModeloSession();

        return $modeloSession->deleteUsuario($id);

    }

    public function encryptPassword($pass){

        $pass = crypt($pass, OPCIONES["seguridad"]["salt"]);

        return $pass;

    }

    public function checkIfEmail( $email ){

        if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ){

            return true;

        }

        return false;

    }

    public function unsetSession(){

        unset( $_SESSION["validarIngreso"] );
                            
        unset( $_SESSION["user_id"] );

    }

    public function setSession( $user_id ){

        $_SESSION["validarIngreso"] = "ok";

        $_SESSION["user_id"] = $user_id; 

    }
}

