<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/EspecialidadController.php';
include '../modelo/MedicoController.php';
include '../modelo/NombreCirugiaController.php';
include '../modelo/consultas_genericas.php';
include '../modelo/ServicioController.php';
include '../modelo/CirugiaController.php';
include '../modelo/TrabajadorController.php';
include '../modelo/CargoController.php';
include '../modelo/MedicoCirugiaController.php';
include '../modelo/PacienteServicioController.php';



//$msg="";

$objCirugiaC=new CirugiaController();
$objEspecialidad= new EspecialidadController();
$objMedico=new MedicoController();
$objNombreCirugia= new NombreCirugiaController();
$objServicioC= new ServicioController();
$objPacienteServC= new PacienteServicioController();
$objTrabajador=new TrabajadorController();
$objMedicoCC=new MedicoCirugiaController();
$objCargo=new CargoController();

$lista_medicos=$objMedico->MostrarMedico();
$lista_especialidades=$objEspecialidad->MostrarEspecialidad();

$lista_nombrec=$objNombreCirugia->MostrarNombreCirugia();
$arr_cargos=$objCargo->BuscarLike("enferm");

$lista_nombrec=$objNombreCirugia->MostrarNombreCirugia();
$lista_roles_medicos=array();
$lista_roles_enf=array();

##variables
$a="";
$msg="";
$error=0;
$idpaciente="";
$id_servicio="";
$id_especialidad="";
$act_select_hidden=0;
#####variables de cirugia################################
$p_idespecialidad_quirurgica="";
$p_id_cirugia="";
$p_id_cirujano="";
$p_fecha_cirugia="";
$p_duracion_cirugia="";
$p_id_insumos="";
$p_precio_cirugia="";
$p_lista_insumos=array();
$p_lista_medicos=array();
$p_cantidad_insumos=0;
$p_cantidad_medicos=0;
$id_cirugia="";

$cg=new ConsultasG();
$p=array();
$p['campo'][0]="especializacion";
$p['valor'][0]="m";
$r=$cg->GenericSelect('roles_cirugia', $p);
if($r){$lista_roles_medicos=$cg->ArregloAsociativoSelect($r, 'roles_cirugia');}

$p=array();
$p['campo'][0]="especializacion";
$p['valor'][0]="t";
$r=$cg->GenericSelect('roles_cirugia', $p);
if($r){$lista_roles_enf=$cg->ArregloAsociativoSelect($r, 'roles_cirugia');}

$arr_cargos=$objCargo->BuscarLike("enferm");

