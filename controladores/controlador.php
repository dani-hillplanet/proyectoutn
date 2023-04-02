<?php
namespace controladores;

use interfaces\vistaInterface as inter;

require_once "./interfaces/vistaInterface.php";

class Controlador implements inter\vistaInterface{
    protected $seccion;
    const ruta_vistas = "./vistas/";

    public function __construct(){
        $this->seccion = "404";
    }
    
    public function getHeaderVista(){
        include self::ruta_vistas . "header.php";
    }

    public function getVista(){

        $get_var = $this->getGet();

        $this->getHeaderVista();

        if( isset($get_var) ){
            
            if(in_array($get_var, $this->getSecciones()) ){
                $this->seccion = $this->getSecciones()[$get_var];
            }

        }
        
        if($get_var == ""){
            $this->seccion = "inicio";
        }
        
        ob_start();

        include self::ruta_vistas . "contenido.php";

        $output = ob_get_clean();

        echo $output;

        $this->getFooterVista();
    }

    public function getFooterVista(){
        include self::ruta_vistas . "footer.php";
    }

    public function getSecciones(){
        return ["noticias"=>"noticias", "contacto"=>"contacto", "quienes-somos"=>"quienes-somos"];
    }

    public function getGet(){
        $var_get = "";
        if(isset($_GET["seccion"]))
            $var_get = \strtolower(filter_var($_GET["seccion"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH));

        return $var_get;
    }

    public function getNavItems(){
        $content = "";
       
        foreach($this->getSecciones() as $key=>$seccion){
            $active = $seccion == $this->getGet() ? "active": ""; 
            $content .= "<li class='nav-item {$active}'><a class='nav-link' href='{$seccion}'>{$seccion}</a></li>";
        }

        echo $content;
    }
}