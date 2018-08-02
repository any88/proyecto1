<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/PacienteController.php';
include '../modelo/ServicioController.php';
include '../modelo/TipoServicioController.php';
include '../modelo/TransaccionController.php';
include '../modelo/PacienteServicioController.php';

$objServicio=new ServicioController();
$objPacienteServ=new PacienteServicioController();
$objTransaccion=new TransaccionController();
$objPaciente=new PacienteController();
$objTS=new TipoServicioController();

$datos=array();
$list_serv=$objPacienteServ->ServiciosDelDia();

##variables
$p_id_servicio="";
$p_estado="";
$msg="";
$mes= MesActual();
$m= Meses();
$nombre_mes=$m[$mes];
if($_POST)
{    
    if(isset($_POST['id_servicio'])){$p_id_servicio=$_POST['id_servicio'];}
    if(isset($_POST['estado'])){$estado=$_POST['estado'];}
    
    if(eliminarblancos($p_id_servicio)!="")
    {
        if(eliminarblancos($p_estado)!="PAGO")
        {
            ##si existe lo elimino
            $arrExiste=$objServicio->BuscarServicio($p_id_servicio, "", "");
            if(count($arrExiste)>0)
            {
                $affected=$objServicio->EliminarServicio($p_id_servicio);
            if($affected==1)
                {
                    $msg="<div class='alert alert-success alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "OK! El servicio ha sido eliminado correctamente.</div>";
                }
                else
                {
                   $msg="<div class='alert alert-danger alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "Error! No se puede eliminar el servicio seleccionado.</div>";

                }
            }
        }
        else
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se puede eliminar el servicio seleccionado pues ya se ha registrado un pago para este servicio.Usted debe primero elimiar la transacci&oacute;n y luego els ervicio.</div>";
        }
    }
}
$datos=array();
$list_serv=$objPacienteServ->ServiciosDelDia();
?>

<br><br>
<section class="about-text">
    <div class="container ">
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user text-info"> Listado de servicios del Mes de <?php echo $nombre_mes;?></i></h3>
        </div>
        <br><br>
        <?php if($msg!=""){echo $msg;}?>
        <table class='table table-responsive table-hover' id='dataTables-example'>
            <thead>
                <tr>
                    <th>Nro</th>
                    <th>Fecha</th>
                    <th>Servicio</th>
                    <th>Paciente</th>
                    <th>Precio</th>
                    <th>Estado Transacci&oacute;n</th>
                    <th>Acci&oacute;n</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                
                for ($i = 0; $i < count($list_serv); $i++) 
                {
                    $id_serviciobd=$list_serv[$i]->getIdservicio();
                    $id_tipo_servbd="";
                    $preciobd="";
                    $estado="PAGO";
                    $nombre_paciente="";
                    $nombre_servicio="";
                    $fecha_servicio=$list_serv[$i]->getFecha();
                    $nro=$i+1;
                    $idPaciente=$list_serv[$i]->getIdpaciente();
                    $arrPacietnes=$objPaciente->BuscarPaciente("", "", "", $idPaciente);
                        if(count($arrPacietnes)>0){$nombre_paciente=$arrPacietnes[0]->getNombre();}
                    $id_transaccionebd=$list_serv[$i]->getIdtransaccion();
                        if($id_transaccionebd==""){$estado="PENDIENTE";}    
                    $arr_servicios=$objServicio->BuscarServicio($id_serviciobd, "", "");
                    if(count($arr_servicios)>0)
                    {
                       $preciobd=$arr_servicios[0]->getPrecio();
                       $id_tipo_servbd=$arr_servicios[0]->getIdTipoServicio();
                       $arrTipoServicios=$objTS->BuscarTipoServicio($id_tipo_servbd, "");
                       if(count($arrTipoServicios)>0){$nombre_servicio=$arrTipoServicios[0]->getTipoServicio();}
                    
                    }

                    
                    echo '<tr>';
                    echo "<td>$nro</td>";
                     echo "<td>$fecha_servicio</td>";
                    echo "<td>$nombre_servicio</td>";
                    echo "<td>$nombre_paciente</td>";
                    echo "<td>s/. $preciobd</td>";
                    echo "<td>$estado</td>";
                    echo '<td>'; 
                    echo "<form name='f' method='post' action='listar_servicios.php' id='f$i'>";
                    echo "<input type='hidden' name='id_servicio' value='$id_serviciobd'>";
                    echo "<input type='hidden' name='estado' value='$estado' id='estado$i'>";
                    echo "<input type='hidden' name='nombre_servicio' value='$nombre_servicio' id='nombre_serv$i'>";
                    echo "<input type='hidden' name='nombre_paciente' value='$nombre_paciente' id='nombre_pac$i'>";
                    echo "<button type='button'class='btn btn-danger btn-xs' id='$i' onclick='EliminarServicio(this.id);' title='Eliminar Servicio'> <i class='fa fa-trash'></i> </button> ";
                    echo "<a href='pago_servicio.php?nik=$id_serviciobd' class='btn btn-success btn-xs' title='Efectuar Pago'> <i class='fa fa-dollar  '> </i> </a>";
                    echo "</form>";
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</section>
