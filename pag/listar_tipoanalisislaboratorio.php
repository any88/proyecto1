<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/TipoAnalisisLaboratorioController.php';

$objTipoAnalisisLab=new TipoAnalisisLaboratorioController();
$list_tipoanalisis=$objTipoAnalisisLab->MostrarTipoAnalisisLaboratorio();
$msg="";

if($_GET)
{
    
    if(isset($_GET["nik"]))
    {
        $id_eliminar=$_GET["nik"];
        
        $arr_existe=array();
        $arr_existe=$objTipoAnalisisLab->BuscarTipoAnalisisLaboratorio($id_eliminar,"");
        if(count($arr_existe)>0)
        {
            $affected=$objTipoAnalisisLab->EliminarTipoAnalisisLaboratorio($id_eliminar);
            if($affected==0){$msg="No se encontro el Tipo de Análisis";}
            else {$msg="Se eliminaron los datos correctamente";}
        }
        else 
        {
            $msg="El Tipo de Análisis que desea eliminar no existe";
        }
        echo "<script>window.location = 'listar_tipoanalisislaboratorio.php';</script>";
    }
}

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-flask"> Listado de Grupos de Análisis</i></h3>
          <div class="text-left">
              <a href='creartipoanalisislaboratorio.php' class="btn btn-success" type="submit">Nuevo Grupo de Análisis</a>
         </div>
          <br>
          <table id="example" class="table table-striped table-hover display table-responsive " style="right: 10px;">
              <thead>
                  <tr>
                      <th>Nro</th>
                      <th>Grupo de Análisis</th>
                                                                  
                      <th>Acci&oacute;n</th>
                  </tr>
              </thead>
              <tbody>
                 <?php 
                 $link_edit="editartipoanalisislaboratorio.php";
                 $link_listar="";
                 for ($i = 0; $i < count($list_tipoanalisis); $i++) 
                 {
                     $nro=$i+1;
                    echo "<tr>";
                    echo "<td>".$nro."</td>";
                    echo "<td>".$list_tipoanalisis[$i]->getTipoAnalisis()."</td>";
                    echo '<td>
                             <a href="'.$link_edit.'?nik='.$list_tipoanalisis[$i]->getIdTipoAnalisisLaboratorio().'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                             <a href="'.$link_listar.'?action=delete&nik='.$list_tipoanalisis[$i]->getIdTipoAnalisisLaboratorio().'&v='.$list_tipoanalisis[$i]->getTipoAnalisis().'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos de '.$list_tipoanalisis[$i]->getTipoAnalisis().' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                     </td>';
                    echo "</tr>";
                 }
                 ?>
              </tbody>
          </table>
        </div>
    </div>
</section>

