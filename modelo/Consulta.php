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
    
        
    public function __construct($idServicio, $idConsulta, $especialidad, $indicaciones, $resultados) {
        $this->idServicio = $idServicio;
        $this->idConsulta = $idConsulta;
        $this->especialidad = $especialidad;
        $this->indicaciones = $indicaciones;
        $this->resultados = $resultados;
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

}
