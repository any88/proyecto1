<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/NombreAnalisisLaboratorioController.php';
include '../modelo/TipoAnalisisLaboratorioController.php';

$objNombreAnalisis=new NombreAnalisisLaboratorioController();
$list_nombreanalisis=$objNombreAnalisis->MostrarNombreAnalisis();
$objTipoAnalisisLab= new TipoAnalisisLaboratorioController();
$list_tipoanalisis= $objTipoAnalisisLab->MostrarTipoAnalisisLaboratorio();
$msg="";

if($_GET)
{
    if(isset($_GET["nik"]))
    {
        $id_eliminar=$_GET["nik"];      
        $arr_existe=array();
        $arr_existe=$objNombreAnalisis->BuscarNombreAnalisis($id_eliminar,"", "");
        if(count($arr_existe)>0)
        {
            $affected=$objNombreAnalisis->EliminarNombreAnalisis($id_eliminar);
            if($affected==0){$msg="No se encontro el análisis";}
            else {$msg="Se eliminaron los datos correctamente";}
        }
        else 
        {
            $msg="El análisis que desea eliminar no existe";
        }
        echo "<script>window.location = 'listar_analisislaboratorio.php';</script>";
    }
}

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-flask"> Listado de Análisis de Laboratorio</i></h3>
          <div class="text-left">
              <a href='crearanalisislaboratorio.php' class="btn btn-success" type="submit">Nuevo Análisis de Laboratorio</a>
         </div>
          <br>
          <table id="example" class="table table-striped table-hover display table-responsive " style="right: 10px;">
              <thead>
                  <tr>
                      <th>Nro</th>
                      <th>Nombre</th>
                      <th>Grupo del Análisis</th>
                                            
                      <th>Acci&oacute;n</th>
                  </tr>
              </thead>
              <tbody>
                 <?php 
                 $link_edit="editaranalisislaboratorio.php";
                 $link_listar="";
                 for ($i = 0; $i < count($list_nombreanalisis); $i++) 
                 {
                     $nro=$i+1;
                    echo "<tr>";
                    echo "<td>".$nro."</td>";
                    echo "<td>".$list_nombreanalisis[$i]->getNombreanalisis()."</td>";
                    for ($j=0; $j < count ($list_tipoanalisis); $j++)
                    {
                        if($list_nombreanalisis[$i]->getIdtipoanalisis()==$list_tipoanalisis[$j]->getIdTipoAnalisisLaboratorio())
                        {
                        echo "<td>".$list_tipoanalisis[$j]->getTipoAnalisis()."</td>";
                        }
                    }
                    
                    echo '<td>
                             <a href="'.$link_edit.'?nik='.$list_nombreanalisis[$i]->getIdnombreanalisis().'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                             <a href="'.$link_listar.'?action=delete&nik='.$list_nombreanalisis[$i]->getIdnombreanalisis().'&v='.$list_nombreanalisis[$i]->getNombreanalisis().'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos '.$list_nombreanalisis[$i]->getNombreanalisis().' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                     </td>';
                    echo "</tr>";
                 }
                 ?>
              </tbody>
          </table>
        </div>
    </div>
</section>
