<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/PacienteServicioController.php';
include '../modelo/PacienteController.php';
include '../modelo/ServicioController.php';
include '../modelo/TipoServicioController.php';

$objPS=new PacienteServicioController();
$objPaciente=new PacienteController();
$objServicio=new ServicioController();
$objTipoS=new TipoServicioController();
$msg="";
$mes_actual=  MesActual();
$anno_actual=  AnnoActual();
$fecha_comparar=$anno_actual.'-'.$mes_actual;

##datos de pacientes que tengan consultas en e mes actual
//$lista_paciente_Serv=$objPS->AgendaClinica($fecha_comparar);
$cant_dias=  cantidadDiasMes($mes_actual, $anno_actual);



?>
<br><br>
<section class="about-text">
    <div class="container">
         <h3 class="text-left"><i class="fa fa-institution text-info"><?php echo "Agenda de consultas para la fecha".$fecha_comparar;?></i></h3>
          
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
                
                echo "<a href='#' title='CONSULTAS' class='btn btn-responsive'><i class=' fa fa-user ' style='color:#8cff70;'></i> <span class='badge' style='background-color:#eae5e5; color:black;'>0</span></a>";
                echo "<a href='#' title='CIRUGIAS' class='btn btn-responsive'><i class='fa  fa-user  ' style='color:#8cff70;'> </i> <span class='badge' style='background-color:#eae5e5; color:black;'>0</span></a>";
                echo "<a href='#' title='HOSPITALIZACION' class='btn btn-responsive'><i class='fa  fa-user  ' style='color:#FFB40F;'></i> <span class='badge' style='background-color:#eae5e5; color:black;'>0</span></a>";
                echo "<a href='#' title='RADIOLOGIA' class='btn  btn-responsive'><i class='fa fa-user  ' style='color:#FF4B4B;'></i> <span class='badge' style='background-color:#eae5e5; color:black;'>0</span></a>";
                echo "<a href='#' title='LABORATORIO' class='btn  btn-responsive'><i class='fa  fa-user  ' style='color:#FF4B4B;'></i> <span class='badge' style='background-color:#eae5e5; color:black;'>0</span></a>";
             
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

                                         for ($k = 0; $k < count($tareas); $k++) {
                                             $id_paciente=$tareas[$k]->getIdpaciente();
                                             $id_servicio=$tareas[$k]->getIdservicio();
                                             $arrPacientes=$objPaciente->BuscarPaciente("", "", "", $id_paciente);
                                             if(count($arrPacientes)>0)
                                            {
                                                 $nomb_paciente=$arrPacientes[0]->getNombre();
                                            }
                                            $arrServicios=$objServicio->BuscarServicio($id_servicio, "", "");
                                            if(count($arrServicios)>0)
                                            {
                                                $id_tipoS=$arrServicios[0]->getIdTipoServicio();
                                                $arrTS=$objTipoS->BuscarTipoServicio($id_tipoS, "");
                                                if(count($arrTS)>0)
                                                {
                                                    $nomb_servicio=$arrTS[0]->getTipoServicio();
                                                }
                                            }
                                             
                                             $iniciales=$nomb_paciente.'-'.$nomb_servicio;
                                             $icon_estado="";
                                             $icon_color="";
                                               $icon_estado="<i class='fa fa-user ' style='color:#8cff70 !important;'></i>";
                                            
                                            
                                             #echo "<a href='modal_tarea.php?id=$id_acc' class='btnModal  pull-left btn btn-sm ' style='color:#000 !important; ' data-idmodal='#divModal' title='$nombre_tipo_contenido' '> <i class='$icon_medip form-control pull-left' style='background-color:$color_medio; width:30px!important;color:white;  position:relative;' ></i>$iniciales $icon_estado</a>&nbsp;";
                                            echo "<label class='pull-left label label-primary btn-responsive' style='width:50%; border:solid 1px; '>";
                                             echo "<i class='fa fa user pull-left'  style='color:white !important; width:35%; heigth:100%!important; position:relative;'  ></i> ";
                                             echo "<a href='modal_tarea.php?id=1' class='btnModal' style='margin-top:5px!important; color:white;' data-idmodal='#divModal' title='$nomb_servicio' '> $icon_estado $iniciales </a>";
                                            echo "</label>";
                                            
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


