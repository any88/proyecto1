<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/TipoAnalisisLaboratorioController.php';

$objTipoAnalisisLab=new TipoAnalisisLaboratorioController();
$tipoamod=array();
$id_tipoamod="";
$msg="";

##variables
$tipoanalisis="";

if(isset($_GET['nik']))
{
$id_tipoamod=$_GET['nik'];
$tipoamod=$objTipoAnalisisLab->BuscarTipoAnalisisLaboratorio($id_tipoamod, "");

    if(count($tipoamod)>0)
    {
        $tipoanalisis=$tipoamod[0]->getTipoAnalisis();
    }
}
if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_tipoamod'])){$id_tipoamod= eliminarblancos($_POST['id_tipoamod']);}
    if(isset($_POST['tipoanalisis'])){$tipoanalisis= eliminarblancos($_POST['tipoanalisis']);}
        
    $error=0;
    ##validar
    
    if($tipoanalisis=="")
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
            $affected=$objTipoAnalisisLab->ModificarTipoAnalisisLaboratorio($id_tipoamod, $tipoanalisis);
            if($affected==1)
            {
                $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                echo "window.location = 'listar_tipoanalisislaboratorio.php';";
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
          <h3 class="text-left"><i class="fa fa-flask"> Editar Tipo de Análisis</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_tipoanalisis" method="post" action="editartipoanalisislaboratorio.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Tipo de Análisis</th>
                  </tr>
                  <tr>
                      <input type="hidden" name="id_tipoamod" value="<?php echo $id_tipoamod; ?>">
                      <td><input type="text" name="tipoanalisis" class="form-control" required="" value="<?php echo $tipoanalisis;?>"></td>
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Registrar</button>
                  <a href='listar_tipoanalisislaboratorio.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>

