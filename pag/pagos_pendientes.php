<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include '../modelo/consultas_genericas.php';
include './header.php';

include '../modelo/PacienteServicioController.php';
include '../modelo/PacienteController.php';
include '../modelo/ServicioController.php';
include '../modelo/MedicoController.php';
include '../modelo/TipoServicioController.php';
include '../modelo/TransaccionController.php';
include '../modelo/ConsultaController.php';
include '../modelo/CirugiaController.php';
include '../modelo/LaboratorioController.php';
include '../modelo/RadiologiaController.php';
include '../modelo/MedicoConsultaController.php';
include '../modelo/LaboratorioRadiologiaController.php';
include '../modelo/LaboratorioClinicoController.php';
include '../modelo/LaboratorioRadiologia_PruebaRadController.php';
include '../modelo/LaboratorioClinico_AnalisisController.php';

$objPacienteServC=new PacienteServicioController();
$objPaciente=new PacienteController();
$objMedicoC=new MedicoController();
$objServicioC=new ServicioController();
$objTipoServicio=new TipoServicioController();
$objTransaccion=new TransaccionController();
$objConsulta= new ConsultaController();
$objCirugia= new CirugiaController();
$objLaboratorio= new LaboratorioController();
$objRadiologia= new RadiologiaController();
$objMedicoConsulta= new MedicoConsultaController();
$objLabClinico= new LaboratorioClinicoController();
$objLabRadiologia= new LaboratorioRadiologiaController();
$objLabClinAnalab= new LaboratorioClinico_AnalisisController();
$objLabRadPruebaRad= new LaboratorioRadiologia_PruebaRadController();

