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
            <div class="panel-heading"><b>Servicios Agendados Para Hoy (<?php echo FechaYMA();?>)</b> <a href="#" title='Ver agenda' class="pull-right btn btn-primary btn-xs"><i class=" fa fa-calendar"></i></a></div>
           <div class="panel-body">
               <table class="table table-responsive" id="dataTables-example">
                   <thead>
                       <tr>
                            <th>Servicio</th>
                            <th>Especialidad</th>
                            <th>Doctor</th>
                            <th>Paciente</th>
                       </tr>
                   </thead>
                   <tbody>
                       
                   </tbody>
                   
                   
               </table>
            
           </div>
            
        </div>
    </div>
</div>
    <div class="col-md-12"></div>
    
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





