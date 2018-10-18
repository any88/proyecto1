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

$lista_meses= Meses();
$nmes= MesActual();
$anno_actual= AnnoActual();
$mmm=$nmes;
if($nmes<10){$mmm='0'.$nmes;}
$fecha=$anno_actual.'-'.$mmm;
$list_serv=$objPacienteServ->AgendaClinica($fecha);
##variables
$p_id_servicio="";
$p_estado="";
$msg="";


if($_POST)
{    
    if(isset($_POST['mes_listS']))
    {
        $nmes=$_POST['mes_listS'];
        if(isset($_POST['anno_listS'])){$anno_actual=$_POST['anno_listS'];}
        $mmm=$nmes;
        if($nmes<10){$mmm='0'.$nmes;}
        $fecha=$anno_actual.'-'.$mmm;
        $list_serv=$objPacienteServ->AgendaClinica($fecha);
       
    }
 else 
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
    
}


?>

<br><br>
<section class="about-text">
    <div class="container ">
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user text-info"> Listado de servicios del Mes de </i>
              <form name="fsearch" method="post" action="listar_servicios.php">
                  <select name="mes_listS" class="form-control" style="width: 200px; margin-left: 368px;margin-top: -25px;">
                  
                  <?php 
                  for ($i = 1; $i <= count($lista_meses); $i++) 
                  {
                    
                    if($nmes==$i)
                    {
                        echo "<option value='$i' selected='selected'> $lista_meses[$i]</option>";
                    }
                    else {echo "<option value='$i'> $lista_meses[$i]</option>";}
                    
                    
                  }
                  ?>
              </select>
              <input type="number" name='anno_listS' min="2010" max="2100" value="<?php echo $anno_actual;?>" class="form-control" style="width: 200px; margin-left: 571px;margin-top: -35px;">
              <button type="submit" class="btn btn-success" style="width: 100px; margin-left: 773px;margin-top: -65px;"/><i class="fa fa-search"></i>Buscar</button>
              </form>
               </h3>
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
                    $idps=$list_serv[$i]->getIdps();
                    $id_serviciobd=$list_serv[$i]->getIdservicio();
                    $id_tipo_servbd="";
                    $preciobd="";
                    $montotransaccion="";
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
                        if($id_transaccionebd!=""){$montotransaccion=$objTransaccion->BuscarTransaccion($id_transaccionebd, "", "")[0]->getMonto();}
                        
                    $arr_servicios=$objServicio->BuscarServicio($id_serviciobd, "", "");
                    if(count($arr_servicios)>0)
                    {
                       $preciobd=$arr_servicios[0]->getPrecio();
                       $id_tipo_servbd=$arr_servicios[0]->getIdTipoServicio();
                       $arrTipoServicios=$objTS->BuscarTipoServicio($id_tipo_servbd, "");
                       if(count($arrTipoServicios)>0){$nombre_servicio=$arrTipoServicios[0]->getTipoServicio();}
                       if($montotransaccion<$preciobd && $montotransaccion>0){$estado="PARCIAL";}
                       
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
                    echo "</form>";
                     echo "<div style='margin-top:-23px; margin-left:25px;'><form action='transaccion_pacientes.php' name='f$i' method='post' >";                       
                        echo "<input type='hidden' name='idt' value='$idps'>";
                        echo "<button type='submit' title='Efectuar pago' class='btn btn-success  btn-xs'> <i class='fa fa-dollar'></i></button>";
                    echo "</form></div>";
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</section>
<?php include './footer.html'; ?>