<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/EspecialidadController.php';
include '../modelo/MedicoController.php';
include '../modelo/TipoServicioController.php';
include '../modelo/TipoAnalisisLaboratorioController.php';
include '../modelo/TipoRadiologiaController.php';
include '../modelo/NombreCirugiaController.php';
include '../modelo/NombreAnalisisLaboratorioController.php';
include '../modelo/NombreRadiologiaController.php';
include '../modelo/InsumoController.php';

//$msg="";
$objMedico=new MedicoController();
$objEspecialidad= new EspecialidadController();
$objTipoServicio= new TipoServicioController();
$objTipoAnalisisLab= new TipoAnalisisLaboratorioController();
$objTipoRadiologia= new TipoRadiologiaController();
$objNombreCirugia= new NombreCirugiaController();
$objNombreAnalisis= new NombreAnalisisLaboratorioController();
$objNombreRadiologia= new NombreRadiologiaController();
$objInsumo= new InsumoController();
$lista_medicos=$objMedico->MostrarMedico();
$lista_especialidades=$objEspecialidad->MostrarEspecialidad();
$lista_tiposervicios=$objTipoServicio->MostrarTipoServicio();
$lista_tiporadiologia=$objTipoRadiologia->MostrarTipoRadiologia();
$lista_nombrec=$objNombreCirugia->MostrarNombreCirugia();
$lista_nombreanalisis=$objNombreAnalisis->MostrarNombreAnalisis();
$lista_nombreradiologia=$objNombreRadiologia->MostrarNombreRadiologia();
$lista_tipoanalisislab=$objTipoAnalisisLab->MostrarTipoAnalisisLaboratorio();
$lista_insumos=$objInsumo->MostrarInsumo();

##variables
$a="";
$id_especialidad="";
$mostrar_consulta="hidden";

if($_GET)
    {
        if(isset($_GET["nik"]))
        {
            $idpaciente= $_GET["nik"];
            //Mostrar($idpaciente);
        }
    }

if($_POST)
    {   // Mostrar($_POST);
    if(isset($_POST["act_select_hidden"]))
        {
            $act_select_hidden=$_POST["act_select_hidden"];
            if($act_select_hidden==1)
            {
                ##consulta
                $mostrar_consulta="";
                
            }
            if($act_select_hidden==2)
            {
                ##c
            }
            
            if($act_select_hidden==0)
            {
                ##completo
            }
    
        }
    }

