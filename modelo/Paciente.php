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
    private $idClienteAseguradora;
    private $grupoSanguineo;
    private $alergiaMed;


    public function __construct($idPaciente, $nombre, $numeroHC, $docID, $fechaNac, $sexo, $telef, $ocupacion, $direccion, $anamnesis, $tiempoDeEnfermedad, $idAseguradora, $email, $idClienteAseguradora, $grupoSanguineo, $alergiaMed) {
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
        $this->idClienteAseguradora = $idClienteAseguradora;
        $this->grupoSanguineo = $grupoSanguineo;
        $this->alergiaMed = $alergiaMed;
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

    function getIdClienteAseguradora() {
        return $this->idClienteAseguradora;
    }

    function getGrupoSanguineo() {
        return $this->grupoSanguineo;
    }

    function getAlergiaMed() {
        return $this->alergiaMed;
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
