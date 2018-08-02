<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/EspecialidadController.php';
include '../modelo/MedicoController.php';
include '../modelo/TipoServicioController.php';
include '../modelo/NombreCirugiaController.php';
include '../modelo/consultas_genericas.php';
include '../modelo/ServicioController.php';
include '../modelo/CirugiaController.php';
include '../modelo/PacienteServicioController.php';
include '../modelo/MedicoCirugiaController.php';


$objCirugiaC=new CirugiaController();
$objEspecialidad= new EspecialidadController();
$objMedico=new MedicoController();
$objNombreCirugia= new NombreCirugiaController();
$objServicioC= new ServicioController();
$objTipoServicio= new TipoServicioController();
$objMedico=new MedicoController();
$objTipoServicio= new TipoServicioController();
$objPacienteServC= new PacienteServicioController();
$objMedicoCC=new MedicoCirugiaController();

$lista_medicos=$objMedico->MostrarMedico();
$lista_especialidades=$objEspecialidad->MostrarEspecialidad();
$lista_tiposervicios=$objTipoServicio->MostrarTipoServicio();
$lista_nombrec=$objNombreCirugia->MostrarNombreCirugia();
$lista_tiposervicios=$objTipoServicio->MostrarTipoServicio();
$lista_nombrec=$objNombreCirugia->MostrarNombreCirugia();

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
$id_servicio="";
$msg="";
$error="";
$idpaciente="";

if($_GET)
{    if(isset($_GET['serv']))
    {
        $id_servicio=$_GET['serv'];
        if(eliminarblancos($id_servicio)!="")
        {
            $arr_servicios=$objServicioC->BuscarServicio($id_servicio, "", "");
            if(count($arr_servicios)>0)
            {
                $p_precio_cirugia=$arr_servicios[0]->getPrecio();
            }
            
            $arrPacienteServ=$objPacienteServC->BuscarPacienteServicio("", "", $id_servicio);
            if(count($arrPacienteServ)>0)
            {
                $p_fecha_cirugia=$arrPacienteServ[0]->getFecha();
                $idpaciente=$arrPacienteServ[0]->getIdpaciente();
            }
        }
    
    }
     if(isset($_GET['nik']))
    {
         $id_cirugia=$_GET['nik'];
         if(eliminarblancos($id_cirugia)!="")
         {
             $arr_cirugia=$objCirugiaC->BuscarCirugia($id_cirugia, "", "");
            if(count($arr_cirugia)>0)
           {
                $p_idespecialidad_quirurgica=$arr_cirugia[0]->getIdEspecialidad();
                $p_id_cirugia=$arr_cirugia[0]->getIdNombreC();
                $p_duracion_cirugia=$arr_cirugia[0]->getDuracion();
                
                $lista_nombrec=$objNombreCirugia->BuscarNombreCirugia("", "", $p_idespecialidad_quirurgica);

           }
           $arrMedCir=$objMedicoCC->BuscarMedicoCirugia("", "", $id_cirugia);
           if(count($arrMedCir)>0)
            {
               $p_id_cirujano=$arrMedCir[0]->getIdmedico();
            }
           
         }
         
         
         
    }
    

}

