<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LaboratorioRadiologia
 *
 * @author MARGOTH TAPIA
 */
class LaboratorioRadiologia {
   
    private $idlabradiologia;
    private $nombrelabrad;
    private $ruc;
    
    function __construct($idlabradiologia, $nombrelabrad, $ruc) {
        $this->idlabradiologia = $idlabradiologia;
        $this->nombrelabrad = $nombrelabrad;
        $this->ruc = $ruc;
    }
    
    function getIdlabradiologia() {
        return $this->idlabradiologia;
    }

    function getNombrelabrad() {
        return $this->nombrelabrad;
    }

    function getRuc() {
        return $this->ruc;
    }

    function setIdlabradiologia($idlabradiologia) {
        $this->idlabradiologia = $idlabradiologia;
    }

    function setNombrelabrad($nombrelabrad) {
        $this->nombrelabrad = $nombrelabrad;
    }

    function setRuc($ruc) {
        $this->ruc = $ruc;
    }
}
