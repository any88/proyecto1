<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/AseguradoraController.php';

$objAseguradora=new AseguradoraController();
$msg="";

##variables
$nombreaseguradora="";
$ruc="";

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['nombreaseguradora'])){$nombreaseguradora= eliminarblancos($_POST['nombreaseguradora']);}
    if(isset($_POST['ruc'])){$ruc=eliminarblancos($_POST['ruc']);}
    
    
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
        ##validar que el ruc no exista en la base de datos
        
        $list_p=$objAseguradora->BuscarAseguradora('', '', $ruc);
        if(count($list_p)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe una aseguradora registrada con ese RUC: $ruc</div>"; 
            $error++;
            
        }
        
        if($error==0)
        {
            $affected=$objAseguradora->CrearAseguradora($nombreaseguradora, $ruc);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Aseguradora registrada satisfactoriamente</div>"; 
                 echo "<script>";
                echo "window.location = 'listar_aseguradoras.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo Insertar la Aseguradora</div>"; 
            }
        }
        
    }
    
}
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="glyphicon glyphicon-heart"> Nueva Aseguradora</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="nueva_aseguradora" method="post" action="crearaseguradora.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> RUC</th>
                  </tr>
                  <tr >
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


