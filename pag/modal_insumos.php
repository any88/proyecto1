<?php
include '../funct/con_tacnamh_db.php';
include '../modelo/InsumoController.php';
$lista_insumos=array();
$objInsumo=new InsumoController();
$lista_insumos=$objInsumo->MostrarInsumo();
 
?>

<div id="divModal" class="modal-dialog" >
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <img src='../img/clinica_logo.png' id="logo" class="pull-left" style="width: 50px;">
            <h4 class="modal-title ">&nbsp;&nbsp; Insumos </h4><br>
            
        </div>
        <div class="modal-body">
            Insumos
            <select name="insumos" class="form-control" id="insumo">
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
                    
        </div>
        <br>
        <div class="modal-footer">
            <button  type="button" class="btn btn-success" onclick="AddInsumos();">Adicionar</button>
            <button class="btn btn-danger " data-dismiss="modal">Cancelar</button>
        </div>
    </div>
</div>

