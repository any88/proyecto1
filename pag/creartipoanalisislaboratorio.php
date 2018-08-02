<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/TipoAnalisisLaboratorioController.php';

$objTipoAnalisisLab=new TipoAnalisisLaboratorioController();
$msg="";

##variables
$tipoanalisis="";

if($_POST)
{
    //Mostrar($_POST);
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
        ##validar que el ruc no exista en la base de datos
        
        $list_p=$objTipoAnalisisLab->BuscarTipoAnalisisLaboratorio('',$tipoanalisis);
        if(count($list_p)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe un tipo de análisis registrado con ese nombre: $tipoanalisis</div>"; 
            $error++;
            
        }
        
        if($error==0)
        {
            $affected=$objTipoAnalisisLab->CrearTipoAnalisisLaboratorio($tipoanalisis);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Tipo de Análisis registrado satisfactoriamente</div>"; 
                 echo "<script>";
                echo "window.location = 'listar_tipoanalisislaboratorio.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo Insertar el Tipo de Análisis</div>"; 
            }
        }
        
    }
    
}
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-flask"> Nuevo Grupo de Análisis</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="nuevo_tipoanalisis" method="post" action="creartipoanalisislaboratorio.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Grupo de Análisis</th>
                  </tr>
                  <tr>
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


