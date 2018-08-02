<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InsumoProveedor
 *
 * @author MARGOTH TAPIA
 */
class InsumoProveedor {
    
    private $idip;
    private $idinsumo;
    private $idproveedor;
    private $cantidad;
    private $fechacompra;
    
    function __construct($idip, $idinsumo, $idproveedor, $cantidad, $fechacompra) {
        $this->idip = $idip;
        $this->idinsumo = $idinsumo;
        $this->idproveedor = $idproveedor;
        $this->cantidad = $cantidad;
        $this->fechacompra = $fechacompra;
    }

    function getIdip() {
        return $this->idip;
    }

    function getIdinsumo() {
        return $this->idinsumo;
    }

    function getIdproveedor() {
        return $this->idproveedor;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getFechacompra() {
        return $this->fechacompra;
    }

    function setIdip($idip) {
        $this->idip = $idip;
    }

    function setIdinsumo($idinsumo) {
        $this->idinsumo = $idinsumo;
    }

    function setIdproveedor($idproveedor) {
        $this->idproveedor = $idproveedor;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setFechacompra($fechacompra) {
        $this->fechacompra = $fechacompra;
    }

}
