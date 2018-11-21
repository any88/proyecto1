<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/AseguradoraController.php';
include '../modelo/PacienteController.php';

$objAseguradora=new AseguradoraController();
$lista_aseguradoras=$objAseguradora->MostrarAseguradora();
$msg="";
$objPaciente=new PacienteController();

##variables
$nombre_paciente="";
$docID="";
$hc="";
$fecha_nac="";
$sexo="";
$telefono="";
$ocupacion="";
$aseguradora="";
$direccion="";
$anamnesis="";
$tiempo_enfermedad="";
$email="";
$idclienteaseguradora="";
$gruposanguineo="";
$alergiamed="";

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['nombre_paciente'])){$nombre_paciente= eliminarblancos($_POST['nombre_paciente']);}
    if(isset($_POST['docID'])){$docID=eliminarblancos($_POST['docID']);}
    if(isset($_POST['hc'])){$hc=eliminarblancos($_POST['hc']);}
    if(isset($_POST['fecha_nac'])){$fecha_nac=eliminarblancos($_POST['fecha_nac']);}
    if(isset($_POST['sexo'])){$sexo=eliminarblancos($_POST['sexo']);}
    if(isset($_POST['telefono'])){$telefono=eliminarblancos($_POST['telefono']);}
    if(isset($_POST['ocupacion'])){$ocupacion=eliminarblancos($_POST['ocupacion']);}
    if(isset($_POST['aseguradora'])){$aseguradora=eliminarblancos($_POST['aseguradora']);}
    if(isset($_POST['direccion'])){$direccion=eliminarblancos($_POST['direccion']);}
    if(isset($_POST['anamnesis'])){$anamnesis=eliminarblancos($_POST['anamnesis']);}
    if(isset($_POST['tiempo_enfermedad'])){$tiempo_enfermedad=eliminarblancos($_POST['tiempo_enfermedad']);}
    if(isset($_POST['email'])){$email=eliminarblancos($_POST['email']);}
    if(isset($_POST['idclienteaseguradora'])){$idclienteaseguradora=eliminarblancos($_POST['idclienteaseguradora']);}
    if(isset($_POST['gruposanguineo'])){$gruposanguineo=eliminarblancos($_POST['gruposanguineo']);}
    if(isset($_POST['alergiamed'])){$alergiamed=eliminarblancos($_POST['alergiamed']);}
    
    $error=0;
    ##validar
    if($nombre_paciente=="" || $docID=="" || $hc=="" || $fecha_nac=="" || $ocupacion=="" || $direccion=="" || $gruposanguineo=="" || $aseguradora=="")
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
        
        ##validar que el paciente no exista en la base de datos
        
        $list_p=$objPaciente->BuscarPaciente('', '', $docID, '');
        if(count($list_p)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe un paciente registrado con documento de identidad igual a $docID</div>"; 
            $error++;
            
        }
        ##validar que el numero de historia clinica no se repita
        $list_pac=$objPaciente->BuscarPaciente($hc, "", "", "");
        if(count($list_pac)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe un paciente registrado con ese n&uacute;mero de historia clinica $hc</div>"; 
            $error++;
            
        }
        
        
        if($error==0)
        {
            $sd= new PacienteController();
            $affected=$objPaciente->CrearPaciente($nombre_paciente, $hc, $docID, $fecha_nac, $sexo, $telefono, $ocupacion, $direccion, $anamnesis, $tiempo_enfermedad, $aseguradora, $email, $idclienteaseguradora, $gruposanguineo, $alergiamed);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Paciente registrado satisfactoriamente</div>"; 
                 echo "<script>";
                echo "window.location = 'listar_pacientes.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo Insertar el Paciente</div>"; 
            }
        }
        
    }
    
}
?>

