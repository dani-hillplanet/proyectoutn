<?php

define("OPCIONES", array(
    'sitio' => array(
        "url_raiz"=>"proyecto_utn/",
        "vistas" => "./vistas"
    ),
    'seguridad'=>array(
        'salt'=> 'FtWfEbvTgpfXezDeCVgcp51SLCNx1px3BAjWHPutM57I5YzrN2'
    ),
    'db'=>array(
        'mysql'=>'host',
        'port'=>'localhost',
        'name'=> 'proyecto_utn',
        'pass'=> '',
        'usuario'=> 'root',
        'tablas'=>array(
            'usuarios'=>array(
                'campos'=> array(
                    'nombre'=>array( 'tipo'=>'varchar', 'form'=>'text', 'long'=>'64', 'null'=> 'NOT NULL' ),
                    'email'=>array( 'tipo'=>'varchar', 'form'=>'email', 'long'=>'128', 'null'=> 'NOT NULL' ),
                    'pass'=>array( 'tipo'=>'varchar', 'form'=>'password', 'long'=> '256', 'null'=> 'NOT NULL' )
                )
            ),
            'blog'=>array(
                'campos'=> array(
                    'titulo'=> array( 'tipo'=>'varchar', 'form'=>'text', 'long'=>'64', 'null'=> 'NOT NULL' ),
                    'contenido'=> array( 'tipo'=>'varchar', 'form'=>'text', 'long'=>'256', 'null'=> 'NOT NULL' ),
                    'fecha_publicacion'=> array( 'tipo'=>'date', 'form'=>'date', 'long'=> '256', 'null'=> 'NOT NULL' ),
                    'fecha_edicion'=> array( 'tipo'=>'date', 'form'=>'date', 'long'=> '256', 'null'=> 'NOT NULL' ),
                    'owner_id'=> array( 'tipo'=>'int', 'form'=>'number', 'null'=> 'NOT NULL' ),
                )
            )
        ),
    )
));