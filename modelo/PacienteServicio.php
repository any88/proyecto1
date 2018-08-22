<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PacienteServicio
 *
 * @author MARGOTH TAPIA
 */
class PacienteServicio {
    
    private $idps;
    private $idpaciente;
    private $idservicio;
    private $fecha;
    private $idtransaccion;
    private $hora;
            
    function __construct($idps, $idpaciente, $idservicio, $fecha, $idtransaccion,$hora) {
        $this->idps = $idps;
        $this->idpaciente = $idpaciente;
        $this->idservicio = $idservicio;
        $this->fecha = $fecha;
        $this->idtransaccion = $idtransaccion;
        $this->hora=$hora;
    }

    function getIdps() {
        return $this->idps;
    }

    function getIdpaciente() {
        return $this->idpaciente;
    }

    function getIdservicio() {
        return $this->idservicio;
    }

    function getFecha() {
        return $this->fecha;
    }
    function getHora() {
        return $this->hora;
    }

    function getIdtransaccion() {
        return $this->idtransaccion;
    }

    function setIdps($idps) {
        $this->idps = $idps;
    }

    function setIdpaciente($idpaciente) {
        $this->idpaciente = $idpaciente;
    }

    function setIdservicio($idservicio) {
        $this->idservicio = $idservicio;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setIdtransaccion($idtransaccion) {
        $this->idtransaccion = $idtransaccion;
    }
}
