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
        
    public function __construct($idServicio, $idLaboratorio, $idTipoAnalisisLaboratorio, $nombre, $resultados) {
        $this->idServicio = $idServicio;
        $this->idLaboratorio = $idLaboratorio;
        $this->idTipoAnalisisLaboratorio = $idTipoAnalisisLaboratorio;
        $this->nombre = $nombre;
        $this->resultados = $resultados;
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
   
    public function getResultados() {
        return $this->resultados;
    }
}
