<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/AseguradoraController.php';
include '../modelo/PacienteController.php';
include '../modelo/consultas_genericas.php';
include '../modelo/TransaccionController.php';
include '../modelo/ServicioController.php';
include '../modelo/PacienteServicioController.php';

$msg="";
$objAseguradora=new AseguradoraController();
$lista_aseguradoras=$objAseguradora->MostrarAseguradora();
$objPaciente=new PacienteController();
$objTransaccion=new TransaccionController();
$objServicio= new ServicioController();
$objPacienteServC=new PacienteServicioController();
$pacmod=array();
$id_pacmod="";
   
##variables
$nombre="";
$docID="";
$hc="";
$fecha_nac="";
$sexo="";
$aseguradora="";
$telefono="";
$ocupacion="";
$email="";
$direccion="";
$anamnesis="";
$tiempo_enfermedad="";
$id_aseguradora="";
$idclienteaseguradora="";
$gruposanguineo="";
$alergiamed="";
$lista_paciente_servicio=array();
$id_ps="";
$precio_real=0;
if(isset($_GET['nik']))
{
$id_pacmod=$_GET['nik'];
$pacmod=$objPaciente->BuscarPaciente("", "", "", $id_pacmod);

    if(count($pacmod)>0)
    {
        $nombre=$pacmod[0]->getNombre();
        $docID=$pacmod[0]->getDocID();
        $hc=$pacmod[0]->getNumeroHC();
        $sexo=$pacmod[0]->getSexo();
        $telefono=$pacmod[0]->getTelef();
        $email=$pacmod[0]->getEmail();
        $direccion=$pacmod[0]->getDireccion();
        $id_aseguradora=$pacmod[0]->getIdAseguradora();
        $ocupacion=$pacmod[0]->getOcupacion();
        $fecha_nac=$pacmod[0]->getFechaNac();
        $anamnesis=$pacmod[0]->getAnamnesis();
        $tiempo_enfermedad=$pacmod[0]->getTiempoDeEnfermedad();
        $edad=$pacmod[0]->GetEdadPaciente();
        $idclienteaseguradora=$pacmod[0]->getIdClienteAseguradora();
        $gruposanguineo=$pacmod[0]->getGrupoSanguineo();
        $alergiamed=$pacmod[0]->getAlergiaMed();
        
    }
   $cg=new ConsultasG();
   $p=array();
   $p['campo'][0]='idpaciente';
   $p['valor'][0]=$id_pacmod;
   $r=$cg->GenericSelect('paciente_servicio', $p);
   if($r)
   {
       $lista_paciente_servicio=$cg->ArregloAsociativoSelect($r, 'paciente_servicio');
      
   }
    
}
if($_POST)
{
    $p_id_servicio="";
    $p_estado="";
    if(isset($_POST['id_servicio'])){$p_id_servicio=$_POST['id_servicio'];}
    if(isset($_POST['estado'])){$estado=$_POST['estado'];}
    if(isset($_POST['id_paciente'])){$id_pacmod=$_POST['id_paciente'];}
    
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
                    echo "<script>";
                        echo "window.location = 'mostrarpaciente.php?nik=$id_pacmod';";
                   echo "</script>";

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
    
    if($id_pacmod!="")
    {
        $cg=new ConsultasG();
        $p=array();
        $p['campo'][0]='idpaciente';
        $p['valor'][0]=$id_pacmod;
        $r=$cg->GenericSelect('paciente_servicio', $p);
        if($r)
        {
            $lista_paciente_servicio=$cg->ArregloAsociativoSelect($r, 'paciente_servicio');

        }
    }
}

