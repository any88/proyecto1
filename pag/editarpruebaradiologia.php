<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/NombreRadiologiaController.php';
include '../modelo/TipoRadiologiaController.php';


$objNombreRadiologia=new NombreRadiologiaController();
$objTipoRadiologia= new TipoRadiologiaController();
$lista_tiporadiologia= $objTipoRadiologia->MostrarTipoRadiologia();
$msg="";

##variables
$nombreradiologia="";
$idtipo="";

if(isset($_GET['nik']))
{
$id_pruebamod=$_GET['nik'];
$pruebamod=$objNombreRadiologia->BuscarNombreRadiologia($id_pruebamod, "", "");

    if(count($pruebamod)>0)
    {
        $nombreradiologia=$pruebamod[0]->getNombreradiologia();
        $idtipo=$pruebamod[0]->getIdtiporadiologia();
    }
}
if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_pruebamod'])){$id_pruebamod= eliminarblancos($_POST['id_pruebamod']);}
    if(isset($_POST['nombreradiologia'])){$nombreradiologia= eliminarblancos($_POST['nombreradiologia']);}
    if(isset($_POST['idtipo'])){$idtipo= eliminarblancos($_POST['idtipo']);}
            
    $error=0;
    ##validar
    
    if($nombreradiologia=="" || $idtipo=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
        $error++;
    }
    else
    {           
        if($error==0)
        {
            $affected=$objNombreRadiologia->ModificarNombreRadiologia($id_pruebamod, $nombreradiologia, $idtipo);
            if($affected==1)
            {
                $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                echo "window.location = 'listar_pruebasradiologia.php';";
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
          <h3 class="text-left"><i class="fa fa-area-chart"> Editar Prueba Radiológica</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="nuevo_insumo" method="post" action="editarpruebaradiologia.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> Tipo de Prueba</th>
                  </tr>
                  <tr >
                      <input type="hidden" name="id_pruebamod" value="<?php echo $id_pruebamod;?>">
                      <td><input type="text" name="nombreradiologia" class="form-control" required="" value="<?php echo $nombreradiologia;?>"></td>
                      <td>
                          <select name="idtipo" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_tiporadiologia); $i++) 
                            {
                               $id_tipo=$lista_tiporadiologia[$i]->getIdTipoRadiologia();
                               $nombre=$lista_tiporadiologia[$i]->getTipoRadiologia();
                               $marcar="";
                               if($id_tipo==$idtipo){$marcar="selected='selected'";}
                               echo "<option value='$id_tipo' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Registrar</button>
                  <a href='listar_pruebasradiologia.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>


