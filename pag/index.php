<?php
/*if($h_id_tipo_usuario!=1)
{
    echo "<script>";
    echo "alert('Usted no tiene acceso a para acceder!!!');";  
    echo "window.location = 'index_user.php';";
    echo "</script>";
}*/
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include '../modelo/consultas_genericas.php';
include './header.php';
include '../modelo/PacienteServicioController.php';
include '../modelo/PacienteController.php';
include '../modelo/ServicioController.php';
include '../modelo/MedicoController.php';
include '../modelo/TipoServicioController.php';
include '../modelo/ConsultaController.php';
include '../modelo/CirugiaController.php';
include '../modelo/HospitalizacionController.php';
include '../modelo/LaboratorioController.php';
include '../modelo/RadiologiaController.php';

$objPacienteServC=new PacienteServicioController();
$objPaciente=new PacienteController();
$objMedicoC=new MedicoController();
$objServicioC=new ServicioController();
$objTipoServicio=new TipoServicioController();
$objConsulta=new ConsultaController();
$objCirugia= new CirugiaController();
$objHospitalizacion= new HospitalizacionController();
$objRadiologia= new RadiologiaController();
$objLaboratorio= new LaboratorioController();

$listaPacientesDelDia=array();
$listaPacientesDelDia=$objPacienteServC->ServiciosDelDia();
?>

  <section id="services">
  
 

<div class="container">
<div class="row">
    
    <div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading"><b> <i class="fa fa-search"></i> Buscar Paciente</b> <a href="crearpaciente.php" title='Nuevo Paciente' class="pull-right btn btn-success btn-xs"><i class=" fa fa-plus"></i></a></div>
        <div class="panel-body">
            <form name="fsearch" method="post" action="buscar_paciente.php">
                <label>Buscar por Nombre</label>
                <input type="text" name="nombre_paciente" placeholder="Nombre paciente" class="form-control">
                <label>Buscar por N&uacute;mero Historia Cl&iacute;nica</label>
                <input type="text" name="nhc" placeholder="N&uacute;meroHC" class="form-control">
                <label>Buscar por Documento de Identidad</label>
                <input type="text" name="docid" placeholder="Documento de Identidad" class="form-control">
                <br>
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary"> Buscar</button>
                </div>
            </form>
            
        </div>
        
    </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><b>Servicios Agendados Para Hoy (<?php echo FechaYMA();$fecha_agenda=FechaYMA();?>)</b> <a href="agendaclinica.php" title='Ver agenda' class="pull-right btn btn-primary btn-xs"><i class=" fa fa-calendar"></i></a></div>
           <div class="panel-body">
               
                       <?php 
                       if(count($listaPacientesDelDia)>0)
                       {
                           echo "<table class='table table-responsive' id='dataTables-example'>";
                            echo "<thead>";
                                echo "<tr>";
                                     echo "<th>Nro.</th>";
                                     echo "<th>Servicio</th>";
                                     echo "<th>Paciente</th>";
                                     echo "<th>Acci&oacute;n</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            for ($i = 0; $i < count($listaPacientesDelDia); $i++) 
                            {
                                $id_servicio=$listaPacientesDelDia[$i]->getIdservicio();
                                $id_paciente=$listaPacientesDelDia[$i]->getIdpaciente();
                                $nomb_paciente="";
                                $arrPacientes=$objPaciente->BuscarPaciente("", "", "", $id_paciente);
                                if(count($arrPacientes)>0)
                                {
                                    $nomb_paciente=$arrPacientes[0]->getNombre();
                                }
                                $arrServicios=$objServicioC->BuscarServicio($id_servicio, "", "");
                                $nomb_servicio="";
                                if(count($arrServicios)>0)
                                {
                                    $id_tipo_servicio=$arrServicios[0]->getIdTipoServicio();
                                    $link="";
                                    $nik="";
                                    if($id_tipo_servicio==1)
                                    {
                                        $link="mostrar_consulta.php";
                                        $arrCons=$objConsulta->BuscarConsulta("", "", $id_servicio);
                                        if(count($arrCons)>0)
                                            {
                                                $nik=$arrCons[0]->getIdConsulta();
                                            }
                                    }
                                    if($id_tipo_servicio==2)
                                    {
                                        $link="mostrar_cirugia.php";
                                        $arrCir=$objCirugia->BuscarCirugia("", "", "", $id_servicio);
                                        if(count($arrCir)>0)
                                            {
                                                $nik=$arrCir[0]->getIdCirugia();
                                            }
                                    }
                                    if($id_tipo_servicio==3)
                                    {
                                        $link="mostrar_hospitalizacion.php";
                                        $arrHosp=$objHospitalizacion->BuscarHospitalizacion("", "", $id_servicio);
                                        if(count($arrCir)>0)
                                            {
                                                $nik=$arrCir[0]->getIdCirugia();
                                            }
                                    }
                                    if($id_tipo_servicio==4)
                                    {
                                        $link="mostrar_radiologia.php";
                                        $arrRad=$objRadiologia->BuscarRadiologia("", "", "", $id_servicio);
                                        if(count($arrRad)>0)
                                            {
                                                $nik=$arrRad[0]->getIdRadiologia();
                                            }
                                    }
                                    if($id_tipo_servicio==5)
                                    {
                                        $link="mostrar_laboratorio.php";
                                        $arrLab=$objLaboratorio->BuscarLaboratorio("", "", "", $id_servicio);
                                        if(count($arrLab)>0)
                                            {
                                                $nik=$arrLab[0]->getIdLaboratorio();
                                            }
                                    }

                                    $arrTipoServicio=$objTipoServicio->BuscarTipoServicio($id_tipo_servicio, "");
                                    if(count($arrTipoServicio)>0)
                                    {
                                        $nomb_servicio=$arrTipoServicio[0]->getTipoServicio();  
                                    }


                                }
                                $nro=$i+1;
                                echo "<tr>";
                                echo "<td>$nro</td>";
                                echo "<td>$nomb_servicio</td>";
                                echo "<td>$nomb_paciente</td>";
                                echo '
                                <td>
                                         <a href="editarpaciente.php?nik='.$id_paciente.'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                                         <a href="listar_pacientes.php?action=delete&nik='.$id_paciente.'&v='.$nomb_paciente.'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos  de el paciente '.$nomb_paciente.' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>

                                         <a href=" '.$link.'?nik='.$nik.'" title="Mostrar datos" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>

                                         '
                             . '</td>';
                                echo "</tr>";
                            }
                             echo "</tbody>";
                             echo "</table>";
                       }
                       else 
                       {
                           echo "<h3>No hay pacientes agendados para hoy.</h3>";
                       }
                       
                       ?>
                   
            
           </div>
            
        </div>
    </div>
</div>
    <div class="col-md-12"></div>
    
  </div>
  </section>
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
<?php

include './footer.html';
?>
<script>
    /**Este es el código que le da la funcionalidad a la modal*/
$('.btnModal').on("click", function(event) {
    event.preventDefault();
 
    var $contenedorModal = $('#myModal');
    var urlModal         = $(this).attr("href");
    var idModal          = $(this).data("idmodal");
 
    $contenedorModal.load(urlModal + ' ' + idModal , function(response) {
    $(this).modal({backdrop: "static"});
    });
});


</script>





