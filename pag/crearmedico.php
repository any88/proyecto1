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

##variables
$nombre_medico="";
$docID="";
$nrocolegiomedico="";
$fecha_nac="";
$sexo="";
$telefono="";
$email="";
$direccion="";
$idespecialidad="";
if($_POST)
{
    //Mostrar($_POST);
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
        
        ##validar que el medico no exista en la base de datos
        
        $list_p=$objMedico->BuscarMedico('', '', $docID);
        if(count($list_p)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe un médico registrado con documento de identidad igual: $docID</div>"; 
            $error++;
            
        }
        
        
        if($error==0)
        {
            $affected=$objMedico->CrearMedico($nrocolegiomedico, $nombre_medico, $docID, $fecha_nac, $sexo, $telefono, $email, $direccion, $idespecialidad);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Médico registrado satisfactoriamente</div>"; 
                 echo "<script>";
                echo "window.location = 'listar_medicos.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo Insertar el Médico</div>"; 
            }
        }
        
    }
    
}
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user-md"> Nuevo Médico</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="nuevo_medico" method="post" action="CrearMedico.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> Doc.Identidad</th>
                      <th> Num. Colegio Médico</th>
                  </tr>
                  <tr >
                      <td><input type="text" name="nombre_medico" placeholder="Nombre(s) Apellido1 Apellido2" class="form-control" required="" value="<?php echo $nombre_medico;?>"></td>
                      <td><input type="text" name="docID" class="form-control" required="" value="<?php echo $docID;?>"></td>
                      <td><input type="text" name="nrocolegiomedico" class="form-control" value="<?php echo $nrocolegiomedico;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th >Fecha Nac.</th>
                      <th>Sexo</th>
                      <th>Teléfono</th>
                  </tr>
                  <tr>
                      <td><input type="date" name="fecha_nac" class="form-control" value="<?php echo $fecha_nac;?>"></td>
                      <td>
                          <select name="sexo" class="form-control">
                              <?php 
                              $selectedf="";
                              $selectedm="";
                              
                                    if($sexo=="F"){$selectedf="selected='selected'";}
                                    else {$selectedm="selected='selected'";}
                              ?>
                              <option value='F' <?php echo $selectedf;?> >F</option>
                              <option value='M' <?php echo $selectedf;?>>M</option>
                          </select>
                      </td>
                      <td><input type="text" name='telefono' class="form-control" value='<?php echo $telefono;?>'></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Email</th>
                      <th >Direcci&oacute;n</th>
                      <th>Especialidad</th>
                  </tr>
                  <tr>
                      <td><input type="email" name="email" class="form-control" value='<?php echo $email;?>'></td>
                      <td >
                          <textarea class="form-control" name="direccion"><?php echo $direccion;?></textarea>
                      </td>
                      <td>
                          <select name="idespecialidad" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php 
                            for ($i = 0; $i < count($lista_especialidades); $i++) 
                            {
                               $id_especialidad=$lista_especialidades[$i]->getIdEspecialidad();
                               $nombre=$lista_especialidades[$i]->getNombreespecialidad();
                               $marcar="";
                               if($id_especialidad==$idespecialidad){$marcar="selected='selected'";}
                               echo "<option value='$id_especialidad' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Registrar</button>
                  <a href='listar_medicos.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>

