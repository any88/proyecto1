<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Hospitalizacion
 *
 * @author MARGOTH TAPIA
 */
class Hospitalizacion {

    private $idServicio;
    private $idHospitalizacion;
    private $fechaIngreso;
    private $fechaAlta;
    private $duracion;
    private $tipoHabitacion;
    private $nroCama;
    private $nombreFamiliar;
    private $parentescoFamiliar;
    private $estadoDelPaciente;
    private $condicionDeAtencion;
    private $PA;
    private $pulso;
    private $temp;
    private $peso;
    private $examenFisico;
    private $precio;
    
    public function __construct($idServicio, $idHospitalizacion, $fechaIngreso, $fechaAlta, $duracion, $tipoHabitacion, $nroCama, $nombreFamiliar, $parentescoFamiliar, $estadoDelPaciente, $condicionDeAtencion, $PA, $pulso, $temp, $peso, $examenFisico, $precio) {
        $this->idServicio = $idServicio;
        $this->idHospitalizacion = $idHospitalizacion;
        $this->fechaIngreso = $fechaIngreso;
        $this->fechaAlta = $fechaAlta;
        $this->duracion = $duracion;
        $this->tipoHabitacion = $tipoHabitacion;
        $this->nroCama = $nroCama;
        $this->nombreFamiliar = $nombreFamiliar;
        $this->parentescoFamiliar = $parentescoFamiliar;
        $this->estadoDelPaciente = $estadoDelPaciente;
        $this->condicionDeAtencion = $condicionDeAtencion;
        $this->PA = $PA;
        $this->pulso = $pulso;
        $this->temp = $temp;
        $this->peso = $peso;
        $this->examenFisico = $examenFisico;
        $this->precio = $precio;
    }

    public function getIdServicio() {
        return $this->idServicio;
    }

    public function getIdHospitalizacion() {
        return $this->idHospitalizacion;
    }

    public function getFechaIngreso() {
        return $this->fechaIngreso;
    }

    public function getFechaAlta() {
        return $this->fechaAlta;
    }

    public function getDuracion() {
        return $this->duracion;
    }

    public function getTipoHabitacion() {
        return $this->tipoHabitacion;
    }

    public function getNroCama() {
        return $this->nroCama;
    }

    public function getNombreFamiliar() {
        return $this->nombreFamiliar;
    }

    public function getParentescoFamiliar() {
        return $this->parentescoFamiliar;
    }

    public function getEstadoDelPaciente() {
        return $this->estadoDelPaciente;
    }

    public function getCondicionDeAtencion() {
        return $this->condicionDeAtencion;
    }

    public function getPA() {
        return $this->PA;
    }

    public function getPulso() {
        return $this->pulso;
    }

    public function getTemp() {
        return $this->temp;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function getExamenFisico() {
        return $this->examenFisico;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setIdServicio($idServicio) {
        $this->idServicio = $idServicio;
    }

    public function setIdHospitalizacion($idHospitalizacion) {
        $this->idHospitalizacion = $idHospitalizacion;
    }

    public function setFechaIngreso($fechaIngreso) {
        $this->fechaIngreso = $fechaIngreso;
    }

    public function setFechaAlta($fechaAlta) {
        $this->fechaAlta = $fechaAlta;
    }

    public function setDuracion($duracion) {
        $this->duracion = $duracion;
    }

    public function setTipoHabitacion($tipoHabitacion) {
        $this->tipoHabitacion = $tipoHabitacion;
    }

    public function setNroCama($nroCama) {
        $this->nroCama = $nroCama;
    }

    public function setNombreFamiliar($nombreFamiliar) {
        $this->nombreFamiliar = $nombreFamiliar;
    }

    public function setParentescoFamiliar($parentescoFamiliar) {
        $this->parentescoFamiliar = $parentescoFamiliar;
    }

    public function setEstadoDelPaciente($estadoDelPaciente) {
        $this->estadoDelPaciente = $estadoDelPaciente;
    }

    public function setCondicionDeAtencion($condicionDeAtencion) {
        $this->condicionDeAtencion = $condicionDeAtencion;
    }

    public function setPA($PA) {
        $this->PA = $PA;
    }

    public function setPulso($pulso) {
        $this->pulso = $pulso;
    }

    public function setTemp($temp) {
        $this->temp = $temp;
    }

    public function setPeso($peso) {
        $this->peso = $peso;
    }

    public function setExamenFisico($examenFisico) {
        $this->examenFisico = $examenFisico;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }
   
}
