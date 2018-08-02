<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Servicio
 *
 * @author MARGOTH TAPIA
 */
class Servicio {
    
    private $idServicio;
    private $idTipoServicio;
    private $precio;
    
    public function __construct($idServicio, $idTipoServicio,  $precio) {
        $this->idServicio = $idServicio;
      
        $this->idTipoServicio = $idTipoServicio;
        $this->precio = $precio;
    }

    public function getIdServicio() {
        return $this->idServicio;
    }

   
    public function getIdTipoServicio() {
        return $this->idTipoServicio;
    }
  
    public function getPrecio() {
        return $this->precio;
    }

    public function setIdServicio($idServicio) {
        $this->idServicio = $idServicio;
    }


    public function setIdTipoServicio($idTipoServicio) {
        $this->idTipoServicio = $idTipoServicio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

}