$list_pacientes=array();
$list_pacientes=$objPacienteServC->MostrarPacienteServicio();

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user text-info"> Listado de Pagos Pendientes</i></h3>
        </div>
        <?php 
        if(count($list_pacientes)>0)
        {
            echo "<table class='table table-responsive' id='dataTables-example'>";
            
            echo "<thead>";
            echo "<tr>";
                echo "<th>Nro.</th>";
                echo "<th>Acreedor</th>";
                echo "<th>Paciente</th>";
                echo "<th>Doc. Id. Pcte</th>";
                echo "<th>Servicio</th>";
                echo "<th>Rol (Cirugías)</th>";
                echo "<th>Fecha del Servicio</th>";
                echo "<th>Precio</th>";
                echo "<th>Deuda</th>";
                echo "<th>Acci&oacute;n</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
                 $link_listar="";
                 $link_mostrar="mostrarpaciente.php";
                 $total_plan=0;
                 $total_real=0;
                 for ($i = 0; $i < count($list_pacientes); $i++) 
                 {
                     $nro=$i+1;
                     $idPaciente=$list_pacientes[$i]->getIdpaciente();
                     $idservicio=$list_pacientes[$i]->getIdservicio();
                     $id_transaccion=$list_pacientes[$i]->getIdtransaccion();
                     $idpacserv=$list_pacientes[$i]->getIdps();
                     $nombrePaciente="";
                     $acreedor="";
                     $nombre_servicio="";
                     $docID="";
                     $numhc="";
                     $fecha_de_pago="";
                     $fpago="";
                     $precio_plan=0;
                     $pago_real=0;
                     $arrP=$objPaciente->BuscarPaciente("", "", "", $idPaciente);
                     if(count($arrP)>0)
                     {
                         $nombrePaciente=$arrP[0]->getNombre();
                         $numhc=$arrP[0]->getNumeroHC();
                         $docID=$arrP[0]->getDocID();
                     }
                     $arrServ=$objServicioC->BuscarServicio($idservicio, "", "");
                     if(count($arrServ)>0)
                     {
                         $precio_plan=$arrServ[0]->getPrecio();
                         $id_ts=$arrServ[0]->getIdTipoServicio();
                         $total_plan=$precio_plan+$total_plan;
                         
                         $arrTS=$objTipoServicio->BuscarTipoServicio($id_ts, "");
                         if(count($arrTS)>0)
                         {
                             $nombre_servicio=$arrTS[0]->getTipoServicio();
                         }
                     }
                     
                     $arrPC=$objPacienteServC->BuscarPacienteServicio($idpacserv, "", "", "");
                     if(count($arrPC)>0)
                     {
                         $fechaserv=$arrPC[0]->getFecha();
                     }
                     
                     $arrTrans=$objTransaccion->BuscarTransaccion($id_transaccion, "", "");
                     
                     if($id_transaccion==""){$estado="PENDIENTE";}
                     else
                     {
                        if(count($arrTrans)>0)
                        {
                            $pago_real=$arrTrans[0]->getMonto();
                            $fecha_de_pago=$arrTrans[0]->getFecha();
                            $fpago=$arrTrans[0]->getFpago();
                            if($pago_real==0 ||$pago_real==""){$estado="PENDIENTE";}
                            if($pago_real>=$precio_plan){$estado="REALIZADO";}
                        } 
                     }
                    
                    if($id_ts==1)
                    {
                        $idconsulta=$objConsulta->BuscarConsulta("", "", $idservicio)[0]->getIdConsulta();
                        $idmedico=$objMedicoConsulta->BuscarMedicoConsulta("", "", $idconsulta)[0]->getIdmedico();
                        $acreedor=$objMedicoC->BuscarMedico($idmedico, "", "")[0]->getNombre();
                    }
                    if($id_ts==2)
                    {
                        $idcirugia=$objCirugia->BuscarCirugia("", "", "", $idservicio)[0]->getIdCirugia();
                        //COMPLETAR
                        $idmedico=$objMedicoConsulta->BuscarMedicoConsulta("", "", $idconsulta)[0]->getIdmedico();
                        //$acreedor=$objMedicoC->BuscarMedico($idmedico, "", "")[0]->getNombre();
                        $acreedor="cualquiera";
                    } 
                    if($id_ts==4)
                    {
                        $idradiologia=$objRadiologia->BuscarRadiologia("", "", "", $idservicio)[0]->getIdRadiologia();
                        $idlabrad=$objLabRadPruebaRad->BuscarLaboratorioRadiologia_PruebaRad("", "", $idradiologia)[0]->getIdlabradiologia();
                        //$acreedor=$objLabRadiologia->BuscarLabRadiologia($idlabrad, "", "")[0]->getNombrelabradiologia();
                        $acreedor=$objLabRadiologia->BuscarLaboratorioRadiologia($idlabrad, "", "")[0]->getNombrelabrad();
                    } 
                    if($id_ts==5)
                    {
                        
                        
                        $idanalisis=$objLaboratorio->BuscarLaboratorio("", "", "", "", $idservicio)[0]->getIdLaboratorio();
                        $labclin=$objLabClinAnalab->BuscarLaboratorioClinico_Analisis("", "", $idanalisis)[0]->getIdlabclinico();
                        //$acreedor=$objLabClinico->BuscarLabClinico($idlabclin, "", "")[0]->getNombrelabclinico();
                        $acreedor=$objLabClinico->BuscarLaboratorioClinico($labclin, "", "")[0]->getNombrelabclin();
                    } 
                     
                    if($pago_real>=$precio_plan && $precio_plan!=0 && $id_ts!=3)
                    {    
                    echo "<tr>";
                    echo "<td>".$nro."</td>";
                    echo "<td>".$acreedor."</td>";
                    echo "<td>".$nombrePaciente."</td>";
                    echo "<td>".$docID."</td>";
                    echo "<td>".$nombre_servicio."</td>";
                    echo "<td>Rol</td>";
                    echo "<td>".$fechaserv."</td>";
                    echo "<td>s/. $precio_plan</td>";
                    echo "<td>s/. $pago_real</td>";
                                        
                    if($nombre_servicio=="Consulta")
                    {
                        $link_mostrar="mostrar_consulta.php";
                    }
                    if($nombre_servicio=="Cirugia")
                    {
                        $link_mostrar="mostrar_cirugia.php";
                    }
                    if($nombre_servicio=="Hospitalización")
                    {
                        $link_mostrar="mostrar_hospitalizacion.php";
                    }
                    if($nombre_servicio=="Radiología")
                    {
                        $link_mostrar="mostrar_radiologia.php";
                    }
                    if($nombre_servicio=="Laboratorio")
                    {
                        $link_mostrar="mostrar_laboratorio.php";
                    }
                    echo '
                    <td>                            
                             <a href="'.$link_listar.'?action=delete&nik='.$idservicio.'&v='.$nombre_servicio.'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos  del servicio seleccionado ('.$nombre_servicio.') ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                 
                             <a href="'.$link_mostrar.'?nik='.$idservicio.'" title="Mostrar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>'
                 . '</td>';
                   echo "</tr>";
                    }
                 }
                 
              echo "</tbody>";
              
            echo "</table>";
        }
        else 
        {
            echo "<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "No existen deudas por saldar en el período.</div>";
        }
        
        ?>
    </div>
</section>

