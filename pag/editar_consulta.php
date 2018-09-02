<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/ConsultaController.php';
include '../modelo/EspecialidadController.php';
include '../modelo/MedicoController.php';
include '../modelo/ServicioController.php';
include '../modelo/PacienteServicioController.php';
include '../modelo/MedicoConsultaController.php';

$msg="";
$objConsulta=new ConsultaController();
$objEspecialidad= new EspecialidadController();
$objMedico= new MedicoController();
$objServicio= new ServicioController();
$objPacienteServ=new PacienteServicioController();
$objMedicoConsulta=new MedicoConsultaController();

$lista_especialidades=$objEspecialidad->MostrarEspecialidad();
$lista_medicos=$objMedico->MostrarMedico();
$lista_medicoConsulta=$objMedicoConsulta->MostrarMedicoConsulta();
$lista_paciente_Serv=$objPacienteServ->MostrarPacienteServicio();
$lista_servicios=$objServicio->MostrarServicio();

##variables
$idservicio="";
$idespecialidad="";
$idmedico="";
$fecha="";
$indicaciones="";
$resultado="";
$precio="";

if(isset($_REQUEST['nik']))
    {
    $idconsmod=$_REQUEST['nik'];
    $consmod=$objConsulta->BuscarConsulta($idconsmod, "", "");
    }

if(isset($consmod))
{
    $idservicio=$consmod[0]->getIdServicio();
    $idespecialidad=$consmod[0]->getEspecialidad();
    $indicaciones=$consmod[0]->getIndicaciones();
    $resultado=$consmod[0]->getResultados();
    
    $medcons=$objMedicoConsulta->BuscarMedicoConsulta("", "", $idconsmod);
    if(count($medcons)>0)
        {
        $idmedico=$medcons[0]->getIdmedico();
        $arraynombres=$objMedico->BuscarMedico($idmedico, "", "");
        if(count($arraynombres)>0){$nombremedico=$arraynombres[0]->getNombre();}
        }
    
    $pacienteserv=$objPacienteServ->BuscarPacienteServicio("", "", $idservicio);
    if(count($pacienteserv)>0){$fecha=$pacienteserv[0]->getFecha();}
        
    $serv=$objServicio->BuscarServicio($idservicio, "", "");
    if(count($serv)>0){$precio=$serv[0]->getPrecio();}   
}

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['idconsmod'])){$idconsmod= eliminarblancos($_POST['idconsmod']);}
    if(isset($_POST['idservicio'])){$idservicio=eliminarblancos($_POST['idservicio']);}
    if(isset($_POST['idespecialidad'])){$idespecialidad=eliminarblancos($_POST['idespecialidad']);}
    if(isset($_POST['idmedico'])){$idmedico= eliminarblancos($_POST['idmedico']);}
    if(isset($_POST['fecha'])){$fecha=eliminarblancos($_POST['fecha']);}
    if(isset($_POST['indicaciones'])){$indicaciones=eliminarblancos($_POST['indicaciones']);}
    if(isset($_POST['resultados'])){$resultado=eliminarblancos($_POST['resultados']);}
    if(isset($_POST['precio'])){$precio=eliminarblancos($_POST['precio']);}
                    
    $error=0;
    ##validar
    
    if($idconsmod=="" || $idespecialidad=="" || $idmedico=="" || $fecha=="" || $precio=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
        $error++;
    }
    else
    {
        if(isNaN($precio))
        {
           $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! El campo precio solo admite n&uacute;meros</div>"; 
           $error++;
        }
           
        if($error==0)
        {
            $affcont=0;
            $arraycons=$objConsulta->BuscarConsulta($idconsmod, $idespecialidad, "", $indicaciones, $resultado);
            //Mostrar($arraycons);
            if(count ($arraycons)==0)
                {
                $modenconsulta=$objConsulta->ModificarConsulta($idconsmod, $idespecialidad, $indicaciones, $resultado);
                if($modenconsulta==0){$affcont++;}
                }
                    
            $arrayserv=$objServicio->BuscarServicio($idservicio, "", $precio);
            if(count ($arrayserv)==0)
                {
                //Mostrar($arrayserv);
                $modenservicio=$objServicio->ModificarPrecioporIdServicio($idservicio, $precio);
                if($modenservicio==0){$affcont++;}
                }
                         
            $arraypacserv=$objPacienteServ->BuscarPacienteServicio("", "", $idservicio, $fecha);
            if(count ($arraypacserv)==0)
                {
                $modenpacserv=$objPacienteServ->ModificarFechaporIdServicio($idservicio, $fecha);
                if($modenpacserv==0){$affcont++;}
                }
            
            $arraymedcons=$objMedicoConsulta->BuscarMedicoConsulta("", $idmedico, $idconsmod);
            if(count ($arraymedcons)==0)
                {
                $modenmedcons=$objMedicoConsulta->ModificarIdMedporIdConsulta($idconsmod, $idmedico);
                if($modenmedcons==0){$affcont++;}
                }
            if($affcont>0)
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error. Actualizacion de datos fallida</div>";
            }
            else
            {
                $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                echo "window.location = 'mostrar_consulta.php?nik=$idconsmod';";
                echo "</script>";
            }
        }
        else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error. Actualizacion de datos fallida</div>"; 
            }   
    }
    
}
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user-md text-info"> Editar Consulta</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_consulta" method="post" action="editar_consulta.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th>Especialidad</th>
                      <th>Doctor</th>
                      <th>Fecha</th>
                  </tr>
                  <tr>
                      <input type="hidden" name="idconsmod" value="<?php echo $idconsmod; ?>">
                      <input type="hidden" name="idservicio" value="<?php echo $idservicio; ?>">
                      <td>
                          <select name="idespecialidad" class="form-control" required="">
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
                      <td>
                          <select name="idmedico" class="form-control" required="">
                              <option value=''>--SELECCIONE--</option>
                              <?php 
                            for ($i = 0; $i < count($lista_medicos); $i++) 
                            {
                               $id_medico=$lista_medicos[$i]->getIdMedico();
                               $nombremedico=$lista_medicos[$i]->getNombre();
                               $marcar="";
                               if($id_medico==$idmedico){$marcar="selected='selected'";}
                               echo "<option value='$id_medico' $marcar>$nombremedico</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td><input type="date" name="fecha" class="form-control" value="<?php echo $fecha;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th >Motivo</th> <!--El campo al que hace referencia es "indicaciones"-->
                      <th>Resultados</th>
                      <th>Precio</th>
                  </tr>
                  <tr>
                  <td>
                      <textarea class="form-control" name="indicaciones"><?php echo $indicaciones;?></textarea>
                  </td>
                  <td>
                      <textarea class="form-control" name="resultados"><?php echo $resultado;?></textarea>
                  </td>
                  <td><input type="text" name="precio" class="form-control" value="<?php echo $precio;?>"></td>     
                  </tr>
                                                      
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Actualizar</button>
                  <a href='mostrar_consulta.php<?php echo "?nik=$idconsmod"?>' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>


