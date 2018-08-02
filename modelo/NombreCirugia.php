<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NombreCirugia
 *
 * @author MARGOTH TAPIA
 */
class NombreCirugia {
    
    private $idNombreCirugia;
    private $nombreCirugia;
    private $idEspecialidad;


    public function __construct($idNombreCirugia, $nombreCirugia, $idEspecialidad) {
        $this->idNombreCirugia = $idNombreCirugia;
        $this->nombreCirugia = $nombreCirugia;
        $this->idEspecialidad = $idEspecialidad;
    }

    public function getIdNombreCirugia() {
        return $this->idNombreCirugia;
    }

    public function getNombreCirugia() {
        return $this->nombreCirugia;
    }

    public function setIdNombreCirugia($idNombreCirugia) {
        $this->idNombreCirugia = $idNombreCirugia;
    }

    public function setNombreCirugia($nombreCirugia) {
        $this->nombreCirugia = $nombreCirugia;
    }
    
    function getIdEspecialidad() {
        return $this->idEspecialidad;
    }

    function setIdEspecialidad($idEspecialidad) {
        $this->idEspecialidad = $idEspecialidad;
    }

}
