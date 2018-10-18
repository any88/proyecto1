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
include '../modelo/ConsultaController.php';
include '../modelo/CirugiaController.php';
include '../modelo/HospitalizacionController.php';
include '../modelo/LaboratorioController.php';
include '../modelo/RadiologiaController.php';
include '../modelo/CamaController.php';

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
$objHospitalizacion=new HospitalizacionController();
$objCamaC=new CamaController();
$lista_pac_hospitalizados=array();
$a=0;
$nomb_pac_hosp="";
$fecha_ingreso="";
$fecha_alta="";
$id_hospitalizacion_creado="";
$nro_cama="";

$msg="";

$p_id_hosp="";
$p_n_paciente="";
$p_fecha_alta="";
$p_fecha_ingreso="";
if($_POST)
{  
    if(isset($_POST['id_hosp']))
   {
        if(isset($_POST['nomb_pac'])){$p_n_paciente=$_POST['nomb_pac'];}
        if(isset($_POST['fecha_alta'])){$p_fecha_alta=$_POST['fecha_alta'];}
        if(isset($_POST['fecha_ingreso'])){$p_fecha_ingreso=$_POST['fecha_ingreso'];}
        $p_id_hosp=$_POST['id_hosp'];
        if($p_fecha_alta=="")
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error! Usted debe de asignar una fecha de alta.</div>";
        }
        else
        {
            if(CompararFechas($p_fecha_alta, $p_fecha_ingreso)==1)
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! La fecha de alta no puede ser menor que la fecha de ingreso ( $p_fecha_alta menor que  $p_fecha_ingreso )</div>";
            }
            else
            {
                $arrHosp=$objHospitalizacion->BuscarHospitalizacion($p_id_hosp, "");
                if(count($arrHosp)>0)
                {
                    $p_num_cama=$arrHosp[0]->getNroCama();
                    $affected=$objCamaC->ModificarEstadoCama($p_num_cama, 0);
                    if($affected==1)
                    {
                        $aff=$objHospitalizacion->AltaPaciente($p_id_hosp,$p_fecha_alta);
                        if($aff==1)
                        {
                            $msg="<div class='alert alert-success alert-dismissable'>"
                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                            . "OK! Se ha dado de alta al paciente $p_n_paciente.</div>";
                        }
                        else
                        {
                            $msg="<div class='alert alert-danger alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "Error! No se pudo dar el alta de hospitalizacion al paciente $p_n_paciente.</div>";
                        }

                    }
                    else
                   {
                        $msg="<div class='alert alert-danger alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "Error! No se pudo modificar el estado de la cama $p_num_cama.</div>";
                   }
                }
            }
            
        }
        
   
   }
}
$arrServH=$objServicioC->BuscarServicio("", 3, "");
if(count($arrServH)>0)
{
    for ($j = 0; $j < count($arrServH); $j++) 
    {
        $id_servicio=$arrServH[$j]->getIdServicio();
        $arrHosp=$objHospitalizacion->BuscarHospitalizacion("", "",$id_servicio);
        
        if(count($arrHosp)>0)
        {           
            $fecha_ingreso=$arrHosp[0]->getFechaIngreso();
            $fecha_alta=$arrHosp[0]->getFechaAlta();
            if($fecha_alta=="0000-00-00" || CompararFechas($fecha_alta,FechaYMA())==0)
            {
                $id_hospitalizacion_creado=$arrHosp[0]->getIdHospitalizacion();
                $nro_cama=$arrHosp[0]->getNroCama();
                $arrPacServH=$objPacienteServC->BuscarPacienteServicio("", "", $id_servicio);

                if(count($arrPacServH)>0)
                {
                    $id_pacienteh=$arrPacServH[0]->getIdpaciente();
                    $arrPaciente=$objPaciente->BuscarPaciente("", "", "", $id_pacienteh);
                    if(count($arrPaciente)>0)
                    {
                        $nomb_pac_hosp=$arrPaciente[0]->getNombre();
                    }
                    $lista_pac_hospitalizados[$a]['nombre_pac']=$nomb_pac_hosp;
                    $lista_pac_hospitalizados[$a]['fecha_ingreso']=$fecha_ingreso;
                    $lista_pac_hospitalizados[$a]['id_hosp']=$id_hospitalizacion_creado;
                    
                    $f= FechaYMA();
                    if($fecha_alta!="0000-00-00"){$f=$fecha_alta;}
                    $lista_pac_hospitalizados[$a]['duracion']= DuracionHosp($fecha_ingreso, $f);
                    $lista_pac_hospitalizados[$a]['nro_cama']=$nro_cama;

                    $a++;
                }
            }
            
            
        }
        
        
    }

}
?>
<br><br>
<section class="about-text">
    <div class="container ">
        <div class="col-md-12">
          
          <div class="row">
          <?php if($msg!=""){echo $msg;}?>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"> <b class="text-info"> <i class="fa fa-bed"></i> Pacientes Hospitalizados</b></div>
            <div class="panel-body">
                <table class='table table-responsive' id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Nro.Cama</th>
                            <th>Nombre</th>
                            <th>Fecha Ingreso</th>
                            <th>Dias Hospitalizados</th>
                            <th>Acci&oacute;n</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            for ($i = 0; $i < count($lista_pac_hospitalizados); $i++) 
                            {
                                $id_hosp_bd=$lista_pac_hospitalizados[$i]['id_hosp'];
                                $nomb_pac_hosp_bd=$lista_pac_hospitalizados[$i]['nombre_pac'];
                                $fecha_ingreso_bd=$lista_pac_hospitalizados[$i]['fecha_ingreso'];
                                $duracion_bd=$lista_pac_hospitalizados[$i]['duracion'];
                                $nro_cama_bd=$lista_pac_hospitalizados[$i]['nro_cama'];
                               
                                echo "<tr>";
                                echo "<td>$nro_cama_bd</td>";
                                echo "<td>$nomb_pac_hosp_bd</td>";
                                echo "<td>$fecha_ingreso_bd</td>";
                                echo "<td>$duracion_bd dias</td>";
                                echo "<td> "
                                                              
                                . "<a href='mostrar_hospitalizacion.php?nik=$id_hosp_bd' class='btn btn-primary btn-xs'><i class='fa fa-eye'></i></a>" ;
                                
                                echo " <button type='button' title='Dar Alta' class='btn btn-success btn-xs' data-toggle='modal' data-target='#divModalAlta'><i class='fa fa-medkit'></i></button>";
                                echo "</tr>";
                                
                            } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
    
</div>
        </div>
    </div>
</section>

<!--Modal Alta paciente -->
<div class="col-lg-12">
   
        <div class="modal fade" id="divModalAlta" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="pacientes_hospitalizados.php" name="fp">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #004731;"> 
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <img src='../img/clinica_logo.png' id="logo" class="pull-left" style="width: 50px; margin-top: -10px;">
                            <h4 class="modal-title" id="H1" style="color: white;">Seleccione la Fecha de Alta</h4>
                        </div>
                        
                        <div class="modal-body">
                            <input type='hidden' name='id_hosp' value='<?php echo $id_hosp_bd;?>'>
                            <input type='hidden' name='nomb_pac' value='<?php echo $nomb_pac_hosp_bd;?>'>
                            <input type='hidden' name='fecha_ingreso' value='<?php echo $fecha_ingreso_bd;?>'>
                            <input type="date" name="fecha_alta" class="form-control">
                        </div>
                        
                        <div class="modal-footer">
                            <button  type="submit" class="btn btn-success">Adicionar</button>
                            <button class="btn btn-danger " data-dismiss="modal" id="m_em">Cancelar</button>
                        </div>
                        
                       </div> 
                     </form>
                    </div>
                </div>
            </div>
</div>

<?php include './footer.html';?>