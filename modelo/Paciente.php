<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Paciente
 *
 * @author MARGOTH TAPIA
 */
class Paciente {
    
    private $idPaciente;
    private $nombre;
    private $numeroHC;
    private $docID;
    private $fechaNac;
    private $sexo;
    private $telef;
    private $email;
    private $ocupacion;
    private $direccion;
    private $anamnesis;
    private $tiempoDeEnfermedad;
    private $idAseguradora;


    public function __construct($idPaciente, $nombre, $numeroHC, $docID, $fechaNac, $sexo, $telef, $ocupacion, $direccion, $anamnesis, $tiempoDeEnfermedad, $idAseguradora, $email) {
        $this->idPaciente = $idPaciente;
        $this->nombre = $nombre;
        $this->numeroHC = $numeroHC;
        $this->docID = $docID;
        $this->fechaNac = $fechaNac;
        $this->sexo = $sexo;
        $this->telef = $telef;
        $this->ocupacion = $ocupacion;
        $this->direccion = $direccion;
        $this->anamnesis = $anamnesis;
        $this->tiempoDeEnfermedad = $tiempoDeEnfermedad;
        $this->idAseguradora = $idAseguradora;
        $this->email = $email;
    }
    
    public function getIdPaciente() {
        return $this->idPaciente;
    }
    
    public function getNombre() {
        return $this->nombre;
    }

    public function getNumeroHC() {
        return $this->numeroHC;
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
    
    function getEmail() {
        return $this->email;
    }

    public function getOcupacion() {
        return $this->ocupacion;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getAnamnesis() {
        return $this->anamnesis;
    }

    public function getTiempoDeEnfermedad() {
        return $this->tiempoDeEnfermedad;
    }
    
    public function getIdAseguradora() {
        return $this->idAseguradora;
    }

    public function setIdPaciente($idPaciente) {
        $this->idPaciente = $idPaciente;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setNumeroHC($numeroHC) {
        $this->numeroHC = $numeroHC;
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
    
    function setEmail($email) {
        $this->email = $email;
    }

    public function setOcupacion($ocupacion) {
        $this->ocupacion = $ocupacion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setAnamnesis($anamnesis) {
        $this->anamnesis = $anamnesis;
    }

    public function setTiempoDeEnfermedad($tiempoDeEnfermedad) {
        $this->tiempoDeEnfermedad = $tiempoDeEnfermedad;
    }
    
    public function setIdAseguradora($idAseguradora) {
        $this->idAseguradora = $idAseguradora;
    }
    
    public function GetEdadPaciente()
    {
       $edad=0;
       $arrF= preg_split("/[-]/", $this->fechaNac);
       if(count($arrF)==3)
        {
            $diaN=$arrF[2];
            $mesN=$arrF[1];
            $annoN=$arrF[0];

        }
        $fecha_actual= FechaYMA();
        $arr_fecha= preg_split('/[-]/', $fecha_actual);
        if(count($arr_fecha)==3)
        {
            $diaA=$arr_fecha[2];
            $mesA=$arr_fecha[1];
            $annoA=$arr_fecha[0];

        }
        
        $edad=$annoA-$annoN;
        if($mesA>$mesN){return $edad;}
        if($mesA<$mesN){return $edad-1;}
        if($mesA==$mesN)
            {if($diaA>=$diaN){return $edad;}
            else { return $edad-1;}}
        
    }
        
}
