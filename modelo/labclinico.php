<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of labclinico
 *
 * @author MARGOTH TAPIA
 */
class labclinico {
    
    private $idlabclinico;
    private $nombrelabclinico;
    private $ruc;
    
    function __construct($idlabclinico, $nombrelabclinico, $ruc) {
        $this->idlabclinico = $idlabclinico;
        $this->nombrelabclinico = $nombrelabclinico;
        $this->ruc = $ruc;
    }

    function getIdlabclinico() {
        return $this->idlabclinico;
    }

    function getNombrelabclinico() {
        return $this->nombrelabclinico;
    }

    function getRuc() {
        return $this->ruc;
    }

    function setIdlabclinico($idlabclinico) {
        $this->idlabclinico = $idlabclinico;
    }

    function setNombrelabclinico($nombrelabclinico) {
        $this->nombrelabclinico = $nombrelabclinico;
    }

    function setRuc($ruc) {
        $this->ruc = $ruc;
    }

}
