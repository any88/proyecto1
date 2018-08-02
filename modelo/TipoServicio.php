<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoServicio
 *
 * @author MARGOTH TAPIA
 */
class TipoServicio {
    
    private $idTipoServicio;
    private $tipoServicio;
    
    public function __construct($idTipoServicio, $tipoServicio) {
        $this->idTipoServicio = $idTipoServicio;
        $this->tipoServicio = $tipoServicio;
    }

    public function getIdTipoServicio() {
        return $this->idTipoServicio;
    }

    public function getTipoServicio() {
        return $this->tipoServicio;
    }

    public function setIdTipoServicio($idTipoServicio) {
        $this->idTipoServicio = $idTipoServicio;
    }

    public function setTipoServicio($tipoServicio) {
        $this->tipoServicio = $tipoServicio;
    }

}
