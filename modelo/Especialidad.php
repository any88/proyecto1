<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Especialidad
 *
 * @author MARGOTH TAPIA
 */
class Especialidad {
   
    private $idEspecialidad;
    private $nombreespecialidad;
    private $esquirurgica;
            
    function __construct($idEspecialidad, $nombreespecialidad, $esquirurgica) {
        $this->idEspecialidad = $idEspecialidad;
        $this->nombreespecialidad = $nombreespecialidad;
        $this->esquirurgica = $esquirurgica;
    }
    
    function getIdEspecialidad() {
        return $this->idEspecialidad;
    }

    function getNombreespecialidad() {
        return $this->nombreespecialidad;
    }

    function setIdEspecialidad($idEspecialidad) {
        $this->idEspecialidad = $idEspecialidad;
    }

    function setNombreespecialidad($nombreespecialidad) {
        $this->nombreespecialidad = $nombreespecialidad;
    }
    
    function getEsquirurgica() {
        return $this->esquirurgica;
    }

    function setEsquirurgica($esquirurgica) {
        $this->esquirurgica = $esquirurgica;
    }
   
}
