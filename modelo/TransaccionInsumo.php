<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TransaccionInsumo
 *
 * @author MARGOTH TAPIA
 */
class TransaccionInsumo {
    
    private $idti;
    private $idtransaccion;
    private $idinsumo;
    private $cantidadinsumo;
    
    function __construct($idti, $idtransaccion, $idinsumo, $cantidadinsumo) {
        $this->idti = $idti;
        $this->idtransaccion = $idtransaccion;
        $this->idinsumo = $idinsumo;
        $this->cantidadinsumo = $cantidadinsumo;
    }

    function getIdti() {
        return $this->idti;
    }

    function getIdtransaccion() {
        return $this->idtransaccion;
    }

    function getIdinsumo() {
        return $this->idinsumo;
    }

    function getCantidadinsumo() {
        return $this->cantidadinsumo;
    }

    function setIdti($idti) {
        $this->idti = $idti;
    }

    function setIdtransaccion($idtransaccion) {
        $this->idtransaccion = $idtransaccion;
    }

    function setIdinsumo($idinsumo) {
        $this->idinsumo = $idinsumo;
    }

    function setCantidadinsumo($cantidadinsumo) {
        $this->cantidadinsumo = $cantidadinsumo;
    }
}