?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
       
              <?php 
              $sexoPaciente="M";
                $img="../img/paciente_masculino.png";
                if($sexoPaciente=="F"){$img="../img/paciente_femenino.png";}
                
                if($msg!=""){echo $msg;}
              ?>
              <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Historia Cl&iacute;nica # (<?php echo $hc;?>)</b>
                            <div class="pull-right">
                                <a href='addservicios.php?nik=<?php echo $id_pacmod;?>' class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Nuevo servicio</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#home" data-toggle="tab">Datos generales Paciente</a>
                                </li>
                                <li><a href="#profile" data-toggle="tab">Servicios</a>
                                </li>
                                
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="home">
                                    <h4>Datos generales del Paciente</h4>
                                    <table class="table table-responsive">
                                        <tr>
                                           <td rowspan='3' style='width:200px;'><img src='<?php echo $img;?>' title='Paciete' style='width:150px;'></td>
                                           <td><b>Nombre: </b><?php echo $nombre;?></td>
                                        </tr>
                                        <tr>

                                            <td><b>Edad: </b> <?php echo $edad;?></td>
                                        </tr>
                                        <tr>

                                            <td><b>Sexo: </b><?php echo $sexo;?></td>
                                        </tr>
                                        <tr >
                                            <td><input type="hidden" name="id_pacmod" value="<?php echo $id_pacmod;?>">
                                                <b>Documento Identidad: </b>
                                            </td>
                                            <td><?php echo $docID;?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Ocupaci&oacute;n: </b></td>
                                            <td><?php echo $ocupacion;?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Aseguradora: </b></td>
                                            <td>
                                                <?php 
                                                  $id_aseguradora=$pacmod[0]->getIdAseguradora();
                                                  for ($i = 0; $i < count($lista_aseguradoras); $i++) 
                                                  {
                                                     if($id_aseguradora==$lista_aseguradoras[$i]->getIdAseguradora())
                                                     echo $lista_aseguradoras[$i]->getNombre();
                                                  }
                                                    ?>    
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>ID de Cliente de Aseguradora: </b></td>
                                            <td><?php echo $idclienteaseguradora;?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Direcci&oacute;n: </b></td>
                                            <td><?php echo $direccion;?></td> 
                                        </tr>
                                        <tr>
                                            <td><b>Teléfono: </b></td>
                                            <td><?php echo $telefono;?></td>
                                        </tr>
                                        <tr>
                                            <td ><b>Email: </b></td>
                                            <td><?php echo $email;?></td>

                                        </tr>
                                        <tr>
                                            <td ><b>Grupo Sanguíneo: </b></td>
                                            <td><?php echo $gruposanguineo;?></td>

                                        </tr>
                                        <tr>
                                            <td ><b>Alergias Medicamentosas: </b></td>
                                            <td><?php echo $alergiamed;?></td>

                                        </tr>
                                        <tr>
                                            <td><b>Anamnesis: </b></td>
                                            <td><?php echo $anamnesis;?></td>
                                        </tr>

                                    </table>
                                    
                                </div>
                                <div class="tab-pane fade" id="profile">
                                    <h4>Servicios</h4>
                                    <div class="col-md-12">
                                        

                                            <table class="table table-responsive table-hover table-bordered" id='dataTables-example'>
                                          <thead>
                                              <tr>

                                                  <th>Tipo Servicio</th>
                                                  <th>Fecha</th>
                                                  <th>Hora</th>
                                                  <th>Precio Acordado</th>
                                                  <th>Pago real</th>
                                                  <th>Estado del servicio</th>
                                                  <th>Acci&oacute;n</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php 
                                                    for ($i = 0; $i < count($lista_paciente_servicio); $i++) 
                                                    {
                                                        $precio_real=0;
                                                        $nro=$i+1;
                                                        $id_ps=$lista_paciente_servicio[$i]['id_ps'];
                                                        $id_paciente_servicio=$lista_paciente_servicio[$i]['idservicio'];
                                                        $fecha=$lista_paciente_servicio[$i]['fecha'];
                                                        $hora=$lista_paciente_servicio[$i]['hora'];
                                                        $id_transaccionebd=$lista_paciente_servicio[$i]['idtransaccion'];
                                                        
                                                        if($id_transaccionebd!="")
                                                        {
                                                            $arrT=$objTransaccion->BuscarTransaccionPorId($id_transaccionebd);
                                                            if(count($arrT)>0)
                                                            {
                                                                $precio_real=$arrT[0]->getMonto();
                                                            }
                                                        }
                                                        $p=array();
                                                        $p['campo'][0]='idservicio';
                                                        $p['valor'][0]=$id_paciente_servicio;
                                                        $r=$cg->GenericSelect('servicio', $p);
                                                        $precio_servicio=0;
                                                        if($r)
                                                        {
                                                            $arr_servicios=$cg->ArregloAsociativoSelect($r, 'servicio');
                                                            if(count($arr_servicios)>0)
                                                            {
                                                                $precio_servicio=$arr_servicios[0]['precio'];
                                                            }
                                                        }
                                                        $nombre_tipo_servicio=$cg->GenericJoinV1('tiposervicio', 'servicio', 'tiposervicio', 'idtiposervicio', 'idservicio', $id_paciente_servicio, 'idtiposervicio');
                                                        $id_tipoS=$cg->GenericJoinV1('tiposervicio', 'servicio', 'idtiposervicio', 'idtiposervicio', 'idservicio', $id_paciente_servicio, 'idtiposervicio');
                                                        $link="#";
                                                        $nik="";
                                                        if($id_tipoS==1)
                                                        {
                                                            ##consultas
                                                            $link="mostrar_consulta.php";
                                                            ##buscar el id de la consulta
                                                            $p['campo'][0]='idservicio';
                                                            $p['valor'][0]=$id_paciente_servicio;
                                                            $r=$cg->GenericSelect('consulta', $p);

                                                            if($r)
                                                            {
                                                                $arr_consultas=$cg->ArregloAsociativoSelect($r, 'consulta');
                                                                if(count($arr_consultas)>0)
                                                                {
                                                                    $nik=$arr_consultas[0]['idconsulta'];
                                                                }
                                                            }

                                                        }
                                                        if($id_tipoS==2)
                                                        {
                                                            ##cirugia
                                                            $link="mostrar_cirugia.php";
                                                            ##buscar el id de la cirugia
                                                            $p['campo'][0]='idservicio';
                                                            $p['valor'][0]=$id_paciente_servicio;
                                                            $r=$cg->GenericSelect('cirugia', $p);

                                                            if($r)
                                                            {
                                                                $arr_cirugias=$cg->ArregloAsociativoSelect($r, 'cirugia');
                                                                if(count($arr_cirugias)>0)
                                                                {
                                                                    $nik=$arr_cirugias[0]['idcirugia'];
                                                                }
                                                            }

                                                        }
                                                        if($id_tipoS==3)
                                                        {
                                                            ##hospitalizacion
                                                            $link="mostrar_hospitalizacion.php";
                                                            ##buscar el id de la hosp
                                                            $p['campo'][0]='idservicio';
                                                            $p['valor'][0]=$id_paciente_servicio;
                                                            $r=$cg->GenericSelect('hospitalizacion', $p);

                                                            if($r)
                                                            {
                                                                $arr_hosp=$cg->ArregloAsociativoSelect($r, 'hospitalizacion');
                                                                if(count($arr_hosp)>0)
                                                                {
                                                                    $nik=$arr_hosp[0]['idhospitalizacion'];
                                                                }
                                                            }

                                                        }
                                                        if($id_tipoS==4)
                                                        {
                                                            ##radiologia
                                                            $link="mostrar_radiologia.php";
                                                            ##buscar el id de la prueba rad
                                                            $p['campo'][0]='idservicio';
                                                            $p['valor'][0]=$id_paciente_servicio;
                                                            $r=$cg->GenericSelect('radiologia', $p);

                                                            if($r)
                                                            {
                                                                $arr_rad=$cg->ArregloAsociativoSelect($r, 'radiologia');
                                                                if(count($arr_rad)>0)
                                                                {
                                                                    $nik=$arr_rad[0]['idradiologia'];
                                                                }
                                                            }

                                                        }
                                                        if($id_tipoS==5)
                                                        {
                                                            ##laboratorio
                                                            $link="mostrar_laboratorio.php";
                                                            ##buscar el id del analisis
                                                            $p['campo'][0]='idservicio';
                                                            $p['valor'][0]=$id_paciente_servicio;
                                                            $r=$cg->GenericSelect('laboratorio', $p);

                                                            if($r)
                                                            {
                                                                $arr_rad=$cg->ArregloAsociativoSelect($r, 'laboratorio');
                                                                if(count($arr_rad)>0)
                                                                {
                                                                    $nik=$arr_rad[0]['idlaboratorio'];
                                                                }
                                                            }

                                                        }

                                                        echo "<tr>";

                                                        echo "<td>$nombre_tipo_servicio</td>";
                                                        echo "<td>$fecha</td>";
                                                        echo "<td>$hora</td>";
                                                        echo "<td>s/. $precio_servicio</td>";
                                                        echo "<td>s/. $precio_real</td>";
                                                        $estado="<b class='text-danger'>PENDIENTE</b>";
                                                        IF($id_transaccionebd!=""){$estado="PAGO";}
                                                        echo "<td>$estado</td>";
                                                        echo"<td>";
                                                          echo "<form name='f$i' method='post' action='transaccion_pacientes.php'>";
                                                            echo "<a href='$link?nik=$nik' class='btn btn-primary  btn-xs' title='Mostrar Servicio'><i class='fa fa-eye'></i></a> ";
                                                            echo "<input type='hidden' name='idt' value='$id_ps'>";
                                                            echo "<button type='submit' title='Efectuar pago' class='btn btn-success  btn-xs'><i class='fa fa-dollar'></i></button>";
                                                            echo "</form>";
                                                           echo "<form method='post' action='mostrarpaciente.php' id='f$i' name='delf'  style='margin-top:-23px; margin-left:50px;'>";
                                                            $est="PENDIENTE";
                                                            if($estado=="PAGO"){$est="PAGO";}
                                                            echo "<input type='hidden' name='id_servicio' value='$id_paciente_servicio'>";
                                                            echo "<input type='hidden' name='id_paciente' value='$id_pacmod'>";
                                                            echo "<input type='hidden' name='estado' value='$est' id='estado$i'>";
                                                            echo "<input type='hidden' name='nombre_servicio' value='$nombre_tipo_servicio' id='nombre_serv$i'>";
                                                            echo "<input type='hidden' name='nombre_paciente' value='$nombre' id='nombre_pac$i'>";
                                                            echo "<button type='button'class='btn btn-danger btn-xs' id='$i' onclick='EliminarServicio(this.id);' title='Eliminar Servicio'><i class='fa fa-trash'></i> </button>";
                                                            echo "</form>";
                                                        echo "</td>";
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
    
        <div class="pull-right">
            <?php
            echo "<a href='#' class='btn btn-primary'>Imprimir</a> ";
            echo "<a href='editarpaciente.php?nik=$id_pacmod' class='btn btn-success'>Editar</a> ";
            echo "<a href='listar_pacientes.php' class='btn btn-danger'>Cancelar</a>";
            ?>
        </div>
        <br><br>

        </div>
        
</section>

<script>

// Select all tabs
$('.nav-tabs a').click(function(){
    $(this).tab('show');
})

// Select tab by name
$('.nav-tabs a[href="#home"]').tab('show')

// Select first tab
$('.nav-tabs a:first').tab('show')

// Select last tab
$('.nav-tabs a:last').tab('show')

// Select fourth tab (zero-based)
$('.nav-tabs li:eq(3) a').tab('show')
</script>