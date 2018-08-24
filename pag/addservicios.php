<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/EspecialidadController.php';
include '../modelo/MedicoController.php';
include '../modelo/LaboratorioController.php';
include '../modelo/TipoServicioController.php';
include '../modelo/TipoAnalisisLaboratorioController.php';
include '../modelo/TipoRadiologiaController.php';
include '../modelo/NombreCirugiaController.php';
include '../modelo/NombreAnalisisLaboratorioController.php';
include '../modelo/NombreRadiologiaController.php';
include '../modelo/InsumoController.php';
include '../modelo/consultas_genericas.php';
include '../modelo/ServicioController.php';
include '../modelo/ConsultaController.php';
include '../modelo/CirugiaController.php';
include '../modelo/RadiologiaController.php';
include '../modelo/labradiologiaController.php';
include '../modelo/labclinicoController.php';
include '../modelo/HospitalizacionController.php';
include '../modelo/TrabajadorController.php';
include '../modelo/CargoController.php';
include '../modelo/InsumoHospitalizacionController.php';


//$msg="";
$objConsulta=new ConsultaController();
$objCirugiaC=new CirugiaController();
$objEspecialidad= new EspecialidadController();
$objInsumo= new InsumoController();
$objMedico=new MedicoController();
$objNombreCirugia= new NombreCirugiaController();
$objNombreAnalisis= new NombreAnalisisLaboratorioController();
$objNombreRadiologia= new NombreRadiologiaController();
$objServicioC= new ServicioController();
$objTipoServicio= new TipoServicioController();
$objTipoAnalisisLab= new TipoAnalisisLaboratorioController();
$objTipoRadiologia= new TipoRadiologiaController();
$objTrabajador=new TrabajadorController();
$objMedico=new MedicoController();
$objTipoServicio= new TipoServicioController();
$objTipoAnalisisLab= new TipoAnalisisLaboratorioController();
$objTipoRadiologia= new TipoRadiologiaController();
$objRadiologia= new RadiologiaController();
$objLaboratorio= new LaboratorioController();
$objLabRadiologia= new labradiologiaController();
$objLabClinico= new labclinicoController();
$objHospitalizacion= new HospitalizacionController();
$objCargo=new CargoController();
$objInsumoHosp=new InsumoHospitalizacionController();

$lista_medicos=$objMedico->MostrarMedico();
$lista_especialidades=$objEspecialidad->MostrarEspecialidad();
$lista_tiposervicios=$objTipoServicio->MostrarTipoServicio();
$lista_tiporadiologia=$objTipoRadiologia->MostrarTipoRadiologia();
$lista_nombrec=$objNombreCirugia->MostrarNombreCirugia();
$lista_nombreanalisis=$objNombreAnalisis->MostrarNombreAnalisis();
$lista_nombreradiologia=$objNombreRadiologia->MostrarNombreRadiologia();
$lista_tipoanalisislab=$objTipoAnalisisLab->MostrarTipoAnalisisLaboratorio();
$lista_insumos=$objInsumo->MostrarInsumo();
$lista_labrad=$objLabRadiologia->MostrarLabRadiologia();
$lista_labclin=$objLabClinico->MostrarLabClinico();
$arr_cargos=$objCargo->BuscarLike("enferm");

$lista_tiposervicios=$objTipoServicio->MostrarTipoServicio();
$lista_tiporadiologia=$objTipoRadiologia->MostrarTipoRadiologia();
$lista_nombrec=$objNombreCirugia->MostrarNombreCirugia();
$lista_nombreanalisis=$objNombreAnalisis->MostrarNombreAnalisis();
$lista_nombreradiologia=$objNombreRadiologia->MostrarNombreRadiologia();
$lista_tipoanalisislab=$objTipoAnalisisLab->MostrarTipoAnalisisLaboratorio();
$lista_insumos=$objInsumo->MostrarInsumo();
$lista_roles_medicos=array();
$lista_roles_enf=array();

##variables
$a="";
$msg="";
$error=0;
$idpaciente="";
$id_servicio="";
$id_especialidad="";
$act_select_hidden=0;
##div de especialidades ################################
$mostrar_consulta="hidden";
$mostrar_cirugia="hidden";
$mostrar_hospitalizacion="hidden";
$mostrar_radiologia="hidden";
$mostrar_laboratorio="hidden";
##variables de la consulta################################
$id_medico_consulta="";
$indicaciones_consulta="";
$resultado_consulta="";
$precio_consulta="";
$fecha_consulta="";
#####variables de cirugia################################
$p_idespecialidad_quirurgica="";
$p_id_cirugia="";
$p_id_cirujano="";
$p_fecha_cirugia= "";
$p_duracion_cirugia="";
$p_id_insumos="";
$p_precio_cirugia="";
$p_lista_insumos=array();
$p_lista_medicos=array();
$p_cantidad_insumos=0;
$p_cantidad_medicos=0;
$p_hora_cirugia="";
##variables hospitalizacion
$fechaingreso="";
$fechaalta="";
$duracionhosp="";
$tipohabit="";
$numcama="";
$estadopcte="";
$nombrefam="";
$parentescofam="";
$condicatencion="";
$pa="";
$pulso="";
$temp="";
$peso="";
$examfis="";
$preciohosp="";
##variables radiologia
$idpruebarad="";
$tiporadiologia="";
$nombreprueba="";
$fechaprueba="";
$precio_rad="";
$resultadosrad="";
$labradiologia="";
##variables de laboratorio
$labclinico="";
$id_tipoanalisis="";
$id_nombreanalisis="";
$resultado_analisis="";
$precio_analisis="";
$fecha_analisis="";


$cg=new ConsultasG();
$p=array();
$p['campo'][0]="especializacion";
$p['valor'][0]="m";
$r=$cg->GenericSelect('roles_cirugia', $p);
if($r){$lista_roles_medicos=$cg->ArregloAsociativoSelect($r, 'roles_cirugia');}

$p=array();
$p['campo'][0]="especializacion";
$p['valor'][0]="t";
$r=$cg->GenericSelect('roles_cirugia', $p);
if($r){$lista_roles_enf=$cg->ArregloAsociativoSelect($r, 'roles_cirugia');}
if($_GET)
    {
        if(isset($_GET["nik"]))
        {
            $idpaciente= $_GET["nik"];
            //Mostrar($idpaciente);
        }
        else
        {
            echo "<script>";
                echo "window.location = 'listar_pacientes.php';";
           echo "</script>";
        }
    }

