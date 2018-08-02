<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/CargoController.php';

$objCargo=new CargoController();
$msg="";

##variables
$nombrecargo="";

if($_POST)
{
    //Mostrar($_POST);
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
        ##validar que el cargo no exista en la base de datos
        
        $list_p=$objCargo->BuscarCargo('', $nombrecargo);
        if(count($list_p)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe un cargo registrado con ese nombre: $nombrecargo</div>"; 
            $error++;
            
        }
        
        if($error==0)
        {
            $affected=$objCargo->CrearCargo($nombrecargo);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Cargo registrado satisfactoriamente</div>"; 
                 echo "<script>";
                echo "window.location = 'listar_cargos.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo Insertar el Cargo</div>"; 
            }
        }
        
    }
    
}
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-angle-double-up"> Nuevo Cargo</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="nuevo_cargo" method="post" action="crearcargo.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                  </tr>
                  <tr >
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