$lista_trabajadores=array();
$t=0;
for ($i = 0; $i < count($arr_cargos); $i++) 
{
    $p_cargo=$arr_cargos[$i]->getIdCargo();
    $arr_trab=$objTrabajador->BuscarTrabajador("", "", "",$p_cargo);
    for ($j = 0; $j < count($arr_trab); $j++) 
    {
        $lista_trabajadores[$t]=$arr_trab[$j];
        $t++;
    }

}
$lista_medicos=array();
$lista_medicos=$objMedico->MostrarMedico();
if($_GET)
{
    $id_cirugia=$_GET['nik'];
    

$contador=0;
for ($index = 0; $index < count($lista_trabajadores); $index++) 
{
   $id_trab=$lista_trabajadores[$index]->getIdTrabajador();
   $arr=$objMedicoCC->BuscarMedicoCirugia("", "", $id_cirugia, "", $id_trab);
   $id_cargo=$lista_trabajadores[$index]->getCargo();
   $nombre_cargo="";
   $arrCargos=$objCargo->BuscarCargo($id_cargo, "");
   if(count($arrCargos)>0){$nombre_cargo=$arrCargos[0]->getNombreCargo();}
   if(count($arr)>0)
   {
       for ($index1 = 0; $index1 < count($arr); $index1++)
       {
           $p_lista_medicos[$contador]['trab']=$lista_trabajadores[$index]->getNombre();
           $p_lista_medicos[$contador]['cargo']=$nombre_cargo;
           $contador++;
       }
        
   }
   
}
for ($index = 0; $index < count($lista_medicos); $index++) 
{
   $id_medico=$lista_medicos[$index]->getIdMedico();
   $arr=$objMedicoCC->BuscarMedicoCirugia("", $id_medico, $id_cirugia);
   $nombre_cargo="";
   
   if(count($arr)>0)
   {
       for ($index1 = 0; $index1 < count($arr); $index1++)
       {
            $p_lista_medicos[$contador]['med']=$lista_medicos[$index]->getNombre();
            $id_rol=$arr[$index1]->getRol();
            $arrrol=array();
            $cg=new ConsultasG();
            $p=array();
            $p['campo'][0]='id_rol';
            $p['valor'][0]=$id_rol;
            $r=$cg->GenericSelect('roles_cirugia', $p);
            if($r)
            {
                $arrrol=$cg->ArregloAsociativoSelect($r, 'roles_cirugia');
                if(count($arrrol)>0){$nombre_cargo=$arrrol[0]['nombre'];}
            }
            $p_lista_medicos[$contador]['cargo']=$nombre_cargo;
            $contador++;
       }
       
   }
   
}
$p_cantidad_medicos= count($p_lista_medicos);
    
}
if($_POST)
{
    if(isset($_POST['cantidad_medicos'])){$p_cantidad_medicos=$_POST['cantidad_medicos'];}
     if(isset($_POST['id_cirugia'])){$id_cirugia=$_POST['id_cirugia'];}
     if(isset($_POST['id_paciente_buscar'])){$idpaciente=$_POST['id_paciente_buscar'];}
     if(isset($_POST['servicios'])){$id_servicio=$_POST['servicios'];}
     if(isset($_POST['act_select_hidden'])) {$act_select_hidden=$_POST['act_select_hidden'];}  
    
    if($p_cantidad_medicos>0)
           {          
               $c_i=0;
               for ($j = 0; $j <= $p_cantidad_medicos; $j++) 
               {
                   $x=0;
                   $var_id_medico="med$j";
                   $var_id_trabajador="trab$j";
                   $var_id_cargo="cargo$j";
                   
                   if(isset($_POST[$var_id_medico]))
                  {$p_lista_medicos[$c_i]['med']=$_POST[$var_id_medico];$x++;}
                  else 
                  {
                      if(isset($_POST[$var_id_trabajador]))
                          {$p_lista_medicos[$c_i]['trab']=$_POST[$var_id_trabajador];$x++;}
                  }
                  if(isset($_POST[$var_id_cargo]))
                          {$p_lista_medicos[$c_i]['cargo']=$_POST[$var_id_cargo];$x++;}
                  
                  if($x!=0){$c_i++;}
               }
               
           }
          if($act_select_hidden==0)
          {  
              ##elimino todos los trabajadores o medicos de medico cirugia donde el id_cirugia =id cirugia
              if($p_cantidad_medicos>0)
              {
                  
                  $affected=$objMedicoCC->EliminarPordCirugia($id_cirugia);
                    if($affected==1)
                    {
                        ##buscar la fecha de la cirugia
                        
                        $arrC=$objCirugiaC->BuscarCirugia($id_cirugia, "", "");
                        if(count($arrC)>0)
                        {
                            $id_servicio=$arrC[0]->getIdServicio();
                            $arrPS=$objPacienteServC->BuscarPacienteServicio("", "", $id_servicio);
                            if(count($arrPS)>0){$p_fecha_cirugia=$arrPS[0]->getFecha();}
                        }
                        
                        for ($i = 0; $i < $p_cantidad_medicos; $i++) 
                      {
                          $xx=0;
                          $pcargo="";$p_idC="";
                          $pmed="";$p_idmc=null;
                          $ptrab="";$p_idt=null;
                         if(isset($_POST["cargo$i"])){$pcargo=$_POST["cargo$i"];}
                         if(isset($_POST["med$i"])){$pmed=$_POST["med$i"];} 
                         if(isset($_POST["trab$i"])){$ptrab=$_POST["trab$i"];} 
                          
                          if($pmed!="")
                          {
                              ##buscar el id del medico por el nombre
                              $arrMed=$objMedico->BuscarMedico("", $pmed, "");
                              if(count($arrMed)>0)
                              {
                                  $p_idmc=$arrMed[0]->getIdMedico();
                                  $xx++;
                              }

                          }
                           if($ptrab!="")
                          {
                               $arrT=$objTrabajador->BuscarTrabajador("", $ptrab, "");
                               if(count($arrT)>0)
                               {
                                  $p_idt=$arrT[0]->getIdTrabajador();
                                  $xx++;
                               }

                          }

                          if($pcargo!="")
                          {
                              $parametros=array();
                              $parametros['campo'][0]="nombre";
                              $parametros['valor'][0]=$pcargo;

                              $r=$cg->GenericSelect('roles_cirugia', $parametros);
                              if($r){
                                  $arrCargos=$cg->ArregloAsociativoSelect($r, 'roles_cirugia');
                                  if(count($arrCargos)>0)
                                  {
                                      $p_idC=$arrCargos[0]['id_rol'];
                                  }

                              }

                          }
                          if($xx!=0)
                          {
                              if($p_idmc!="")
                              {
                                  $aff=$objMedicoCC->CrearMedicoCirugia($p_idmc, $id_cirugia, $p_fecha_cirugia, "", $p_idC, "");
                              }
                              if($p_idt!="")
                              {
                                  $aff=$objMedicoCC->CrearMedicoCirugia("", $id_cirugia, $p_fecha_cirugia, "", $p_idC, $p_idt);
                              }
                              
                              
                          }
                          if($aff==0)
                          {
                              $msg="<div class='alert alert-danger alert-dismissable'>"
                              . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                              . "Error! No se pudieron modificar los datos de la cirugia  </div>"; 
                          }
                          else
                          {
                              $msg="<div class='alert alert-success alert-dismissable'>"
                              . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                              . "OK! Los datos de la cirugia fueron modificados con exito. </div>"; 

                              echo "<script>";
                                  echo "window.location = 'mostrar_cirugia.php?nik=$id_cirugia';";
                             echo "</script>";
                          }
                      }
                    }
                    else
                    {
                        $msg="<div class='alert alert-danger alert-dismissable'>"
                          . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                          . "Error! No se pudieron borrar los datos anteriores de la cirugia  </div>"; 

                    }
              }
              
              
                
          }
          
          
}

