<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include '../modelo/consultas_genericas.php';
include './header.php';

include '../modelo/PacienteServicioController.php';
include '../modelo/PacienteController.php';
include '../modelo/ServicioController.php';
include '../modelo/MedicoController.php';
include '../modelo/TipoServicioController.php';
include '../modelo/TransaccionController.php';

$objPacienteServC=new PacienteServicioController();
$objPaciente=new PacienteController();
$objMedicoC=new MedicoController();
$objServicioC=new ServicioController();
$objTipoServicio=new TipoServicioController();
$objTransaccion=new TransaccionController();

if($_GET)
{
    
    if(isset($_GET["nik"]))
    {
        $id_eliminar=$_GET["nik"];
        
        $arr_existe=array();
        $arr_existe=$objServicioC->BuscarServicio($id_eliminar, "", "");
        if(count($arr_existe)>0)
        {
            $affected=$objPaciente->EliminarPaciente($id_eliminar);
            if($affected==0){$msg="No se encontro el paciente";}
            else {$msg="Se eliminaron los datos correctamente";}
        }
        else 
        {
            $msg="EL Servicio que desea eliminar no existe";
        }
        echo "<script>window.location = 'cobros_pendientes.php';</script>";
    }
}

$list_pacientes=array();
$list_pacientes=$objPacienteServC->MostrarPacienteServicio();

include './menu_caja.php';
?>
<br><br>
<section class="about-text">
    <div class="ingres_costo ">
      
        <div class="">
          <h3 class="text-left"><i class="fa fa-user text-info"> Listado de Cobros Pendientes</i></h3>
        </div>
        <?php 
        if(count($list_pacientes)>0)
        {
            echo "<table class='table table-responsive' id='dataTables-example'>";
            
            echo "<thead>";
            echo "<tr>";
                echo "<th>Nro.</th>";
                echo "<th>Paciente</th>";
                echo "<th>Doc. Id</th>";
                echo "<th>Num. HC</th>";
                echo "<th>Servicio</th>";
                echo "<th>Estado</th>";
                echo "<th>Precio Plan</th>";
                echo "<th>Pago Real</th>";
                echo "<th>Acci&oacute;n</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
                 $link_edit="editarpaciente.php";
                 $link_listar="";
                 $link_servicio="addservicios.php";
                 $link_mostrar="mostrarpaciente.php";
                 $total_plan=0;
                 $total_real=0;
                 for ($i = 0; $i < count($list_pacientes); $i++) 
                 {
                     $nro=$i+1;
                     $idps=$list_pacientes[$i]->getIdps();
                     $idPaciente=$list_pacientes[$i]->getIdpaciente();
                     $idservicio=$list_pacientes[$i]->getIdservicio();
                     $id_transaccion=$list_pacientes[$i]->getIdtransaccion();
                     $nombrePaciente="";
                     $nombre_servicio="";
                     $docID="";
                     $numhc="";
                     $estado="";
                     $precio_plan=0;
                     $pago_real=0;
                     $arrP=$objPaciente->BuscarPaciente("", "", "", $idPaciente);
                     if(count($arrP)>0)
                     {
                         $nombrePaciente=$arrP[0]->getNombre();
                         $numhc=$arrP[0]->getNumeroHC();
                         $docID=$arrP[0]->getDocID();
                     }
                     $arrServ=$objServicioC->BuscarServicio($idservicio, "", "");
                     if(count($arrServ)>0)
                     {
                         $precio_plan=$arrServ[0]->getPrecio();
                         $id_ts=$arrServ[0]->getIdTipoServicio();
                         $total_plan=$precio_plan+$total_plan;
                         
                         $arrTS=$objTipoServicio->BuscarTipoServicio($id_ts, "");
                         if(count($arrTS)>0)
                         {
                             $nombre_servicio=$arrTS[0]->getTipoServicio();
                         }
                     }
                     
                     $arrTrans=$objTransaccion->BuscarTransaccion($id_transaccion, "", "");
                     
                     if($id_transaccion==""){$estado="PENDIENTE";}
                     else
                     {
                        if(count($arrTrans)>0)
                        {
                            $pago_real=$arrTrans[0]->getMonto();
                            if($pago_real==0 ||$pago_real==""){$estado="PENDIENTE";}
                            if($pago_real>0 && $pago_real<$precio_plan && $pago_real!=""){$estado="PARCIAL";}
                            $total_real=$pago_real+$total_real;
                        } 
                     }
                    if($pago_real<$precio_plan || $precio_plan==0)
                    { 
                    echo "<tr>";
                    echo "<td>".$nro."</td>";
                    echo "<td>".$nombrePaciente."</td>";
                    echo "<td>".$docID."</td>";
                    echo "<td>".$numhc."</td>";
                    echo "<td>".$nombre_servicio."</td>";
                    echo "<td>".$estado."</td>";
                    echo "<td>s/. $precio_plan</td>";
                    echo "<td>s/. $pago_real</td>";
                   /* echo '
                    <td>
                    
                             <a href="transaccion_caja.php?nik='.$id_transaccion.'" title="Pagar servicios" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></a>

                             <a href="'.$link_listar.'?action=delete&nik='.$idservicio.'&v='.$nombre_servicio.'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos  de el paciente '.$nombre_servicio.' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                 
                             <a href="'.$link_mostrar.'?nik='.$idPaciente.'" title="Mostrar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>'
                 . '</td>';*/
                    echo '<td>'; 
                     echo "<div style='margin-left:25px;'><form action='transaccion_caja.php' name='f$i' method='post' >";                       
                        echo "<input type='hidden' name='idt' value='$idps'>";
                        echo "<button type='submit' title='Efectuar pago' class='btn btn-success  btn-xs'> <i class='fa fa-dollar'></i></button>";
                    echo "</form></div>";
                    echo '</td>';
                   echo "</tr>";
                    }
                 }
                 
              echo "</tbody";
              
            echo "</table>";
        }
        else 
        {
            echo "<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "La clinica no presenta cobros penientes...</div>";
        }
        
        ?>
    </div>
</section>

