<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/AseguradoraController.php';
include '../modelo/PacienteController.php';
include '../modelo/consultas_genericas.php';

$msg="";
$objAseguradora=new AseguradoraController();
$lista_aseguradoras=$objAseguradora->MostrarAseguradora();
$objPaciente=new PacienteController();
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
$lista_paciente_servicio=array();

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

?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
       
          <form name="mostrar_paciente">
              <?php 
              $sexoPaciente="M";
                $img="../img/paciente_masculino.png";
                if($sexoPaciente=="F"){$img="../img/paciente_femenino.png";}
              ?>
              <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Historia Cl&iacute;nica # (<?php echo $hc;?>)</b>
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
                                        <tr class="text text-info">
                                           <td rowspan='3' style='width:200px;'><img src='<?php echo $img;?>' title='Paciete' style='width:150px;'></td><td><b>Nombre</b><?php echo $nombre;?></td>
                                        </tr>
                                        <tr>

                                            <td> <?php echo $edad;?></td>
                                        </tr>
                                        <tr>

                                            <td><?php echo $sexo;?></td>
                                        </tr>
                                        <tr >
                                            <td>

                                                <input type="hidden" name="id_pacmod" value="<?php echo $id_pacmod;?>">
                                                Documento Identidad:</td>
                                            <td><?php echo $docID;?></td>
                                        </tr>
                                        <tr class="text text-info">
                                            <th>Ocupaci&oacute;n</th>
                                            <td><?php echo $ocupacion;?></td>

                                        </tr>
                                        <tr>
                                            <th>Aseguradora</th>
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
                                           <th>Direcci&oacute;n</th>
                                           <td><?php echo $direccion;?></td>      

                                        </tr>
                                        <tr class="text text-info">
                                            <th>Teléfono</th>
                                            <td><?php echo $telefono;?></td>
                                        </tr>
                                        <tr class="text text-info">
                                            <th >Email</th>
                                            <td><?php echo $email;?></td>

                                        </tr>
                                        <tr>
                                            <th>Anamnesis</th>
                                            <td><?php echo $anamnesis;?></td>
                                        </tr>

                                    </table>
                                    
                                </div>
                                <div class="tab-pane fade" id="profile">
                                    <h4>Servicios</h4>
                                    <div class="col-md-12">
                                        <form class="form-horizontal">

                                            <table class="table table-responsive table-hover table-bordered" id='dataTables-example'>
                                          <thead>
                                              <tr>

                                                  <th>Tipo Servicio</th>
                                                  <th>Fecha</th>
                                                  <th>Precio</th>
                                                  <th>Acci&oacute;n</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php 
                                                    for ($i = 0; $i < count($lista_paciente_servicio); $i++) 
                                                    {
                                                        $nro=$i+1;
                                                        $id_paciente_servicio=$lista_paciente_servicio[$i]['idservicio'];
                                                        $fecha=$lista_paciente_servicio[$i]['fecha'];
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
                                                        echo "<td>s/. $precio_servicio</td>";
                                                        echo"<td><a href='$link?nik=$nik' class='btn btn-primary  btn-xs'><i class='fa fa-eye'></i></a></td>";
                                                        echo "</tr>";
                                                    } 
                                              ?>
                                          </tbody>

                                      </table>
                                        </form>

                                </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
              
              
          
              
          </form>
       
        </div>
    
        


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