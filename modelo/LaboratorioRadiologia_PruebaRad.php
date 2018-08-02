<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LaboratorioRadiologia_PruebaRad
 *
 * @author MARGOTH TAPIA
 */
class LaboratorioRadiologia_PruebaRad {

    private $id_labradpruebarad;
    private $idlabradiologia;
    private $idradiologia;
    private $fecha;
    private $idtransaccion;
    
    function __construct($id_labradpruebarad, $idlabradiologia, $idradiologia, $fecha, $idtransaccion) {
        $this->id_labradpruebarad = $id_labradpruebarad;
        $this->idlabradiologia = $idlabradiologia;
        $this->idradiologia = $idradiologia;
        $this->fecha = $fecha;
        $this->idtransaccion = $idtransaccion;
    }

    function getId_labradpruebarad() {
        return $this->id_labradpruebarad;
    }

    function getIdlabradiologia() {
        return $this->idlabradiologia;
    }

    function getIdradiologia() {
        return $this->idradiologia;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getIdtransaccion() {
        return $this->idtransaccion;
    }

    function setId_labradpruebarad($id_labradpruebarad) {
        $this->id_labradpruebarad = $id_labradpruebarad;
    }

    function setIdlabradiologia($idlabradiologia) {
        $this->idlabradiologia = $idlabradiologia;
    }

    function setIdradiologia($idradiologia) {
        $this->idradiologia = $idradiologia;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setIdtransaccion($idtransaccion) {
        $this->idtransaccion = $idtransaccion;
    }
}
