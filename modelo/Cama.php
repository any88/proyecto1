<?php

class Cama
{
    private $id_cama;
    private $num_cama;
    private $estado;
    
    function __construct($id_cama, $num_cama, $estado) {
        $this->id_cama = $id_cama;
        $this->num_cama = $num_cama;
        $this->estado = $estado;
    }
    function getId_cama() {
        return $this->id_cama;
    }

    function getNum_cama() {
        return $this->num_cama;
    }

    function getEstado() {
        return $this->estado;
    }



}

