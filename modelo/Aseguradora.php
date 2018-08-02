<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Aseguradora
 *
 * @author MARGOTH TAPIA
 */
class Aseguradora {

    private $idAseguradora;
    private $nombre;
    private $RUC;
    
    public function __construct($idAseguradora, $nombre, $RUC) {
        $this->idAseguradora = $idAseguradora;
        $this->nombre = $nombre;
        $this->RUC = $RUC;
    }

    public function getIdAseguradora() {
        return $this->idAseguradora;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getRUC() {
        return $this->RUC;
    }

    public function setIdAseguradora($idAseguradora) {
        $this->idAseguradora = $idAseguradora;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setRUC($RUC) {
        $this->RUC = $RUC;
    }
    
}
