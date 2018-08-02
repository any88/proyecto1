<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TransaccionTrabajador
 *
 * @author MARGOTH TAPIA
 */
class TransaccionTrabajador {
    
    private $idtt;
    private $dtransaccion;
    private $idtrabajador;
    private $observaciones;
    
    function __construct($idtt, $dtransaccion, $idtrabajador, $observaciones) {
        $this->idtt = $idtt;
        $this->dtransaccion = $dtransaccion;
        $this->idtrabajador = $idtrabajador;
        $this->observaciones = $observaciones;
    }

    function getIdtt() {
        return $this->idtt;
    }

    function getDtransaccion() {
        return $this->dtransaccion;
    }

    function getIdtrabajador() {
        return $this->idtrabajador;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function setIdtt($idtt) {
        $this->idtt = $idtt;
    }

    function setDtransaccion($dtransaccion) {
        $this->dtransaccion = $dtransaccion;
    }

    function setIdtrabajador($idtrabajador) {
        $this->idtrabajador = $idtrabajador;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }
}
