<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/PacienteController.php';
include '../modelo/ServicioController.php';
include '../modelo/consultas_genericas.php';

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-search-plus text-info"> </i> Datos del Paciente</h3>
          <div class="col-md-2" ></div>
          <div class="col-md-8" >
              <input type="text" name="user" class="form-control" value="<?php echo "";?>">
              <button type="button" class="btn btn-success"> Buscar</button>          
          </div>
          <div class="col-md-2" ></div>
          
        </div>
    </div>
</section>
