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
?>

  <section id="services">
  
 

<div class="container">


      <div class="row">
        <div class="col-md-12">
          <h3 class="section-title">Panel de Administración</h3>
          <div class="section-title-divider"></div>
          
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-user"></i></div>
          <h4 class="service-title"><a href="listar_pacientes.php">Pacientes</a></h4>
          <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-user-md"></i></div>
          <h4 class="service-title"><a href="listar_medicos.php">Medicos</a></h4>
          <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-user"></i></div>
          <h4 class="service-title"><a href="listar_trabajadores.php">Trabajadores</a></h4>
         <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="glyphicon glyphicon-heart"></i></div>
          <h4 class="service-title"><a href="listar_aseguradoras.php">Aseguradoras</a></h4>
         <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="glyphicon glyphicon-star"></i></div>
          <h4 class="service-title"><a href="listar_especialidades.php">Especialidades</a></h4>
          <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-angle-double-up"></i></div>
          <h4 class="service-title"><a href="listar_cargos.php">Cargos</a></h4>
           <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-medkit"></i></div>
          <h4 class="service-title"><a href="listar_insumos.php">Insumos</a></h4>
         <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-truck"></i></div>
          <h4 class="service-title"><a href="listar_proveedores.php">Proveedores</a></h4>
          <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-hospital-o"></i></div>
          <h4 class="service-title"><a href="listar_tiposervicio.php">Tipo de Servicio</a></h4>
           <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-flask"></i></div>
          <h4 class="service-title"><a href="listar_tipoanalisislaboratorio.php">Grupos de Análisis</a></h4>
         <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-area-chart"></i></div>
          <h4 class="service-title"><a href="listar_tiporadiologia.php">Grupos de Pruebas Radiológicas</a></h4>
          <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-hand-scissors-o"></i></div>
          <h4 class="service-title"><a href="listar_nombrecirugia.php">Tipo de Cirugía</a></h4>
           <p class="service-description">Descripci&oacute;n..</p>
        </div>  
          <div class="col-md-12"></div>
          <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-flask"></i></div>
          <h4 class="service-title"><a href="listar_analisislaboratorio.php">Tipo de Análisis</a></h4>
         <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-area-chart"></i></div>
          <h4 class="service-title"><a href="listar_pruebasradiologia.php">Tipo de Prueba Radiológica</a></h4>
          <p class="service-description">Descripci&oacute;n..</p>
        </div>
        
       
          
      </div>
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