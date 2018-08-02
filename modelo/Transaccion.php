<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Transaccion
 *
 * @author MARGOTH TAPIA
 */
class Transaccion {

    private $idTransaccion;
    private $idTipoTransaccion;
    private $fecha;
    private $monto;
    private $motivo;
    
    public function __construct($idTransaccion, $idTipoTransaccion, $fecha, $monto, $motivo) {
        $this->idTransaccion = $idTransaccion;
        $this->idTipoTransaccion = $idTipoTransaccion;
        $this->fecha = $fecha;
        $this->monto = $monto;
        $this->motivo = $motivo;
    }
    
    public function getIdTransaccion() {
        return $this->idTransaccion;
    }

    public function getIdTipoTransaccion() {
        return $this->idTipoTransaccion;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function getMotivo() {
        return $this->motivo;
    }

    public function setIdTransaccion($idTransaccion) {
        $this->idTransaccion = $idTransaccion;
    }

    public function setIdTipoTransaccion($idTipoTransaccion) {
        $this->idTipoTransaccion = $idTipoTransaccion;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setMonto($monto) {
        $this->monto = $monto;
    }

    public function setMotivo($motivo) {
        $this->motivo = $motivo;
    }

}
