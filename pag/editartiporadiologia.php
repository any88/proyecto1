<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/TipoRadiologiaController.php';

$objTipoRadiologia=new TipoRadiologiaController();
$tipormod=array();
$id_tipormod="";
$msg="";

##variables
$tiporadiologia="";

if(isset($_GET['nik']))
{
$id_tipormod=$_GET['nik'];
$tipormod=$objTipoRadiologia->BuscarTipoRadiologia($id_tipormod, "");

    if(count($tipormod)>0)
    {
        $tiporadiologia=$tipormod[0]->getTipoRadiologia();
    }
}
if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_tipormod'])){$id_tipormod= eliminarblancos($_POST['id_tipormod']);}
    if(isset($_POST['tiporadiologia'])){$tiporadiologia= eliminarblancos($_POST['tiporadiologia']);}
        
    $error=0;
    ##validar
    
    if($tiporadiologia=="")
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
            $affected=$objTipoRadiologia->ModificarTipoRadiologia($id_tipormod, $tiporadiologia);
            if($affected==1)
            {
                $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                echo "window.location = 'listar_tiporadiologia.php';";
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
          <h3 class="text-left"><i class="fa fa-area-chart"> Editar Tipo de Prueba Radiológica</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_tiporadiologia" method="post" action="editartiporadiologia.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Tipo de Prueba</th>
                  </tr>
                  <tr>
                      <input type="hidden" name="id_tipormod" value="<?php echo $id_tipormod; ?>">
                      <td><input type="text" name="tiporadiologia" class="form-control" required="" value="<?php echo $tiporadiologia;?>"></td>
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Registrar</button>
                  <a href='listar_tiporadiologia.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>

