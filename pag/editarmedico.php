<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/MedicoController.php';
include '../modelo/EspecialidadController.php';

$msg="";
$objMedico=new MedicoController();
$objEspecialidad= new EspecialidadController();
$lista_especialidades=$objEspecialidad->MostrarEspecialidad();

if(isset($_REQUEST['nik']))
    {
    $id_medmod=$_REQUEST['nik'];
    $medmod=$objMedico->BuscarMedico($id_medmod, "", "");
    }
if(isset($_POST['id_trabmod']))
    {
    $id_medmod=$_POST['id_medmod'];
    } 

##variables
$nombre_medico="";
$docID="";
$nrocolegiomedico="";
$fecha_nac="";
if(isset($medmod))
{
    $sexo=$medmod[0]->getSexo();
    $idespecialidad=$medmod[0]->getEspecialidad();
}
else
{
    $sexo="";
    $idespecialidad="";
}
$telefono="";
$email="";
$direccion="";

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_medmod'])){$id_medmod= eliminarblancos($_POST['id_medmod']);}
    if(isset($_POST['nombre_medico'])){$nombre_medico= eliminarblancos($_POST['nombre_medico']);}
    if(isset($_POST['docID'])){$docID=eliminarblancos($_POST['docID']);}
    if(isset($_POST['nrocolegiomedico'])){$nrocolegiomedico=eliminarblancos($_POST['nrocolegiomedico']);}
    if(isset($_POST['fecha_nac'])){$fecha_nac=eliminarblancos($_POST['fecha_nac']);}
    if(isset($_POST['sexo'])){$sexo=eliminarblancos($_POST['sexo']);}
    if(isset($_POST['telefono'])){$telefono=eliminarblancos($_POST['telefono']);}
    if(isset($_POST['email'])){$email=eliminarblancos($_POST['email']);}
    if(isset($_POST['direccion'])){$direccion=eliminarblancos($_POST['direccion']);}
    if(isset($_POST['idespecialidad'])){$idespecialidad=eliminarblancos($_POST['idespecialidad']);}
        
    $error=0;
    ##validar
    
    if($nombre_medico=="" || $docID=="" || $nrocolegiomedico=="" || $fecha_nac=="" || $telefono=="" || $direccion=="" || $idespecialidad=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
        $error++;
    }
    else
    {
        if(isNaN($telefono))
        {
           $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! El campo tel&eacute;fono solo admite n&uacute;meros</div>"; 
           $error++;
        }
           
        if($error==0)
        {
            $affected=$objMedico->ModificarMedico($id_medmod, $nrocolegiomedico, $nombre_medico, $docID, $fecha_nac, $sexo, $telefono, $email, $direccion, $idespecialidad);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                echo "window.location = 'listar_medicos.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Actualizacion de datos fallida</div>"; 
            }
        }
        
    }
    
}
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user-md"> Editar Médico</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_medico" method="post" action="editarmedico.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> Doc.Identidad</th>
                      <th> Num. Colegio Médico</th>
                  </tr>
                  <tr >
                      <input type="hidden" name="id_medmod" value="<?php echo $id_medmod; ?>">
                      <td><input type="text" name="nombre_medico" class="form-control" required="" value="<?php echo $medmod[0]->getNombre();?>"></td>
                      <td><input type="text" name="docID" class="form-control" required="" value="<?php echo $medmod[0]->getDocID();?>"></td>
                      <td><input type="text" name="nrocolegiomedico" class="form-control" value="<?php echo $medmod[0]->getNroColegioMed();?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th >Fecha Nac.</th>
                      <th>Sexo</th>
                      <th>Teléfono</th>
                  </tr>
                  <tr>
                      <td><input type="date" name="fecha_nac" class="form-control" value="<?php echo $medmod[0]->getFechaNac();?>"></td>
                      <td>
                          <select name="sexo" class="form-control">
                              <?php 
                              $selectedf="";
                              $selectedm="";
                              
                                    if($sexo=="F"){$selectedf="selected='selected'";}
                                    else {$selectedm="selected='selected'";}
                              ?>
                              <option value='F' <?php echo $selectedf;?> >F</option>
                              <option value='M' <?php echo $selectedm;?>>M</option>
                          </select>
                      </td>
                      <td><input type="text" name='telefono' class="form-control" value="<?php echo $medmod[0]->getTelef();?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Email</th>
                      <th >Direcci&oacute;n</th>
                      <th>Especialidad</th>
                  </tr>
                  <tr>
                      <td><input type="email" name="email" class="form-control" value="<?php echo $medmod[0]->getEmail();?>"></td>
                      <td >
                          <textarea class="form-control" name="direccion"><?php echo $medmod[0]->getDireccion();?></textarea>
                      </td>
                      <td>
                          <select name="idespecialidad" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php 
                            for ($i = 0; $i < count($lista_especialidades); $i++) 
                            {
                               $id_especialidad=$lista_especialidades[$i]->getIdEspecialidad();
                               $nombreespecialidad=$lista_especialidades[$i]->getNombreespecialidad();
                               $marcar="";
                               if($id_especialidad==$idespecialidad){$marcar="selected='selected'";}
                               echo "<option value='$id_especialidad' $marcar>$nombreespecialidad</option>";
                            }
                              ?>
                          </select>
                      </td>
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Actualizar</button>
                  <a href='listar_medicos.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>


