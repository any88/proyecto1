<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LaboratorioClinico
 *
 * @author MARGOTH TAPIA
 */
class LaboratorioClinico {
    
    private $idlabclinico;
    private $nombrelabclin;
    private $ruc;
    
    function __construct($idlabclinico, $nombrelabclin, $ruc) {
        $this->idlabclinico = $idlabclinico;
        $this->nombrelabclin = $nombrelabclin;
        $this->ruc = $ruc;
    }

    function getIdlabclinico() {
        return $this->idlabclinico;
    }

    function getNombrelabclin() {
        return $this->nombrelabclin;
    }

    function getRuc() {
        return $this->ruc;
    }

    function setIdlabclinico($idlabclinico) {
        $this->idlabclinico = $idlabclinico;
    }

    function setNombrelabclin($nombrelabclin) {
        $this->nombrelabclin = $nombrelabclin;
    }

    function setRuc($ruc) {
        $this->ruc = $ruc;
    }
}
