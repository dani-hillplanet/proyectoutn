<?php
namespace controlador;

require_once "controlador.php";

require_once "./interfaces/vistaInterface.php";

use vistaInterface\VistaInterface as inter;

use controlador\Controlador as ctrls;

class ControladorVista extends ctrls implements inter {

    public $bg_color;

    public function __construct($bg_color = "lightGrey"){

        parent::__construct();

        $this->bg_color = $bg_color;

    }

    public function getHeaderVista($title){
        include self::ruta_vistas . "header.php";
    }

    public function getVista(){
        
        $seccion = isset( $_GET["seccion"] ) ? $this->limpiarGet( $_GET["seccion"] ) : "inicio"; 

        $data_actual = array();

        if( ! isset( $_POST["url"] ) ){
            
            $this->getHeaderVista( $seccion );

        }
        
        $ctrl_session = new controladorSession();

        if( $this->checkForSession() ){     
            
            if( $seccion != "inicio" && in_array( $seccion, $this->getSeccionesSession() ) ){

                switch($seccion){

                    case 'login':

                        $this->seccion = "login";
                        
                        if( isset( $_POST["url"] ) ){
                            
                            unset( $_POST["url"] );

                            $mensajes_error = array();

                            $errors = 0;

                            if( !isset( $_POST["email"] ) ){

                                $mensajes_error = array( "email" => "El email o la contraseña no son los correctos." );

                                $errors ++;

                            }else if( $ctrl_session->checkIfEmail( $_POST["email"] ) ){

                                $mensajes_error = array( "email" => "El email no tiene el formato indicado. Ej. test@test.com" );

                                $errors ++;

                            }

                            if( !isset($_POST["pass"] ) ){

                                $mensajes_error = array( "pass" => "Debes ingresar un password." );

                                $errors ++;
                            }

                            if( $errors > 0 ){

                                $this->devolverJson( array( "mensaje" => $mensajes_error, "estado" => false ));

                            }else{

                                $usuario = $ctrl_session->getUsuario( $_POST );

                                if(! is_array( $usuario ) ){
                                    
                                    $this->devolverJson( array( "mensaje" => "El email o la contraseña no son los correctos.", "estado" => false ));
                                
                                }else{

                                    $ctrl_session->setSession($usuario["ID"]);

                                    $this->devolverJson( array( "mensaje" => "Haz ingresado correctamente. Te redirigiremos en instantes.", "estado" => true ));

                                }

                            }

                        }

                    break;
                    case 'registrarse':

                        $this->seccion = "registrarse";

                        if( isset( $_POST["url"] ) ){

                            $counter_error = 0;

                            if( $_POST["nombre"] == "" ){

                                $mensaje['nombre'] = "El nombre de usuario esta vacio.";

                            }else if( isset( $_POST["nombre"] ) ){

                                $data["nombre"] = $this->limpiarPostString($_POST["nombre"]);
                                
                                if( is_array( $ctrl_session->getUsuario( $data ) ) ){

                                    $mensaje['nombre'] = "El nombre de usuario ya existe.";

                                    $counter_error ++;

                                }
                            }

                            if( $_POST["email"] == "" ){

                                $mensaje['email'] = "El email de usuario esta vacio.";
                                
                            }else if ( $ctrl_session->checkIfEmail( $_POST["email"] ) ) {

                                $mensaje['email'] = "El formato del email es incorrecto";

                            }else if( isset( $_POST["email"] ) ){

                                $data["email"] = $this->limpiarPostString($_POST["email"]);

                                if(is_array( $ctrl_session->getUsuario( $data )) ){

                                    $mensaje['email'] = "El email ya existe.";

                                    $counter_error ++;
                                    
                                }
                            }

                            if( $counter_error > 0 ){

                                $this->devolverJson( array( "mensaje" => $mensaje, "estado" => false ));

                            }else{

                                if( $ctrl_session->setUsuario( $_POST ) ){

                                    $this->devolverJson( array( "mensaje" => "El usuario ha sido registrado efectivamente. Te redirigiremos en instantes.", "estado" => true ));

                                }else{

                                    $this->devolverJson( array( "mensaje" => "Hubo un error en la base de datos. Intentalo nuevamente más tarde.", "estado" => false ));

                                }

                            }

                        }
                    break;
                    case 'recuperar_contrasena':

                        $this->seccion = "recuperar_contrasena";

                    break;
                }
            }else{
                $this->seccion = "login";
            }

        }else{

            if( ! isset( $_POST["url"] ) ){

                $this->getMenu();
                
            }

            if( $seccion != "inicio" ){
                
                if( in_array( $seccion, $this->getSecciones() ) ){

                    $this->seccion = $seccion ;

                    switch($seccion){

                        case 'actualizar':
                            
                            $data_actual = (new \modelo\ModeloSession() )->getUsuario( array( "ID"=> $_SESSION["user_id"] ) );

                            if( isset( $_POST["url"] ) ){

                                if( $ctrl_session->updateUsuario( $_POST, $data_actual ) ){

                                    $this->devolverJson( array( "mensaje" => "El usuario con nombre {$data_actual['nombre']} ha sido actualizado correctamente.", "estado" => true ) );
                        
                                }else{
                    
                                    $this->devolverJson( array( "mensaje" => "No hemos podido actualizar. Intentalo nuevamente más tarde.", "estado" => false ) );
                    
                                }

                            }

                        break;

                        case 'eliminar':
                            if( isset( $_POST["url"] ) ){

                                $id = intval( $_POST["id"] );

                                //echo json_encode($ctrl_session->deleteUsuario($id));die();
                                if( $ctrl_session->deleteUsuario($id) ){
                                    
                                    $ctrl_session->unsetSession();

                                    $this->devolverJson( array( "mensaje" => "Usuario eliminado", "estado" => true ) );

                                }else{

                                    $this->devolverJson( array( "mensaje" => "Hubo un error. Por favor intentalo más tarde.", "estado" => false ) );
                                    
                                }
                                
                            }

                        break;

                        case 'salir':
                            
                            unset( $_SESSION["validarIngreso"] );
                            
                            unset( $_SESSION["user_id"] );

                            
                            $this->redirect("/proyecto_utn", $statusCode = 303);

                        break;

                    }

                }else{

                    $this->redirect("/proyecto_utn", $statusCode = 303);

                }

            }else{

                $this->seccion = "inicio";
            }

        }

        echo $this->devolverTemplate( self::ruta_vistas . "contenido.php", $data_actual );


        $this->getFooterVista();
    }

    public function getFooterVista(){

        include self::ruta_vistas . "footer.php";

    }

    public function getSecciones(){

        return ["noticias"=>"noticias", "contacto"=>"contacto", "quienes-somos"=>"quienes-somos", "actualizar"=>"actualizar", "salir"=>"salir", "eliminar"=>"eliminar"];
    
    }

    public function getMenu(){

        echo '<header>';

            include "./vistas/nav.php";

        echo '</header>';

    }

    public function getSeccionesSession(){

        return ["login"=>"login", "registrarse"=>"registrarse"];

    }
}