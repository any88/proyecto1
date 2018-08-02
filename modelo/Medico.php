<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Medico
 *
 * @author MARGOTH TAPIA
 */
class Medico {
    
    private $idMedico;
    private $nombre;
    private $nroColegioMed;
    private $docID;
    private $fechaNac;
    private $sexo;
    private $telef;
    private $email;
    private $direccion;
    private $especialidad;
    
    public function __construct($idMedico, $nroColegioMed, $nombre, $docID, $fechaNac, $sexo, $telef, $email, $direccion, $especialidad) {
        $this->idMedico = $idMedico;
        $this->nombre = $nombre;
        $this->nroColegioMed = $nroColegioMed;
        $this->docID = $docID;
        $this->fechaNac = $fechaNac;
        $this->sexo = $sexo;
        $this->telef = $telef;
        $this->email = $email;
        $this->direccion = $direccion;
        $this->especialidad = $especialidad;
    }

    public function getIdMedico() {
        return $this->idMedico;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getNroColegioMed() {
        return $this->nroColegioMed;
    }

    public function getDocID() {
        return $this->docID;
    }

    public function getFechaNac() {
        return $this->fechaNac;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function getTelef() {
        return $this->telef;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getEspecialidad() {
        return $this->especialidad;
    }

    public function setIdMedico($idMedico) {
        $this->idMedico = $idMedico;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setNroColegioMed($nroColegioMed) {
        $this->nroColegioMed = $nroColegioMed;
    }

    public function setDocID($docID) {
        $this->docID = $docID;
    }

    public function setFechaNac($fechaNac) {
        $this->fechaNac = $fechaNac;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    public function setTelef($telef) {
        $this->telef = $telef;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setEspecialidad($especialidad) {
        $this->especialidad = $especialidad;
    }
  
}
