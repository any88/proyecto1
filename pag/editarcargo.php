<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/CargoController.php';

$objCargo=new CargoController();
$carmod=array();
$id_carmod="";
$msg="";

##variables
$nombrecargo="";

if(isset($_GET['nik']))
{
$id_carmod=$_GET['nik'];
$carmod=$objCargo->BuscarCargo($id_carmod, "");

    if(count($carmod)>0)
    {
        $nombrecargo=$carmod[0]->getNombreCargo();
    }
}
if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_carmod'])){$id_carmod= eliminarblancos($_POST['id_carmod']);}
    if(isset($_POST['nombrecargo'])){$nombrecargo= eliminarblancos($_POST['nombrecargo']);}
            
    $error=0;
    ##validar
    
    if($nombrecargo=="")
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
            $affected=$objCargo->ModificarCargo($id_carmod, $nombrecargo);
            if($affected==1)
            {
                $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                echo "window.location = 'listar_cargos.php';";
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
          <h3 class="text-left"><i class="fa fa-angle-double-up"> Editar Cargo</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_cargo" method="post" action="editarcargo.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                  </tr>
                  <tr >
                      <input type="hidden" name="id_carmod" value="<?php echo $id_carmod; ?>">
                      <td><input type="text" name="nombrecargo" class="form-control" required="" value="<?php echo $nombrecargo;?>"></td>
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Registrar</button>
                  <a href='listar_cargos.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>

