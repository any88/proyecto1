<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RolesCirugia
 *
 * @author any
 */
class RolesCirugia {
    
    private $idrol;
    private $nombre;
    private $especializacion;
    
    function __construct($idrol, $nombre, $especializacion) {
        $this->idrol = $idrol;
        $this->nombre = $nombre;
        $this->especializacion = $especializacion;
    }
    
    function getIdrol() {
        return $this->idrol;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEspecializacion() {
        return $this->especializacion;
    }

}
