<?php
session_start();

require "./configuracion.php";
require "./modelos/modeloSession.php";
require "./controladores/controladorSession.php";
require "./controladores/controladorVista.php";


use controlador\ControladorVista as vista;

(new vista("#cecece"))->getVista();