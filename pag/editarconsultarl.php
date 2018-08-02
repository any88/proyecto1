<?php

// EN DESARROLLO!!! VER COMENTARIOS PARA MAS INFO..

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/ConsultaController.php';
include '../modelo/EspecialidadController.php';
include '../modelo/MedicoController.php';

$msg="";
$objMedico=new MedicoController();
$objEspecialidad= new EspecialidadController();
$objConsulta= new ConsultaController();
$lista_especialidades=$objEspecialidad->MostrarEspecialidad();
$lista_medicos=$objMedico->MostrarMedico();

if(isset($_REQUEST['nik']))
    {
    $id_consmod=$_REQUEST['nik'];
    $consmod=$objConsulta->BuscarConsulta($id_consmod, "", "");
    }
if(isset($_POST['id_consmod']))
    {
    $id_consmod=$_POST['id_consmod'];
    } 

##variables
$especialidad="";
$medico="";
$fecha="";
$indicaciones="";
$resultados="";
$precio="";

if(isset($consmod))
{
    $especialidad=$consmod[0]->getEspecialidad();
    $idconsulta=$consmod[0]->getIdConsulta();
    $indicaciones=$consmod[0]->getIndicaciones();
    $resultados= $consmod[0]->getResultados();
    $precio= $consmod[0]->getPrecio();
}

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_consmod'])){$id_consmod= eliminarblancos($_POST['id_consmod']);}
    if(isset($_POST['especialidad'])){$especialidad=eliminarblancos($_POST['especialidad']);}
    if(isset($_POST['medico'])){$medico= eliminarblancos($_POST['medico']);}
    if(isset($_POST['fecha'])){$fecha=eliminarblancos($_POST['fecha']);}
    if(isset($_POST['indicaciones'])){$indicaciones=eliminarblancos($_POST['indicaciones']);}
    if(isset($_POST['resultados'])){$resultados=eliminarblancos($_POST['resultados']);}
    if(isset($_POST['precio'])){$precio=eliminarblancos($_POST['precio']);}
            
    $error=0;
    ##validar
    
    if($especialidad=="" || $medico=="" || $fecha=="" || $precio=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
        $error++;
    }
               
    if($error==0)
        {
            $affected=$objConsulta->ModificarConsulta($id_consmod, $especialidad, $indicaciones, $resultados, $precio);
            // $affected2 es para comprobar el medico y la fecha, se necesita crear clase de referencia
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
          <h3 class="text-left"><i class="fa fa-user-md"> Editar Consulta</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_consulta" method="post" action="editarconsultarl.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Especialidad</th>
                      <th> Doctor</th>
                      <th> Fecha</th>
                  </tr>
                  <tr >
                      <input type="hidden" name="id_consmod" value="<?php echo $id_consmod; ?>">                     
                      <td>
                          <select name="especialidad" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php 
                            for ($i = 0; $i < count($lista_especialidades); $i++) 
                            {
                               $id_especialidad=$lista_especialidades[$i]->getIdEspecialidad();
                               $nombreespecialidad=$lista_especialidades[$i]->getNombreespecialidad();
                               $marcar="";
                               if($id_especialidad==$especialidad){$marcar="selected='selected'";}
                               echo "<option value='$id_especialidad' $marcar>$nombreespecialidad</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td><input type="text" name="medico" class="form-control" required="" value="<?php echo $medico;?>"></td>
                      <td><input type="date" name="fecha" class="form-control" value="<?php echo $fecha;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th> Indicaciones</th>
                      <th> Resultados</th>
                      <th> Precio</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="indicaciones" class="form-control" value="<?php echo $indicaciones;?>"></td>
                      
                      <!-- Recordar que "resultados" guarda imagenes, realizar los ajustes para el caso-->
                      <td><input type="text" name="resultados" class="form-control" value="<?php echo $resultados;?>"></td>
                      <td><input type="text" name='precio' class="form-control" value="<?php echo $precio;?>"></td>
                  </tr>                                                     
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Actualizar</button>
                  <!-- aqui se debe construir con variables el enlace de retorno (la pag con los servs del 
                  paciente seleccionado) -->
                  <a href='listar_pacientes.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>