?>
<br><br>
<section class="about-text">
    <div class="container ">
        <div class="col-md-12">
            <form name='cirugia' method="post" action="edita_equipo_cirugia.php" id='cirugia_form'>
                <input type="hidden" name="act_select_hidden" id="cirugia_hidden" value="0">
                <input type="hidden" name="servicios"  value="<?php echo $id_servicio;?>">
                <input type="hidden" name="id_paciente_buscar"  value="<?php echo $idpaciente;?>">
                <input type="hidden" name="id_cirugia"  value="<?php echo $id_cirugia;?>">
          <h3 class="text-left"><i class="fa fa-user text-info"> Datos del equipo medico</i></h3>
          
          <div class="col-md-12" >
              <?php 
              if($msg!=""){echo $msg;}
              ?>
                  <table class="table table-responsive table-bordered" id="tabla_med_equipo">
                    <tr>
                        <th colspan="3" >
                            <label class="text-primary">Equipo M&eacute;dico</label>
                            
                            <input type="hidden" name="cantidad_medicos" id='cantidad_med' value="<?php echo $p_cantidad_medicos;?>">
                            <div class="text-right">
                            <button type='button' class='btn btn-primary btn-xs' title='Adicionar Medicos' data-toggle='modal' ddata-toggle="modal" data-target="#divModalMed" style="margin-top: -45px;"><i class='fa fa-user-md'></i> Adicionar M&eacute;dico</button>
                            
                            </div>
                      </th>
                  </tr>
                  <tr>
                      <th>Nombre</th>
                      <th>Cargo</th>
                      <th>Acci&oacute;n</th>
                  </tr>
                  <?php 
                     if($p_cantidad_medicos!=0)
                    {                                     
                         for ($i = 0; $i < count($p_lista_medicos); $i++) 
                         {
                             $med="";
                             $trab="";
                             if(isset($p_lista_medicos[$i]['med'])){$med=$p_lista_medicos[$i]['med'];  }
                             if(isset($p_lista_medicos[$i]['trab'])){$trab=$p_lista_medicos[$i]['trab'];  }
                           
                           $carg=$p_lista_medicos[$i]['cargo']; 
                           
                           echo "<tr id='e$i'>";
                           if($med!="")
                           {
                                echo "<td><input type='text' name='med$i' value='$med' readonly='readonly' class='form-control' id='med$i'></td>";
                           }
                           if($trab!="")
                           {
                               echo "<td><input type='text' name='trab$i' value='$trab' readonly='readonly' class='form-control' id='med$i'></td>";
                           }
                          
                           echo "<td><input type='text' name='cargo$i' class='form-control'  value='$carg' readonly='readonly'></td>";
                           echo "<td><button class='btn btn-danger brn-xs fa fa-close' id='e$i' onclick='deleteRowEquipoMedico(this.id);'></button></td>";
                           echo '</tr>';
                         }
                    }
                     ?>
              </table>
              </div>
              
              <div class="text-right col-md-12">
                  <button  type="submit" class="btn btn-success">Registrar</button>
                  <a href='mostrar_cirugia.php?nik=<?php echo $id_cirugia;?>' class="btn btn-danger" >Cancelar</a>
              </div>
          </form>
        </div>
    </div>
