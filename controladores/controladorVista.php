<?php
namespace controladores;

require "controlador.php";

class ControladorVista extends Controlador {

    public $bg_color;

    public function __construct($bg_color = "lightGrey"){
        parent::__construct();
        $this->bg_color = $bg_color;
    }

}