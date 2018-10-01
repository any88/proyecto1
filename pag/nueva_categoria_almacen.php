<?php
session_start();
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/CategoriaAlmacenController.php';
$objCategAlmacC=new CategoriaAlmacenController();

$msg="";
$p_id_categoria="";
$p_nombre_categoria="";

if($_POST)
{
    if(isset($_POST['nombre'])){$p_nombre_categoria=$_POST['nombre'];}
    if(eliminarblancos($p_nombre_categoria)=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error! El campo nombre de la categor&iacute;a no puede quedar vac&iacute;o.</div>";
        
    }
    else
    {
        $p_nombre_categoria= strtoupper($p_nombre_categoria);
        
        $arr_categoriasBuscar=$objCategAlmacC->BuscarCategoria("", $p_nombre_categoria);
        if(count($arr_categoriasBuscar)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! La categor&iacute;a $p_nombre_categoria ya existe.</div>";
        }
        else
        {
            $affected=$objCategAlmacC->CrearCategoriaAlmacen($p_nombre_categoria);
            if($affected==0)
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo agregar la nueva categor&iacute;a $p_nombre_categoria al almacen.</div>";
            }
            else
            {
                $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "OK! La categor&iacute;a $p_nombre_categoria ha sido agregada correctamente.</div>";

                $_SESSION['msg']=$msg;
                echo "<script>";
                    echo "window.location = 'categorias_almacen.php';";
               echo "</script>";

            }
        }
        
    }
}

include './menu_almacen.php';
?>
<br><br>
<section class="about-text">
    <div class="ingres_costo ">
        <div class="col-md-12">
          <?php 
          if($msg!=""){echo $msg;}
          ?>
          <div class="panel panel-default">
              <div class="panel-heading">
                  <b class="text-left"><i class="fa fa-tag text-info"> NUEVA CATEGORIAS DE ALMACEN</i></b>
                  
              </div>
              <div class="panel-body">
                  <form name="f" method="post" action="nueva_categoria_almacen.php">
                    <div class="col-md-3">
                        <img src="../img/CATEGORIAS.png" style="margin-top: -20px; margin-left: 3px; width: 200px;">
                    </div>
                    <div class="col-md-9">
                        <label>Nombre de la Categor&iacute;a</label>
                        <input type="text" name="nombre" value="<?php echo $p_nombre_categoria;?>" class="form-control" style='text-transform:uppercase;' required="">
                        <br><br>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <a href="categorias_almacen.php" class="btn btn-danger">Volver</a>
                        </div>

                    </div>
                </form>  
              </div>
          </div>
        </div>
    </div>
</section>
    

