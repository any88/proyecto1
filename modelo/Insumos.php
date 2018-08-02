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
    private $precioUnitario;
    
    public function __construct($idInsumo, $nombre, $precioUnitario) {
        $this->idInsumo = $idInsumo;
        $this->nombre = $nombre;
        $this->precioUnitario = $precioUnitario;
    }

    public function getIdInsumo() {
        return $this->idInsumo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecioUnitario() {
        return $this->precioUnitario;
    }

    public function setIdInsumo($idInsumo) {
        $this->idInsumo = $idInsumo;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPrecioUnitario($precioUnitario) {
        $this->precioUnitario = $precioUnitario;
    }

}