</section>

<div id="divModalMed" class='modal fade'  tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' > 
    <div class="modal-dialog">
        <div class="modal-content">
       <div class="modal-header" style="background-color: #004731;"> 
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <img src='../img/clinica_logo.png' id="logo" class="pull-left" style="width: 50px; margin-top: -10px;">
            <h4 class="modal-title" id="H1" style="color: white;">Listado de Miembros para el equipo de la Cirug&i&iacute;a</h4>
        </div>
        <div class="modal-body ">
            <img src="../img/doctores.png" style="width: 120px;" id='imagen_modal'>
                <div style="margin-left: 155px;width: 70%!important; margin-top: -85px;">
                    
                    <input type="radio" name="medic" id="tipoM" onclick="MostrarSelect();" checked="checked"> M&eacute;dico
                    <input type="radio" name="medic" id="tipoE" onclick="MostrarSelect();" > Enfermer&iacute;a
                </div>
                
                <div style="margin-left: 155px;width: 70%!important; margin-top: -30px;" class="" id='select_med' >
                    <br><br>
                    <label>Selecccione el personal M&eacute;dico</label>
                    <select name="personal_med" class="form-control selectpicker" id="pers_med" data-live-search='true'>
                        <option value=''>--SELECCIONE--</option>
                        <?php 
                      for ($i = 0; $i < count($lista_medicos); $i++) 
                      {
                         $id_m=$lista_medicos[$i]->getIdMedico();
                         $nombre=$lista_medicos[$i]->getNombre();
                         echo "<option value='$nombre' >$nombre</option>";
                      }
                        ?>
                    </select>
                    <label>Selecccione el rol a desempe&ntilde;ar</label>
                    <select name="carg" class="form-control selectpicker" id="cargM" data-live-search='true'>
                        <option value=''>--SELECCIONE--</option>
                        <?php 
                      for ($i = 1; $i < count($lista_roles_medicos); $i++) 
                      {
                         $id_m=$lista_roles_medicos[$i]['id_rol'];
                         $nombre=$lista_roles_medicos[$i]['nombre'];
                         echo "<option value='$nombre' >$nombre</option>";
                      }
                        ?>
                    </select>
                    
                </div>                
                <div style="margin-left: 155px;width: 70%!important; margin-top: -30px;" class="hidden" id="select_enf">
                    <br><br>
                    <label>Selecccione el personal de enfermeria</label>
                    <select name="insumos" class="form-control selectpicker" id="pers_enf" data-live-search='true'>
                        <option value=''>--SELECCIONE--</option>
                        <?php 
                      for ($i = 0; $i < count($lista_trabajadores); $i++) 
                      {
                         $id_trab=$lista_trabajadores[$i]->getIdTrabajador();
                         $nombre=$lista_trabajadores[$i]->getNombre();
                         
                         echo "<option value='$nombre'>$nombre</option>";
                      }
                        ?>
                    </select>
                    <label>Seleccione el rol a realizar en la cirug&iacute;a</label>
                    <select name="cargos" class="form-control selectpicker" id="cargE" data-live-search='true'>
                        <option value=''>--SELECCIONE--</option>
                        <?php 
                      for ($i = 0; $i < count($lista_roles_enf); $i++) 
                      {
                         $id_trab=$lista_roles_enf[$i]['id_rol'];
                         $nombre=$lista_roles_enf[$i]['nombre'];
                         
                         echo "<option value='$nombre'>$nombre</option>";
                      }
                        ?>
                    </select>
                    
            </div>
            
                    
        </div>
       
        <br>
        <div class="modal-footer">
            <button  type="button" class="btn btn-success" onclick="AddEquipo();">Adicionar</button>
            <button class="btn btn-danger " data-dismiss="modal" id="m_equipoMF">Cancelar</button>
        </div>
         </div>
    </div>
</div>

