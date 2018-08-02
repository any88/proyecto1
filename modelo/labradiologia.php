<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of labradiologia
 *
 * @author MARGOTH TAPIA
 */
class labradiologia {
    
    private $idlabradiologia;
    private $nombrelabradiologia;
    private $ruc;
    
    function __construct($idlabradiologia, $nombrelabradiologia, $ruc) {
        $this->idlabradiologia = $idlabradiologia;
        $this->nombrelabradiologia = $nombrelabradiologia;
        $this->ruc = $ruc;
    }

    function getIdlabradiologia() {
        return $this->idlabradiologia;
    }

    function getNombrelabradiologia() {
        return $this->nombrelabradiologia;
    }

    function getRuc() {
        return $this->ruc;
    }

    function setIdlabradiologia($idlabradiologia) {
        $this->idlabradiologia = $idlabradiologia;
    }

    function setNombrelabradiologia($nombrelabradiologia) {
        $this->nombrelabradiologia = $nombrelabradiologia;
    }

    function setRuc($ruc) {
        $this->ruc = $ruc;
    }

}
