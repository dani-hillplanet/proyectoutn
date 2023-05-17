<?php 
namespace vistaInterface;

interface VistaInterface{
    public function getHeaderVista($title);
    public function getFooterVista();
    public function getSecciones();
    public function getMenu();
    public function getSeccionesSession();
    public function limpiarPostString($post);
}