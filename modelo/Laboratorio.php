<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Laboratorio
 *
 * @author MARGOTH TAPIA
 */
class Laboratorio {
    
    private $idServicio;
    private $idLaboratorio;
    private $idTipoAnalisisLaboratorio;
    private $nombre;
    private $resultados;
    private $precio;
    
    public function __construct($idServicio, $idLaboratorio, $idTipoAnalisisLaboratorio, $nombre, $resultados, $precio) {
        $this->idServicio = $idServicio;
        $this->idLaboratorio = $idLaboratorio;
        $this->idTipoAnalisisLaboratorio = $idTipoAnalisisLaboratorio;
        $this->nombre = $nombre;
        $this->resultados = $resultados;
        $this->precio = $precio;
    }

    public function getIdServicio() {
        return $this->idServicio;
    }

    public function getIdLaboratorio() {
        return $this->idLaboratorio;
    }

    public function getIdTipoAnalisisLaboratorio() {
        return $this->idTipoAnalisisLaboratorio;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }
    
    public function getResultados() {
        return $this->resultados;
    }

    public function setResultados($resultados) {
        $this->resultados = $resultados;
    }

    public function setIdServicio($idServicio) {
        $this->idServicio = $idServicio;
    }

    public function setIdLaboratorio($idLaboratorio) {
        $this->idLaboratorio = $idLaboratorio;
    }

    public function setIdTipoAnalisisLaboratorio($idTipoAnalisisLaboratorio) {
        $this->idTipoAnalisisLaboratorio = $idTipoAnalisisLaboratorio;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

}
