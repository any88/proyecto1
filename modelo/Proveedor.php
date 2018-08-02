<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Proveedor
 *
 * @author MARGOTH TAPIA
 */
class Proveedor {
    
    private $idProveedor;
    private $nombre;
    private $RUC;
    
    public function __construct($idProveedor, $nombre, $RUC) {
        $this->idProveedor = $idProveedor;
        $this->nombre = $nombre;
        $this->RUC = $RUC;
    }

    public function getIdProveedor() {
        return $this->idProveedor;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getRUC() {
        return $this->RUC;
    }

    public function setIdProveedor($idProveedor) {
        $this->idProveedor = $idProveedor;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setRUC($RUC) {
        $this->RUC = $RUC;
    }

}
