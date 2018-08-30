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
$med_nombre="";
$trab_nombre="";
$cargo_nombre="";
         
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
           $p_lista_medicos[$contador]['trab']=$lista_trabajadores[$index]->getIdTrabajador();
           $p_lista_medicos[$contador]['trab_nomb']=$lista_trabajadores[$index]->getNombre();
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
            $p_lista_medicos[$contador]['med']=$lista_medicos[$index]->getIdMedico();
            $p_lista_medicos[$contador]['med_nomb']=$lista_medicos[$index]->getNombre();

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
     if(isset($_POST['med_nombre'])){$med_nombre=$_POST['med_nombre'];}
     if(isset($_POST['trab_nombre'])){$trab_nombre=$_POST['trab_nombre'];}
     if(isset($_POST['cargo'])){$cargo_nombre=$_POST['cargo'];}
     
     if($act_select_hidden==0)
     {
         ##adicionar
         ##que el trabajador o medico no exita ya en el mismo equipo medico y que el rol no sea cirujano principal
        
         $add_medico="";
         $add_trabajador="";
         $cargo="";
         $carg="";
         $p_fecha= FechaYMA();
         if(isset($_POST['personal_med'])){$add_medico=$_POST['personal_med'];}
         if(isset($_POST['trabajadores'])){$add_trabajador=$_POST['trabajadores'];}
         if(isset($_POST['cargos'])){$cargo=$_POST['cargos'];}
         if(isset($_POST['carg'])){$carg=$_POST['carg'];}
         if($cargo==""){$cargo=$carg;}
         $arrEquipCir=$objMedicoCC->BuscarMedicoCirugia("", $add_medico, $id_cirugia,"",$add_trabajador);
         if(count($arrEquipCir)>0)
         {
              $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! El trabajador ya forma parte del equipo cirugia.</div>"; 
                 $error++;
         }
         if($error==0)
         {
             $affected=$objMedicoCC->CrearMedicoCirugia($add_medico, $id_cirugia, $p_fecha, "", $cargo, $add_trabajador);
             
             if($affected==0)
             {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se puede agregar el nuevo miembro al equipo de cirugia.</div>"; 
                 
             }
             if($affected==1)
             {
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "OK! Se ha agregado correctamente un miembro al equipo de cirugia</div>"; 
                 
             }
         }
         
         
     }
     if($act_select_hidden==1)
     {
         ##eliminar
         $eliminar_medico="";
         $eliminar_trabajador="";
         
         if(isset($_POST['eliminar_medico'])){$eliminar_medico=$_POST['eliminar_medico'];}
         if(isset($_POST['eliminar_trabajador'])){$eliminar_trabajador=$_POST['eliminar_trabajador'];}
         
         $arrEquipCir=$objMedicoCC->BuscarMedicoCirugia("", $eliminar_medico, $id_cirugia,"",$eliminar_trabajador);
         if(count($arrEquipCir)>0)
         {
             $id_medico_cirugia_elimianr=$arrEquipCir[0]->getIdmc();
             $id_rol_cirugiaT=$arrEquipCir[0]->getRol();
             if($id_rol_cirugiaT==1)
             {
                 $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Para modificar o eliminar los datos del cirujano principal usted debe de editar los datos generales de la cirugia.</div>"; 
                 $error++;
             }
             if($error==0)
             {
                 
                     $affected=$objMedicoCC->EliminarMedicoCirugia($id_medico_cirugia_elimianr);
                     if($affected==0)
                     {
                         $msg="<div class='alert alert-danger alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "Error! No se pudieron eliminar los datos del $cargo_nombre $med_nombre $trab_nombre</div>"; 
                 
                     }
                     if($affected==1)
                     {
                         $msg="<div class='alert alert-success alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "OK!Se han eliminado correctamente los datos del $cargo_nombre $med_nombre $trab_nombre</div>"; 
                     }
                 
                
             }
             
         }
     }
    
          
          
}

