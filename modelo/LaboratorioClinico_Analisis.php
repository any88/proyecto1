<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LaboratorioClinico_Analisis
 *
 * @author MARGOTH TAPIA
 */
class LaboratorioClinico_Analisis {
    
    private $idlabclinanalab;
    private $idlabclinico;
    private $idlaboratorio;
    private $fecha;
    private $idtransaccion;
    
    function __construct($idlabclinanalab, $idlabclinico, $idlaboratorio, $fecha, $idtransaccion) {
        $this->idlabclinanalab = $idlabclinanalab;
        $this->idlabclinico = $idlabclinico;
        $this->idlaboratorio = $idlaboratorio;
        $this->fecha = $fecha;
        $this->idtransaccion = $idtransaccion;
    }
    
    function getLabclinanalab() {
        return $this->idlabclinanalab;
    }

    function getIdlabclinico() {
        return $this->idlabclinico;
    }

    function getIdlaboratorio() {
        return $this->idlaboratorio;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getIdtransaccion() {
        return $this->idtransaccion;
    }

    function setLabclinanalab($idlabclinanalab) {
        $this->idlabclinanalab = $idlabclinanalab;
    }

    function setIdlabclinico($idlabclinico) {
        $this->idlabclinico = $idlabclinico;
    }

    function setIdlaboratorio($idlaboratorio) {
        $this->idlaboratorio = $idlaboratorio;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setIdtransaccion($idtransaccion) {
        $this->idtransaccion = $idtransaccion;
    }
}
