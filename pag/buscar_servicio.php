<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/PacienteController.php';
include '../modelo/ServicioController.php';
include '../modelo/consultas_genericas.php';
include '../modelo/TipoServicioController.php';
include '../modelo/MedicoController.php';
include '../modelo/PacienteServicioController.php';
include '../modelo/TransaccionController.php';
include '../modelo/MedicoCirugiaController.php';
include '../modelo/MedicoConsultaController.php';
include '../modelo/ConsultaController.php';
include '../modelo/CirugiaController.php';

$lista_tipoS=array();
$lista_Medicos=array();
$objTS=new TipoServicioController();
$objServicio=new ServicioController();
$objMedico=new MedicoController();
$objPacienteServ=new PacienteServicioController();
$objTransaccion=new TransaccionController();
$objPaciente=new PacienteController();
$objMedCirugia=new MedicoCirugiaController();
$objMedConsulta=new MedicoConsultaController();
$objConsulta=new ConsultaController();
$objCirugia=new CirugiaController();

$lista_tipoS=$objTS->MostrarTipoServicio();
$lista_Medicos=$objMedico->MostrarMedico();

##variables
$p_idTS="";
$p_fecha="";
$p_doctor="";
$msgs="";
$msg="";
$datos=array();
$datosFecha=array();
$datosDoctor=array();
$datosAll=array();
$tipo_busqueda="";
##hidens
$tipo_servicio_class='hidden';
$fecha_servicio_class='hidden';
$nombre_doctor_class='hidden';

$chekedts="";
$chekedfs="";
$chekednd="";

