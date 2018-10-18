<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/TipoRadiologiaController.php';

$objTipoRadiologia=new TipoRadiologiaController();
$list_tiporadiologia=$objTipoRadiologia->MostrarTipoRadiologia();
$msg="";

if($_GET)
{
    //Mostrar($_GET);
    if(isset($_GET["nik"]))
    {
        $id_eliminar=$_GET["nik"];
        
        $arr_existe=array();
        $arr_existe=$objTipoRadiologia->BuscarTipoRadiologia($id_eliminar,"");
        if(count($arr_existe)>0)
        {
            //Mostrar($arr_existe);
            $affected=$objTipoRadiologia->EliminarTipoRadiologia($id_eliminar);
            if($affected==0){$msg="No se encontró el Tipo de Prueba Radiológica";}
            else {$msg="Se eliminaron los datos correctamente";}
        }
        else 
        {
            $msg="El Tipo de Prueba Radiológica que desea eliminar no existe";
        }
        echo "<script>window.location = 'listar_tiporadiologia.php';</script>";
    }
}

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-area-chart"> Listado de Grupos de Pruebas Radiológicas</i></h3>
          <div class="text-left">
              <a href='creartiporadiologia.php' class="btn btn-success" type="submit">Nuevo Grupo de Prueba</a>
         </div>
          <br>
          <table id="example" class="table table-striped table-hover display table-responsive " style="right: 10px;">
              <thead>
                  <tr>
                      <th>Nro</th>
                      <th>Grupo de Prueba Radiológica</th>
                                                                  
                      <th>Acci&oacute;n</th>
                  </tr>
              </thead>
              <tbody>
                 <?php 
                 $link_edit="editartiporadiologia.php";
                 $link_listar="";
                 for ($i = 0; $i < count($list_tiporadiologia); $i++) 
                 {
                     $nro=$i+1;
                    echo "<tr>";
                    echo "<td>".$nro."</td>";
                    echo "<td>".$list_tiporadiologia[$i]->getTipoRadiologia()."</td>";
                    echo '<td>
                             <a href="'.$link_edit.'?nik='.$list_tiporadiologia[$i]->getIdTipoRadiologia().'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                             <a href="'.$link_listar.'?action=delete&nik='.$list_tiporadiologia[$i]->getIdTipoRadiologia().'&v='.$list_tiporadiologia[$i]->getTipoRadiologia().'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos de '.$list_tiporadiologia[$i]->getTipoRadiologia().' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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