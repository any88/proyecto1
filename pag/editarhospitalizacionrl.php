<?php

// EN DESARROLLO!!! VER COMENTARIOS PARA MAS INFO..

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/HospitalizacionController.php';

$msg="";
$objHospitalizacion=new HospitalizacionController();
$lista_hospitalizacion= $objHospitalizacion->MostrarHospitalizacion();

if(isset($_REQUEST['nik']))
    {
    $id_hospmod=$_REQUEST['nik'];
    $hospmod=$objHospitalizacion->BuscarHospitalizacion($id_hopsmod, "", "");
    }
if(isset($_POST['id_hospmod']))
    {
    $id_hospmod=$_POST['id_hospmod'];
    } 

##variables
$fechaingreso="";
$fechaalta="";
$duracion="";
$tipohab="";
$numcam="";
$estadopaciente="";
$nombrefamiliar="";
$parentescofamiliar="";
$condicionatencion="";
$pa="";
$pulso="";
$temp="";
$peso="";
$examfis="";
$precio="";


if(isset($hospmod))
{
    $fechaingreso=$hospmod[0]->getFechaIngreso();
    $fechaalta=$hospmod[0]->getFechaAlta();
    $duracion=$hospmod[0]->getDuracion();
    $tipohab=$hospmod[0]->getTipoHabitacion();
    $numcam=$hospmod[0]->getNroCama();
    $estadopaciente=$hospmod[0]->getEstadoDelPaciente();
    $nombrefamiliar=$hospmod[0]->getNombreFamiliar();
    $parentescofamiliar=$hospmod[0]->getParentescoFamiliar();
    $condicionatencion=$hospmod[0]->getCondicionDeAtencion();
    $pa=$hospmod[0]->getPA();
    $pulso=$hospmod[0]->getPulso();
    $temp=$hospmod[0]->getPulso();
    $peso=$hospmod[0]->getPeso();
    $examfis=$hospmod[0]->getExamenFisico();
    $precio=$hospmod[0]->getPrecio();
}

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_hospmod'])){$id_hospmod= eliminarblancos($_POST['id_hospmod']);}
    if(isset($_POST['fechaingreso'])){$fechaingreso=eliminarblancos($_POST['fechaingreso']);}
    if(isset($_POST['fechaalta'])){$fechaalta=eliminarblancos($_POST['fechaalta']);}
    if(isset($_POST['duracion'])){$duracion= eliminarblancos($_POST['duracion']);}
    if(isset($_POST['tipohab'])){$tipohab=eliminarblancos($_POST['tipohab']);}
    if(isset($_POST['numcam'])){$numcam=eliminarblancos($_POST['numcam']);}
    if(isset($_POST['estadopaciente'])){$estadopaciente=eliminarblancos($_POST['estadopaciente']);}
    if(isset($_POST['nombrefamiliar'])){$nombrefamiliar=eliminarblancos($_POST['nombrefamiliar']);}
    if(isset($_POST['parentescofamiliar'])){$parentescofamiliar=eliminarblancos($_POST['parentescofamiliar']);}
    if(isset($_POST['condicionatencion'])){$condicionatencion=eliminarblancos($_POST['condicionatencion']);}
    if(isset($_POST['pa'])){$pa=eliminarblancos($_POST['pa']);}
    if(isset($_POST['pulso'])){$pulso=eliminarblancos($_POST['pulso']);}
    if(isset($_POST['temp'])){$temp=eliminarblancos($_POST['temp']);}
    if(isset($_POST['peso'])){$peso=eliminarblancos($_POST['peso']);}
    if(isset($_POST['examfis'])){$examfis=eliminarblancos($_POST['examfis']);}
    if(isset($_POST['precio'])){$precio=eliminarblancos($_POST['precio']);}
            
    $error=0;
    ##validar
    
    if($fechaingreso=="" || $tipohab=="" || $numcam=="" || $estadopaciente=="" || $condicionatencion=="" || 
            $pa=="" || $pulso=="" || $temp=="" || $peso=="" || $examfis=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
        $error++;
    }
               
    if($error==0)
        {
            $affected=$objHospitalizacion->ModificarHospitalizacion($id_hospmod, $fechaingreso, $fechaalta, 
                    $duracion, $tipohab, $numcam, $nombrefamiliar, $parentescofamiliar, $estadopaciente, 
                    $condicionatencion, $pa, $pulso, $temp, $peso, $examfis, $precio);
            // $affected2 es para comprobar la fecha, se necesita crear clase de referencia (paciente_servicio)
            $affected2="";
            if($affected==1 && $affected2==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                // aqui se debe construir con variables el enlace de retorno (la pag con los servs del paciente
                // seleccionado)
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
    

?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-hospital-o"> Editar Hospitalización</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_hospitalizacion" method="post" action="editarhospitalizacionrl.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Fecha de Ingreso</th>
                      <th> Fecha de Alta</th>
                      <th> Duración</th>
                  </tr>
                  <tr>
                      <input type="hidden" name="id_labmod" value="<?php echo $id_labmod; ?>">
                      <td><input type="date" name="fechaingreso" class="form-control" value="<?php echo $fechaingreso;?>"></td>
                      <td><input type="date" name="fechaalta" class="form-control" value="<?php echo $fechaalta;?>"></td>
                      <td><input type="text" name="duracion" class="form-control" value="<?php echo $duracion;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th> Tipo de Habitación</th>
                      <th> Num. de Cama</th>
                      <th> Estado del Paciente</th>
                  </tr>
                  <tr>                    
                      <td>
                          <select name="tipohab" class="form-control">
                              <?php 
                              $selectedf="";
                              $selectedc="";
                              
                                    if($tipohab=="Full"){$selectedf="selected='selected'";}
                                    else {$selectedc="selected='selected'";}
                              ?>
                              <option value='Full' <?php echo $selectedf;?> >Full</option>
                              <option value='Compartida' <?php echo $selectedc;?>>Compartida</option>
                          </select>
                      </td>
                      <td><input type="text" name="numcam" class="form-control" value="<?php echo $numcam;?>"></td>
                      <td><input type="text" name='estadopaciente' class="form-control" value="<?php echo $estadopaciente;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th> Nombre del Familiar</th>
                      <th> Parentesco del Familiar</th>
                      <th> Condición de Atención</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="nombrefamiliar" class="form-control" value="<?php echo $nombrefamiliar;?>"></td>
                      <td><input type="text" name="parentescofamiliar" class="form-control" value="<?php echo $parentescofamiliar;?>"></td>
                      <td><input type="text" name="condicionatencion" class="form-control" value="<?php echo $condicionatencion;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th> PA</th>
                      <th> Pulso</th>
                      <th> Temperatura</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="pa" class="form-control" value="<?php echo $pa;?>"></td>
                      <td><input type="text" name="pulso" class="form-control" value="<?php echo $pulso;?>"></td>
                      <td><input type="text" name="temp" class="form-control" value="<?php echo $temp;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th> Peso (Kg)</th>
                      <th> Exámen Físico</th>
                      <th> Precio</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="peso" class="form-control" value="<?php echo $peso;?>"></td>
                      <td><input type="text" name="examfis" class="form-control" value="<?php echo $examfis;?>"></td>
                      <td><input type="text" name="precio" class="form-control" value="<?php echo $precio;?>"></td>
                  </tr>
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Actualizar</button>
                  <!-- aqui se debe construir con variables el enlace de retorno (la pag con los servs del 
                  paciente seleccionado) -->
                  <a href='listar_pacientes.php' class="btn btn-danger" type="submit">Cancelar</a>
                  <br>
                  <br>
              </div>
              
          </form>
        </div>
    </div>
</section>