?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-hospital-o"> Nuevo Servicio</i></h3>
          <?php 
             //echo $msg;
          ?>
          <form name="nuevo_servicio" method="post" action="crearservicio.php" id="ff">
              <br>
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      
                      <th>Seleccione el Tipo de Servicio</th>
                  </tr>
                  <tr>                      
                      <td>
                          <input type="hidden" name="act_select_hidden" id="act_hidden" value="0">
                          <select name="servicios" class="form-control" id="periodo">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                              
                            for ($i = 0; $i < count($lista_tiposervicios); $i++) 
                            {
                               $id_servicio=$lista_tiposervicios[$i]->getIdTipoServicio();
                               $nombre=$lista_tiposervicios[$i]->getTipoServicio();
                               $marcar="";
                               if($id_servicio==$servicios){$marcar="selected='selected'";}
                               echo "<option value='$id_servicio' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                  </tr>
              </table>
          
          
              <!--CONSULTA-->
              <div class="<?php echo $mostrar_consulta;?>" id="consulta">
              <br>
              <h3 class="text-left"><i class="fa fa-user text-info"> Nueva Consulta</i></h3>
              <div id="respuesta"></div>
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Especialidad</th>
                      <th> Doctor</th>
                      <th> Fecha</th>
                  </tr>
                  <tr >
                      <td>
                          <select name="idespecialidad" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                              
                            for ($i = 0; $i < count($lista_especialidades); $i++) 
                            {
                               $id_especialidad=$lista_especialidades[$i]->getIdEspecialidad();
                               $nombre=$lista_especialidades[$i]->getNombreespecialidad();
                               $marcar="";
                               if($id_especialidad==$idespecialidad){$marcar="selected='selected'";}
                               echo "<option value='$id_especialidad' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td>
                          <select name="medicos" class="form-control" id='medicos_select'>
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
                      <td><input type="date" name="fecha" class="form-control" value="<?php echo $a;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th >Indicaciones</th>
                      <th>Resultados</th>
                      <th> Precio</th>
                  </tr>
                  <tr>
                      <td>
                          <textarea class="form-control" name="indicaciones"><?php echo $a;?></textarea>
                      </td>
                      <td>
                          <textarea class="form-control" name="resultados"><?php echo $a;?></textarea>
                      </td>
                      <td><input type="text" name="precio" class="form-control" value="<?php echo $a;?>"></td>
                  </tr>
              </table>
              </div>    
             
              <!--CIRUGIA-->
              <div class="hidden" id="cirugia">
              <br>
              <h3 class="text-left"><i class="fa fa-user text-info"> Nueva Cirugía</i></h3>
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Especialidad Quirúrgica</th>
                      <th> Nombre de la Cirugía</th>
                      <th> Cirujano Principal</th>
                      <th>Fecha</th>
                  </tr>
                  <tr >
                      <td>
                          <select name="especialidadquirurgica" class="form-control" >
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($lista_medicos); $i++) 
                            {
                               $id_medico=$lista_especialidades[$i]->getIdEspecialidad();
                               $nombre=$lista_especialidades[$i]->getNombreespecialidad();
                               $marcar="";
                               if($id_especialidad==$especialidadquirurgica){$marcar="selected='selected'";}
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
                               if($id_cirugia==$nombrecirugia){$marcar="selected='selected'";}
                               echo "<option value='$id_cirugia' $marcar>$nombre</option>";
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
                      <td><input type="date" name="fecha" class="form-control" required="" value="<?php echo $a;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Duración</th>
                      <th>Insumos</th>
                      <th>Precio</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="duracion" class="form-control" value="<?php echo $a;?>"></td>
                      <td>
                          <select name="insumos" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php 
                            for ($i = 0; $i < count($lista_insumos); $i++) 
                            {
                               $id_insumo=$lista_insumos[$i]->getIdInsumo();
                               $nombre=$lista_insumos[$i]->getNombre();
                               $marcar="";
                               if($id_insumo==$insumos){$marcar="selected='selected'";}
                               echo "<option value='$id_insumo' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td><input type="text" name="precio" class="form-control" value="<?php echo $a;?>"></td>
                  </tr>
              </table>
             </div>
              
              <!--HOSPITALIZACION-->
              <div class="hidden" id="hosp">
              <br>
              <h3 class="text-left"><i class="fa fa-user text-info"> Nuevo Ingreso</i></h3>
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Fecha Ingreso</th>
                      <th> Fecha de Alta</th>
                      <th> Duración</th>
                  </tr>
                  <tr >
                      <td><input type="date" name="fechaingreso" placeholder="Nombre(s) Apellido1 Apellido2" class="form-control" required="" value="<?php echo $a;?>"></td>
                      <td><input type="date" name="fechaalta" class="form-control" required="" value="<?php echo $a;?>"></td>
                      <td><input type="text" name="duracion" class="form-control" value="<?php echo $a;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th >Tipo de Habitación</th>
                      <th>Num. de Cama</th>
                      <th>Estado del Paciente</th>
                  </tr>
                  <tr>
                      <td>
                          <select name="tipocirugia" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <option value=''>Full</option>
                              <option value=''>Compartida</option>
                          </select>
                      </td>
                      <td><input type="text" name='numdecama' class="form-control" value='<?php echo $a;?>'></td>
                      <td><input type="text" name='estadopaciente' class="form-control" value='<?php echo $a;?>'></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Nombre del Familiar</th>
                      <th>Parentesco del Familiar</th>
                      <th>Condición de Atención</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="nombrefamiliar" class="form-control" value='<?php echo $a;?>'></td>
                      <td><input type="text" name="parentescofamiliar" class="form-control" value='<?php echo $a;?>'></td>
                      <td><input type="text" name='condatencion' class="form-control" required="" value='<?php echo $a;?>'></td>
                  </tr>
                  <tr class="text text-info">
                      <th >PA</th>
                      <th >Pulso</th>
                      <th>Temperatura</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="pa" class="form-control" value='<?php echo $a;?>'></td>
                      <td><input type="text" name="pulso" class="form-control" value='<?php echo $a;?>'></td>
                      <td><input type="text" name="temperatura" class="form-control" value='<?php echo $a;?>'></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Peso (Kg)</th>
                      <th>Examen Físico</th>
                      <th>Precio</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="peso" class="form-control" value='<?php echo $a;?>'></td>
                      <td>
                          <textarea class="form-control" name="examenfisico"><?php echo $a;?></textarea>
                      </td>
                      <td><input type="text" name="precio" class="form-control" value='<?php echo $a;?>'></td>
                  </tr>
              </table>
             </div>
              
              <!--RADIOLOGIA-->
              <div class="hidden" id="rad">
              <br>
              <h3 class="text-left"><i class="fa fa-user text-info"> Nueva Prueba de Radiología</i></h3>
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Tipo de Prueba</th>
                      <th>Nombre de la Prueba</th>
                      <th>Fecha</th>
                  </tr>
                  <tr >
                      <td>
                          <select name="tiporadiologia" class="form-control">
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
                          <select name="nombreprueba" class="form-control">
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
                      <td><input type="date" name="fecha" class="form-control" value="<?php echo $a;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th> Precio</th>
                      <th> Resultados</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="precio" class="form-control" value="<?php echo $a;?>"></td>
                      <td>
                          <textarea class="form-control" name="resultado"><?php echo $a;?></textarea>
                      </td>
                  </tr>
              </table>    
              </div>
        
              <!--LABORATORIO-->
              <div class="hidden" id="lab">
              <h3 class="text-left"><i class="fa fa-user text-info"> Nuevo Análisis de Laboratorio</i></h3>
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Tipo de Análisis</th>
                      <th> Nombre del Análisis</th>
                      <th> Fecha</th>
                  </tr>
                  <tr >
                      <td>
                          <select name="tipoanalisis" class="form-control">
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
                          <select name="nombreanalisis" class="form-control">
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
                      <td><input type="date" name="fecha" class="form-control" required="" value="<?php echo $a;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th >Precio</th>
                      <th >Resultados</th>
                  <tr>
                      <td><input type="text" name="precio" class="form-control" required="" value="<?php echo $a;?>"></td>
                      <td>
                          <textarea class="form-control" name="resultados"><?php echo $a;?></textarea>
                      </td>
                  </tr>
              </table>
              </div>
              <div class="text-right">
                  <button  type="submit" class="btn btn-success">Registrar</button>
                  <a href='index.php' class="btn btn-danger" >Cancelar</a>
              </div>
              <br>
          </form> 
          
        </div>
        
        
    </div>
</section>

<script>
document.getElementById('periodo').addEventListener('change', function() {
     var fform=document.getElementById('ff');
     var act_hidden=document.getElementById('act_hidden');
     var select=document.getElementById('periodo');
     
     //variables
     var consulta=document.getElementById('consulta');
     var cirugia=document.getElementById('cirugia');
     var hosp=document.getElementById('hosp');
     var rad=document.getElementById('rad');
     var lab=document.getElementById('lab');
     
     if(select.value==1)
     {
         act_hidden.value=1;
         
         consulta.setAttribute("class","");
         cirugia.setAttribute("class","hidden");
         hosp.setAttribute("class","hidden");
         rad.setAttribute("class","hidden");
         lab.setAttribute("class","hidden");
         
     }
     if(select.value==2)
     {
         act_hidden.value=2;
         
         cirugia.setAttribute("class","");
         consulta.setAttribute("class","hidden");         
         hosp.setAttribute("class","hidden");
         rad.setAttribute("class","hidden");
         lab.setAttribute("class","hidden");
     }
     if(select.value==3)
     {
         act_hidden.value=3;
         
         hosp.setAttribute("class","");
         consulta.setAttribute("class","hidden");
         cirugia.setAttribute("class","hidden");
         rad.setAttribute("class","hidden");
         lab.setAttribute("class","hidden");
     }
     if(select.value==4)
     {
         act_hidden.value=4;
         
         rad.setAttribute("class","");
         lab.setAttribute("class","hidden");
         consulta.setAttribute("class","hidden");
         cirugia.setAttribute("class","hidden");
         hosp.setAttribute("class","hidden");
     }
     if(select.value==5)
     {
         act_hidden.value=5;
         
         lab.setAttribute("class","");
         consulta.setAttribute("class","hidden");
         cirugia.setAttribute("class","hidden");
         hosp.setAttribute("class","hidden");
         rad.setAttribute("class","hidden");
         
     }
     //fform.submit();
 
   /***/
    //h_p.value=1;   
    //f_periodo.submit();
}, false);

</script>