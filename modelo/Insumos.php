<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Insumos
 *
 * @author MARGOTH TAPIA
 */
class Insumos {
    
    private $idInsumo;
    private $nombre;
    private $cant_min_almacen;
    private $id_categoria_almacen;


    public function __construct($idInsumo, $nombre, $cant_min_almacen,$p_id_cat_almacen) {
        $this->idInsumo = $idInsumo;
        $this->nombre = $nombre;
        $this->cant_min_almacen = $cant_min_almacen;
        $this->id_categoria_almacen=$p_id_cat_almacen;
    }

    public function getIdInsumo() {
        return $this->idInsumo;
    }

    public function getNombre() {
        return $this->nombre;
    }
    function getCant_min_almacen() {
        return $this->cant_min_almacen;
    }
    function getId_categoria_almacen() {
        return $this->id_categoria_almacen;
    }


     
   

}