##cargar datos
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
           $p_lista_medicos[$contador]['trab']=$lista_trabajadores[$index]->getIdTrabajador();
           $p_lista_medicos[$contador]['trab_nomb']=$lista_trabajadores[$index]->getNombre();
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
            $p_lista_medicos[$contador]['med']=$lista_medicos[$index]->getIdMedico();
            $p_lista_medicos[$contador]['med_nomb']=$lista_medicos[$index]->getNombre();

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
?>
<br><br>
<section class="about-text">
    <div class="container ">
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user text-info"> Datos del equipo medico</i></h3>
          <div class="col-md-12" >
              <?php 
              if($msg!=""){echo $msg;}
              ?>
                  <table class="table table-responsive table-bordered" id="tabla_med_equipo">
                    <tr>
                        <th colspan="3" >
                            <label class="text-primary">Equipo M&eacute;dico</label>
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
                                                        
                         for ($i = 0; $i < count($p_lista_medicos); $i++) 
                         {
                             $med="";
                             $med_nombre="";
                             $trab="";
                             $trab_nombre="";
                             
                             if(isset($p_lista_medicos[$i]['med_nomb'])){$med_nombre=$p_lista_medicos[$i]['med_nomb'];  }
                             if(isset($p_lista_medicos[$i]['med'])){$med=$p_lista_medicos[$i]['med'];  }
                             if(isset($p_lista_medicos[$i]['trab_nomb'])){$trab_nombre=$p_lista_medicos[$i]['trab_nomb'];  }
                             if(isset($p_lista_medicos[$i]['trab'])){$trab=$p_lista_medicos[$i]['trab'];  }
                           
                           $carg=$p_lista_medicos[$i]['cargo']; 
                           $carg_nombre=$p_lista_medicos[$i]['cargo']; 
                           echo "<form name='f$i' method='post' action='edita_equipo_cirugia.php' id='form$i'>";
                           echo "<tr id='e$i'>";
                           echo "<input type='hidden' name='act_select_hidden'  id='hidenV$i' value='0'>";
                           echo "<input type='hidden' name='eliminar_medico'  value='$med'>";
                           echo "<input type='hidden' name='eliminar_trabajador'  value='$trab'>";
                           echo "<input type='hidden' name='servicios'  value='$id_servicio'>";
                            echo "<input type='hidden' name='id_paciente_buscar'  value='$idpaciente'>";
                            echo "<input type='hidden' name='id_cirugia'  value='$id_cirugia'>";
                          
                           if($med!="")
                           {
                                echo "<td>"
                               . "<input type='text' name='med_nombre' value='$med_nombre' readonly='readonly' class='form-control' id='medN$i'>"
                               . "</td>";
                           }
                           if($trab!="")
                           {
                               echo "<td>"
                               . "<input type='text' name='trab_nombre' value='$trab_nombre' readonly='readonly' class='form-control' id='medT$i'>"
                               . "</td>";
                           }
                          
                           echo "<td><input type='text' name='cargo' class='form-control'  value='$carg' readonly='readonly'></td>";
                           echo "<td><button class='btn btn-danger brn-xs fa fa-close' id='$i' onclick='ElimiarEquipoMed(this.id);'></button></td>";
                           echo '</tr>';
                           echo "</form>";
                         }
                    
                     ?>
              </table>
              </div>
              
              <div class="text-right col-md-12">
                  <a href='mostrar_cirugia.php?nik=<?php echo $id_cirugia;?>' class="btn btn-primary" >Volver</a>
              </div>
         
        </div>
    </div>
</section>

<div id="divModalMed" class='modal fade'  tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' > 
    <div class="modal-dialog">
        <form name="m" method="post" action="edita_equipo_cirugia.php" id="modal_equipo_c">
        <div class="modal-content">
       <div class="modal-header" style="background-color: #004731;"> 
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <img src='../img/clinica_logo.png' id="logo" class="pull-left" style="width: 50px; margin-top: -10px;">
            <h4 class="modal-title" id="H1" style="color: white;">Listado de Miembros para el equipo de la Cirug&i&iacute;a</h4>
        </div>
        <div class="modal-body ">
            <img src="../img/doctores.png" style="width: 120px;" id='imagen_modal'>
                <div style="margin-left: 155px;width: 70%!important; margin-top: -85px;">
                    <input type="hidden" name="act_select_hidden" value="0" id="act_hiddenModal">
                    <input type='hidden' name='id_cirugia'  value='<?php echo $id_cirugia;?>'>
                    <input type="radio" name="medic" id="tipoM" onclick="MostrarSelect();" checked="checked" value='m'> M&eacute;dico
                    <input type="radio" name="medic" id="tipoE" onclick="MostrarSelect();"  value="t"> Enfermer&iacute;a
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
                         echo "<option value='$id_m' >$nombre</option>";
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
                         echo "<option value='$id_m' >$nombre</option>";
                      }
                        ?>
                    </select>
                    
                </div>                
                <div style="margin-left: 155px;width: 70%!important; margin-top: -30px;" class="hidden" id="select_enf">
                    <br><br>
                    <label>Selecccione el personal de enfermeria</label>
                    <select name="trabajadores" class="form-control selectpicker" id="pers_enf" data-live-search='true'>
                        <option value=''>--SELECCIONE--</option>
                        <?php 
                      for ($i = 0; $i < count($lista_trabajadores); $i++) 
                      {
                         $id_trab=$lista_trabajadores[$i]->getIdTrabajador();
                         $nombre=$lista_trabajadores[$i]->getNombre();
                         
                         echo "<option value='$id_trab'>$nombre</option>";
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
                         
                         echo "<option value='$id_trab'>$nombre</option>";
                      }
                        ?>
                    </select>
                    
            </div>
            
                    
        </div>
       
        <br>
        <div class="modal-footer">
            <button  type="button" class="btn btn-success" onclick="AddEquipoCirugia();">Adicionar</button>
            <button class="btn btn-danger " data-dismiss="modal" id="m_equipoMF">Cancelar</button>
        </div>
         </div>
        </form>
    </div>
</div>

