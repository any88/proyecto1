<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/consultas_genericas.php';
include '../modelo/PacienteController.php';
include '../modelo/MedicoController.php';
include '../modelo/TrabajadorController.php';
include '../modelo/ServicioController.php';
include '../modelo/CirugiaController.php';
include '../modelo/InsumoController.php';
include '../modelo/PacienteServicioController.php';
include '../modelo/EspecialidadController.php';
include '../modelo/NombreCirugiaController.php';
include '../modelo/MedicoCirugiaController.php';
include '../modelo/InsumoCirugiaController.php';

$objPaciente=new PacienteController();
$objMedico= new MedicoController();
$objTrabajador= new TrabajadorController();
$objServicio= new ServicioController();
$objCirugia=new CirugiaController();
$objInsumo=new InsumoController();
$objPacienteServ= new PacienteServicioController();
$objEspecialidad= new EspecialidadController();
$objNombreCirugia= new NombreCirugiaController();
$objMedicoCirugia= new MedicoCirugiaController();
$objInsumoCirugia= new InsumoCirugiaController();

$msg="";
$error=0;
$lista_insumos_cirugia=array();
$lista_insumos_almacen=$objInsumo->MostrarInsumo();

$cant_insumos="";
$id_cirugia="";
$insumos="";
$id_insumo_cirugia="";
$act_select_hidden="";
if($_GET)
{
   $id_cirugia=$_GET['nik'];
   $lista_insumos_cirugia=$objInsumoCirugia->BuscarInsumoCirugia("", "", $id_cirugia);   
}
if($_POST)
{
    if(isset($_POST['id_cirugia'])){$id_cirugia=$_POST['id_cirugia'];}
    if(isset($_POST['act_select_hidden'])) {$act_select_hidden=$_POST['act_select_hidden'];}
    
    if($act_select_hidden==0)
    {
        if(isset($_POST['id_insumo_cirugia'])){$id_insumo_cirugia=$_POST['id_insumo_cirugia'];}
        #Eliminar
        
        $arrInsCir=$objInsumoCirugia->BuscarInsumoCirugia($id_insumo_cirugia, "", "");
        if(count($arrInsCir)==0)
        {
            $error++;
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error!El insumo que desea eliminar ya no existe. Revise que no halla sido borrado por otro usuario de la aplicaci&oacute;n.</div>"; 
        }
        else
        {
            $affected=$objInsumoCirugia->EliminarInsumoCirugia($id_insumo_cirugia);
            if($affected==0)
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo eliminar el insumo.</div>"; 
            }
            if($affected==1)
           {
                $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "OK! Insumo eliminado correctamente.</div>"; 
           }
        }
        
    }
    if($act_select_hidden==1)
    {
        #Crear
        
        if(isset($_POST['cant_insumos'])){$cant_insumos=$_POST['cant_insumos'];}
        if(isset($_POST['insumos'])){$insumos=$_POST['insumos'];}
        
        if(isNaN($cant_insumos))
        {
            $error++;
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error!La cantidad introducida debe de ser un n&uacute;mero.</div>"; 
        }
        if(eliminarblancos($cant_insumos==""))
        {
            $error++;
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error!El campo cantidad de insumos no puede estar vac&iacute;o.</div>"; 
        }
        if($error==0)
        {
            $affected=$objInsumoCirugia->CrearInsumoCirugia($insumos, $id_cirugia, $cant_insumos);
            if($affected==0)
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error!No se pudo aagregar el insumo a la cirug&iacute;.</div>"; 
            }
            if($affected==1)
            {
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "OK!Insumo agregado correctamente.</div>"; 
            }
        }
    }
    if($act_select_hidden==2)
    {
       
        if(isset($_POST['cant_insumos'])){$cant_insumos=$_POST['cant_insumos'];}
        if(isset($_POST['insumos'])){$insumos=$_POST['insumos'];}
        if(isset($_POST['id_insumo_cirugia'])){$id_insumo_cirugia=$_POST['id_insumo_cirugia'];}
        if(isNaN($cant_insumos))
        {
            $error++;
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error!La cantidad introducida debe de ser un n&uacute;mero.</div>"; 
        }
        if(eliminarblancos($cant_insumos==""))
        {
            $error++;
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error!El campo cantidad de insumos no puede estar vac&iacute;o.</div>"; 
        }
        $arrInsCir=$objInsumoCirugia->BuscarInsumoCirugia($id_insumo_cirugia, "", "");
        if(count($arrInsCir)==0)
        {
            $error++;
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error!El insumo que desea modificar ya no existe. Revise que no halla sido borrado por otro usuario de la aplicaci&oacute;n.</div>"; 
        }
        else
        {
            $cant_insumosbd=$arrInsCir[0]->getCantidadinsumo();
            if($cant_insumos==$cant_insumosbd)
            {
                $error++;
                $msg="<div class='alert alert-warning alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "No hay nada que modificar los datos son los mismos.</div>"; 
            }
        }
        
        if($error==0)
        {
            $affected=$objInsumoCirugia->ModificarInsumoCirugia($id_insumo_cirugia, $insumos, $id_cirugia, $cant_insumos) ;
            if($affected==0)
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
               . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
               . "Error!No se pudieron modificar los datos.</div>"; 
            }
            if($affected==1)
             {
                $msg="<div class='alert alert-success alert-dismissable'>"
               . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
               . "OK! los datos fueron modificados correctamente.</div>"; 
             }
        }
    }
}
 $lista_insumos_cirugia=$objInsumoCirugia->BuscarInsumoCirugia("", "", $id_cirugia);   
 ?>
