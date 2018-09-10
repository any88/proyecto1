<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/PacienteServicioController.php';
include '../modelo/PacienteController.php';
include '../modelo/ServicioController.php';
include '../modelo/TipoServicioController.php';
include '../modelo/ConsultaController.php';
include '../modelo/CirugiaController.php';
include '../modelo/HospitalizacionController.php';
include '../modelo/RadiologiaController.php';
include '../modelo/LaboratorioController.php';

$objPS=new PacienteServicioController();
$objPaciente=new PacienteController();
$objServicio=new ServicioController();
$objTipoS=new TipoServicioController();
$objConsulta=new ConsultaController();
$objCirugia=new CirugiaController();
$objHospitalizacion=new HospitalizacionController();
$objRadiologia=new RadiologiaController();
$objLaboratorio=new LaboratorioController();

$msg="";
$mes_actual=  MesActual();
$anno_actual=  AnnoActual();
$fecha_comparar=$anno_actual.'-'.$mes_actual;

##datos de pacientes que tengan consultas en e mes actual
//$lista_paciente_Serv=$objPS->AgendaClinica($fecha_comparar);
$cant_dias=  cantidadDiasMes($mes_actual, $anno_actual);

$contador_consultas=0;
$contador_ciruga=0;
$contador_hospitalizacion=0;
$contador_radiologia=0;
$contador_laboratorio=0;

$mact=$mes_actual;
$p_fecha=$fecha_comparar;
IF($mes_actual<10){$mact='0'.$mes_actual;$p_fecha=$anno_actual.'-'.$mact;}
$arr_serv_del_mes=$objPS->AgendaClinica($p_fecha);

for ($k = 0; $k < count($arr_serv_del_mes); $k++) 
{
    $id_s=$arr_serv_del_mes[$k]->getIdservicio();
    $arrServB=$objServicio->BuscarServicio($id_s, "", "");
    if(count($arrServB)>0)
    {
        $idts=$arrServB[0]->getIdTipoServicio();
        if($idts==1){ $contador_consultas++;}
        if($idts==2){ $contador_ciruga++;}
        if($idts==3){ $contador_hospitalizacion++;}
        if($idts==4){ $contador_radiologia++;}
        if($idts==5){ $contador_laboratorio++;}
    }
}
        