if($_POST)
    {   
        if(isset($_POST['servicios'])){$id_servicio=$_POST['servicios'];}
        if(isset($_POST['act_select_hidden'])) {$act_select_hidden=$_POST['act_select_hidden'];}  
        if(isset($_POST['id_paciente_buscar'])){$idpaciente=$_POST['id_paciente_buscar'];}
        else
        {
            echo "<script>";
            echo "alert('No se ha podido encontrar al paciente');";
                echo "window.location = 'listar_pacientes.php';";
           echo "</script>";
        }
        
        if($act_select_hidden==2)
        {
            #solo se envio el select de servicios y hay que mostrar el div que el correspopnda
           if($id_servicio==1)
            {##mostrar consulta
               
                $mostrar_consulta="";
                $mostrar_cirugia="hidden";
                $mostrar_hospitalizacion="hidden";
                $mostrar_radiologia="hidden";
                $mostrar_laboratorio="hidden";
            }
            if($id_servicio==2)
            {##mostrar cirugia
               
                $mostrar_consulta="hidden";
                $mostrar_cirugia="";
                $mostrar_hospitalizacion="hidden";
                $mostrar_radiologia="hidden";
                $mostrar_laboratorio="hidden";
            }
            if($id_servicio==3)
            {##mostrar hospitalizacion
               
                $mostrar_consulta="hidden";
                $mostrar_cirugia="hidden";
                $mostrar_hospitalizacion="";
                $mostrar_radiologia="hidden";
                $mostrar_laboratorio="hidden";
            }
            if($id_servicio==4)
            {##mostrar radiologia
               
                $mostrar_consulta="hidden";
                $mostrar_cirugia="hidden";
                $mostrar_hospitalizacion="hidden";
                $mostrar_radiologia="";
                $mostrar_laboratorio="hidden";
                
            }
            if($id_servicio==5)
            {##mostrar laboratorio
               
                $mostrar_consulta="hidden";
                $mostrar_cirugia="hidden";
                $mostrar_hospitalizacion="hidden";
                $mostrar_radiologia="hidden";
                $mostrar_laboratorio="";
            }
        }
       ##para consulta 
       if(isset($_POST['idespecialidad']))
       {          
           $id_especialidad=$_POST['idespecialidad'];
           $mostrar_consulta="";
           if(isset($_POST['act_select_hidden']))
            {
               $act_select_hidden=$_POST['act_select_hidden'];
               if($act_select_hidden==1)
               {
                   ##cargar medicos
                   $lista_medicos=$objMedico->BuscarMedico("", "", "", $id_especialidad);
               }
               else
               {
                    
                   ##insertar servicio
                   if(isset($_POST['medicos'])){$id_medico_consulta=$_POST['medicos'];}
                   if(isset($_POST['fecha'])){$fecha_consulta=$_POST['fecha'];}
                   if(isset($_POST['indicaciones'])){$indicaciones_consulta=$_POST['indicaciones'];}
                   if(isset($_POST['resultados'])){$resultados_consulta=$_POST['resultados'];}
                   if(isset($_POST['precio'])){$precio_consulta=$_POST['precio'];}
                   if(isset($_POST['id_tipo_servicio'])){$id_servicio=$_POST['id_tipo_servicio'];}
                  
                   if(eliminarblancos($id_servicio)=="")
                       {
                            $msg="<div class='alert alert-danger alert-dismissable'>"
                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                            . "Error! Usted debe de seleccionar un tipo de servicio</div>"; 
                        $error++;
                               
                       }
                       if(eliminarblancos($precio_consulta)=="")
                       {
                            $msg="<div class='alert alert-danger alert-dismissable'>"
                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                            . "Error! Usted debe de poner un precio a este servicio</div>"; 
                            $error++;
                               
                       }
                       else 
                       {
                           #que el precio sea un numero
                           if(isNaN($precio_consulta))
                           {
                               $msg="<div class='alert alert-danger alert-dismissable'>"
                                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                . "Error! El precio debe de ser un n&uacute;mero</div>"; 
                                $error++;
                           }
                       }
                       
                       if($error==0)
                       {
                           $aff=$objServicioC->CrearServicio($id_servicio, $precio_consulta);  
                           
                           if($aff!=0)
                           {
                               $affected=$objConsulta->CrearConsulta($aff, $id_especialidad, $indicaciones_consulta, $resultado_consulta, $precio_consulta);
                               if($affected!=0)
                               {
                                    ##creo medico servicio
                                    $id_consultabd=$affected;
                                    $cg=new ConsultasG();
                                    $p=array();
                                    $a=0;
                                    $p['campo'][$a]='idconsulta';
                                    $p['valor'][$a]=$id_consultabd;
                                    $a++;
                                    $p['campo'][$a]='idmedico';
                                    $p['valor'][$a]=$id_medico_consulta;
                                    $a++;
                                    $p['campo'][$a]='fecha';
                                    $p['valor'][$a]=$fecha_consulta;
                                    $a++;
                                    
                                    $affected=$cg->GenericInsert('medico_consulta', $p);
                                    if($affected==1)
                                    {
                                        ##insertar paciente-servicio
                                        $p=array();
                                        $a=0;
                                        $p['campo'][$a]='idservicio';
                                        $p['valor'][$a]=$aff;
                                        $a++;
                                        $p['campo'][$a]='fecha';
                                        $p['valor'][$a]=$fecha_consulta;
                                        $a++;
                                        $p['campo'][$a]='idpaciente';
                                        $p['valor'][$a]=$idpaciente;
                                        $a++;
                                        
                                        $affected=$cg->GenericInsert('paciente_servicio', $p);
                                        if($affected==1)
                                        {
                                            $msg="<div class='alert alert-success alert-dismissable'>"
                                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                            . "OK! Se han registrado los datos correctamente.</div>";
                                            echo "<script>";
                                            echo "window.location = 'index.php';";
                                            echo "</script>";
                                        }
                                        else 
                                        {
                                            $objServicioC->EliminarServicio($aff);
                                            $msg="<div class='alert alert-danger alert-dismissable'>"
                                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                            . "Error! No se pudieron insertar los datos del paciente-servicio.</div>";
                                        
                                        }
                                        
                                        
                                    }
                                    else
                                    {
                                        $objServicioC->EliminarServicio($aff);
                                        $msg="<div class='alert alert-danger alert-dismissable'>"
                                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                        . "Error! No se pudieron insertar los datos del medico-consulta.</div>";
                                        
                                    }
                               }
                               else 
                                {
                                   $objServicioC->EliminarServicio($aff);
                                   $msg="<div class='alert alert-danger alert-dismissable'>"
                                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                    . "Error! No se pudo registrar los datos de la consulta.</div>"; 
                                }
                           }
                           else
                            {
                               $msg="<div class='alert alert-danger alert-dismissable'>"
                                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                    . "Error! No se creo el servicio.</div>"; 
                            }
                       }
                       
                  
               }
            }
           
       }
       
       ##cirugia
       if(isset($_POST['especialidadquirurgica']))
       {
           $mostrar_cirugia="";
           $mostrar_consulta='hidden';
           
           $p_idespecialidad_quirurgica=$_POST['especialidadquirurgica'];
           if(isset($_POST['cantidad_insumos'])){$p_cantidad_insumos=$_POST['cantidad_insumos'];}
           if(isset($_POST['nombrecirugia'])){$p_id_cirugia=$_POST['nombrecirugia'];}
           if(isset($_POST['duracion'])){$p_duracion_cirugia=$_POST['duracion'];}
           if(isset($_POST['precio'])){$p_precio_cirugia=$_POST['precio'];}
           if(isset($_POST['fecha'])){$p_fecha_cirugia=$_POST['fecha'];}
           if(isset($_POST['medicos'])){$p_id_cirujano=$_POST['medicos'];}
           if(isset($_POST['cantidad_medicos'])){$p_cantidad_medicos=$_POST['cantidad_medicos'];}
           if(isset($_POST['hora'])){$p_hora_cirugia=$_POST['hora'];}
           
///////////////////////////////////////////////////////////////esto estaba disperso al inicio, debe ser de cirugia

           ##cargar trabajadores
$lista_trabajadores=array();
$t=0;
for ($i = 0; $i < count($arr_cargos); $i++) 
{
    $p_cargo=$arr_cargos[$i]->getIdCargo();
    $arr_trab=$objTrabajador->BuscarTrabajador("", "", "",$p_cargo);
    for ($j = 0; $j < count($arr_trab); $j++) 
    {
        $lista_trabajadores[$t]=$arr_trab[$j];
        $t++;
    }

}


/////////////////////////////////////////////////////////////////////////////
          
           if($p_cantidad_insumos!=0)
           {          
               $c_i=0;
               for ($j = 0; $j <= $p_cantidad_insumos; $j++) 
               {
                   $x=0;
                   $var_ins="insumo$j";
                   $var_cantidad="cantidad$j";
                  if(isset($_POST[$var_ins]))
                  {$p_lista_insumos[$c_i]['insumo']=$_POST[$var_ins];$x++;}
                  if(isset($_POST[$var_cantidad]))
                  {$p_lista_insumos[$c_i]['cantidad']=$_POST[$var_cantidad];$x++;}
                  else 
                  {
                      if($x==1){$p_lista_insumos[$c_i]['cantidad']=0;}
                  }
                  if($x!=0){$c_i++;}
               }
               
           }
            if($p_cantidad_medicos!=0)
           {          
               $c_i=0;
               for ($j = 0; $j <= $p_cantidad_medicos; $j++) 
               {
                   $x=0;
                   $var_id_medico="med$j";
                   $var_id_trabajador="trab$j";
                   $var_id_cargo="cargo$j";
                   
                   if(isset($_POST[$var_id_medico]))
                  {$p_lista_medicos[$c_i]['med']=$_POST[$var_id_medico];$x++;}
                  else 
                  {
                      if(isset($_POST[$var_id_trabajador]))
                          {$p_lista_medicos[$c_i]['trab']=$_POST[$var_id_trabajador];$x++;}
                  }
                  if(isset($_POST[$var_id_cargo]))
                          {$p_lista_medicos[$c_i]['cargo']=$_POST[$var_id_cargo];$x++;}
                  
                  if($x!=0){$c_i++;}
               }
               
           }
           
           if($act_select_hidden==1)
           {
               ##cargar cirugia, cirujanos,
               $lista_nombrec=$objNombreCirugia->BuscarNombreCirugia("", "", $p_idespecialidad_quirurgica);
               $lista_medicos=$objMedico->BuscarMedico("", "", "", $p_idespecialidad_quirurgica);
               //Mostrar($lista_medicos);
           }
           else
           {
               ##insertar
              
               if(eliminarblancos($p_idespecialidad_quirurgica)=="")
               {
                   $msg="<div class='alert alert-danger alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "Error! Usted debe de seleccionar la especialidad para la cirug&iacute;a</div>"; 
                    $error++;
               }
               if(eliminarblancos($p_id_cirugia)=="")
               {
                   $p_nomb_especialidadQ="";
                   $p_nomb_especialidadQ=$objEspecialidad->BuscarEspecialidad($p_idespecialidad_quirurgica, "", "");
                    $msg="<div class='alert alert-danger alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "Error! Usted debe de seleccionar la cirug&iacute;a a realizar para la especialidad $p_nomb_especialidadQ</div>"; 
                    $error++;
               }
               if(eliminarblancos($p_fecha_cirugia)=="")
               {
                    $msg="<div class='alert alert-danger alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "Error! Usted debe de seleccionar la fecha para la cirug&iacute;a </div>"; 
                    $error++;
               }
               if(eliminarblancos($p_hora_cirugia)=="")
               {
                    $msg="<div class='alert alert-danger alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "Error! Usted debe de seleccionar la Hora para la cirug&iacute;a </div>"; 
                    $error++;
               }
               if(eliminarblancos($p_id_cirujano)=="")
               {
                   $msg="<div class='alert alert-danger alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "Error! Usted debe de seleccionar el cirujano principal para la cirug&iacute;a </div>"; 
                    $error++;
               }
               
               if($error==0)
               {
                   ##insertar servicio
                   $id_servicio_creado=$objServicioC->CrearServicio($id_servicio, $p_precio_cirugia);
                   if($id_servicio_creado!=0)
                    {
                        ##insertar paciente-servicio
                       ##insertar paciente-servicio
                        $p=array();
                        $a=0;
                        $p['campo'][$a]='idservicio';
                        $p['valor'][$a]=$id_servicio_creado;
                        $a++;
                        $p['campo'][$a]='fecha';
                        $p['valor'][$a]=$p_fecha_cirugia;
                        $a++;
                        $p['campo'][$a]='hora';
                        $p['valor'][$a]=$p_hora_cirugia;
                        $a++;
                        $p['campo'][$a]='idpaciente';
                        $p['valor'][$a]=$idpaciente;
                        $a++;
                        $affected=$cg->GenericInsert('paciente_servicio', $p);
                        if($affected==1)
                        {
                            ##insertar cirugia
                            $id_cirugia_creada=$objCirugiaC->CrearCirugia($id_servicio_creado, $p_idespecialidad_quirurgica, $p_id_cirugia, $p_duracion_cirugia, $p_precio_cirugia);
                            if($id_cirugia_creada!=0)
                            {
                                ##insertar insumo_cirugia
                                $cont_insumos=0;
                                for ($i = 0; $i < $p_cantidad_insumos; $i++) 
                                {
                                    if(isset($_POST["insumo$i"]))
                                    {
                                        $p_idIns="";
                                        $p_id_insumo_cir=$_POST["insumo$i"];
                                        $arrInsumo=$objInsumo->BuscarInsumo("", $p_id_insumo_cir, "");
                                        if(count($arrInsumo)>0){$p_idIns=$arrInsumo[0]->getIdInsumo();}
                                        $p_cantidad_insumos_cir=0;
                                        if(isset($_POST["cantidad$i"])){$p_cantidad_insumos_cir=$_POST["cantidad$i"];}
                                        
                                        $p=array();
                                        $a=0;
                                        $p['campo'][$a]="idinsumo";
                                        $p['valor'][$a]=$p_idIns;
                                        $a++;
                                        $p['campo'][$a]="idcirugia";
                                        $p['valor'][$a]="$id_cirugia_creada";
                                        $a++;
                                        $p['campo'][$a]="cantidadinsumo";
                                        $p['valor'][$a]=$p_cantidad_insumos_cir;
                                        $a++;
                                        
                                        $affI=$cg->GenericInsert('insumo_cirugia', $p);                                    
                                        if($affI==0){$cont_insumos++;}
                                    }
                                }
                               
                                                                
                                ##insertar medico cirugia
                                $cont_med_cir=0;
                                ##primero el cirujano principal
                                $p=array();
                                $a=0;
                                $p['campo'][$a]="idcirugia";
                                $p['valor'][$a]="$id_cirugia_creada";
                                $a++;
                                $p['campo'][$a]="idmedico";
                                $p['valor'][$a]="$p_id_cirujano";
                                $a++;
                                $p['campo'][$a]="fecha";
                                $p['valor'][$a]="$p_fecha_cirugia";
                                $a++;
                                $p['campo'][$a]="id_rol_cirugia";
                                $p['valor'][$a]=1;
                                $a++;
                                $aff=$cg->GenericInsert('medico_cirugia', $p);
                                
                                if($aff==1)
                                {
                                    if($p_cantidad_medicos>0)
                                    {
                                        for ($i = 0; $i < $p_cantidad_medicos; $i++) 
                                        {
                                            $xx=0;
                                            $pcargo="";
                                            $pmed="";
                                            $ptrab="";
                                           if(isset($_POST["cargo$i"])){$pcargo=$_POST["cargo$i"];}
                                           if(isset($_POST["med$i"])){$pmed=$_POST["med$i"];} 
                                           if(isset($_POST["trab$i"])){$ptrab=$_POST["trab$i"];} 
                                            $p=array();
                                            $a=0;
                                            $p['campo'][$a]="idcirugia";
                                            $p['valor'][$a]="$id_cirugia_creada";
                                            $a++;
                                            if($pmed!="")
                                            {
                                                ##buscar el id del medico por el nombre
                                                $arrMed=$objMedico->BuscarMedico("", $pmed, "");
                                                if(count($arrMed)>0)
                                                {
                                                    $p_idmc=$arrMed[0]->getIdMedico();
                                                    $p['campo'][$a]="idmedico";
                                                    $p['valor'][$a]=$p_idmc;
                                                    $a++;
                                                    $xx++;
                                                }
                                                
                                            }
                                             if($ptrab!="")
                                            {
                                                 $arrT=$objTrabajador->BuscarTrabajador("", $ptrab, "");
                                                 if(count($arrT)>0)
                                                 {
                                                    $p_idt=$arrT[0]->getIdTrabajador();
                                                    $p['campo'][$a]="id_trabajador";
                                                    $p['valor'][$a]=$p_idt;
                                                    $a++;
                                                    $xx++;
                                                 }
                                               
                                            }
                                            
                                            $p['campo'][$a]="fecha";
                                            $p['valor'][$a]="$p_fecha_cirugia";
                                            $a++;
                                            if($pcargo!="")
                                            {
                                                $parametros=array();
                                                $parametros['campo'][0]="nombre";
                                                $parametros['valor'][0]=$pcargo;
                                                
                                                $r=$cg->GenericSelect('roles_cirugia', $parametros);
                                                if($r){
                                                    $arrCargos=$cg->ArregloAsociativoSelect($r, 'roles_cirugia');
                                                    if(count($arrCargos)>0)
                                                    {
                                                        $p_idC=$arrCargos[0]['id_rol'];
                                                        $p['campo'][$a]="id_rol_cirugia";
                                                        $p['valor'][$a]=$p_idC;
                                                        $a++;
                                                    }
                                                    
                                                }
                                                
                                                
                                            }
                                            if($xx!=0)
                                            {$aff=$cg->GenericInsert('medico_cirugia', $p);}
                                            if($aff==0){$cont_med_cir++;}
                                        }
                                    }
                                    
                                    if($cont_insumos!=0)
                                    {
                                         $msg="<div class='alert alert-danger alert-dismissable'>"
                                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                        . "Error! Los datos de los insumops en la cirugia no fueron insertados correctamente.</div>";
                                        $aff=$objServicioC->EliminarServicio($id_servicio_creado);
                                    }
                                    if($cont_med_cir!=0)
                                    {
                                         $msg="<div class='alert alert-danger alert-dismissable'>"
                                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                        . "Error! Los datos del equipo de la cirugia no fueron insertados correctamente.</div>";
                                        $aff=$objServicioC->EliminarServicio($id_servicio_creado);
                                    }
                                    
                                    if($cont_insumos==0 && $cont_med_cir==0)
                                    {
                                         $msg="<div class='alert alert-success alert-dismissable'>"
                                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                        . "OK! Los datos fueron insertado correctamente.</div>";
                                         $_SESSION['msg']=$msg;
                                         echo "<script>";
                                            echo "window.location = 'listar_pacientes.php';";
                                        echo "</script>";
                                    }
                                    
                                
                                }
                                else 
                                {
                                    $msg="<div class='alert alert-danger alert-dismissable'>"
                                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                    . "Error! Los datos del cirujano principal no fueron insertados correctamente.</div>";
                                    $aff=$objServicioC->EliminarServicio($id_servicio_creado);
                                
                                }
                               
                                
                            }
                            else
                            {
                                $objServicioC->EliminarServicio($id_servicio_creado);
                                $msg="<div class='alert alert-danger alert-dismissable'>"
                                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                . "Error! No se pudieron insertar los datos de la cirugia.</div>";

                            }
                            
                        }
                        else 
                        {
                            $objServicioC->EliminarServicio($id_servicio_creado);
                            $msg="<div class='alert alert-danger alert-dismissable'>"
                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                            . "Error! No se pudieron insertar los datos del paciente-servicio.</div>";

                        }
                    }
                    else 
                    {
                        
                        $msg="<div class='alert alert-danger alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "Error! No se pudo insertar el servicio.</div>";
                                        
                    }
               }               
           }
       }
       
       ##para hospitalizacion 
       if(isset($_POST['fechaingreso']))
       {           
           $mostrar_hospitalizacion="";
           $fechaingreso=$_POST['fechaingreso'];
           if(isset($_POST['cantidad_insumos'])){$p_cantidad_insumos=$_POST['cantidad_insumos'];}
           if($p_cantidad_insumos!=0)
           {          
               $c_i=0;
               for ($j = 0; $j <= $p_cantidad_insumos; $j++) 
               {
                   $x=0;
                   $var_ins="insumo$j";
                   $var_cantidad="cantidad$j";
                  if(isset($_POST[$var_ins]))
                  {$p_lista_insumos[$c_i]['insumo']=$_POST[$var_ins];$x++;}
                  if(isset($_POST[$var_cantidad]))
                  {$p_lista_insumos[$c_i]['cantidad']=$_POST[$var_cantidad];$x++;}
                  else 
                  {
                      if($x==1){$p_lista_insumos[$c_i]['cantidad']=0;}
                  }
                  if($x!=0){$c_i++;}
               }
               
           }
           if(isset($_POST['act_select_hidden']))
            {
               
               $act_select_hidden=$_POST['act_select_hidden'];  //util aca?
                if($act_select_hidden!=1)
                {
                   
                    ##insertar servicio
                   if(isset($_POST['fechaalta'])){$fechaalta=$_POST['fechaalta'];}
                   if(isset($_POST['duracionhosp'])){$duracionhosp=$_POST['duracionhosp'];}
                   if(isset($_POST['habit'])){$tipohabit=$_POST['habit'];}
                   if(isset($_POST['numcama'])){$numcama=$_POST['numcama'];}
                   if(isset($_POST['estadopcte'])){$estadopcte=$_POST['estadopcte'];}
                   if(isset($_POST['nombrefam'])){$nombrefam=$_POST['nombrefam'];}
                   if(isset($_POST['parentescofam'])){$parentescofam=$_POST['parentescofam'];}
                   if(isset($_POST['condicatencion'])){$condicatencion=$_POST['condicatencion'];}
                   if(isset($_POST['pa'])){$pa=$_POST['pa'];}
                   if(isset($_POST['pulso'])){$pulso=$_POST['pulso'];}
                   if(isset($_POST['temp'])){$temp=$_POST['temp'];}
                   if(isset($_POST['peso'])){$peso=$_POST['peso'];}
                   if(isset($_POST['examfis'])){$examfis=$_POST['examfis'];}
                   if(isset($_POST['preciohosp'])){$preciohosp=$_POST['preciohosp'];}
                       else{$preciohosp=0;}
                                                            
                   if(eliminarblancos($tipohabit)=="" || $numcama=="" || eliminarblancos($estadopcte)=="" || 
                   eliminarblancos($condicatencion)=="" || eliminarblancos($pa)=="" || eliminarblancos($pulso)==""
                    || eliminarblancos($temp)=="" || eliminarblancos($peso)=="" || eliminarblancos($examfis)=="")
                       {
                            $msg="<div class='alert alert-danger alert-dismissable'>"
                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                            . "Error! Existen campos obligatorios en blanco</div>"; 
                        $error++;
                               
                       }
                       
                           if($preciohosp==""){$preciohosp=0;}
                           #que el precio sea un numero
                           if(isNaN($preciohosp))
                           {
                               $msg="<div class='alert alert-danger alert-dismissable'>"
                                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                . "Error! El precio debe de ser un n&uacute;mero (hosp)</div>"; 
                                $error++;
                           }
                       
                       if(isNaN($numcama) || isNaN($peso))
                            {
                                $msg="<div class='alert alert-danger alert-dismissable'>"
                                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                . "Error! Los campos numero de cama y peso solo admiten numeros</div>"; 
                                $error++;
                            }
                       
                       if($error==0)
                       { 
                           $aff=$objServicioC->CrearServicio($id_servicio, $preciohosp);  
                           
                           if($aff!=0)
                           {
                               $id_hospitalizacion_creado=$objHospitalizacion->CrearHospitalizacion($aff, $fechaingreso, $fechaalta, $duracionhosp,
                                       $tipohabit, $numcama, $nombrefam, $parentescofam, $estadopcte, $condicatencion, 
                                       $pa, $pulso, $temp, $peso, $examfis, $preciohosp);
                               //Mostrar($affected);

                               if($id_hospitalizacion_creado!=0)
                               {
                                    ##insertar paciente-servicio
                                    $cg=new ConsultasG();
                                    $p=array();
                                    $a=0;
                                    $p['campo'][$a]='idservicio';
                                    $p['valor'][$a]=$aff;
                                    $a++;
                                    $p['campo'][$a]='fecha';
                                    $p['valor'][$a]=$fechaingreso;
                                    $a++;
                                    $p['campo'][$a]='idpaciente';
                                    $p['valor'][$a]=$idpaciente;
                                    $a++;
                                        
                                        $affected=$cg->GenericInsert('paciente_servicio', $p);
                                        if($affected==1)
                                        {
                                            ##insertar insumos
                                             ##insertar insumo_cirugia
                                            $cont_insumos=0;
                                            
                                            for ($i = 0; $i < $p_cantidad_insumos; $i++) 
                                            {
                                                if(isset($_POST["insumo$i"]))
                                                {
                                                    $p_id_insumo_cir="";
                                                    $p_idIns="";
                                                    $p_nombre_ins=$_POST["insumo$i"];
                                                    $arrInsumo=$objInsumo->BuscarInsumo("", $p_id_insumo_cir, "");
                                                    if(count($arrInsumo)>0){$p_idIns=$arrInsumo[0]->getIdInsumo();}
                                                    $p_cantidad_insumos_cir=0;
                                                    if(isset($_POST["cantidad$i"])){$p_cantidad_insumos_cir=$_POST["cantidad$i"];}
                                                    
                                                    $arrInsH=$objInsumo->BuscarInsumo("", $p_nombre_ins, "");
                                                    if(count($arrInsH)>0){$p_id_insumo_cir=$arrInsH[0]->getIdInsumo();}
                                                    $affI=$objInsumoHosp->CrearInsumoHospitalizacion($p_id_insumo_cir, $id_hospitalizacion_creado, "", "");                                   
                                                    if($affI==0){$cont_insumos++;}
                                                }
                                            }
                                            if($cont_insumos==0)
                                            {
                                                $msg="<div class='alert alert-success alert-dismissable'>"
                                                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                                . "OK! Se han registrado los datos correctamente.</div>";
                                                echo "<script>";
                                                echo "window.location = 'listar_pacientes.php';";
                                                echo "</script>";
                                            }
                                            else
                                            {
                                                $objServicioC->EliminarServicio($aff);
                                                $msg="<div class='alert alert-danger alert-dismissable'>"
                                                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                                . "Error! No se pudieron insertar los datos de insumos hospitalizacion.</div>";
                                        
                                            }
                                            
                                        }
                                        else 
                                        {
                                            $objServicioC->EliminarServicio($aff);
                                            $msg="<div class='alert alert-danger alert-dismissable'>"
                                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                            . "Error! No se pudieron insertar los datos del paciente-servicio.</div>";
                                        }
                               }
                               else 
                                {
                                   $objServicioC->EliminarServicio($aff);
                                   $msg="<div class='alert alert-danger alert-dismissable'>"
                                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                    . "Error! No se pudo registrar los datos de la hospitalizacion.</div>"; 
                                }
                           }
                           else
                            {
                               $msg="<div class='alert alert-danger alert-dismissable'>"
                                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                    . "Error! No se creo el servicio.</div>"; 
                            }
                       }
                }
                   
                       //aqui poner algo para cuando no se cumpla y se recarguen nuevamente los valores
                       //seleccionados en los select
               }
            }
       
       ##para radiologia 
       if(isset($_POST['tiporadiologia']))
       {          
           $tiporadiologia=$_POST['tiporadiologia'];
           $mostrar_radiologia="";
           if(isset($_POST['act_select_hidden']))
            {
               $act_select_hidden=$_POST['act_select_hidden'];
               if($act_select_hidden==1)
               {
                   ##cargar categorias de pruebas
                   //$lista_tiporadiologia=$objTipoRadiologia->BuscarTipoRadiologia("", $tiporadiologia);
                   $lista_nombreradiologia=$objNombreRadiologia->BuscarNombreRadiologia("", "", $tiporadiologia);
               }
               else
               {
                    
                   ##insertar servicio
                   if(isset($_POST['nombreprueba'])){$nombreprueba=$_POST['nombreprueba'];}
                   if(isset($_POST['fechaprueba'])){$fechaprueba=$_POST['fechaprueba'];}
                   if(isset($_POST['resultadorad'])){$resultadosrad=$_POST['resultadorad'];}
                   if(isset($_POST['preciorad'])){$precio_rad=$_POST['preciorad'];}
                   if(isset($_POST['labrad'])){$labradiologia=$_POST['labrad'];}
                                     
                   if(eliminarblancos($id_servicio)=="")
                       {
                            $msg="<div class='alert alert-danger alert-dismissable'>"
                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                            . "Error! Usted debe de seleccionar un tipo de servicio</div>"; 
                        $error++;
                               
                       }
                       if(eliminarblancos($precio_rad)=="")
                       {
                            $msg="<div class='alert alert-danger alert-dismissable'>"
                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                            . "Error! Usted debe de poner un precio a este servicio (radiologia)</div>"; 
                            $error++;
                               
                       }
                       else 
                       {
                           #que el precio sea un numero
                           if(isNaN($precio_rad))
                           {
                               $msg="<div class='alert alert-danger alert-dismissable'>"
                                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                . "Error! El precio debe de ser un n&uacute;mero (rad)</div>"; 
                                $error++;
                           }
                       }
                       
                       if($error==0)
                       {
                           $aff=$objServicioC->CrearServicio($id_servicio, $precio_rad);  
                           
                           if($aff!=0)
                           {
                               $affected=$objRadiologia->CrearRadiologia($aff, $tiporadiologia, $nombreprueba, $resultadosrad, $precio_rad);
                               if($affected!=0)
                               {
                                    ##creo labradiologia pruebaradiologia (labrad_pruebarad)
                                    $id_consultabd=$affected;
                                    $cg=new ConsultasG();
                                    $p=array();
                                    $a=0;
                                    $p['campo'][$a]='idradiologia';
                                    $p['valor'][$a]=$id_consultabd;
                                    $a++;
                                    $p['campo'][$a]='idlabradiologia';
                                    $p['valor'][$a]=$labradiologia;
                                    $a++;
                                    $p['campo'][$a]='fecha';
                                    $p['valor'][$a]=$fechaprueba;
                                    $a++;
                                    
                                    $affected=$cg->GenericInsert('labrad_pruebarad', $p);
                                    if($affected==1)
                                    {
                                        ##insertar paciente-servicio
                                        $p=array();
                                        $a=0;
                                        $p['campo'][$a]='idservicio';
                                        $p['valor'][$a]=$aff;
                                        $a++;
                                        $p['campo'][$a]='fecha';
                                        $p['valor'][$a]=$fechaprueba;
                                        $a++;
                                        $p['campo'][$a]='idpaciente';
                                        $p['valor'][$a]=$idpaciente;
                                        $a++;
                                        
                                        $affected=$cg->GenericInsert('paciente_servicio', $p);
                                        if($affected==1)
                                        {
                                            $msg="<div class='alert alert-success alert-dismissable'>"
                                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                            . "OK! Se han registrado los datos correctamente.</div>";
                                            echo "<script>";
                                            echo "window.location = 'listar_pacientes.php';";
                                            echo "</script>";
                                        }
                                        else 
                                        {
                                            $objServicioC->EliminarServicio($aff);
                                            $msg="<div class='alert alert-danger alert-dismissable'>"
                                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                            . "Error! No se pudieron insertar los datos del paciente-servicio.</div>";
                                        
                                        }
                                        
                                        
                                    }
                                    else
                                    {
                                        $objServicioC->EliminarServicio($aff);
                                        $msg="<div class='alert alert-danger alert-dismissable'>"
                                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                        . "Error! No fue posible insertar los datos del labradiologia-pruebaradiologia.</div>";
                                        
                                    }
                               }
                               else 
                                {
                                   $objServicioC->EliminarServicio($aff);
                                   $msg="<div class='alert alert-danger alert-dismissable'>"
                                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                    . "Error! No fue posible registrar los datos de la prueba.</div>"; 
                                }
                           }
                           else
                            {
                               $msg="<div class='alert alert-danger alert-dismissable'>"
                                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                    . "Error! No se creo el servicio.</div>"; 
                            }
                       }
                       //aqui poner algo para cuando no se cumpla y se recarguen nuevamente los valores
                       //seleccionados en los select
               }
            }
           
       }
       
       ##para laboratorio 
       if(isset($_POST['tipoanalisis']))
       {          
           $id_tipoanalisis=$_POST['tipoanalisis'];
           $mostrar_laboratorio="";
           if(isset($_POST['act_select_hidden']))
            {
               $act_select_hidden=$_POST['act_select_hidden'];
               if($act_select_hidden==1)
               {
                   ##cargar categorias de analisis
                   $lista_tipoanalisislab=$objTipoAnalisisLab->BuscarTipoAnalisisLaboratorio($id_tipoanalisis, "");
               }
               else
               {
                    
                   ##insertar servicio
                   if(isset($_POST['nombreanalisis'])){$id_nombreanalisis=$_POST['nombreanalisis'];}
                   if(isset($_POST['fechaanalisis'])){$fecha_analisis=$_POST['fechaanalisis'];}
                   if(isset($_POST['resultadolab'])){$resultado_analisis=$_POST['resultadolab'];}
                   if(isset($_POST['preciolab'])){$precio_analisis=$_POST['preciolab'];}
                   if(isset($_POST['labclin'])){$labclinico=$_POST['labclin'];}
                                     
                   if(eliminarblancos($id_servicio)=="")
                       {
                            $msg="<div class='alert alert-danger alert-dismissable'>"
                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                            . "Error! Usted debe de seleccionar un tipo de servicio</div>"; 
                        $error++;
                               
                       }
                       if(eliminarblancos($precio_analisis)=="")
                       {
                            $msg="<div class='alert alert-danger alert-dismissable'>"
                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                            . "Error! Usted debe de poner un precio a este servicio (laboratorio)</div>"; 
                            $error++;
                               
                       }
                       else 
                       {
                           #que el precio sea un numero
                           if(isNaN($precio_analisis))
                           {
                               $msg="<div class='alert alert-danger alert-dismissable'>"
                                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                . "Error! El precio debe de ser un n&uacute;mero (lab)</div>"; 
                                $error++;
                           }
                       }
                                           
                       if($error==0)
                       {
                           $aff=$objServicioC->CrearServicio($id_servicio, $precio_analisis);  
                           
                           if($aff!=0)
                           {
                               //Mostrar([$aff, $id_tipoanalisis, $id_nombreanalisis, $precio_analisis, $resultado_analisis]);
                               $affected=$objLaboratorio->CrearLaboratorio($aff, $id_tipoanalisis, $id_nombreanalisis, $resultado_analisis);
                               //Mostrar($affected);
                               if($affected!=0)
                               {
                                    ##creo labclinico analisislaboratorio (labclin_analab)
                                    $id_consultabd=$affected;
                                    $cg=new ConsultasG();
                                    $p=array();
                                    $a=0;
                                    $p['campo'][$a]='idlaboratorio';
                                    $p['valor'][$a]=$id_consultabd;
                                    $a++;
                                    $p['campo'][$a]='idlabclinico';
                                    $p['valor'][$a]=$labclinico;
                                    $a++;
                                    $p['campo'][$a]='fecha';
                                    $p['valor'][$a]=$fecha_analisis;
                                    $a++;
                                    
                                    $affected=$cg->GenericInsert('labclin_analab', $p);
                                    if($affected==1)
                                    {
                                        ##insertar paciente-servicio
                                        $p=array();
                                        $a=0;
                                        $p['campo'][$a]='idservicio';
                                        $p['valor'][$a]=$aff;
                                        $a++;
                                        $p['campo'][$a]='fecha';
                                        $p['valor'][$a]=$fecha_analisis;
                                        $a++;
                                        $p['campo'][$a]='idpaciente';
                                        $p['valor'][$a]=$idpaciente;
                                        $a++;
                                        
                                        $affected=$cg->GenericInsert('paciente_servicio', $p);
                                        if($affected==1)
                                        {
                                            $msg="<div class='alert alert-success alert-dismissable'>"
                                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                            . "OK! Se han registrado los datos correctamente.</div>";
                                            echo "<script>";
                                            echo "window.location = 'listar_pacientes.php';";
                                            echo "</script>";
                                        }
                                        else 
                                        {
                                            $objServicioC->EliminarServicio($aff);
                                            $msg="<div class='alert alert-danger alert-dismissable'>"
                                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                            . "Error! No se pudieron insertar los datos del paciente-servicio.</div>";
                                        
                                        }
                                        
                                        
                                    }
                                    else
                                    {
                                        $objServicioC->EliminarServicio($aff);
                                        $msg="<div class='alert alert-danger alert-dismissable'>"
                                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                        . "Error! No fue posible insertar los datos del labclinico-analisislaboratorio.</div>";
                                        
                                    }
                               }
                               else 
                                {
                                   $objServicioC->EliminarServicio($aff);
                                   $msg="<div class='alert alert-danger alert-dismissable'>"
                                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                    . "Error! No fue posible registrar los datos del analisis.</div>"; 
                                }
                           }
                           else
                            {
                               $msg="<div class='alert alert-danger alert-dismissable'>"
                                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                    . "Error! No se creo el servicio.</div>"; 
                            }
                       }
                       //aqui poner algo para cuando no se cumpla y se recarguen nuevamente los valores
                       //seleccionados en los select
               }
            }
           
       }
       
       
    }

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
         <h3 class="text-left"><i class="fa fa-stethoscope text-info"> Nuevo Servicio</i></h3>
        </div>
        
        <form name="nuevo_servicio" method="post" action="addservicios.php" id="ff">
              <br>
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      
                      <th>Seleccione el Tipo de Servicio</th>
                  </tr>
                  <tr>                      
                      <td>
                          <input type="hidden" name="id_paciente_buscar"  value="<?php echo $idpaciente;?>">
                          <input type="hidden" name="act_select_hidden" id="act_hidden" value="0">
                          <select name="servicios" class="form-control" id="periodo">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                              
                            for ($i = 0; $i < count($lista_tiposervicios); $i++) 
                            {
                               $idservicio=$lista_tiposervicios[$i]->getIdTipoServicio();
                               $nombre=$lista_tiposervicios[$i]->getTipoServicio();
                               $marcar="";
                               if($id_servicio==$idservicio){$marcar="selected='selected'";}
                               echo "<option value='$idservicio' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                  </tr>
              </table>
         </form>
        <?php 
        if($msg!=""){ echo $msg;}
        ?>
        
        <!--CONSULTA-->
        
        <form id="cc" method="post" action="addservicios.php" name="ccf">          
              <div class="<?php echo $mostrar_consulta;?>" id="consulta">
              <br>
              <h3 class="text-left"><i class="fa fa-user text-info"> Nueva Consulta</i></h3>
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Especialidad</th>
                      <th> Doctor</th>
                      <th> Fecha</th>
                  </tr>
                  <tr >
                      <td>
                          <input type="hidden" name="act_select_hidden" id="consulta_hidden" value="0">
                          <input type="hidden" name="servicios"  value="<?php echo $id_servicio;?>">
                          <input type="hidden" name="id_paciente_buscar"  value="<?php echo $idpaciente;?>">
                          <select name="idespecialidad" class="form-control" id="esp" onchange="SubmitConsulta();">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                                                            
                          for ($i = 0; $i < count($lista_especialidades); $i++) 
                            {
                               $idespecialidad=$lista_especialidades[$i]->getIdEspecialidad();
                               $nombre=$lista_especialidades[$i]->getNombreespecialidad();
                               $marcar="";
                               if($id_especialidad==$idespecialidad){$marcar="selected='selected'";}
                               echo "<option value='$idespecialidad' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td>
                          <select name="medicos" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_medicos); $i++) 
                            {
                               $id_medico=$lista_medicos[$i]->getIdMedico();
                               $nombre=$lista_medicos[$i]->getNombre();
                               $marcar="";
                               if($id_medico==$medicos){$marcar="selected='selected'";}
                               echo "<option value='$id_medico' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td><input type="date" name="fecha" class="form-control" value="<?php echo $fecha_consulta;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th >Indicaciones</th>
                      <th>Resultados</th>
                      <th> Precio</th>
                  </tr>
                  <tr>
                      <td>
                          <textarea class="form-control" name="indicaciones"><?php echo $indicaciones_consulta;?></textarea>
                      </td>
                      <td>
                          <textarea class="form-control" name="resultados"><?php echo $resultado_consulta;?></textarea>
                      </td>
                      <td><input type="text" name="precio" class="form-control" value="<?php echo $precio_consulta;?>"></td>
                  </tr>
              </table>
              <div class="text-right">
                  <button  type="submit" class="btn btn-success">Registrar</button>
                  <a href='index.php' class="btn btn-danger" >Cancelar</a>
              </div>
              </div>  
        </form>
        
        <!--CIRUGIA-->        
        <form name='cirugia' method="post" action="addservicios.php" id='cirugia_form'>
              <div class="<?php echo $mostrar_cirugia;?>" id="cirugia">
              <br>
              <h3 class="text-left"><i class="fa fa-plus-square text-info"> Nueva Cirugía</i></h3>
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Especialidad Quirúrgica</th>
                      <th> Nombre de la Cirugía</th>
                      <th colspan="2"> Cirujano Principal</th>
                      
                  </tr>
                  <tr >
                      <td>
                          <input type="hidden" name="act_select_hidden" id="cirugia_hidden" value="0">
                          <input type="hidden" name="servicios"  value="<?php echo $id_servicio;?>">
                          <input type="hidden" name="id_paciente_buscar"  value="<?php echo $idpaciente;?>">
                          <select name="especialidadquirurgica" class="form-control" onchange="SubmitCirugia();">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_especialidades); $i++) 
                            {
                               $id_especialidad=$lista_especialidades[$i]->getIdEspecialidad();
                               $nombre=$lista_especialidades[$i]->getNombreespecialidad();
                               $marcar="";
                               if($id_especialidad==$p_idespecialidad_quirurgica){$marcar="selected='selected'";}
                               echo "<option value='$id_especialidad' $marcar >$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td>
                          <select name="nombrecirugia" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_nombrec); $i++) 
                            {
                               $id_cirugia=$lista_nombrec[$i]->getIdNombreCirugia();
                               $nombre=$lista_nombrec[$i]->getNombreCirugia();
                               $marcar="";
                               if($id_cirugia==$p_id_cirugia){$marcar="selected='selected'";}
                               echo "<option value='$id_cirugia' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td colspan="2">
                          <select name="medicos" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_medicos); $i++) 
                            {
                               $id_medico=$lista_medicos[$i]->getIdMedico();
                               $nombre=$lista_medicos[$i]->getNombre();
                               $marcar="";
                               if($id_medico==$p_id_cirujano){$marcar="selected='selected'";}
                               echo "<option value='$id_medico' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      
                  </tr>
                  <tr class="text text-info">
                      <th>Duración</th>
                      
                      <th >Precio</th>
                      <th>Fecha</th>
                      <th colspan="2">Hora (24H)</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="duracion" class="form-control" value="<?php echo $p_duracion_cirugia;?>"></td>
                      
                      <td ><input type="text" name="precio" class="form-control" value="<?php echo $p_precio_cirugia;?>"></td>
                      <td><input type="date" name="fecha" class="form-control" required="" value="<?php echo $p_fecha_cirugia;?>"></td>
                      <td><input type="time" name="hora" class="form-control" required="" value="<?php echo $p_hora_cirugia;?>"></td>
                  </tr>
                 
              </table>
              
              <div class="col-md-12" >
                  
                  <table class="table table-bordered table-responsive" id="tabla_insumos">
                      <tr>
                          <th colspan="3" >
                              <label class="text-primary">Listado de Insumos</label> 
                                <div class="text-right">
                                  <button type='button' class='btn btn-primary btn-xs' title='Adicionar Insumos' data-toggle='modal' data-target='#divModal' style="margin-top: -45px;"><i class='fa fa-medkit'></i> Adicionar Insumos</button>
                                </div>
                               <input type="hidden" name="cantidad_insumos" id='cantidad_insumos' value="<?php echo $p_cantidad_insumos;?>">
                         
                          </th>
                      </tr>
                      <tr>
                      <th>Insumos</th>
                      <th>Cantidad</th>
                      <th>Acci&oacute;n</th>
                     </tr>
                     <?php 
                     if($p_cantidad_insumos!=0)
                    {                        
                         for ($i = 0; $i < count($p_lista_insumos); $i++) 
                         {
                           $insumobd=$p_lista_insumos[$i]['insumo'];  
                           $cantidadbd=$p_lista_insumos[$i]['cantidad'];  
                           
                           echo "<tr id='$i'>";
                           echo "<td><input type='text' name='insumo$i' value='$insumobd' readonly='readonly' class='form-control'></td>";
                           echo "<td><input type='number' name='cantidad$i' class='form-control' min='1' value='$cantidadbd'></td>";
                           echo "<td><button class='btn btn-danger brn-xs fa fa-close' id='$i' onclick='deleteRow(this.id);'></button></td>";
                           echo '</tr>';
                         }
                    }
                     ?>
                      
                  
              </table>
              </div>
              
               <div class="col-md-12" >
                  <table class="table table-responsive table-bordered" id="tabla_med_equipo">
                    <tr>
                        <th colspan="3" >
                            <label class="text-primary">Equipo M&eacute;dico</label>
                            <input type="hidden" name="cantidad_medicos" id='cantidad_med' value="<?php echo $p_cantidad_medicos;?>">
                            <div class="text-right">
                            <button type='button' class='btn btn-primary btn-xs' title='Adicionar Medicos' data-toggle='modal' ddata-toggle="modal" data-target="#divModalMed" style="margin-top: -45px;"><i class='fa fa-user-md'></i> Adicionar M&eacute;dico</button>
                            
                            </div>
                      </th>
                  </tr>
                  <tr>
                      <th>Nombre</th>
                      <th>Cargo</th>
                      <th>Acci&oacute;n</th>
                  </tr>
                  <?php 
                     if($p_cantidad_medicos!=0)
                    {                       
                         for ($i = 0; $i < count($p_lista_medicos); $i++) 
                         {
                             $med="";
                             $trab="";
                             if(isset($p_lista_medicos[$i]['med'])){$med=$p_lista_medicos[$i]['med'];  }
                             if(isset($p_lista_medicos[$i]['trab'])){$trab=$p_lista_medicos[$i]['trab'];  }
                           
                           $carg=$p_lista_medicos[$i]['cargo']; 
                           
                           echo "<tr id='e$i'>";
                           if($med!="")
                           {
                                echo "<td><input type='text' name='med$i' value='$med' readonly='readonly' class='form-control' id='med$i'></td>";
                           }
                           if($trab!="")
                           {
                               echo "<td><input type='text' name='trab$i' value='$trab' readonly='readonly' class='form-control' id='med$i'></td>";
                           }
                          
                           echo "<td><input type='text' name='cargo$i' class='form-control'  value='$carg' readonly='readonly'></td>";
                           echo "<td><button class='btn btn-danger brn-xs fa fa-close' id='e$i' onclick='deleteRow(this.id);'></button></td>";
                           echo '</tr>';
                         }
                    }
                     ?>
              </table>
              </div>
              
              <div class="text-right col-md-12">
                  <button  type="submit" class="btn btn-success">Registrar</button>
                  <a href='index.php' class="btn btn-danger" >Cancelar</a>
              </div>
              
             </div>
            <br><br><br>
        </form>
        
        <!--HOSPITALIZACION-->
        <form name='hospitalizacion' method="post" action="addservicios.php" id='hosp_form'>          
              <div class="<?php echo $mostrar_hospitalizacion;?>" id="hospitalizacion">
              <br>
              <h3 class="text-left"><i class="fa fa-user text-info"> Nuevo Ingreso</i></h3>
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th>Fecha Ingreso</th>
                      <th>Fecha de Alta</th>
                      <th>Duración</th>
                  </tr>
                  <tr>
                          <input type="hidden" name="act_select_hidden" id="hospitalizacion_hidden" value="0">
                          <input type="hidden" name="servicios"  value="<?php echo $id_servicio;?>">
                          <input type="hidden" name="id_paciente_buscar"  value="<?php echo $idpaciente;?>">
                      <td><input type="date" name="fechaingreso" class="form-control" required="" value="<?php echo $fechaingreso;?>"></td>  
                      <td><input type="date" name="fechaalta" class="form-control" value="<?php echo $fechaalta;?>"></td>
                      <td><input type="text" name="duracionhosp" class="form-control" value="<?php echo $duracionhosp;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Tipo de Habitación</th>
                      <th>Num. de Cama</th>
                      <th>Estado del Paciente</th>
                  </tr>
                  <tr>
                      <td>
                          <select name="habit" class="form-control" required="">
                              <option value=''>--SELECCIONE--</option>
                              <option value='f'>Full</option>
                              <option value='c'>Compartida</option>
                          </select>
                      </td>
                      <td><input type="text" name='numcama' class="form-control" required="" value='<?php echo $numcama;?>'></td>
                      <td><input type="text" name='estadopcte' class="form-control" required="" value='<?php echo $estadopcte;?>'></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Nombre del Familiar</th>
                      <th>Parentesco del Familiar</th>
                      <th>Condición de Atención</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="nombrefam" class="form-control" value='<?php echo $nombrefam;?>'></td>
                      <td><input type="text" name="parentescofam" class="form-control" value='<?php echo $parentescofam;?>'></td>
                      <td><input type="text" name='condicatencion' class="form-control" required="" value='<?php echo $condicatencion;?>'></td>
                  </tr>
                  <tr class="text text-info">
                      <th>PA</th>
                      <th>Pulso</th>
                      <th>Temperatura</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="pa" class="form-control" required="" value='<?php echo $pa;?>'></td>
                      <td><input type="text" name="pulso" class="form-control" required="" value='<?php echo $pulso;?>'></td>
                      <td><input type="text" name="temp" class="form-control" required="" value='<?php echo $temp;?>'></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Peso (Kg)</th>
                      <th>Examen Físico</th>
                      <th>Precio</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="peso" class="form-control" required="" value='<?php echo $peso;?>'></td>
                      <td>
                          <textarea class="form-control" name="examfis" required=""><?php echo $examfis;?></textarea>
                      </td>
                      <td><input type="text" name="preciohosp" class="form-control" value='<?php echo $preciohosp;?>'></td>
                  </tr>
              </table>
              <div class="text-right">
                  <button  type="submit" class="btn btn-success">Registrar</button>
                  <a href='index.php' class="btn btn-danger" >Cancelar</a>
                  <br>
                  <br>
              </div>
              <div class="col-md-5" >
                  <table class="table table-responsive" id="tabla_insumosH">
                    <tr>
                      <th colspan="3" >
                          <input type="hidden" name="cantidad_insumos" id='cantidad_insumosH' value="<?php echo $p_cantidad_insumos;?>">
                          <label>Listado de Insumos</label>
                            <div class="text-right">
                                <button type='button' class='btn btn-primary btn-xs' title='Adicionar Insumos' data-toggle='modal' data-target='#divModalHosp' style="margin-top: -45px;"><i class='fa fa-medkit'></i> Adicionar Insumos</button>
                            </div>
                      </th>
                      </tr>
                      <tr>
                      <th>Insumos</th>
                      <th>Cantidad</th>
                      <th>Acci&oacute;n</th>
                     </tr>
                     <?php 
                     if($p_cantidad_insumos!=0)
                    {                        
                         for ($i = 0; $i < count($p_lista_insumos); $i++) 
                         {
                           $insumobd=$p_lista_insumos[$i]['insumo'];  
                           $cantidadbd=$p_lista_insumos[$i]['cantidad'];  
                           
                           echo "<tr id='$i'>";
                           echo "<td><input type='text' name='insumo$i' value='$insumobd' readonly='readonly' class='form-control'></td>";
                           echo "<td><input type='number' name='cantidad$i' class='form-control' min='1' value='$cantidadbd'></td>";
                           echo "<td><button class='btn btn-danger brn-xs fa fa-close' id='$i' onclick='deleteRow(this.id);'></button></td>";
                           echo '</tr>';
                         }
                    }
                     ?>
                      
                  
              </table>
              </div>
              </div>
        </form>
        
        <!--RADIOLOGIA-->
        <form name='radiologia' method="post" action="addservicios.php" id='rad_form'>         
              <div class="<?php echo $mostrar_radiologia;?>" id="radiologia">
              <br>
              <h3 class="text-left"><i class="fa fa-user text-info"> Nueva Prueba Radiológica</i></h3>
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th>Tipo de Prueba</th>
                      <th>Nombre de la Prueba</th>
                      <th>Fecha</th>
                  </tr>
                  <tr >
                      <td>
                          <input type="hidden" name="act_select_hidden" id="radiologia_hidden" value="0">
                          <input type="hidden" name="servicios"  value="<?php echo $id_servicio;?>">
                          <input type="hidden" name="id_paciente_buscar"  value="<?php echo $idpaciente;?>">
                          <select name="tiporadiologia" class="form-control" required="" onchange="SubmitRadiologia();">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_tiporadiologia); $i++) 
                            {
                               $id_tiporadiologia=$lista_tiporadiologia[$i]->getIdTipoRadiologia();
                               $nombre=$lista_tiporadiologia[$i]->getTipoRadiologia();
                               $marcar="";
                               if($id_tiporadiologia==$tiporadiologia){$marcar="selected='selected'";}
                               echo "<option value='$id_tiporadiologia' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>    
                      <td>
                          <select name="nombreprueba" class="form-control" required="">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_nombreradiologia); $i++) 
                            {
                               $id_nombreradiologia=$lista_nombreradiologia[$i]->getIdnombreradiologia();
                               $nombre=$lista_nombreradiologia[$i]->getNombreradiologia();
                               $marcar="";
                               if($id_nombreradiologia==$nombreprueba){$marcar="selected='selected'";}
                               echo "<option value='$id_nombreradiologia' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td><input type="date" name="fechaprueba" class="form-control" required="" value="<?php echo $fechaprueba;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Laboratorio Radiológico</th>
                      <th> Resultados</th>
                      <th> Precio</th>
                  </tr>
                  <tr>
                      <td>
                          <select name="labrad" class="form-control" required="">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_labrad); $i++) 
                            {
                               $id_labrad=$lista_labrad[$i]->getIdlabradiologia();
                               $nombre=$lista_labrad[$i]->getNombrelabradiologia();
                               $marcar="";
                               if($id_labrad==$labrad){$marcar="selected='selected'";}
                               echo "<option value='$id_labrad' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td>
                          <textarea class="form-control" name="resultadorad"><?php echo $resultadosrad;?></textarea>
                      </td>
                      <td><input type="text" name="preciorad" class="form-control" required="" value="<?php echo $precio_rad;?>"></td>
                  </tr>
              </table>
              <div class="text-right">
                  <button  type="submit" class="btn btn-success">Registrar</button>
                  <a href='index.php' class="btn btn-danger" >Cancelar</a>
                  <br><br>
              </div>
              </div>
        </form>
        
        <!--LABORATORIO-->
        <form name='laboratorio' method="post" action="addservicios.php" id='lab_form'>          
              <div class="<?php echo $mostrar_laboratorio;?>" id="laboratorio">
              <br>
              <h3 class="text-left"><i class="fa fa-user text-info"> Nuevo Análisis de Laboratorio</i></h3>
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Tipo de Análisis</th>
                      <th> Nombre del Análisis</th>
                      <th> Fecha</th>
                  </tr>
                  <tr>
                      <td>
                          <input type="hidden" name="act_select_hidden" id="analisis_hidden" value="0">
                          <input type="hidden" name="servicios"  value="<?php echo $id_servicio;?>">
                          <input type="hidden" name="id_paciente_buscar"  value="<?php echo $idpaciente;?>">
                          <select name="tipoanalisis" class="form-control" required="" onchange="">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_tipoanalisislab); $i++) 
                            {
                               $id_tipoanalisis=$lista_tipoanalisislab[$i]->getIdTipoAnalisisLaboratorio();
                               $nombre=$lista_tipoanalisislab[$i]->getTipoAnalisis();
                               $marcar="";
                               if($id_tipoanalisis==$tipoanalisis){$marcar="selected='selected'";}
                               echo "<option value='$id_tipoanalisis' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td>
                          <select name="nombreanalisis" class="form-control" required="">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_nombreanalisis); $i++) 
                            {
                               $id_nombreanalisis=$lista_nombreanalisis[$i]->getIdnombreanalisis();
                               $nombreanalisis=$lista_nombreanalisis[$i]->getNombreanalisis();
                               $marcar="";
                               if($id_nombreanalisis==$nombreanalisis){$marcar="selected='selected'";}
                               echo "<option value='$id_nombreanalisis' $marcar>$nombreanalisis</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td><input type="date" name="fechaanalisis" class="form-control" required="" value="<?php echo $fecha_analisis;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Laboratorio Clínico</th>
                      <th>Resultados</th>
                      <th>Precio</th>
                  </tr>
                  <tr>
                      <td>
                          <select name="labclin" class="form-control" required="">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_labclin); $i++) 
                            {
                               $id_labclin=$lista_labclin[$i]->getIdlabclinico();
                               $nombre=$lista_labclin[$i]->getNombrelabclinico();
                               $marcar="";
                               if($id_labclin==$labclin){$marcar="selected='selected'";}
                               echo "<option value='$id_labclin' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td>
                          <textarea class="form-control" name="resultadolab"><?php echo $resultado_analisis;?></textarea>
                      </td>
                      <td><input type="text" name="preciolab" class="form-control" required="" value="<?php echo $precio_analisis;?>"></td>
                  </tr>
              </table>
              <div class="text-right">
                  <button  type="submit" class="btn btn-success">Registrar</button>
                  <a href='index.php' class="btn btn-danger" >Cancelar</a>
                  <br><br>
              </div>
              </div>
             
        </form>
   
    </div>
</section>
<!--div class="modal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true"></div>-->
<script>
document.getElementById('periodo').addEventListener('change', function() {
     var fform=document.getElementById('ff');
     var act_hidden=document.getElementById('act_hidden');
     
     act_hidden.value=2;
     fform.submit();
 
}, false);

</script>

<script>
    /**Este es el código que le da la funcionalidad a la modal
$('.btnModal').on("click", function(event) {
    event.preventDefault();
 
    var $contenedorModal = $('#myModal');
    var urlModal         = $(this).attr("href");
    var idModal          = $(this).data("idmodal");
 
    $contenedorModal.load(urlModal + ' ' + idModal , function(response) {
    $(this).modal({backdrop: "static"});
    });
});
*/

</script>


<div id="divModal" class='modal fade'  tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'> 
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #004731;"> 
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <img src='../img/clinica_logo.png' id="logo" class="pull-left" style="width: 50px; margin-top: -10px;">
            <h4 class="modal-title" id="H1" style="color: white;">Listado de Insumos para la Cirug&i&iacute;a</h4>
        </div>
        <div class="modal-body ">
                <img src="../img/medicamento.jpg" style="width: 120px;">
                <div style="margin-left: 155px;width: 70%!important; margin-top: -85px;">
                 Selecccione el Insumo
                <select name="insumos" class="form-control selectpicker" id="insumo" data-live-search='true'>
                    <option value=''>--SELECCIONE--</option>
                    <?php 
                  for ($i = 0; $i < count($lista_insumos); $i++) 
                  {
                     $id_insumo=$lista_insumos[$i]->getIdInsumo();
                     $nombre=$lista_insumos[$i]->getNombre();
                     $marcar="";
                     if($id_insumo==$insumos){$marcar="selected='selected'";}
                     echo "<option value='$nombre' $marcar>$nombre</option>";
                  }
                    ?>
                </select>
            </div>
            
                    
        </div>
        <br>
        <div class="modal-footer">
            <button  type="button" class="btn btn-success" onclick="AddInsumos();">Adicionar</button>
            <button class="btn btn-danger " data-dismiss="modal" id="m_em">Cancelar</button>
        </div>
    </div> 
    </div>
</div>

<div id="divModalMed" class='modal fade'  tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' > 
    <div class="modal-dialog">
        <div class="modal-content">
       <div class="modal-header" style="background-color: #004731;"> 
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <img src='../img/clinica_logo.png' id="logo" class="pull-left" style="width: 50px; margin-top: -10px;">
            <h4 class="modal-title" id="H1" style="color: white;">Listado de Miembros para el equipo de la Cirug&i&iacute;a</h4>
        </div>
        <div class="modal-body ">
            <img src="../img/doctores.png" style="width: 120px;" id='imagen_modal'>
                <div style="margin-left: 155px;width: 70%!important; margin-top: -85px;">
                    
                    <input type="radio" name="medic" id="tipoM" onclick="MostrarSelect();" checked="checked"> M&eacute;dico
                    <input type="radio" name="medic" id="tipoE" onclick="MostrarSelect();" > Enfermer&iacute;a
                </div>
                
                <div style="margin-left: 155px;width: 70%!important; margin-top: -30px;" class="" id='select_med' >
                    <br><br>
                    <label>Selecccione el personal M&eacute;dico</label>
                    <select name="personal_med" class="form-control selectpicker" id="pers_med" data-live-search='true'>
                        <option value=''>--SELECCIONE--</option>
                        <?php 
                      for ($i = 0; $i < count($lista_medicos); $i++) 
                      {
                         $id_m=$lista_medicos[$i]->getIdMedico();
                         $nombre=$lista_medicos[$i]->getNombre();
                         echo "<option value='$nombre' >$nombre</option>";
                      }
                        ?>
                    </select>
                    <label>Selecccione el rol a desempe&ntilde;ar</label>
                    <select name="carg" class="form-control selectpicker" id="cargM" data-live-search='true'>
                        <option value=''>--SELECCIONE--</option>
                        <?php 
                      for ($i = 1; $i < count($lista_roles_medicos); $i++) 
                      {
                         $id_m=$lista_roles_medicos[$i]['id_rol'];
                         $nombre=$lista_roles_medicos[$i]['nombre'];
                         echo "<option value='$nombre' >$nombre</option>";
                      }
                        ?>
                    </select>
                    
                </div>                
                <div style="margin-left: 155px;width: 70%!important; margin-top: -30px;" class="hidden" id="select_enf">
                    <br><br>
                    <label>Selecccione el personal de enfermeria</label>
                    <select name="insumos" class="form-control selectpicker" id="pers_enf" data-live-search='true'>
                        <option value=''>--SELECCIONE--</option>
                        <?php 
                      for ($i = 0; $i < count($lista_trabajadores); $i++) 
                      {
                         $id_trab=$lista_trabajadores[$i]->getIdTrabajador();
                         $nombre=$lista_trabajadores[$i]->getNombre();
                         
                         echo "<option value='$nombre'>$nombre</option>";
                      }
                        ?>
                    </select>
                    <label>Seleccione el rol a realizar en la cirug&iacute;a</label>
                    <select name="cargos" class="form-control selectpicker" id="cargE" data-live-search='true'>
                        <option value=''>--SELECCIONE--</option>
                        <?php 
                      for ($i = 0; $i < count($lista_roles_enf); $i++) 
                      {
                         $id_trab=$lista_roles_enf[$i]['id_rol'];
                         $nombre=$lista_roles_enf[$i]['nombre'];
                         
                         echo "<option value='$nombre'>$nombre</option>";
                      }
                        ?>
                    </select>
                    
            </div>
            
                    
        </div>
       
        <br>
        <div class="modal-footer">
            <button  type="button" class="btn btn-success" onclick="AddEquipo();">Adicionar</button>
            <button class="btn btn-danger " data-dismiss="modal" id="m_equipoMF">Cancelar</button>
        </div>
         </div>
    </div>
</div>

<!--Modal insumo hospitalizacion -->
<div class="col-lg-12">
   
        <div class="modal fade" id="divModalHosp" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #004731;"> 
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <img src='../img/clinica_logo.png' id="logo" class="pull-left" style="width: 50px; margin-top: -10px;">
                            <h4 class="modal-title" id="H1" style="color: white;">Listado de Insumos para la Hospitalizaci&oacute;n</h4>
                        </div>
                        <div class="modal-body">
                            <img src="../img/medicamento.jpg" style="width: 120px;">
                            <div style="margin-left: 155px;width: 70%!important; margin-top: -85px;">
                             Selecccione el Insumo
                            <select name="insumos" class="form-control selectpicker" id="insumoH" data-live-search='true'>
                                <option value=''>--SELECCIONE--</option>
                                <?php 
                              for ($i = 0; $i < count($lista_insumos); $i++) 
                              {
                                 $id_insumo=$lista_insumos[$i]->getIdInsumo();
                                 $nombre=$lista_insumos[$i]->getNombre();
                                 $marcar="";
                                 if($id_insumo==$insumos){$marcar="selected='selected'";}
                                 echo "<option value='$nombre' $marcar>$nombre</option>";
                              }
                                ?>
                            </select>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button  type="button" class="btn btn-success" onclick="AddInsumosHosp();">Adicionar</button>
                            <button class="btn btn-danger " data-dismiss="modal" id="m_em">Cancelar</button>
                        </div>
                        
                    </div>
                </div>
            </div>
</div>