<br><br>
<section class="about-text">
    <div class="container ">
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user text-info"> Listado de Insumos de la cirugia</i></h3>
          <?php 
              if($msg!=""){echo $msg;}
          ?>
          <table class="table table-responsive table-hover table-bordered">
               <tr>
                    <th colspan="4" >
                        <label class="text-primary">Insumos</label>
                        <div class="text-right">
                        <button type='button' class='btn btn-primary btn-xs' title='Adicionar Insumos' data-toggle='modal' ddata-toggle="modal" data-target="#divModal" style="margin-top: -45px;"><i class='fa fa-user-md'></i> Adicionar Insumos</button>
                        </div>
                  </th>
                  </tr>
              <tr>
                  <th>Nro.</th>
                  <th>Insumo</th>
                  <th>Cantidad Suministrada</th>
                  <th>Acci&oacute;n</th>
              </tr>
              <?php 
               for ($i = 0; $i < count($lista_insumos_cirugia); $i++) 
               {
                   $nro=$i+1;
                   $id_insumo_cirugia=$lista_insumos_cirugia[$i]->getIdic();
                   $id_insumo=$lista_insumos_cirugia[$i]->getIdinsumo();
                   $cantidad=$lista_insumos_cirugia[$i]->getCantidadinsumo();
                   $nombre_insumo="";
                   $arrInsumos=$objInsumo->BuscarInsumo($id_insumo, "", "");
                   if(count($arrInsumos)>0){$nombre_insumo=$arrInsumos[0]->getNombre();}
                   echo "<form name='fi$i' method='post' id='formuladioInsumos$i'>";
                   echo "<input type='hidden' name='act_select_hidden' value='0' id='act_hiddenMIns$i'>";
                   echo "<input type='hidden' name='id_cirugia'  value='$id_cirugia'>";
                   echo "<input type='hidden' name='insumos'  value='$id_insumo'>";
                   echo "<input type='hidden' name='id_insumo_cirugia'  value='$id_insumo_cirugia'>";
                   echo "<tr>";
                   echo "<td>$nro</td>";
                   echo "<td>$nombre_insumo</td>";
                   echo "<td><input type='text' name='cant_insumos'  value='$cantidad' class='form-control' readonly='true' id='cantInsumo$i'></td>";
                   echo "<td>"
                   . "<button type='button' class='btn btn-danger' value='$i' onclick='EliminarInsumos(this.value)' title='Eliminar Insumos'><i class='fa fa-trash'></i></button>"
                   . " <button type='button' class='btn btn-warning' id='$i' title='Modificar Cantidad Insumos' onclick='EditarInsumos(this.id);'><i class='fa fa-pencil'></i></button>"
                   . "</td>";
                   echo "</tr>";
                   echo "</form>";
               }
              
              ?>
              
          </table>
          <div class="text-right col-md-12">
                  <a href='mostrar_cirugia.php?nik=<?php echo $id_cirugia;?>' class="btn btn-primary" >Volver</a>
          </div>
        </div>
    </div>
</section>

<div id="divModal" class='modal fade'  tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'> 
    <div class="modal-dialog">
    <form name='f' method="post" action="editar_insumos_cirugia.php" id='form_insumos'>
      <input type="hidden" name="act_select_hidden" value="0" id="act_hiddenMInsumos">
      <input type='hidden' name='id_cirugia'  value='<?php echo $id_cirugia;?>'>
    <div class="modal-content">
        <div class="modal-header" style="background-color: #004731;"> 
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <img src='../img/clinica_logo.png' id="logo" class="pull-left" style="width: 50px; margin-top: -10px;">
            <h4 class="modal-title" id="H1" style="color: white;">Listado de Insumos para la Cirug&iacute;a</h4>
        </div>
        <div class="modal-body ">
                <img src="../img/medicamento.jpg" style="width: 120px;">
                <div style="margin-left: 155px;width: 70%!important; margin-top: -85px;">
                    <label> Selecccione el Insumo</label>
                <select name="insumos" class="form-control selectpicker" id="insumo" data-live-search='true'>
                    <option value=''>--SELECCIONE--</option>
                    <?php 
                  for ($i = 0; $i < count($lista_insumos_almacen); $i++) 
                  {
                     $id_insumo=$lista_insumos_almacen[$i]->getIdInsumo();
                     $nombre=$lista_insumos_almacen[$i]->getNombre();
                     echo "<option value='$id_insumo'>$nombre</option>";
                  }
                    ?>
                </select>
                 <label>Cantidad</label>
                 <input type="text" name="cant_insumos" class="form-control">
            </div>
            
                    
        </div>
        <br>
        <div class="modal-footer">
            <button  type="button" class="btn btn-success" onclick="AgregarInsumos();">Adicionar</button>
            <button class="btn btn-danger " data-dismiss="modal" id="m_em">Cancelar</button>
        </div>
    </div> 
    </form>
    </div>
</div>
