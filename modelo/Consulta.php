<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Consulta
 *
 * @author MARGOTH TAPIA
 */
class Consulta {

    private $idServicio;
    private $idConsulta;
    private $especialidad;
    private $indicaciones;
    private $resultados;
    private $precio;
    
    public function __construct($idServicio, $idConsulta, $especialidad, $indicaciones, $resultados, $precio) {
        $this->idServicio = $idServicio;
        $this->idConsulta = $idConsulta;
        $this->especialidad = $especialidad;
        $this->indicaciones = $indicaciones;
        $this->resultados = $resultados;
        $this->precio = $precio;
    }

    public function getIdServicio() {
        return $this->idServicio;
    }

    public function getIdConsulta() {
        return $this->idConsulta;
    }

    public function getEspecialidad() {
        return $this->especialidad;
    }

    public function getIndicaciones() {
        return $this->indicaciones;
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

    public function setIdConsulta($idConsulta) {
        $this->idConsulta = $idConsulta;
    }

    public function setEspecialidad($especialidad) {
        $this->especialidad = $especialidad;
    }

    public function setIndicaciones($indicaciones) {
        $this->indicaciones = $indicaciones;
    }

    public function setResultados($resultados) {
        $this->resultados = $resultados;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

}
