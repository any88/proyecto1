<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/AseguradoraController.php';

$objAseguradora=new AseguradoraController();
$asegmod=array();
$id_asegmod="";
$msg="";

##variables
$nombreaseguradora="";
$ruc="";

if(isset($_GET['nik']))
{
$id_asegmod=$_GET['nik'];
$asegmod=$objAseguradora->BuscarAseguradora($id_asegmod, "", "");

    if(count($asegmod)>0)
    {
        $nombreaseguradora=$asegmod[0]->getNombre();
        $ruc=$asegmod[0]->getRUC();       
    }
}
if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_asegmod'])){$id_asegmod= eliminarblancos($_POST['id_asegmod']);}
    if(isset($_POST['nombreaseguradora'])){$nombreaseguradora= eliminarblancos($_POST['nombreaseguradora']);}
    if(isset($_POST['ruc'])){$ruc= eliminarblancos($_POST['ruc']);}
        
    $error=0;
    ##validar
    
    if($nombreaseguradora=="" || $ruc=="")
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
            $affected=$objAseguradora->ModificarAseguradora($id_asegmod, $nombreaseguradora, $ruc);
            if($affected==1)
            {
                $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                echo "window.location = 'listar_aseguradoras.php';";
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
          <h3 class="text-left"><i class="glyphicon glyphicon-heart"> Editar Aseguradora</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_aseguradora" method="post" action="editaraseguradora.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> RUC</th>
                  </tr>
                  <tr >
                      <td><input type="hidden" name="id_asegmod" value="<?php echo $id_asegmod; ?>"</td>
                      <td><input type="text" name="nombreaseguradora" class="form-control" required="" value="<?php echo $nombreaseguradora;?>"></td>
                      <td><input type="text" name="ruc" class="form-control" required="" value="<?php echo $ruc;?>"></td> 
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Registrar</button>
                  <a href='listar_aseguradoras.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>

