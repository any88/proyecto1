<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoAnalisisLaboratorio
 *
 * @author MARGOTH TAPIA
 */
class TipoAnalisisLaboratorio {
    
    private $idTipoAnalisisLaboratorio;
    private $tipoAnalisis;
    
    public function __construct($idTipoAnalisisLaboratorio, $tipoAnalisis) {
        $this->idTipoAnalisisLaboratorio = $idTipoAnalisisLaboratorio;
        $this->tipoAnalisis = $tipoAnalisis;
    }
    
    public function getIdTipoAnalisisLaboratorio() {
        return $this->idTipoAnalisisLaboratorio;
    }

    public function getTipoAnalisis() {
        return $this->tipoAnalisis;
    }

    public function setIdTipoAnalisisLaboratorio($idTipoAnalisisLaboratorio) {
        $this->idTipoAnalisisLaboratorio = $idTipoAnalisisLaboratorio;
    }

    public function setTipoAnalisis($tipoAnalisis) {
        $this->tipoAnalisis = $tipoAnalisis;
    }

}
