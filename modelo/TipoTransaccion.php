<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoTransaccion
 *
 * @author MARGOTH TAPIA
 */
class TipoTransaccion {
    
    private $idTipoTransaccion;
    private $tipoTransaccion;
    
    public function __construct($idTipoTransaccion, $tipoTransaccion) {
        $this->idTipoTransaccion = $idTipoTransaccion;
        $this->tipoTransaccion = $tipoTransaccion;
    }
    
    public function getIdTipoTransaccion() {
        return $this->idTipoTransaccion;
    }

    public function getTipoTransaccion() {
        return $this->tipoTransaccion;
    }

    public function setIdTipoTransaccion($idTipoTransaccion) {
        $this->idTipoTransaccion = $idTipoTransaccion;
    }

    public function setTipoTransaccion($tipoTransaccion) {
        $this->tipoTransaccion = $tipoTransaccion;
    }



}
