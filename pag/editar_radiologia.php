<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/RadiologiaController.php';
include '../modelo/TipoRadiologiaController.php';
include '../modelo/NombreRadiologiaController.php';
include '../modelo/ServicioController.php';
include '../modelo/PacienteServicioController.php';
include '../modelo/LaboratorioRadiologiaController.php';
include '../modelo/LaboratorioRadiologia_PruebaRadController.php';

$msg="";
$objRadiologia=new RadiologiaController();
$objTipoRadiologia= new TipoRadiologiaController();
$objNombreRadiologia= new NombreRadiologiaController();
$objServicio= new ServicioController();
$objPacienteServ=new PacienteServicioController();
$objLabRadiologia=new LaboratorioRadiologiaController();
$objLabRadPruebaRad= new LaboratorioRadiologia_PruebaRadController();

$lista_tiporadiologia=$objTipoRadiologia->MostrarTipoRadiologia();
$lista_nombreradiologia=$objNombreRadiologia->MostrarNombreRadiologia();
$lista_labrad=$objLabRadiologia->MostrarLaboratorioRadiologia();
$lista_labradprbrad=$objLabRadPruebaRad->MostrarLaboratorioRadiologia_PruebaRad();
$lista_paciente_Serv=$objPacienteServ->MostrarPacienteServicio();
$lista_servicios=$objServicio->MostrarServicio();

##variables
$idradmod="";
$idservicio="";
$idtipo="";
$idnombre="";
$fecha="";
$idlabrad="";
$nombrelabrad="";
$resultado="";
$precio="";

if(isset($_REQUEST['nik']))
    {
    $idradmod=$_REQUEST['nik'];
    $radmod=$objRadiologia->BuscarRadiologia($idradmod, "", "");
    }

if(isset($radmod))
{
    $idservicio=$radmod[0]->getIdServicio();
    $idtipo=$radmod[0]->getIdTipoRadiologia();
    $idnombre=$radmod[0]->getNombre();
    $resultado=$radmod[0]->getResultados();
           
    $labradiologia=$objLabRadPruebaRad->BuscarLaboratorioRadiologia_PruebaRad("", "", $idradmod);
    if(count($labradiologia)>0)
        {
        $idlabrad=$labradiologia[0]->getIdlabradiologia();
        $arraynombres=$objLabRadiologia->BuscarLaboratorioRadiologia($idlabrad, "", "");
        if(count($arraynombres)>0){$nombrelabrad=$arraynombres[0]->getNombrelabrad();}
        }
    
    $pacienteserv=$objPacienteServ->BuscarPacienteServicio("", "", $idservicio);
    if(count($pacienteserv)>0){$fecha=$pacienteserv[0]->getFecha();}
        
    $serv=$objServicio->BuscarServicio($idservicio, "", "");
    if(count($serv)>0){$precio=$serv[0]->getPrecio();}
    
}


if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_radmod'])){$idradmod= eliminarblancos($_POST['id_radmod']);}
    if(isset($_POST['idservicio'])){$idservicio= eliminarblancos($_POST['idservicio']);}
    if(isset($_POST['idtipo'])){$idtipo=eliminarblancos($_POST['idtipo']);}
    if(isset($_POST['idnombre'])){$idnombre= eliminarblancos($_POST['idnombre']);}
    if(isset($_POST['fecha'])){$fecha=eliminarblancos($_POST['fecha']);}
    if(isset($_POST['idlabrad'])){$idlabrad=eliminarblancos($_POST['idlabrad']);}
    if(isset($_POST['resultados'])){$resultado=eliminarblancos($_POST['resultados']);}
    if(isset($_POST['precio'])){$precio=eliminarblancos($_POST['precio']);}
                    
    $error=0;
    ##validar
    
    if($idradmod=="" || $idtipo=="" || $idnombre=="" || $fecha=="" || $idlabrad=="" || $precio=="")
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
            $arrayrad=$objRadiologia->BuscarRadiologia($idradmod, $idtipo, $idnombre, "", $resultado);
            if(count ($arrayrad)==0)
                {
                $modenradiologia=$objRadiologia->ModificarRadiologia($idradmod, $idtipo, $idnombre, $resultado);
                if($modenradiologia==0){$affcont++;}
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
            
            $arraylabradprbrad=$objLabRadPruebaRad->BuscarLaboratorioRadiologia_PruebaRad("", $idlabrad, $idradmod);
            if(count ($arraylabradprbrad)==0)
                {
                $modenlabradprbrad=$objLabRadPruebaRad->ModificarIdlabRadporIdAnalisisLab($idradmod, $idlabrad);
                if($modenlabradprbrad==0){$affcont++;}
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
                echo "window.location = 'mostrar_radiologia.php?nik=$idradmod';";
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
          <h3 class="text-left"><i class="fa fa-user-md text-info"> Editar Prueba Radiológica</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_radiologia" method="post" action="editar_radiologia.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th>Tipo de Prueba</th>
                      <th>Nombre de la Prueba</th>
                      <th>Fecha</th>
                  </tr>
                  <tr>
                      <input type="hidden" name="id_radmod" value="<?php echo $idradmod; ?>">
                      <input type="hidden" name="idservicio" value="<?php echo $idservicio; ?>">
                      <td>
                      <select name="idtipo" class="form-control" required="">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_tiporadiologia); $i++) 
                            {
                               $id_tiporadiologia=$lista_tiporadiologia[$i]->getIdTipoRadiologia();
                               $nombre=$lista_tiporadiologia[$i]->getTipoRadiologia();
                               $marcar="";
                               if($id_tiporadiologia==$idtipo){$marcar="selected='selected'";}
                               echo "<option value='$id_tiporadiologia' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>    
                      <td>
                          <select name="idnombre" class="form-control" required="">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_nombreradiologia); $i++) 
                            {
                               $id_nombreradiologia=$lista_nombreradiologia[$i]->getIdnombreradiologia();
                               $nombre=$lista_nombreradiologia[$i]->getNombreradiologia();
                               $marcar="";
                               if($id_nombreradiologia==$idnombre){$marcar="selected='selected'";}
                               echo "<option value='$id_nombreradiologia' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td><input type="date" name="fecha" class="form-control" value="<?php echo $fecha;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Laboratorio Radiológico</th>
                      <th>Resultados</th>
                      <th>Precio</th>
                  </tr>
                  <tr>
                  <td>
                      
                      <select name="idlabrad" class="form-control" required="">
                         <option value=''>--SELECCIONE--</option>
                            <?php
                            for ($i = 0; $i < count($lista_labrad); $i++) 
                            {
                               $id_labrad=$lista_labrad[$i]->getIdlabradiologia();
                               $nombre=$lista_labrad[$i]->getNombrelabrad();
                               $marcar="";
                               if($id_labrad==$idlabrad){$marcar="selected='selected'";}
                               echo "<option value='$id_labrad' $marcar>$nombre</option>";
                            }
                            ?>
                      </select>
                  </td>
                  <td>
                      <textarea class="form-control" name="resultados"><?php echo $resultado;?></textarea>
                  </td>
                  <td><input type="text" name="precio" class="form-control" value="<?php echo $precio;?>"></td>     
                  </tr>
                                                      
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Actualizar</button>
                  <a href='mostrar_radiologia.php<?php echo "?nik=$idradmod"?>' class="btn btn-danger" type="submit">Cancelar</a>
                  <!--
                  echo"<td><a href='$link?nik=$nik' class='btn btn-primary  btn-xs'><i class='fa fa-eye'></i></a></td>";
                  -->
              </div>
              
          </form>
        </div>
    </div>
</section>


