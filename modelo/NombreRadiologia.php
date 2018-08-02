<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NombreRadiologia
 *
 * @author MARGOTH TAPIA
 */
class NombreRadiologia {
    
    private $idnombreradiologia;
    private $nombreradiologia;
    private $idtiporadiologia;
    
    function __construct($idnombreradiologia, $nombreradiologia, $idtiporadiologia) {
        $this->idnombreradiologia = $idnombreradiologia;
        $this->nombreradiologia = $nombreradiologia;
        $this->idtiporadiologia = $idtiporadiologia;
    }

    function getIdnombreradiologia() {
        return $this->idnombreradiologia;
    }

    function getNombreradiologia() {
        return $this->nombreradiologia;
    }

    function getIdtiporadiologia() {
        return $this->idtiporadiologia;
    }

    function setIdnombreradiologia($idnombreradiologia) {
        $this->idnombreradiologia = $idnombreradiologia;
    }

    function setNombreradiologia($nombreradiologia) {
        $this->nombreradiologia = $nombreradiologia;
    }

    function setIdtiporadiologia($idtiporadiologia) {
        $this->idtiporadiologia = $idtiporadiologia;
    }

}
