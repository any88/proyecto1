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
          <h3 class="section-title">Panel de Control</h3>
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
          <div class="service-icon"><i class="fa fa-plus"></i></div>
          <h4 class="service-title"><a href="#" onclick="Msg();">Servicios</a></h4>
          <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-cart-plus"></i></div>
          <h4 class="service-title"><a href="#" onclick="Msg();">Caja</a></h4>
         <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-flask"></i></div>
          <h4 class="service-title"><a href="#" onclick="Msg();">Farmacia</a></h4>
         <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-bar-chart"></i></div>
          <h4 class="service-title"><a href="#" onclick="Msg();">Reportes</a></h4>
          <p class="service-description">Descripci&oacute;n..</p>
        </div>
        <div class="col-md-4 service-item">
          <div class="service-icon"><i class="fa fa-cogs"></i></div>
          <h4 class="service-title"><a href="nomencladores.php">Administraci&oacute;n</a></h4>
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





