<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InsumoCirugia
 *
 * @author MARGOTH TAPIA
 */
class InsumoCirugia {
    
    private $idic;
    private $idinsumo;
    private $idcirugia;
    private $cantidadinsumo;
    
    function __construct($idic, $idinsumo, $idcirugia, $cantidadinsumo) {
        $this->idic = $idic;
        $this->idinsumo = $idinsumo;
        $this->idcirugia = $idcirugia;
        $this->cantidadinsumo = $cantidadinsumo;
    }

    function getIdic() {
        return $this->idic;
    }

    function getIdinsumo() {
        return $this->idinsumo;
    }

    function getIdcirugia() {
        return $this->idcirugia;
    }

    function getCantidadinsumo() {
        return $this->cantidadinsumo;
    }

    function setIdic($idic) {
        $this->idic = $idic;
    }

    function setIdinsumo($idinsumo) {
        $this->idinsumo = $idinsumo;
    }

    function setIdcirugia($idcirugia) {
        $this->idcirugia = $idcirugia;
    }

    function setCantidadinsumo($cantidadinsumo) {
        $this->cantidadinsumo = $cantidadinsumo;
    }

}
