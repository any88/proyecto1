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
    private $precio_base;

    function __construct($idTipoServicio, $tipoServicio, $precio_base) {
        $this->idTipoServicio = $idTipoServicio;
        $this->tipoServicio = $tipoServicio;
        $this->precio_base = $precio_base;
    }
    function getPrecio_base() {
        return $this->precio_base;
    }

    function getIdTipoServicio() {
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
