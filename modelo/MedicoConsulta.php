<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MedicoConsulta
 *
 * @author MARGOTH TAPIA
 */
class MedicoConsulta {
    
    private $idmc;
    private $idmedico;
    private $idconsulta;
    private $fecha;
    private $idtransaccion;
    
    function __construct($idmc, $idmedico, $idconsulta, $fecha, $idtransaccion) {
        $this->idmc = $idmc;
        $this->idmedico = $idmedico;
        $this->idconsulta = $idconsulta;
        $this->fecha = $fecha;
        $this->idtransaccion = $idtransaccion;
    }
    function getIdmc() {
        return $this->idmc;
    }

    function getIdmedico() {
        return $this->idmedico;
    }

    function getIdconsulta() {
        return $this->idconsulta;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getIdtransaccion() {
        return $this->idtransaccion;
    }

}
