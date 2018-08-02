<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cargo
 *
 * @author MARGOTH TAPIA
 */
class Cargo {
    
    private $idCargo;
    private $nombreCargo;
    
    function __construct($idCargo, $nombreCargo) {
        $this->idCargo = $idCargo;
        $this->nombreCargo = $nombreCargo;
    }
    
    function getIdCargo() {
        return $this->idCargo;
    }

    function getNombreCargo() {
        return $this->nombreCargo;
    }

    function setIdCargo($idCargo) {
        $this->idCargo = $idCargo;
    }

    function setNombreCargo($nombreCargo) {
        $this->nombreCargo = $nombreCargo;
    }

}