if($_POST)
{   
    if(isset($_POST['servicios'])){$id_servicio=$_POST['servicios'];}
    if(isset($_POST['act_select_hidden'])) {$act_select_hidden=$_POST['act_select_hidden'];}  
    if(isset($_POST['id_paciente_buscar'])){$idpaciente=$_POST['id_paciente_buscar'];}
    if(isset($_POST['id_cirugia'])){$id_cirugia=$_POST['id_cirugia'];}
    
    ##cirugia
       if(isset($_POST['especialidadquirurgica']))
       {
          $p_idespecialidad_quirurgica=$_POST['especialidadquirurgica'];
           
           if(isset($_POST['nombrecirugia'])){$p_id_cirugia=$_POST['nombrecirugia'];}
           if(isset($_POST['duracion'])){$p_duracion_cirugia=$_POST['duracion'];}
           if(isset($_POST['precio'])){$p_precio_cirugia=$_POST['precio'];}
           if(isset($_POST['fecha'])){$p_fecha_cirugia=$_POST['fecha'];}
           if(isset($_POST['medicos'])){$p_id_cirujano=$_POST['medicos'];}

           if($act_select_hidden==1)
           {
               ##cargar cirugia, cirujanos,
               $lista_nombrec=$objNombreCirugia->BuscarNombreCirugia("", "", $p_idespecialidad_quirurgica);
               $lista_medicos=$objMedico->BuscarMedico("", "", "", $p_idespecialidad_quirurgica);
               //Mostrar($lista_medicos);
           }
           else
           {
                ##Modificar
              
               if(eliminarblancos($p_idespecialidad_quirurgica)=="")
               {
                   $msg="<div class='alert alert-danger alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "Error! Usted debe de seleccionar la especialidad para la cirug&iacute;a</div>"; 
                    $error++;
               }
               if(eliminarblancos($p_id_cirugia)=="")
               {
                   $p_nomb_especialidadQ="";
                   $arrEspecialidad=$objEspecialidad->BuscarEspecialidad($p_idespecialidad_quirurgica, "", "");
                   if(count($arrEspecialidad)>0){$p_nomb_especialidadQ=$arrEspecialidad[0]->getNombreespecialidad();}
                    $msg="<div class='alert alert-danger alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "Error! Usted debe de seleccionar la cirug&iacute;a a realizar para la especialidad $p_nomb_especialidadQ</div>"; 
                    $error++;
               }
               if(eliminarblancos($p_fecha_cirugia)=="")
               {
                    $msg="<div class='alert alert-danger alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "Error! Usted debe de seleccionar la fecha para la cirugua cirug&iacute;a </div>"; 
                    $error++;
               }
               if(eliminarblancos($p_id_cirujano)=="")
               {
                   $msg="<div class='alert alert-danger alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "Error! Usted debe de seleccionar el cirujano principal para la cirug&iacute;a </div>"; 
                    $error++;
               }
               
               if($error==0)
               {
                   ##modificar en servicios solo si se modifica elprecio
                    $success=0;
                   $arrS=$objServicioC->BuscarServicio($id_servicio, "", $p_precio_cirugia);
                   if(count($arrS)==0)
                   {
                       $affected=$objServicioC->ModificarServicio($id_servicio, 2, $p_precio_cirugia);
                       if($affected==0)
                       {
                           $msg="<div class='alert alert-danger alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "Error! No se pudieron modificar el precio de la cirug&iacute;a </div>"; 
                       }
                       else {$success++;}
                   }
                   
                   ##modificar en paciente servicio solo si se modifica la fecha
                   $arrPS=$objPacienteServC->BuscarPacienteServicio("", "", $id_servicio,$p_fecha_cirugia);
                   if(count($arrPS)==0)
                   {
                       $affected=$objPacienteServC->ModificarFechaporIdServicio($id_servicio, $p_fecha_cirugia);
                       
                       if($affected==0)
                       {
                           $msg="<div class='alert alert-danger alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "Error! No se pudieron modificar la fecha de la cirug&iacute;a </div>"; 
                       }
                       else {$success++;}
                   }
                   
                   ##modificar en cirugia solo si se modifica la duracion y la especialidad y el nombre de la cirugia
                   $arrCirugia=$objCirugiaC->BuscarCirugia($id_cirugia, $p_idespecialidad_quirurgica, $p_id_cirugia,$id_servicio);
                   if(count($arrCirugia)==0)
                   {
                       $affected=$objCirugiaC->ModificarCirugia($id_cirugia, $p_idespecialidad_quirurgica, $p_id_cirugia, $p_duracion_cirugia, $p_precio_cirugia);
                      
                       if($affected==0)
                       {
                           $msg="<div class='alert alert-danger alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "Error! No se pudieron modificar los campos duracion, especialidad y nombre cirugia </div>"; 
                       }
                       else {$success++;}
                   }
                   
                   ##modificar en medico cirugia solo si se modifica el medico encargado 
                   $arrMedCir=$objMedicoCC->BuscarMedicoCirugia("", $p_id_cirujano, $id_cirugia,1);
                   
                   if(count($arrMedCir)==0)
                   {
                       $affected=$objMedicoCC->ModificarCirujanoPrincipal($p_id_cirujano, $id_cirugia);
                       if($affected==0)
                       {
                           $msg="<div class='alert alert-danger alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "Error! No se pudieron modificar los datos del cirujano principal</div>"; 
                       }
                       else {$success++;}
                   }
                   
                   ##ver si todos los datos se modificaron
                   if($success>0 && $msg=="")
                   {
                        $msg="<div class='alert alert-success alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "OK! Los datos fueron modificados correctamente..</div>"; 
                        $_SESSION['msg']=$msg;
                        echo "<script>";
                            echo "window.location ='mostrarpaciente.php?nik=$idpaciente'";
                       echo "</script>";
                        
                   }
                   
                   if($success==0 && $msg=="")
                   {
                       $msg="<div class='alert alert-warning alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "No hay nada que modificar</div>"; 
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
            <?php if($msg!=""){echo $msg;}?>
            <form name='cirugia' method="post" action="editar_datoscirugia.php" id='cirugia_form'>
              <div class="<?php echo $mostrar_cirugia;?>" id="cirugia">
              <br>
              <h3 class="text-left"><i class="fa fa-plus-square text-info"> Nueva Cirugía</i></h3>
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Especialidad Quirúrgica</th>
                      <th> Nombre de la Cirugía</th>
                      <th> Cirujano Principal</th>
                      
                  </tr>
                  <tr >
                      <td>
                          <input type="hidden" name="act_select_hidden" id="cirugia_hidden" value="0">
                          <input type="hidden" name="servicios"  value="<?php echo $id_servicio;?>">
                          <input type="hidden" name="id_paciente_buscar"  value="<?php echo $idpaciente;?>">
                          <input type="hidden" name="id_cirugia"  value="<?php echo $id_cirugia;?>">
                          <select name="especialidadquirurgica" class="form-control" onchange="SubmitCirugia();">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_especialidades); $i++) 
                            {
                               $id_especialidad=$lista_especialidades[$i]->getIdEspecialidad();
                               $nombre=$lista_especialidades[$i]->getNombreespecialidad();
                               $marcar="";
                               if($id_especialidad==$p_idespecialidad_quirurgica){$marcar="selected='selected'";}
                               echo "<option value='$id_especialidad' $marcar >$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td>
                          <select name="nombrecirugia" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_nombrec); $i++) 
                            {
                               $id_cirugia=$lista_nombrec[$i]->getIdNombreCirugia();
                               $nombre=$lista_nombrec[$i]->getNombreCirugia();
                               $marcar="";
                               if($id_cirugia==$p_id_cirugia){$marcar="selected='selected'";}
                               echo "<option value='$id_cirugia' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td>
                          <select name="medicos" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_medicos); $i++) 
                            {
                               $id_medico=$lista_medicos[$i]->getIdMedico();
                               $nombre=$lista_medicos[$i]->getNombre();
                               $marcar="";
                               if($id_medico==$p_id_cirujano){$marcar="selected='selected'";}
                               echo "<option value='$id_medico' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      
                  </tr>
                  <tr class="text text-info">
                      <th>Duración</th>
                      
                      <th >Precio</th>
                      <th>Fecha</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="duracion" class="form-control" value="<?php echo $p_duracion_cirugia;?>"></td>
                      
                      <td ><input type="text" name="precio" class="form-control" value="<?php echo $p_precio_cirugia;?>"></td>
                      <td><input type="date" name="fecha" class="form-control" required="" value="<?php echo $p_fecha_cirugia;?>"></td>
                  </tr>
                 
              </table>
              
              
              
              <div class="text-right col-md-12">
                  <button  type="submit" class="btn btn-success">Modificar</button>
                  <a href='mostrarpaciente.php?nik=<?php echo $idpaciente;?>' class="btn btn-danger" >Cancelar</a>
              </div>
              
             </div>
            <br><br><br>
        </form>
          
        </div>
    </div>
</section>



