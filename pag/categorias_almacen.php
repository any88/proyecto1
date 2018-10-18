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
    if(isset($_POST['id_cat_almacen'])){$p_id_categoria=$_POST['id_cat_almacen'];}
    if(isset($_POST['nomb_cat_almacen'])){$p_nombre_categoria=$_POST['nomb_cat_almacen'];}
    
    if($p_id_categoria!="")
    {
        $affected=$objCategAlmacC->EliminarConsulta($p_id_categoria);
        if($affected==1)
        {
            $msg="<div class='alert alert-success alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "OK! La categor&iacute;a $p_nombre_categoria ha sido eliminado Correctamente.</div>";
        }
        else
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error! La categor&iacute;a $p_nombre_categoria no pudo ser eliminado.</div>";
        }
    }
}
$lista_cat_almacen=$objCategAlmacC->MostrarCategoria();
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
                  <b class="text-left"><i class="fa fa-tag text-info"> CATEGORIAS DE ALMACEN</i></b>
                  <div class="pull-right" style="margin-top: -5px;">
                      <a href="nueva_categoria_almacen.php" class="btn btn-primary btn-xs"><i class="fa fa-plus"> Nueva Categor&iacute;a</i></a>
                  </div>
              </div>
              <div class="panel-body">
              
                  <table class="table table-responsive table-hover" id="dataTables-example">
                      <thead>
                          <tr>
                              <th>Nro.</th>
                              <th>Nombre</th>
                              <th>Acci&oacute;n</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 
                          if(count($lista_cat_almacen)>0)
                          {
                              for ($i = 0; $i < count($lista_cat_almacen); $i++) 
                              {
                                  $nro=$i+1;
                                  $id_categoria=$lista_cat_almacen[$i]->getId_categoria_almacen();
                                  $nombre_categoriaAlm=$lista_cat_almacen[$i]->getNombre_categoria();
                              
                                  echo "<tr>";
                                    echo "<td>$nro";
                                        
                                    echo "</td>";
                                    echo "<td>$nombre_categoriaAlm</td>";
                                    echo "<td>";
                                        echo "<form method='post' action='categorias_almacen.php' id='form$i'>";
                                        echo "<a href='editar_Categoria_Almacen.php?nik=$id_categoria' class='btn btn-primary btn-xs'><i class='fa fa-edit'></i></a>";
                                        echo "<input type='hidden' name='id_cat_almacen' value='$id_categoria'>";
                                        echo "<input type='hidden' name='nomb_cat_almacen' value='$nombre_categoriaAlm'>";
                                        echo " <button type='button' class='btn btn-primary btn-xs' title='ELiminar' onclick='EliminarCategoriaAlmacen(this.id,this.value);'  value='$i' id='$nombre_categoriaAlm'> <i class='fa fa-trash'></i></button></form> ";
                              
                                    echo "</td>";
                                  echo "</tr>";
                              }
                          }
                          
                          ?>
                      </tbody>
                      
                  </table>
              </div>
          </div>
        </div>
    </div>
</section>
            

