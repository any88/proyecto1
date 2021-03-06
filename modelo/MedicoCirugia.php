<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MedicoCirugia
 *
 * @author MARGOTH TAPIA
 */
class MedicoCirugia {
    
    private $idmc;
    private $idmedico;
    private $idcirugia;
    private $fecha;
    private $idtransaccion;
    private $rol;
    private $id_trabajador;
            
    function __construct($idmc, $idmedico, $idcirugia, $fecha, $idtransaccion,$prol,$id_trabajador) {
        $this->idmc = $idmc;
        $this->idmedico = $idmedico;
        $this->idcirugia = $idcirugia;
        $this->fecha = $fecha;
        $this->idtransaccion = $idtransaccion;
        $this->rol=$prol;
        $this->id_trabajador=$id_trabajador;
    }

    function getIdmc() {
        return $this->idmc;
    }

    function getIdmedico() {
        return $this->idmedico;
    }
    function getTrabajador() {
        return $this->id_trabajador;
    }

    function getIdcirugia() {
        return $this->idcirugia;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getIdtransaccion() {
        return $this->idtransaccion;
    }

    function getRol() {
        return $this->rol;
    }
    
}