<br>
<section class="about-text">
    <div class="container ">
      <?php 
             echo $msg;
      ?>  
        <form name="nuevo_paciente" method="post" action="crearpaciente.php">
              <div class="col-md-12" style=" border-style: solid; border-width: 1px;">
              <div class="text-center">
                  <h3 ><i class="fa fa-pagelines text-info"> Historia Clinica Nro.<input type="text" name="hc" class="form-control" value="<?php echo $hc;?>" placeholder="Nro. historia Clinica"> </i></h3>
              </div>
              
             
              <fieldset class="scheduler-border">
                  <legend class="scheduler-border">Datos Generales del Paciente</legend>
                  <table class="table table-responsive">
                  <tr >
                      <th> Nombre</th>
                      <th> Doc.Identidad</th>
                      <th> Fecha Nac.</th>
                  </tr>
                  <tr >
                      <td><input type="text" name="nombre_paciente" placeholder="Nombre(s) Apellido1 Apellido2" class="form-control" required="" value="<?php echo $nombre_paciente;?>"></td>
                      <td><input type="text" name="docID" class="form-control" required="" value="<?php echo $docID;?>"></td>
                      <td><input type="date" name="fecha_nac" class="form-control" value="<?php echo $fecha_nac;?>"></td>
                  </tr>
                  <tr >
                      <th  colspan="2">Ocupaci&oacute;n</th>
                      <th>Sexo</th>
                      
                  </tr>
                  <tr>
                      <td colspan="2"><input type="text" name='ocupacion' class="form-control" required="" value='<?php echo $ocupacion;?>'></td>
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
                      
                  </tr>
                  </table>
              </fieldset>
              <fieldset class="scheduler-border">
                  <legend class="scheduler-border">Datos de Contacto</legend>
                  <table class="table table-responsive">
                    <tr>
                        <th>Teléfono</th>
                        <th>Email</th>
                        
                    </tr>
                    <tr>
                        <td><input type="text" name='telefono' class="form-control" value='<?php echo $telefono;?>'></td>
                        <td><input type="email" name="email" class="form-control" value='<?php echo $email;?>'></td>
                        

                    </tr>
                    <tr >
                        <th colspan="2" >Direcci&oacute;n</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <textarea class="form-control" name="direccion"><?php echo $direccion;?></textarea>
                        </td>
                    </tr>
                  </table>
              </fieldset>
              
              <fieldset class="scheduler-border">
                  <legend class="scheduler-border">Datos de Aseguradora</legend>
                  <table class="table table-responsive">
                  <tr >
                      <th>Aseguradora</th>
                      <th>ID de Cliente en Aseguradora</th>
                      
                  </tr>
                  <tr>
                      <td>
                          <select name="aseguradora" class='form-control selectpicker' data-live-search='true'>
                              <option value=''>--SELECCIONE--</option>
                              <?php 
                            for ($i = 0; $i < count($lista_aseguradoras); $i++) 
                            {
                               $id_aseguradora=$lista_aseguradoras[$i]->getIdAseguradora();
                               $nombre=$lista_aseguradoras[$i]->getNombre();
                               $marcar="";
                               if($id_aseguradora==$aseguradora){$marcar="selected='selected'";}
                               echo "<option value='$id_aseguradora' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td><input type="text" name="idclienteaseguradora" class="form-control" value="<?php echo $idclienteaseguradora;?>"></td>
                      
                                            
                  </tr>
                  </table>
              </fieldset>
              
              <fieldset class="scheduler-border">
                  <legend class="scheduler-border">Datos M&eacute;dicos</legend>
                  <table class="table table-responsive">
                  <tr >
                      <th>Tiempo Enfermedad</th>
                      
                      <th>Grupo Sanguíneo</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="tiempo_enfermedad" class="form-control" value="<?php echo $tiempo_enfermedad;?>"></td>
                      
                      <td><input type="text" name="gruposanguineo" class="form-control" value="<?php echo $gruposanguineo;?>"></td>
                      
                  </tr>
                  <tr >
                      <th colspan="2">Alergia Medicamentosa</th>
                  </tr>
                  <tr>
                      <td colspan="2">
                          <textarea class="form-control" name="alergiamed" ><?php echo $alergiamed;?></textarea>
                      </td>
                  </tr>
                  
                  <tr>
                      <th  colspan="2">Anamnesis</th>
                  </tr>
                  <tr>
                      <td colspan="2">
                          <textarea class="form-control" name="anamnesis" ><?php echo $anamnesis;?></textarea>
                      </td>
                  </tr>
                  
              </table>
              </fieldset>
             </div> 
              <br>
              <div class="text-right">
                  <button class="btn btn-primary" type="submit"> <i class=" fa fa-save"></i> Registrar</button>
                  <a href='listar_pacientes.php' class="btn btn-primary" type="submit"><i class=" fa fa-retweet"></i> Cancelar</a>
              </div>
              <br><br>
          </form>
        
    </div>
</section>

<?php 
    include './footer.html';
?>