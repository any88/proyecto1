<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NombreAnalisisLaboratorio
 *
 * @author MARGOTH TAPIA
 */
class NombreAnalisisLaboratorio {
    
    private $idnombreanalisis;
    private $nombreanalisis;
    private $idtipoanalisis;
    
    function __construct($idnombreanalisis, $nombreanalisis, $idtipoanalisis) {
        $this->idnombreanalisis = $idnombreanalisis;
        $this->nombreanalisis = $nombreanalisis;
        $this->idtipoanalisis = $idtipoanalisis;
    }

    function getIdnombreanalisis() {
        return $this->idnombreanalisis;
    }

    function getNombreanalisis() {
        return $this->nombreanalisis;
    }

    function getIdtipoanalisis() {
        return $this->idtipoanalisis;
    }

    function setIdnombreanalisis($idnombreanalisis) {
        $this->idnombreanalisis = $idnombreanalisis;
    }

    function setNombreanalisis($nombreanalisis) {
        $this->nombreanalisis = $nombreanalisis;
    }

    function setIdtipoanalisis($idtipoanalisis) {
        $this->idtipoanalisis = $idtipoanalisis;
    }

}
