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


$lista_tipoS=array();
$lista_Medicos=array();
$objTS=new TipoServicioController();
$objServicio=new ServicioController();
$objMedico=new MedicoController();
$objPacienteServ=new PacienteServicioController();
$objTransaccion=new TransaccionController();
$objPaciente=new PacienteController();

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

if($_POST)
{    
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
     if(eliminarblancos($p_fecha)!="")
     {
         $datosFecha=$objPacienteServ->BuscarPacienteServicio("", "", "",$p_fecha);
         if(count($datosFecha)==0)
        {
             $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se han encontrado resultados para su criterio de b&uacute;Squeda.</div>";
        }
     }
     if(eliminarblancos($p_doctor)!="")
     {
         $datosDoctor=$objMedico->BuscarMedico($p_doctor, "", "", ""); 
         if(count($datosDoctor)==0)
        {
             $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se han encontrado resultados para su criterio de b&uacute;Squeda.</div>";
        }
     }
     
     
      
    }
    
    
}
?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left  text-info"><i class="fa fa-search-plus"> </i> Buscar Servicios</h3>
          <div class="col-md-2" ></div>
          <div class="col-md-8" >
              <form name="f" method="post" action="buscar_servicio.php">
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
              <label>Fecha del servicio</label>
              <input type="date" name="fecha" class="form-control" value="<?php //echo $p_fecha;?>">
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
              <button type="submit" class="btn btn-success"> Buscar</button>  
          </form>
          </div>
          <div class="col-md-2" ></div>
          <div class="col-md-12" >
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
                  
                  echo "<table class='table table-responsive table-hover' id='example'>";
                  echo"<thead>";
                  echo '<tr>';
                  echo '<th>Tipo Servicio</th>';
                  echo '<th>Precio</th>';
                  echo '<th>Fecha</th>';
                  echo '<th>Paciente</th>';
                  echo '<th>Estado Transacci&oacute;n</th>';
                  echo '<th>Acci&oacute;n</th>';
                  echo '</tr>';
                  echo"<thead>";
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
                        echo "<td>";
                        if($estado=="PENDIENTE")
                        {
                            echo "<a href='elimServicio.php?nik=$idsbd' class='btn btn-danger btn-xs'><i class='fa fa-trash '></i></a> ";
                        }
                        
                        echo "<a href='pago_servicio.php?nik=$idsbd' class='btn btn-success btn-xs' title='Efectuar Pago'> <i class='fa fa-dollar  '> </i> </a> ";
                        echo "<a href='mostrarpaciente.php?nik=$idsbd' class=' btn btn-primary btn-xs'> <i class='fa fa-eye'></i></a> ";
                        echo "</td>";
                        echo '</tr>';
                  }
                  echo '</tbody>';
                  echo '</table>';
              }
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



