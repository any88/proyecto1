<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/AseguradoraController.php';
include '../modelo/PacienteController.php';

$msg="";
$objAseguradora=new AseguradoraController();
$lista_aseguradoras=$objAseguradora->MostrarAseguradora();
$objPaciente=new PacienteController();
$pacmod=array();
$id_pacmod="";
   
##variables
$nombre="";
$docID="";
$hc="";
$fecha_nac="";
$sexo="";
$aseguradora="";
$telefono="";
$ocupacion="";
$email="";
$direccion="";
$anamnesis="";
$tiempo_enfermedad="";
$id_aseguradora="";
$idclienteaseguradora="";
$gruposanguineo="";
$alergiamed="";

if(isset($_GET['nik']))
{
$id_pacmod=$_GET['nik'];
$pacmod=$objPaciente->BuscarPaciente("", "", "", $id_pacmod);

    if(count($pacmod)>0)
    {
        $nombre=$pacmod[0]->getNombre();
        $docID=$pacmod[0]->getDocID();
        $hc=$pacmod[0]->getNumeroHC();
        $sexo=$pacmod[0]->getSexo();
        $telefono=$pacmod[0]->getTelef();
        $email=$pacmod[0]->getEmail();
        $direccion=$pacmod[0]->getDireccion();
        $id_aseguradora=$pacmod[0]->getIdAseguradora();
        $ocupacion=$pacmod[0]->getOcupacion();
        $fecha_nac=$pacmod[0]->getFechaNac();
        $anamnesis=$pacmod[0]->getAnamnesis();
        $tiempo_enfermedad=$pacmod[0]->getTiempoDeEnfermedad();
        $idclienteaseguradora=$pacmod[0]->getIdClienteAseguradora();
        $gruposanguineo=$pacmod[0]->getGrupoSanguineo();
        $alergiamed=$pacmod[0]->getAlergiaMed();
        
    }
}
if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_pacmod'])){$id_pacmod= eliminarblancos($_POST['id_pacmod']);}
    if(isset($_POST['nombre'])){$nombre= eliminarblancos($_POST['nombre']);}
    if(isset($_POST['docID'])){$docID=eliminarblancos($_POST['docID']);}
    if(isset($_POST['hc'])){$hc=eliminarblancos($_POST['hc']);}
    if(isset($_POST['fecha_nac'])){$fecha_nac=eliminarblancos($_POST['fecha_nac']);}
    if(isset($_POST['sexo'])){$sexo=eliminarblancos($_POST['sexo']);}
    if(isset($_POST['telefono'])){$telefono=eliminarblancos($_POST['telefono']);}
    if(isset($_POST['email'])){$email=eliminarblancos($_POST['email']);}
    if(isset($_POST['direccion'])){$direccion=eliminarblancos($_POST['direccion']);}
    if(isset($_POST['ocupacion'])){$ocupacion=eliminarblancos($_POST['ocupacion']);}
    if(isset($_POST['anamnesis'])){$anamnesis=eliminarblancos($_POST['anamnesis']);}
    if(isset($_POST['tiempo_enfermedad'])){$tiempo_enfermedad=eliminarblancos($_POST['tiempo_enfermedad']);}
    if(isset($_POST['id_aseguradora'])){$id_aseguradora=eliminarblancos($_POST['id_aseguradora']);}
    if(isset($_POST['idclienteaseguradora'])){$idclienteaseguradora=eliminarblancos($_POST['idclienteaseguradora']);}
    if(isset($_POST['gruposanguineo'])){$gruposanguineo=eliminarblancos($_POST['gruposanguineo']);}
    if(isset($_POST['alergiamed'])){$alergiamed=eliminarblancos($_POST['alergiamed']);}
    
    $error=0;
    ##validar
    
    if($nombre=="" || $docID=="" || $telefono=="" || $fecha_nac=="" || $hc=="" || $direccion=="" || $gruposanguineo=="")
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
        ##buscar todos los datos del paciente y verifica si el numero de identidad e hc son distintos que no exista otro paciente
        #que tenga el mismo numero
        $datos_paciente=$objPaciente->BuscarPaciente("", "", "", $id_pacmod);
        if(count($datos_paciente)>0)
        {
            if($hc!=$datos_paciente[0]->getNumeroHC())
            {
                ##validar que el numero de historia clinica no se repita
                $list_pac=$objPaciente->BuscarPaciente($hc, "", "", "");
                if(count($list_pac)>0)
                {
                    $msg="<div class='alert alert-danger alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "Error! Ya existe un paciente registrado con ese n&uacute;mero de historia clinica $hc</div>"; 
                    $error++;

                }
            }
            if($docID!=$datos_paciente[0]->getDocID())
            {
                    $list_p=$objPaciente->BuscarPaciente('', '', $docID, '');
                    if(count($list_p)>0)
                    {
                        $msg="<div class='alert alert-danger alert-dismissable'>"
                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                            . "Error! Ya existe un paciente registrado con documento de identidad igual a $docID</div>"; 
                        $error++;

                    }
            }
        }
        else
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! EL paciente ha ya no se encuentra disponible para realizar esta operaci&oacute;n. Verifique que no este eliminado.</div>"; 
           $error++;
        }
            
        if($error==0)
        {
            $affected=$objPaciente->ModificarPaciente($id_pacmod, $nombre, $hc, $docID, $fecha_nac, $sexo, $telefono, $ocupacion, $direccion, $anamnesis, $tiempo_enfermedad, $id_aseguradora, $email, $idclienteaseguradora, $gruposanguineo, $alergiamed);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                echo "window.location = 'listar_pacientes.php';";
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
//Mostrar($pacmod);
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user text-info"> Editar Paciente</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_paciente" method="post" action="editarpaciente.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> Doc.Identidad</th>
                      <th> Num. HC</th>
                  </tr>
                  <tr 
                      <td><input type="hidden" name="id_pacmod" value="<?php echo $id_pacmod; ?>"</td>
                      <td><input type="text" name="nombre" class="form-control" required="" value="<?php echo $nombre;?>"></td>
                      <td><input type="text" name="docID" class="form-control" required="" value="<?php echo $docID;?>"></td>
                      <td><input type="text" name="hc" class="form-control" value="<?php echo $hc;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Fecha Nacimiento</th>
                      <th>Sexo</th>
                      <th>Teléfono</th>
                  </tr>
                  <tr>
                      <td><input type="date" name="fecha_nac" class="form-control" value='<?php echo $fecha_nac;?>'></td>
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
                      <td><input type="text" name='telefono' class="form-control" value='<?php echo $telefono;?>'></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Ocupaci&oacute;n</th>
                      <th >Email</th>
                      <th>Direcci&oacute;n</th>   
                  </tr>
                  <tr>
                      <td><input type="text" name="ocupacion" class="form-control" value='<?php echo $ocupacion;?>'></td>
                      <td><input type="email" name="email" class="form-control" value='<?php echo $email;?>'></td>
                      <td >
                          <textarea class="form-control" name="direccion"><?php echo $direccion;?></textarea>
                      </td>
                  </tr>
                  <tr class="text text-info">
                      <th>Aseguradora</th>
                      <th>ID de Cliente en Aseguradora</th>
                      <th>Grupo Sanguíneo</th>
                  </tr>
                  <tr>
                      <td>
                          <select name="id_aseguradora" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                              
                            for ($i = 0; $i < count($lista_aseguradoras); $i++) 
                            {
                               $id_a=$lista_aseguradoras[$i]->getIdAseguradora();
                               $nombrea=$lista_aseguradoras[$i]->getNombre();
                               $marcar="";
                               if($id_a==$id_aseguradora){$marcar="selected='selected'";}
                               echo "<option value='$id_a' $marcar>$nombrea</option>";
                            }
                              ?>
                          </select>    
                      </td>
                      <td><input type="text" name="idclienteaseguradora" class="form-control" value='<?php echo $idclienteaseguradora;?>'></td>
                      <td><input type="text" name="gruposanguineo" class="form-control" value='<?php echo $gruposanguineo;?>'></td>                   
                  </tr>
                  <tr class="text text-info">
                      <th>Anamnesis</th>
                      <th>Tiempo Enfermedad</th>
                      <th>Alergia Medicamentosa</th>
                  </tr>
                  <tr>
                      <td><textarea class="form-control" name="anamnesis"><?php echo $anamnesis;?></textarea></td>
                      <td><input type="number" name="tiempo_enfermedad" class="form-control" value='<?php echo $tiempo_enfermedad;?>'></td>
                      <td><input type="text" name="alergiamed" class="form-control" value='<?php echo $alergiamed;?>'></td>                     
                  </tr>                  
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Actualizar</button>
                  <a href='listar_pacientes.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>
