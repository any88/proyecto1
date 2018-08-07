<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cirugia
 *
 * @author MARGOTH TAPIA
 */
class Cirugia {
    
    private $idServicio;
    private $idCirugia;
    private $idEspecialidad;
    private $idNombreC;
    private $duracion;
        
    public function __construct($idServicio, $idCirugia, $idEspecialidad, $idNombreC, $duracion) {
        $this->idServicio = $idServicio;
        $this->idCirugia = $idCirugia;
        $this->idEspecialidad = $idEspecialidad;
        $this->idNombreC = $idNombreC;
        $this->duracion = $duracion;
    }

    public function getIdServicio() {
        return $this->idServicio;
    }

    public function getIdCirugia() {
        return $this->idCirugia;
    }

    public function getIdNombreC() {
        return $this->idNombreC;
    }

    public function getDuracion() {
        return $this->duracion;
    }
  
    public function getIdEspecialidad() {
        return $this->idEspecialidad;
    }
}