if($_POST)
{    
    
    ##hiddens
    if(isset($_POST['optionsRadiosInline'])){$tipo_busqueda=$_POST['optionsRadiosInline'];}
    if(isset($_POST['tipoc'])){$p_idTS=$_POST['tipoc'];}
    if(isset($_POST['fecha'])){$p_fecha=$_POST['fecha'];}
    if(isset($_POST['doctor'])){$p_doctor=$_POST['doctor'];}
    
    if(eliminarblancos($p_idTS)=="" && eliminarblancos($p_fecha)=="" && eliminarblancos($p_doctor)=="")
    {
        $msgs="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
    }
    else
    {
        
        if($tipo_busqueda=="ts")
        {
            $chekedts='checked="checked"';
            $chekedfs="";
            $chekednd="";
            $tipo_servicio_class='';
            $fecha_servicio_class='hidden';
            $nombre_doctor_class='hidden';

            if(eliminarblancos($p_idTS)!="")
            {
                $datos=$objServicio->BuscarServicio("", $p_idTS, "");  
                if(count($datos)==0)
               {
                    $msg="<div class='alert alert-danger alert-dismissable'>"
                       . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                       . "Error! No se han encontrado resultados para su criterio de b&uacute;Squeda.</div>";
               }
            }
        }
        if($tipo_busqueda=="fs")
        {
            $tipo_servicio_class='hidden';
            $fecha_servicio_class="";
            $nombre_doctor_class='hidden';
            
            $chekedts='';
            $chekedfs='checked="checked"';
            $chekednd="";
            
            if(eliminarblancos($p_fecha)!="")
            {
                $datosFecha=$objPacienteServ->BuscarPacienteServicio("", "", "",$p_fecha);
                if(count($datosFecha)==0)
               {
                    $msg="<div class='alert alert-danger alert-dismissable'>"
                       . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                       . "Error! No se han encontrado resultados para su criterio de b&uacute;squeda Fecha $p_fecha.</div>";
               }
            }
        }
        
        if($tipo_busqueda=='nd')
        {
            $tipo_servicio_class='hidden';
            $fecha_servicio_class="hidden";
            $nombre_doctor_class='';
            
            $chekedts='';
            $chekedfs="";
            $chekednd='checked="checked"';
            if(eliminarblancos($p_doctor)!="")
            {
                $nombre_doctor="";
                $arrMedico=$objMedico->BuscarMedico($p_doctor, "", "");
                if(count($arrMedico)>0){$nombre_doctor=$arrMedico[0]->getNombre();}
                $ArrmedCir=$objMedCirugia->BuscarMedicoCirugia("", $p_doctor, "");
                $arrMedConsultas=$objMedConsulta->BuscarMedicoConsulta("", $p_doctor, "");
                
                $a=0;
                if(count($arrMedConsultas)>0)
                {
                    for ($i = 0; $i < count($arrMedConsultas); $i++) 
                    {
                        $id_consultas=$arrMedConsultas[$i]->getIdconsulta();
                        $fechaD="";
                        
                        $nombre_servicio="";
                        $precio="";
                        $estado='PAGO';
                        $id_servicio=0;
                        
                        $datConsulta=$objConsulta->BuscarConsulta($id_consultas, "");
                        if(count($datConsulta)>0)
                        {
                            $id_servicio=$datConsulta[0]->getIdServicio();
                           
                            $datServicio=$objServicio->BuscarServicio($id_servicio, "", "");
                            if(count($datServicio)>0)
                            {
                                $id_tiposervicioD=$datServicio[0]->getIdTipoServicio();
                                $precio=$datServicio[0]->getPrecio();
                                
                                $datTipoServicioD=$objTS->BuscarTipoServicio($id_tiposervicioD, "");
                                if(count($datTipoServicioD)>0){$nombre_servicio=$datTipoServicioD[0]->getTipoServicio();}
                                
                                $datPacienteServicio=$objPacienteServ->BuscarPacienteServicio("", "", $id_servicio);
                                if(count($datPacienteServicio)>0)
                                {
                                    $id_transaccion=$datPacienteServicio[0]->getIdtransaccion();
                                    $fechaD=$datPacienteServicio[0]->getFecha();
                                    
                                    if($id_transaccion==0 || $id_transaccion=""){$estado="PENDIENTE";}
                                }
                            }
                            
                            $datosDoctor[$a]['id_servicio']=$id_servicio;
                            $datosDoctor[$a]['nomb_servicio']=$nombre_servicio;
                            $datosDoctor[$a]['nomb_doctor']=$nombre_doctor;
                            $datosDoctor[$a]['fecha']=$fechaD;
                            $datosDoctor[$a]['estado']=$estado;
                            $datosDoctor[$a]['precio']=$precio;
                            $a++;
                        }
                    }
                }
                if(count($ArrmedCir)>0)
                {
                    for ($i = 0; $i < count($ArrmedCir); $i++) 
                    {
                        $id_cirugia=$ArrmedCir[$i]->getIdcirugia();
                        $fechaD="";
                       
                        $nombre_servicio="";
                        $precio="";
                        $estado='PAGO';
                        $id_servicio=0;
                        
                        $datCirugia=$objCirugia->BuscarCirugia($id_cirugia, "", "");
                        if(count($datCirugia)>0)
                        {
                            $idservicio=$datCirugia[0]->getIdServicio();
                            $datServicio=$objServicio->BuscarServicio($id_servicio, "", "");
                            if(count($datServicio)>0)
                            {
                                $id_tiposervicioD=$datServicio[0]->getIdTipoServicio();
                                $precio=$datServicio[0]->getPrecio();
                                
                                $datTipoServicioD=$objTS->BuscarTipoServicio($id_tiposervicioD, "");
                                if(count($datTipoServicioD)>0){$nombre_servicio=$datTipoServicioD[0]->getTipoServicio();}
                                
                                $datPacienteServicio=$objPacienteServ->BuscarPacienteServicio("", "", $id_servicio);
                                if(count($datPacienteServicio)>0)
                                {
                                    $id_transaccion=$datPacienteServicio[0]->getIdtransaccion();
                                    $fechaD=$datPacienteServicio[0]->getFecha();
                                    
                                    if($id_transaccion==0 || $id_transaccion=""){$estado="PENDIENTE";}
                                }
                            }
                            
                            $datosDoctor[$a]['id_servicio']=$id_servicio;
                            $datosDoctor[$a]['nomb_servicio']=$nombre_servicio;
                            $datosDoctor[$a]['nomb_doctor']=$nombre_doctor;
                            $datosDoctor[$a]['fecha']=$fechaD;
                            $datosDoctor[$a]['estado']=$estado;
                            $datosDoctor[$a]['precio']=$precio;
                            $a++;
                        }
                    }
                }
                if(count($datosDoctor)==0)
               {
                    $msg="<div class='alert alert-danger alert-dismissable'>"
                       . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                       . "Error! No se han encontrado resultados para su criterio de b&uacute;Squeda Doctor.</div>";
               }
               
            }
        }
    }
    
    
    
    
}
?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          
          <?php 
          if($msg!=""){echo $msg;}
          ?>
          <div class="panel panel-default">
              <div class="panel-heading">
                  <b class="text-left"><i class="fa fa-search text-info"> BUSCAR SERVICIOS</i></b>
                 
              </div>
              <div class="panel-body">
                  
                  <form name="f" method="post" action="buscar_servicio.php">
                      <div class="form-group">
                          <label class="radio-inline">
                              <input name="optionsRadiosInline" id="optionsRadiosInline1" value="ts" <?php echo $chekedts;?> type="radio" onclick="TShidden();"><label>Tipo de servicio</label>
                        </label>
                        <label class="radio-inline">
                            <input name="optionsRadiosInline" id="optionsRadiosInline2" value="fs" type="radio" <?php echo $chekedfs;?> onclick="FShidden();"><label>Fecha del servicio</label>
                        </label>
                          <label class="radio-inline">
                            <input name="optionsRadiosInline" id="optionsRadiosInline3" value="nd" type="radio" <?php echo $chekednd;?> onclick="NDhidden();"><label>Nombre del Doctor</label>
                        </label>
                      </div>
                      <div id="tipo_servicioH" class="<?php echo $tipo_servicio_class;?>">
                          <label>Tipo de servicio</label>
                            <select name="tipoc" class="form-control">
                                <option value="">--SELECIONE--</option>
                                <?php 
                                if(count($lista_tipoS)>0)
                                  {
                                    for ($i = 0; $i < count($lista_tipoS); $i++) 
                                    {
                                     $idTS=$lista_tipoS[$i]->getIdTipoServicio();
                                     $nombts=$lista_tipoS[$i]->getTipoServicio();
                                     $selected="";
                                     //if($p_idTS==$idTS){$selected="selected='selected'";}

                                     echo "<option value='$idTS' $selected>$nombts</option>";
                                    }
                                  }

                                ?>
                            </select>
                      </div>
                    <div id="fecha_servicioH" class="<?php echo $fecha_servicio_class;?>">
                    <label>Fecha del servicio</label>
                    <input type="date" name="fecha" class="form-control" value="<?php //echo $p_fecha;?>">
                    </div>
                    <div id="nombre_doctorH" class="<?php echo $nombre_doctor_class;?>">
                    <label>Nombre del Doctor</label>
                    <select name="doctor" class="form-control">
                        <option value="">--SELECIONE--</option>
                        <?php 
                        if(count($lista_Medicos)>0)
                          {
                            for ($i = 0; $i < count($lista_Medicos); $i++) 
                            {
                             $idTS=$lista_Medicos[$i]->getIdMedico();
                             $nombts=$lista_Medicos[$i]->getNombre();
                             $selected="";
                             //if($p_doctor==$idTS){$selected="selected='selected'";}

                             echo "<option value='$idTS' $selected>$nombts</option>";
                            }
                          }

                        ?>
                    </select>
                    </div>
                    <br>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class=" fa fa-search"></i> Buscar</button>
                    </div> 

                </form>   
              </div>
          </div>
          
              
         
          <?php 
          if($msgs!=""){ echo $msgs;}
          if(count($datos)>0 || count($datosFecha)>0 || count($datosDoctor)>0)
          {
              echo '<hr>';
              echo '<h3>Resultados de la b&uacute;squeda</h3>';
              if(count($datos)>0)
              {
                  $nombreTipoServicio="";
                  $arrtp=$objTS->BuscarTipoServicio($p_idTS, "");
                  if(count($arrtp)>0){$nombreTipoServicio=$arrtp[0]->getTipoServicio();}
                  echo "<b>Resultados para parametro Tipo de Servicio $nombreTipoServicio</b><br>";
                  
                  echo "<table class='table table-responsive table-hover' id='dataTables-example'>";
                  echo"<thead>";
                  echo '<tr>';
                  echo '<th>Tipo Servicio</th>';
                  echo '<th>Precio</th>';
                  echo '<th>Fecha</th>';
                  echo '<th>Paciente</th>';
                  echo '<th>Estado Transacci&oacute;n</th>';
                  //echo '<th>Acci&oacute;n</th>';
                  echo '</tr>';
                  echo"</thead>";
                  echo '<tbody>';
                  for ($i = 0; $i < count($datos); $i++) 
                  {
                      $idsbd=$datos[$i]->getIdServicio();
                      $idtsbd=$datos[$i]->getIdTipoServicio();
                      $preciobd=$datos[$i]->getPrecio();
                      
                      $arrtp=$objTS->BuscarTipoServicio($idtsbd, "");
                      $ntsbd="";
                      if(count($arrtp)>0){$ntsbd=$arrtp[0]->getTipoServicio();}
                      
                      $fechabd="";
                      $estado="PAGO";
                      $nombrePaciente="";
                      $id_pacientebd="";
                      $arrF=$objPacienteServ->BuscarPacienteServicio("", "", $idsbd);
                      
                      if(count($arrF)>0)
                        {$fechabd=$arrF[0]->getFecha();
                      $idTransaccion=$arrF[0]->getIdtransaccion();
                      if($idTransaccion==0 || $idTransaccion==""){$estado="PENDIENTE";}
                      $idpaciente=$arrF[0]->getIdpaciente();
                      $arrPac=$objPaciente->BuscarPaciente("", "", "", $idpaciente);
                      if(count($arrPac)>0){$nombrePaciente=$arrPac[0]->getNombre();}
                      
                      }
                      
                        echo '<tr>';
                        echo "<td>$ntsbd</td>";
                        echo "<td>$preciobd</td>";
                        echo "<td>$fechabd</td>";
                        echo "<td>$nombrePaciente</td>";
                        echo "<td>$estado</td>";
                        /*echo "<td>";
                        if($estado=="PENDIENTE")
                        {
                            echo "<a href='elimServicio.php?nik=$idsbd' class='btn btn-primary btn-xs'><i class='fa fa-trash '></i></a> ";
                        }
                        
                        echo "<a href='pago_servicio.php?nik=$idsbd' class='btn btn-primary btn-xs' title='Efectuar Pago'> <i class='fa fa-dollar  '> </i> </a> ";
                        echo "<a href='mostrarpaciente.php?nik=$idsbd' class=' btn btn-primary btn-xs'> <i class='fa fa-eye'></i></a> ";
                        echo "</td>";*/
                        echo '</tr>';
                  }
                  echo '</tbody>';
                  echo '</table>';
              }
              if(count($datosFecha)>0)
              {
                  echo "<table class='table table-responsive table-hover' id='dataTables-example'>";
                  echo"<thead>";
                  echo '<tr>';
                  echo '<th>Tipo Servicio</th>';
                  echo '<th>Precio</th>';
                  echo '<th>Fecha</th>';
                  echo '<th>Paciente</th>';
                  echo '<th>Estado Transacci&oacute;n</th>';
                  //echo '<th>Acci&oacute;n</th>';
                  echo '</tr>';
                  echo"</thead>";
                  echo '<tbody>';
                  for ($i = 0; $i < count($datosFecha); $i++) 
                  {
                      $id_pacienteDF=$datosFecha[$i]->getIdpaciente();
                      $id_servicioDF=$datosFecha[$i]->getIdservicio();
                      $fechaDF=$datosFecha[$i]->getFecha();
                      $idTransaccionDF=$datosFecha[$i]->getIdtransaccion();
                      $nombre_paciente="";
                      $nombre_servicio="";
                      $estado="PAGO";
                      $precioDF=0;
                      if($idTransaccionDF==0 || $idTransaccionDF==""){$estado="PENDIENTE";} 
                      
                      $datPacienteDF=$objPaciente->BuscarPaciente("", "", "", $id_pacienteDF);
                      if(count($datPacienteDF)>0){$nombre_paciente=$datPacienteDF[0]->getNombre();}
                      
                      $datServicioDF=$objServicio->BuscarServicio($id_servicioDF, "", "");
                      if(count($datServicioDF)>0)
                      {
                          $idTipoServicioDF=$datServicioDF[0]->getIdTipoServicio();
                          $precioDF=$datServicioDF[0]->getPrecio();
                          
                          $datTipoServDF=$objTS->BuscarTipoServicio($idTipoServicioDF, "");
                          if(count($datTipoServDF)>0){$nombre_servicio=$datTipoServDF[0]->getTipoServicio();}
                      }
                      
                      echo '<tr>';
                      
                      echo "<td>$nombre_servicio</td>";
                      echo "<td>$precioDF</td>";
                      echo "<td>$fechaDF</td>";
                      echo "<td>$nombre_paciente</td>";
                      echo "<td>$estado</td>";
                     /* echo "<td>";
                      if($estado=="PENDIENTE")
                        {
                            echo "<a href='elimServicio.php?nik=$id_servicioDF' class='btn btn-primary btn-xs'><i class='fa fa-trash '></i></a> ";
                        }
                        
                        echo "<a href='pago_servicio.php?nik=$id_servicioDF' class='btn btn-primary btn-xs' title='Efectuar Pago'> <i class='fa fa-dollar  '> </i> </a> ";
                        echo "<a href='mostrarpaciente.php?nik=$id_servicioDF' class=' btn btn-primary btn-xs'> <i class='fa fa-eye'></i></a> ";
                        echo "</td>";*/
                        echo '</tr>';
                  }
                  
                  echo '</tbody>';
                  echo '</table>';
              }
             if(count($datosDoctor)>0)
             {
                 echo "<table class='table table-responsive table-hover' id='dataTables-example'>";
                  echo"<thead>";
                  echo '<tr>';
                  echo '<th>Tipo Servicio</th>';
                  echo '<th>Precio</th>';
                  echo '<th>Fecha</th>';
                  echo '<th>Doctor</th>';
                  //echo '<th>Estado Transacci&oacute;n</th>';
                  echo '<th>Acci&oacute;n</th>';
                  echo '</tr>';
                  echo"</thead>";
                  echo '<tbody>';
                  for ($i = 0; $i < count($datosDoctor); $i++) 
                  {
                      
                      $nombre_servicioD=$datosDoctor[$i]['nomb_servicio'];
                      $id_servicioD=$datosDoctor[$i]['id_servicio'];
                      $precioD=$datosDoctor[$i]['precio'];
                      $nombre_d=$datosDoctor[$i]['nomb_doctor'];
                      $estado=$datosDoctor[$i]['estado'];
                      $fechaD=$datosDoctor[$i]['fecha'];
                      echo '<tr>';
                      
                      echo "<td>$nombre_servicio</td>";
                      echo "<td>$precioD</td>";
                      echo "<td>$fechaD</td>";
                      echo "<td>$nombre_d</td>";
                      echo "<td>$estado</td>";
                      /*echo "<td>";
                      if($estado=="PENDIENTE")
                        {
                            echo "<a href='elimServicio.php?nik=$id_servicioD' class='btn btn-primary btn-xs'><i class='fa fa-trash '></i></a> ";
                        }
                        
                        echo "<a href='pago_servicio.php?nik=$id_servicioD' class='btn btn-primary btn-xs' title='Efectuar Pago'> <i class='fa fa-dollar  '> </i> </a> ";
                        echo "<a href='mostrarpaciente.php?nik=$id_servicioD' class=' btn btn-primary btn-xs'> <i class='fa fa-eye'></i></a> ";
                        echo "</td>";*/
                        echo '</tr>';
                  }
                  }
                  echo '</tbody>';
                  echo '</table>';
             }
          
          else
          {
              echo '<br><br>';
              echo $msg;
          }
          ?>
        </div>
        </div>
    </div>
</section>
<div style="bottom: 0px; position: relative; width: 100%;">
   <?php 

include './footer.html';
?> 
</div>



