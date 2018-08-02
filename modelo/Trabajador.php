<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Trabajador
 *
 * @author MARGOTH TAPIA
 */
class Trabajador {

    private $idTrabajador;
    private $docID;
    private $nombre;
    private $fechaNac;
    private $sexo;
    private $telef;
    private $email;
    private $direccion;
    private $cargo;
    private $salario;
    
    public function __construct($idTrabajador, $docID, $nombre, $fechaNac, $sexo, $telef, $email, $direccion, $cargo, $salario) {
        $this->idTrabajador = $idTrabajador;
        $this->docID = $docID;
        $this->nombre = $nombre;
        $this->fechaNac = $fechaNac;
        $this->sexo = $sexo;
        $this->telef = $telef;
        $this->email = $email;
        $this->direccion = $direccion;
        $this->cargo = $cargo;
        $this->salario = $salario;
    }

    public function getIdTrabajador() {
        return $this->idTrabajador;
    }

    public function getDocID() {
        return $this->docID;
    }

    public function getNombre() {
        return $this->nombre;
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

    public function getCargo() {
        return $this->cargo;
    }

    public function getSalario() {
        return $this->salario;
    }

    public function setIdTrabajador($idTrabajador) {
        $this->idTrabajador = $idTrabajador;
    }

    public function setDocID($docID) {
        $this->docID = $docID;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
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

    public function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    public function setSalario($salario) {
        $this->salario = $salario;
    }

}
