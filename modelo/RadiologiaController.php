<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RadiologiaController
 *
 * @author MARGOTH TAPIA
 */
include '../Modelo/Radiologia.php';

class RadiologiaController {

    public function RadiologiaController() {
        
    }

    public function CrearRadiologia($p_idservicio, $p_idtiporadiologia, $p_nombre, $p_resultado) {
        $affected = 0;
        $bd = new con_mysqli("", "", "", "");

        ##Validar Iny Sql
        $p_idservicio = $bd->real_scape_string($p_idservicio);
        $p_idtiporadiologia = $bd->real_scape_string($p_idtiporadiologia);
        $p_nombre = $bd->real_scape_string($p_nombre);
        $p_resultado = $bd->real_scape_string($p_resultado);
        
        $consulta = "INSERT INTO `radiologia` (`idservicio`, `idtiporadiologia`, `idnombreradiologia`, `resultado`) VALUES ('$p_idservicio', '$p_idtiporadiologia', '$p_nombre', '$p_resultado')";

        $r = $bd->consulta($consulta);
        if ($r) 
        {
            $affected = $bd->affected_row();
            $consulta="SELECT LAST_INSERT_ID()";
                $r=$bd->consulta($consulta);
                if($r)
                {
                    $fila=$bd->fetch_array($r);
                    $affected=$fila[0];
                }
        }
        $bd->Close();
        return $affected;
    }

    public function ModificarRadiologia($p_id, $p_idtiporadiologia, $p_nombre, $p_resultado) {
        $affected = 0;
        $bd = new con_mysqli("", "", "", "");

        ##Validar Iny Sql
        $p_idtiporadiologia = $bd->real_scape_string($p_idtiporadiologia);
        $p_nombre = $bd->real_scape_string($p_nombre);
        $p_resultado = $bd->real_scape_string($p_resultado);
        
        $radiologia = "UPDATE `radiologia` SET `idtiporadiologia`='$p_idtiporadiologia', `idnombreradiologia`='$p_nombre', `resultado`='$p_resultado' WHERE (`idradiologia`='$p_id')";

        $r = $bd->radiologia($radiologia);
        if ($r) {
            $affected = $bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }

    public function EliminarRadiologia($p_id) {
        $affected = 0;
        $bd = new con_mysqli("", "", "", "");

        ##Validar Iny Sql
        $p_id = $bd->real_scape_string($p_id);

        $radiologia = "DELETE FROM `radiologia` WHERE (`idradiologia`='$p_id')";

        $r = $bd->radiologia($radiologia);
        if ($r) {
            $affected = $bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }

    public function MostrarRadiologia() {
        $result = array();
        $bd = new con_mysqli("", "", "", "");
        $radiologia = "SELECT * FROM `radiologia` order by `idradiologia` ASC";
        $r = $bd->consulta($radiologia);
        if ($r) {
            $a = 0;
            while ($fila = $bd->fetch_assoc($r)) {

                $p_idradiologia = $fila["idradiologia"];
                $p_idtiporadiologia = $fila["idtiporadiologia"];
                $p_nombre = $fila["idnombreradiologia"];
                $p_resultado = $fila["resultado"];
                
                $objRadiologia = new Radiologia($p_idradiologia, $p_idtiporadiologia, $p_nombre, $p_resultado);
                $result[$a] = $objRadiologia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }

    public function BuscarRadiologia($p_idradiologia, $p_idtiporadiologia, $p_nombre) {
        $result = array();
        $bd = new con_mysqli("", "", "", "");
        $radiologia = "SELECT * FROM `radiologia` ";

        if ($p_idradiologia != "") {
            $radiologia = $radiologia . "WHERE `idradiologia`='$p_idradiologia'";
        }
        if ($p_idtiporadiologia != "") {
            if ($p_idradiologia == "") {
                $radiologia = $radiologia . "WHERE `idtiporadiologia`='$p_idtiporadiologia'";
            } else {
                $radiologia = $radiologia . " and `idtiporadiologia`='$p_idtiporadiologia'";
            }
        }
        if ($p_nombre != "") {
            if ($p_idradiologia == "" && $p_idtiporadiologia == "") {
                $radiologia = $radiologia . "WHERE `idnombreradiologia`='$p_nombre'";
            } else {
                $radiologia = $radiologia . " and `idnombreradiologia`='$p_nombre'";
            }
        }


        $radiologia = $radiologia . " order by `idradiologia` ASC";
        $r = $bd->consulta($radiologia);
        if ($r) {
            $a = 0;
            while ($fila = $bd->fetch_assoc($r)) {

                $p_idservicio = $fila["idservicio"];
                $p_idradiologia = $fila["idradiologia"];
                $p_idtiporadiologia = $fila["idtiporadiologia"];
                $p_nombre = $fila["idnombreradiologia"];
                $p_resultado = $fila["resultado"];
                
                $objRadiologia = new Radiologia($p_idservicio, $p_idradiologia, $p_idtiporadiologia, $p_nombre, $p_resultado);
                $result[$a] = $objRadiologia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }

    public function CargarRadiologiaID($search) {
        $result = array();
        $bd = new con_mysqli("", "", "", "");

        ##Validar parametros
        $search = $bd->real_scape_string($search);

        $radiologia = "SELECT * FROM `radiologia` WHERE `idradiologia` LIKE '%$search%'";
        $r = $bd->radiologia($radiologia);
        if ($r) {
            $a = 0;
            while ($fila = $bd->fetch_assoc($r)) {
                $bd_radiologia = $fila["idradiologia"];
                $result[$a] = $bd_radiologia;
                $a++;
            }
        }
        $bd->Close();

        return $result;
    }

    public function CargarRadiologia($search) {
        $result = array();
        $bd = new con_mysqli("", "", "", "");

        ##Validar parametros
        $search = $bd->real_scape_string($search);

        $radiologia = "SELECT * FROM `radiologia` WHERE `idradiologia` LIKE '%$search%'";
        $r = $bd->radiologia($radiologia);
        if ($r) {
            $a = 0;
            while ($fila = $bd->fetch_assoc($r)) {
                $bd_idradiologia = $fila["idradiologia"];
                $bd_nombre = $fila["idnombreradiologia"];
                $result[$a] = "($bd_idradiologia) " . $bd_nombre;
                $a++;
            }
        }
        $bd->Close();

        return $result;
    }

}
