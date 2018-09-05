<?php

class Caja
{
    private $id;
    private $cantidad;
    function __construct($id, $cantidad) {
        $this->id = $id;
        $this->cantidad = $cantidad;
    }

    function getCantidad() {
        return $this->cantidad;
    }
    function getId() {
        return $this->id;
    }





}

