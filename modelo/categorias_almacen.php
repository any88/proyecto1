<?php

class CategoriasAlmacen
{
    private $id_categoria_almacen;
    private $nombre_categoria;
    
    function __construct($id_categoria_almacen, $nombre_categoria) {
        $this->id_categoria_almacen = $id_categoria_almacen;
        $this->nombre_categoria = $nombre_categoria;
    }
    function getId_categoria_almacen() {
        return $this->id_categoria_almacen;
    }

    function getNombre_categoria() {
        return $this->nombre_categoria;
    }



    
}

