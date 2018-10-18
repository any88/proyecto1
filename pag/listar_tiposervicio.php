<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/TipoServicioController.php';

$objTipoServicio=new TipoServicioController();
$list_tiposervicio=$objTipoServicio->MostrarTipoServicio();
$msg="";

if($_GET)
{
    //Mostrar($_GET);
    if(isset($_GET["nik"]))
    {
        $id_eliminar=$_GET["nik"];
        
        $arr_existe=array();
        $arr_existe=$objTipoServicio->BuscarTipoServicio($id_eliminar,"");
        if(count($arr_existe)>0)
        {
            //Mostrar($arr_existe);
            $affected=$objTipoServicio->EliminarTipoServicio($id_eliminar);
            if($affected==0){$msg="No se encontró el Tipo de Servicio";}
            else {$msg="Se eliminaron los datos correctamente";}
        }
        else 
        {
            $msg="El Tipo de Servicio que desea eliminar no existe";
        }
        echo "<script>window.location = 'listar_tiposervicio.php';</script>";
    }
}

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-hospital-o"> Listado de Tipos de Servicio</i></h3>
          <div class="text-left">
              <a href='creartiposervicio.php' class="btn btn-success" type="submit">Nuevo Tipo de Servicio</a>
         </div>
          <br>
          <table id="dataTables-example" class="table table-striped table-hover display table-responsive " style="right: 10px;">
              <thead>
                  <tr>
                      <th>Nro</th>
                      <th>Tipo de Servicio</th>
                      <th>Precio Base</th>                                            
                      <th>Acci&oacute;n</th>
                  </tr>
              </thead>
              <tbody>
                 <?php 
                 $link_edit="editartiposervicio.php";
                 $link_listar="";
                 for ($i = 0; $i < count($list_tiposervicio); $i++) 
                 {
                     $nro=$i+1;
                    echo "<tr>";
                    echo "<td>".$nro."</td>";
                    echo "<td>".$list_tiposervicio[$i]->getTipoServicio()."</td>";
                    echo "<td> s/. ".$list_tiposervicio[$i]->getPrecio_base()."</td>";
                    echo '<td>
                             <a href="'.$link_edit.'?nik='.$list_tiposervicio[$i]->getIdTipoServicio().'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                             <a href="'.$link_listar.'?action=delete&nik='.$list_tiposervicio[$i]->getIdTipoServicio().'&v='.$list_tiposervicio[$i]->getTipoServicio().'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos de '.$list_tiposervicio[$i]->getTipoServicio().' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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