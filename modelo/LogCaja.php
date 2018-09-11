<?php

class LogCaja
{
    private $id_log_caja;
    private $accion;
    private $motivo;
    private $cantidad;
    private $fecha;
    private $id_usuario;
    private $nombre_entrega;
            
    function __construct($id_log_caja, $accion, $motivo, $cantidad, $fecha, $id_usuario,$nombre_entrega) {
        $this->id_log_caja = $id_log_caja;
        $this->accion = $accion;
        $this->motivo = $motivo;
        $this->cantidad = $cantidad;
        $this->fecha = $fecha;
        $this->id_usuario = $id_usuario;
        $this->nombre_entrega=$nombre_entrega;
    }
    function getNombre_entrega() {
        return $this->nombre_entrega;
    }

        
    function getId_log_caja() {
        return $this->id_log_caja;
    }

    function getAccion() {
        return $this->accion;
    }

    function getMotivo() {
        return $this->motivo;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getId_usuario() {
        return $this->id_usuario;
    }



}
