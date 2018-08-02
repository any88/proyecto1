<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InsumoHospitalizacion
 *
 * @author MARGOTH TAPIA
 */
class InsumoHospitalizacion {
    
    private $idih;
    private $idinsumo;
    private $idhospitalizacion;
    private $fecha;
    private $cantidadinsumo;
    
    function __construct($idih, $idinsumo, $idhospitalizacion, $fecha, $cantidadinsumo) {
        $this->idih = $idih;
        $this->idinsumo = $idinsumo;
        $this->idhospitalizacion = $idhospitalizacion;
        $this->fecha = $fecha;
        $this->cantidadinsumo = $cantidadinsumo;
    }

    function getIdih() {
        return $this->idih;
    }

    function getIdinsumo() {
        return $this->idinsumo;
    }

    function getIdhospitalizacion() {
        return $this->idhospitalizacion;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getCantidadinsumo() {
        return $this->cantidadinsumo;
    }

    function setIdih($idih) {
        $this->idih = $idih;
    }

    function setIdinsumo($idinsumo) {
        $this->idinsumo = $idinsumo;
    }

    function setIdhospitalizacion($idhospitalizacion) {
        $this->idhospitalizacion = $idhospitalizacion;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setCantidadinsumo($cantidadinsumo) {
        $this->cantidadinsumo = $cantidadinsumo;
    }

}
