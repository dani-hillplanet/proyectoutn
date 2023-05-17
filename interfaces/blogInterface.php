<?php 
namespace blogInterface;

interface BlogInterface{
    public function getNoticia( $data );
    public function setNoticia($data);
    public function updateNoticia($data, $data_actual);
    public function deleteNoticia($id);
}