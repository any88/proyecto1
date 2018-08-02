<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoRadiologia
 *
 * @author MARGOTH TAPIA
 */
class TipoRadiologia {
    
    private $idTipoRadiologia;
    private $tipoRadiologia;
    
    public function __construct($idTipoRadiologia, $tipoRadiologia) {
        $this->idTipoRadiologia = $idTipoRadiologia;
        $this->tipoRadiologia = $tipoRadiologia;
    }

    public function getIdTipoRadiologia() {
        return $this->idTipoRadiologia;
    }

    public function getTipoRadiologia() {
        return $this->tipoRadiologia;
    }

    public function setIdTipoRadiologia($idTipoRadiologia) {
        $this->idTipoRadiologia = $idTipoRadiologia;
    }

    public function setTipoRadiologia($tipoRadiologia) {
        $this->tipoRadiologia = $tipoRadiologia;
    }

}
