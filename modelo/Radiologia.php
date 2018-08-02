<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Radiologia
 *
 * @author MARGOTH TAPIA
 */
class Radiologia {
  
    private $idServicio;
    private $idRadiologia;
    private $idTipoRadiologia;
    private $nombre;
    private $resultados;
    private $precio;
    
    public function __construct($idServicio, $idRadiologia, $idTipoRadiologia, $nombre, $resultados, $precio) {
        $this->idServicio = $idServicio;
        $this->idRadiologia = $idRadiologia;
        $this->idTipoRadiologia = $idTipoRadiologia;
        $this->nombre = $nombre;
        $this->resultados = $resultados;
        $this->precio = $precio;
    }
    
    public function getIdServicio() {
        return $this->idServicio;
    }

    public function getIdRadiologia() {
        return $this->idRadiologia;
    }

    public function getIdTipoRadiologia() {
        return $this->idTipoRadiologia;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getResultados() {
        return $this->resultados;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setIdServicio($idServicio) {
        $this->idServicio = $idServicio;
    }

    public function setIdRadiologia($idRadiologia) {
        $this->idRadiologia = $idRadiologia;
    }

    public function setIdTipoRadiologia($idTipoRadiologia) {
        $this->idTipoRadiologia = $idTipoRadiologia;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setResultados($resultados) {
        $this->resultados = $resultados;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

}
