<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/LaboratorioController.php';
include '../modelo/TipoAnalisisLaboratorioController.php';
include '../modelo/NombreAnalisisLaboratorioController.php';
include '../modelo/ServicioController.php';
include '../modelo/PacienteServicioController.php';
include '../modelo/LaboratorioClinicoController.php';
include '../modelo/LaboratorioClinico_AnalisisController.php';

$msg="";
$objLaboratorio=new LaboratorioController();
$objTipoAnalisisLab= new TipoAnalisisLaboratorioController();
$objNombreAnalisis= new NombreAnalisisLaboratorioController();
$objServicio= new ServicioController();
$objPacienteServ=new PacienteServicioController();
$objLabClinico=new LaboratorioClinicoController();
$objLabClinAnalab= new LaboratorioClinico_AnalisisController();

$lista_tipoanalisislab=$objTipoAnalisisLab->MostrarTipoAnalisisLaboratorio();
$lista_nombreanalisis=$objNombreAnalisis->MostrarNombreAnalisis();
$lista_labclin=$objLabClinico->MostrarLaboratorioClinico();
$lista_labclinanalab=$objLabClinAnalab->MostrarLaboratorioClinico_Analisis();
$lista_paciente_Serv=$objPacienteServ->MostrarPacienteServicio();
$lista_servicios=$objServicio->MostrarServicio();

##variables
$idlabmod="";
$idservicio="";
$idtipo="";
$idnombre="";
$fecha="";
$idlabclin="";
$nombrelabclin="";
$resultado="";
$precio="";

if(isset($_REQUEST['nik']))
    {
    $idlabmod=$_REQUEST['nik'];
    $labmod=$objLaboratorio->BuscarLaboratorio($idlabmod, "", "");
    }