?>
<br><br>
<section class="about-text">
    <div class="container">
         <h3 class="text-left"><i class="fa fa-calendar text-info"><?php echo " Agenda de Servicios para el perído ".$fecha_comparar;?></i></h3>
          
          <?php 
        if($msg!="")
        {
            echo "<div class='alert alert-warning alert-dismissable text-center'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button> $msg </div>'";
        }
        ?>
        
        <div class="col-md-12">
         
          <div class="panel panel-default container-fluid">
              <form name='f' method='post' action='tareas_list.php'>
              <div class="panel-heading table-responsive  row" style="background-color: #286090;">
                  <b style="color:white;">Pacientes agendados por dia</b>
                   
                <?php 
                
                echo "<input type='hidden' name='fecha' value='$fecha_comparar'>";
                echo "<div class='btn-group pull-right' style='margin-top:-5px;'>";
                
                echo "<a href='#' title='CONSULTAS' class='btn btn-responsive'><i style='color:#FFF;' class='fa fa-user'> </i> <span class='badge'color:#FFF;'> $contador_consultas</span></a>";
                echo "<a href='#' title='CIRUGIAS' class='btn btn-responsive'><i style='color:#FFF;' class='fa fa-heartbeat'> </i> <span class='badge' style='background-color:#004731; color:#FFF;'>$contador_ciruga</span></a>";
                echo "<a href='#' title='HOSPITALIZACION' class='btn btn-responsive'><i style='color:#FFF;' class='fa fa-bed'> </i> <span class='badge' color:#FFF;' style='background-color:#FF803E';>$contador_hospitalizacion</span></a>";
                echo "<a href='#' title='RADIOLOGIA' class='btn  btn-responsive'><i style='color:#FFF;' class='fa fa-plus-square'></i> <span class='badge' style='background-color:#800080; color:#FFF;'>$contador_radiologia</span></a>";
                echo "<a href='#' title='LABORATORIO' class='btn  btn-responsive'><i style='color:#FFF;' class='fa fa-flask'></i> <span class='badge' style='background-color:#FF0000; color:#FFF;'>$contador_laboratorio</span></a>";
             
                echo "</div>";
                
                ?>
                </div>
                </form>
              <div class="panel-body">
                  <div class='col-md-12 form-group table-responsive '>
                        <table class='table  table-bordered' width="100%">
                          <?php 
                          echo "<thead>";
                             echo "<tr>"; 
                              echo "<th>Domingo</th>";
                              echo "<th>Lunes</th>";
                              echo "<th>Martes</th>";
                              echo "<th>Miercoles</th>";
                              echo "<th>Jueves</th>";
                              echo "<th>Viernes</th>";
                              echo "<th>Sabado</th>";

                             echo "</tr>";
                          echo "</thead>";
                          echo "<tbody>";
                          $dia=1;
                          $icon_estado="<i class='fa fa-user '></i>";
                          for ($j = 0; $j < $cant_dias; $j++) ###matriz de 7 *5
                          {

                              echo "<tr>";
                              for ($i = 0; $i < 7; $i++) 
                              {
                                  if($dia<=$cant_dias){

                                 $dia_semana=  DiaSemana($mes_actual, $anno_actual, $dia);
                                  echo "<td>"; 
                                  echo "<div class='form-group'>";
                                  if($dia_semana==$i)
                                  {
                                      echo "<p class='dia_calend'>$dia</p>"; 
                                      ##buscar si en este dia se pidio alguna tarea mes/dia/anno
                                     $db=$dia;
                                     $mesB=$mes_actual;
                                     if($db<10){$db='0'.$db;}
                                     if($mesB<10){$mesB='0'.$mesB;}
                                     //$fecha_buscar=$mesB.'/'.$db.'/'.$anno_campanna;
                                     $fecha_buscar=$anno_actual.'-'.$mesB.'-'.$db;
                                     $tareas=$objPS->AgendaClinica($fecha_buscar);
                                    
                                     if(count($tareas)>0)
                                      {$br=0;

                                      $pull_fila=0;
                                         for ($k = 0; $k < count($tareas); $k++) {
                                             $pull_fila++;
                                             $id_paciente=$tareas[$k]->getIdpaciente();
                                             $id_servicio=$tareas[$k]->getIdservicio();
                                             $arrPacientes=$objPaciente->BuscarPaciente("", "", "", $id_paciente);
                                             $nomb_paciente_completo="";
                                             if(count($arrPacientes)>0)
                                            {
                                                 $nomb_paciente=$arrPacientes[0]->getNombre();
                                                 $nomb_paciente= eliminarblancos($nomb_paciente);
                                                 $arrN= preg_split("/\s+/ ", $nomb_paciente);
                                                 $nomb_paciente_completo=$nomb_paciente;
                                                 $nomb_paciente=$arrN[0];
                                            }
                                            $arrServicios=$objServicio->BuscarServicio($id_servicio, "", "");
                                            $label_clase="label_consulas";
                                            $link="";
                                            $nik="";
                                            
                                            if(count($arrServicios)>0)
                                            {
                                                $id_tipoS=$arrServicios[0]->getIdTipoServicio();
                                                if($id_tipoS==1)
                                                    {  
                                                        $label_clase="label_consulas";
                                                        $arrCons=$objConsulta->BuscarConsulta("", "", $id_servicio);
                                                        if(count($arrCons)>0)
                                                            {
                                                                $nik=$arrCons[0]->getIdConsulta();
                                                            }
                                                        $link="mostrar_consulta.php?nik=$nik";
                                                        $icon_estado="<i class='fa fa-user '></i>";
                                                    }
                                                if($id_tipoS==2)
                                                    {
                                                        $label_clase="label_cirugia";
                                                        $arrCir=$objCirugia->BuscarCirugia("", "", "", $id_servicio);
                                                        if(count($arrCir)>0)
                                                            {
                                                                $nik=$arrCir[0]->getIdCirugia();
                                                            }
                                                         $link="mostrar_cirugia.php?nik=$nik";
                                                         $icon_estado="<i class='fa fa-heartbeat'></i>";
                                                         
                                                    }
                                                if($id_tipoS==3)
                                                    { 
                                                        $label_clase="label_hospitalizacion";
                                                        $arrHosp=$objHospitalizacion->BuscarHospitalizacion("", "", $id_servicio);
                                                        if(count($arrHosp)>0)
                                                            {
                                                                $nik=$arrHosp[0]->getIdHospitalizacion();
                                                            }
                                                         $link="mostrar_hospitalizacion.php?nik=$nik";
                                                         $icon_estado="<i class='fa fa-bed'></i>";
                                                    }
                                                if($id_tipoS==4)
                                                    { 
                                                        $label_clase="label_radiologia";
                                                        $arrRad=$objRadiologia->BuscarRadiologia("", "", "", $id_servicio);
                                                        if(count($arrRad)>0)
                                                            {
                                                                $nik=$arrRad[0]->getIdRadiologia();
                                                            }
                                                        $link="mostrar_radiologia.php?nik=$nik";
                                                        $icon_estado="<i class='fa fa-plus-square '></i>";
                                                    }
                                                if($id_tipoS==5)
                                                    { 
                                                        $label_clase="label_laboratorio";
                                                        $arrLab=$objLaboratorio->BuscarLaboratorio("", "", "", $id_servicio);
                                                        if(count($arrLab)>0)
                                                            {
                                                                $nik=$arrLab[0]->getIdLaboratorio();
                                                            }
                                                        $link="mostrar_laboratorio.php?nik=$nik";
                                                        $icon_estado="<i class='fa fa-flask '></i>";
                                                    }
                                               
                                                $arrTS=$objTipoS->BuscarTipoServicio($id_tipoS, "");
                                                if(count($arrTS)>0)
                                                {
                                                    $nomb_servicio=$arrTS[0]->getTipoServicio();
                                                }
                                            }
                                            /* $cad=substr($nomb_servicio,0,1);
                                             $cad=$cad.substr($nomb_servicio,1,1);*/
                                             $iniciales=$nomb_paciente;
                                             
                                             $icon_color="";
                                            
                                             $pull='pull-left';
                                             if($pull_fila==2){$pull='pull-right';$pull_fila=0;}
                                             $tooltip="Servicio de $nomb_servicio para el paciente $nomb_paciente_completo. Fecha $fecha_buscar";
                                            
                                            echo "<div class='$label_clase $pull'><label class='  label btn-responsive' data-toggle='tooltip' data-placement='bottom' data-original-title='$tooltip'>";
                                            echo "<i class='fa fa user pull-left'  style='color:white !important; width:35%; heigth:100%!important; position:relative;'  ></i> ";
                                            echo "<a href='$link' style='margin-top:5px!important; color:white;' data-toggle='modal' data-idmodal='#divModalAgenda'> $icon_estado $iniciales </a>";
                                            echo "</label></div>";
                                            echo "<div style='height:3px;'></div>";
                                            if($br==1) {echo '<br>';$br=0;}else{$br++;}
                                         }
                                      }
                                     $dia++;

                                  }
                                  else{echo '<p></p>';}
                                  echo "</div>";

                                  echo "</td>";

                                  }
                                  else{break;}

                              }

                                echo "</tr>"; 

                                if($dia>=$cant_dias){break;}

                          }
                         echo "</tbody>";
                          ?>
                  </table>
                    </div>

              </div>
          </div>
        
         
          
          
          
        

    </div>
    
</section>


<br><br>
<!-- Esta es la envoltura de las ventanas modales de bootstrap, el contenido como: header, body o footer se cargarán en este contenedor vía ajax (específicamente load)  -->
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true"></div>

<script>
    /**Este es el código que le da la funcionalidad a la modal*/
$('.btnModal').on("click", function(event) {
    event.preventDefault();
 
    var $contenedorModal = $('#myModal');
    var urlModal         = $(this).attr("href");
    var idModal          = $(this).data("idmodal");
 
    $contenedorModal.load(urlModal + ' ' + idModal , function(response) {
    $(this).modal({backdrop: "static"});
    });
});


</script>

