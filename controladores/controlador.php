<?php
namespace controlador;

class Controlador {

    protected $seccion;

    const ruta_vistas = OPCIONES["sitio"]["vistas"] . "/";

    public function __construct(){

        $this->seccion = "404";

    }

    public function devolverTemplate($ruta, $data = null){

        ob_start();

        include $ruta;

        $output = ob_get_clean();

        return $output;

    }

    public function limpiarPostString($post){
        
        $var_post = \strtolower(filter_var($post, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH));
        

        return $var_post;

    }

    public function limpiarGet($get){
        
        $var_get = \strtolower(filter_var($_GET["seccion"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH));
        

        return $var_get;

    }

    public function getNavItems(){

        $content = "";
       
        foreach($this->getSecciones() as $key=>$seccion){
            $active = isset($_GET["seccion"]) && $seccion == $this->limpiarGet($_GET["seccion"]) ? "active": ""; 
            $content .= "<li class='nav-item {$active}'><a class='nav-link' href='{$seccion}'>{$seccion}</a></li>";
        }

        echo $content;

    }

    protected function checkForSession(){

        return ! isset( $_SESSION["validarIngreso"] ) ? true : false;

    }

    protected function devolverJson($data){

        echo json_encode($data);
        
        die();

    }

    function redirect($url, $statusCode = 303){

        header('Location: ' . $url, true, $statusCode);

        die();

    }

}