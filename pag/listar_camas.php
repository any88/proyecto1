<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/CamaController.php';
$objCamaC=new CamaController();

$msg="";
if($_POST)
{
    if(isset($_POST['idcama']))
    {
        $p_idcama=$_POST['idcama'];
        ##verificar que la cama no este ocupada
        $datosCama=$objCamaC->BuscarCama($p_idcama, "", "");
        if(count($datosCama)>0)
        {
            $p_estado=$datosCama[0]->getEstado();
            $p_nro_cama=$datosCama[0]->getNum_cama();
            if($p_estado==1)
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se puede eliminar la cama $p_nro_cama pues se encuentra ocupada en estos momentos.</div>";
            }
            else 
            {
                $aff=$objCamaC->EliminarCama($p_idcama);
                if($aff==0)
                {
                    $msg="<div class='alert alert-danger alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "Error! No se puede eliminar la cama en etos momentos.</div>";
                }
                else 
                {
                    $msg="<div class='alert alert-success alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "OK! Cama eliminada correctamente.</div>";
                }
            }
        }
    }
}
$lista_camas=$objCamaC->MostrarCamas();
?>
<br><br>
<section class="about-text">
    <div class="container ">
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user text-info"> Listado de Camas</i></h3>
          <a href='nueva_cama.php' class="btn btn-success">Nueva Cama</a>
          <br><br>
          <?php
            if($msg!=""){echo $msg;}
          ?>
          <table class="table table-responsive display" id="dataTables-example">
              <thead>
                  <tr>
                      <th>Nro. Cama</th>
                      <th>Estado</th>
                      <th>Acci&oacute;n</th>
                  </tr>
              </thead>
              <tbody>
                  <?php 
                  for ($i = 0; $i < count($lista_camas); $i++) 
                  {
                    $id_cama=$lista_camas[$i]->getId_cama();
                    $nro_cama=$lista_camas[$i]->getNum_cama();
                    $estado=$lista_camas[$i]->getEstado();
                   
                    if($estado==0){$nomb_estado="DISPONIBLE";}
                    else { $nomb_estado="OCUPADO";}
                    echo '<tr>';
                        echo "<td>$nro_cama</td>";
                        echo "<td>$nomb_estado</td>";
                        echo "<td>";
                        echo "<form name='f$i' method='post' action='listar_camas.php'>";
                            echo "<input type='hidden' name='idcama' value='$id_cama'>";
                            //echo "<a href='editar_camas.php?nik=$id_cama' class='btn btn-success'><i class='fa fa-edit'></i></a>";
                            echo " <button class='btn btn-danger'><i class='fa fa-trash'></i></button>";
                        echo "</form>";
                        echo "</td>";
                    echo '</tr>';
                  }
                  ?>
              </tbody>
          </table>
          <div class="pull-right">
              <a href="nomencladores.php" class="btn btn-danger">Cancelar</a>
          </div>
        </div>
    </div>
</section>


