<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/NombreRadiologiaController.php';
include '../modelo/TipoRadiologiaController.php';

$objNombreRadiologia=new NombreRadiologiaController();
$list_nombreradiologia=$objNombreRadiologia->MostrarNombreRadiologia();
$objTipoRadiologia= new TipoRadiologiaController();
$list_tiporadiologia= $objTipoRadiologia->MostrarTipoRadiologia();
$msg="";

if($_GET)
{
    if(isset($_GET["nik"]))
    {
        $id_eliminar=$_GET["nik"];      
        $arr_existe=array();
        $arr_existe=$objNombreRadiologia->BuscarNombreRadiologia($id_eliminar,"", "");
        if(count($arr_existe)>0)
        {
            $affected=$objNombreRadiologia->EliminarNombreRadiologia($id_eliminar);
            if($affected==0){$msg="No se encontro la prueba";}
            else {$msg="Se eliminaron los datos correctamente";}
        }
        else 
        {
            $msg="La prueba que desea eliminar no existe";
        }
        echo "<script>window.location = 'listar_pruebasradiologia.php';</script>";
    }
}

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-area-chart"> Listado de Pruebas Radiológicas</i></h3>
          <div class="text-left">
              <a href='crearpruebaradiologia.php' class="btn btn-success" type="submit">Nueva Prueba Radiológica</a>
         </div>
          <br>
          <table id="example" class="table table-striped table-hover display table-responsive " style="right: 10px;">
              <thead>
                  <tr>
                      <th>Nro</th>
                      <th>Nombre</th>
                      <th>Grupo de Pruebas</th>
                                            
                      <th>Acci&oacute;n</th>
                  </tr>
              </thead>
              <tbody>
                 <?php 
                 $link_edit="editarpruebaradiologia.php";
                 $link_listar="";
                 for ($i = 0; $i < count($list_nombreradiologia); $i++) 
                 {
                     $nro=$i+1;
                    echo "<tr>";
                    echo "<td>".$nro."</td>";
                    echo "<td>".$list_nombreradiologia[$i]->getNombreradiologia()."</td>";
                    for ($j=0; $j < count ($list_tiporadiologia); $j++)
                    {
                        if($list_nombreradiologia[$i]->getIdtiporadiologia()==$list_tiporadiologia[$j]->getIdTipoRadiologia())
                        {
                        echo "<td>".$list_tiporadiologia[$j]->getTipoRadiologia()."</td>";
                        }
                    }
                    
                    echo '<td>
                             <a href="'.$link_edit.'?nik='.$list_nombreradiologia[$i]->getIdnombreradiologia().'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                             <a href="'.$link_listar.'?action=delete&nik='.$list_nombreradiologia[$i]->getIdnombreradiologia().'&v='.$list_nombreradiologia[$i]->getNombreradiologia().'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos '.$list_nombreradiologia[$i]->getNombreradiologia().' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                     </td>';
                    echo "</tr>";
                 }
                 ?>
              </tbody>
          </table>
        </div>
    </div>
</section>
<?php include './footer.html'; ?>