if(isset($labmod))
{
    $idservicio=$labmod[0]->getIdServicio();
    $idtipo=$labmod[0]->getIdTipoAnalisisLaboratorio();
    $idnombre=$labmod[0]->getNombre();
    $resultado=$labmod[0]->getResultados();
    
    $labanalisis=$objLabClinAnalab->BuscarLaboratorioClinico_Analisis("", "", $idlabmod);
    if(count($labanalisis)>0)
        {
        $idlabclin=$labanalisis[0]->getIdlabclinico();
        $arraynombres=$objLabClinico->BuscarLaboratorioClinico($idlabclin, "", "");
        if(count($arraynombres)>0){$nombrelabclin=$arraynombres[0]->getNombrelabclin();}
        }
    
    $pacienteserv=$objPacienteServ->BuscarPacienteServicio("", "", $idservicio);
    if(count($pacienteserv)>0){$fecha=$pacienteserv[0]->getFecha();}
        
    $serv=$objServicio->BuscarServicio($idservicio, "", "");
    if(count($serv)>0){$precio=$serv[0]->getPrecio();}    
}

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['idlabmod'])){$idlabmod= eliminarblancos($_POST['idlabmod']);}
    if(isset($_POST['idservicio'])){$idservicio=eliminarblancos($_POST['idservicio']);}
    if(isset($_POST['idtipo'])){$idtipo=eliminarblancos($_POST['idtipo']);}
    if(isset($_POST['idnombre'])){$idnombre= eliminarblancos($_POST['idnombre']);}
    if(isset($_POST['fecha'])){$fecha=eliminarblancos($_POST['fecha']);}
    if(isset($_POST['idlabclin'])){$idlabclin=eliminarblancos($_POST['idlabclin']);}
    if(isset($_POST['resultados'])){$resultado=eliminarblancos($_POST['resultados']);}
    if(isset($_POST['precio'])){$precio=eliminarblancos($_POST['precio']);}
                    
    $error=0;
    ##validar
    
    if($idlabmod=="" || $idtipo=="" || $idnombre=="" || $fecha=="" || $idlabclin=="" || $precio=="")
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
            $arraylab=$objLaboratorio->BuscarLaboratorio($idlabmod, $idtipo, $idnombre, "", $resultado);
            if(count ($arraylab)==0)
                {
                $modenlaboratorio=$objLaboratorio->ModificarLaboratorio($idlabmod, $idtipo, $idnombre, $resultado);
                if($modenlaboratorio==0){$affcont++;}
                }
                    
            $arrayserv=$objServicio->BuscarServicio($idservicio, "", $precio);
            if(count ($arrayserv)==0)
                {
                $modenservicio=$objServicio->ModificarPrecioporIdServicio($idservicio, $precio);
                if($modenservicio==0){$affcont++;}
                }
                         
            $arraypacserv=$objPacienteServ->BuscarPacienteServicio("", "", $idservicio, $fecha);
            if(count ($arraypacserv)==0)
                {
                $modenpacserv=$objPacienteServ->ModificarFechaporIdServicio($idservicio, $fecha);
                if($modenpacserv==0){$affcont++;}
                }
            
            $arraylabclinanalab=$objLabClinAnalab->BuscarLaboratorioClinico_Analisis("", $idlabclin, $idlabmod);
            if(count ($arraylabclinanalab)==0)
                {
                $modenlabclinanalab=$objLabClinAnalab->ModificarIdlabClinporIdAnalisisLab($idlabmod, $idlabclin);
                if($modenlabclinanalab==0){$affcont++;}
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
                echo "window.location = 'mostrar_laboratorio.php?nik=$idlabmod';";
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
          <h3 class="text-left"><i class="fa fa-user-md text-info"> Editar Análisis de Laboratorio</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_laboratorio" method="post" action="editar_laboratorio.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th>Tipo de Análisis</th>
                      <th>Nombre del Análisis</th>
                      <th>Fecha</th>
                  </tr>
                  <tr>
                      <input type="hidden" name="idlabmod" value="<?php echo $idlabmod; ?>">
                      <input type="hidden" name="idservicio" value="<?php echo $idservicio; ?>">
                      <td>
                      <select name="idtipo" class="form-control" required="">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_tipoanalisislab); $i++) 
                            {
                               $id_tipoanalisis=$lista_tipoanalisislab[$i]->getIdTipoAnalisisLaboratorio();
                               $nombre=$lista_tipoanalisislab[$i]->getTipoAnalisis();
                               $marcar="";
                               if($id_tipoanalisis==$idtipo){$marcar="selected='selected'";}
                               echo "<option value='$id_tipoanalisis' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>    
                      <td>
                          <select name="idnombre" class="form-control" required="">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_nombreanalisis); $i++) 
                            {
                               $id_nombreanalisis=$lista_nombreanalisis[$i]->getIdnombreanalisis();
                               $nombreanalisis=$lista_nombreanalisis[$i]->getNombreanalisis();
                               $marcar="";
                               if($id_nombreanalisis==$idnombre){$marcar="selected='selected'";}
                               echo "<option value='$id_nombreanalisis' $marcar>$nombreanalisis</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td><input type="date" name="fecha" class="form-control" value="<?php echo $fecha;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Laboratorio Clínico</th>
                      <th>Resultados</th>
                      <th>Precio</th>
                  </tr>
                  <tr>
                  <td>
                      <select name="idlabclin" class="form-control" required="">
                         <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_labclin); $i++) 
                            {
                               $id_labclin=$lista_labclin[$i]->getIdlabclinico();
                               $nombre=$lista_labclin[$i]->getNombrelabclin();
                               $marcar="";
                               if($id_labclin==$idlabclin){$marcar="selected='selected'";}
                               echo "<option value='$id_labclin' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                  </td>
                  <td><textarea class="form-control" name="resultados"><?php echo $resultado;?></textarea></td>                  </td>
                  <td><input type="text" name="precio" class="form-control" value="<?php echo $precio;?>"></td>     
                  </tr>
                                                      
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Actualizar</button>
                  <a href='mostrar_laboratorio.php<?php echo "?nik=$idlabmod"?>' class="btn btn-danger" type="submit">Cancelar</a>
                  <!--
                  echo"<td><a href='$link?nik=$nik' class='btn btn-primary  btn-xs'><i class='fa fa-eye'></i></a></td>";
                  -->
              </div>
              
          </form>
        </div>
    </div>
</section>


