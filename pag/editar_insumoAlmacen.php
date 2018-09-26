<?php
session_start();
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/InsumoAlmacenController.php';
include '../modelo/InsumoController.php';
include '../modelo/ProveedorController.php';
include '../modelo/CategoriaAlmacenController.php';


$objInsumoAlmacenC=new InsumoAlmacenController();
$objInsumoC=new InsumoController();
$objProveedor=new ProveedorController();

$msg="";
$error=0;

$lista_insumos=$objInsumoC->MostrarInsumo();
$p_id_insumo="";
$p_nombre_insumo="";
$lista_proveedores=$objProveedor->MostrarProveedor();
$p_id_proveedor="";
$p_nombre_proveedor="";

$p_cantidad=0;
$p_precio=0;
$p_precio_venta=0;
$p_fecha_compra="";
$p_fecha_vencimiento="";
$p_lote="";

$id_ins_almacen="";
if($_GET)
{
    if(isset($_GET['nik'])){$id_ins_almacen=$_GET['nik'];}
    if(eliminarblancos($id_ins_almacen)!="")
    {
        $datos_insAlmacen=$objInsumoAlmacenC->BuscarInsumoAlmacen($id_ins_almacen, "", "", "", "", "", "", "", "");
        if(count($datos_insAlmacen)>0)
        {
            $p_id_insumo=$datos_insAlmacen[0]->getId_insumo();
            $p_id_proveedor=$datos_insAlmacen[0]->getId_proveedor();
            $p_cantidad=$datos_insAlmacen[0]->getCantidad();
            $p_precio=$datos_insAlmacen[0]->getPrecio_compra();
            $p_precio_venta=$datos_insAlmacen[0]->getPrecio_venta();
            $p_lote=$datos_insAlmacen[0]->getLote();
            $p_fecha_compra=$datos_insAlmacen[0]->getFecha_compra();
            $p_fecha_vencimiento=$datos_insAlmacen[0]->getFecha_vencimiento();
        }
        else
        {
             $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "No se encontraron los datos del insumo seleccionado.</div>";
             $_SESSION['msg']=$msg;
             echo "<script>";
                echo "window.location = 'almacen_gestion.php';";
            echo "</script>";
        }
    }
    else
    {
        echo "<script>";
            echo "window.location = 'almacen_gestion.php';";
        echo "</script>";
    }
}

if($_POST)
{
    
    if(isset($_POST['ins_almacen'])){$id_ins_almacen=eliminarblancos($_POST['ins_almacen']);}
    if(isset($_POST['insumo'])){$p_id_insumo=eliminarblancos($_POST['insumo']);}
    if(isset($_POST['cantidad'])){$p_cantidad=eliminarblancos($_POST['cantidad']);}
    if(isset($_POST['precio_compra'])){$p_precio=eliminarblancos($_POST['precio_compra']);}
    if(isset($_POST['precio_venta'])){$p_precio_venta=eliminarblancos($_POST['precio_venta']);}
    if(isset($_POST['fecha_compra'])){$p_fecha_compra=eliminarblancos($_POST['fecha_compra']);}
    if(isset($_POST['fecha_vencimiento'])){$p_fecha_vencimiento=eliminarblancos($_POST['fecha_vencimiento']);}
    if(isset($_POST['proveedor'])){$p_id_proveedor=eliminarblancos($_POST['proveedor']);}
    if(isset($_POST['lote'])){$p_lote=eliminarblancos($_POST['lote']);}
    
    $p_lote= strtoupper($p_lote);
    if($p_id_insumo=="" || $p_id_proveedor=="" || $p_cantidad==0 || $p_cantidad=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error! Los campos 'Insumo','Cantidad' y 'Proveedor' no pueden quedar vac&iacute;os.</div>";
        $error++;
    }
    else
    {
        if(isNaN($p_cantidad))
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error! EL campo cantidad de Insumos solo admite n&uacute;meros.</div>";
            $error++;
        }
        if(isNaN($p_precio))
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error! EL campo precio de compra solo admite n&uacute;meros.</div>";
            $error++;
        }
        if(isNaN($p_precio_venta))
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error! EL campo precio de ventas solo admite n&uacute;meros.</div>";
            $error++;
        }
    }
    
    if($error==0)
    {
        $affected=$objInsumoAlmacenC->ModificarInsumoAlmacen($id_ins_almacen,$p_id_insumo, $p_cantidad, $p_precio, $p_fecha_compra, $p_precio_venta, $p_lote, $p_fecha_vencimiento, $p_id_proveedor);
        
        if($affected==0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error! No se pudo editar el insumo.</div>";
        }
        else
        {
            $msg="<div class='alert alert-success alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "OK! Insumo editado correctamente.</div>";
            
            $_SESSION['msg']=$msg;
            echo "<script>";
                echo "window.location = 'almacen_gestion.php';";
           echo "</script>";

        }
    }
    
    
    
}



include './menu_almacen.php';
?>
<br><br>
<section class="about-text">
    <div class="ingres_costo ">
        <div class="col-md-12">
          <?php 
          if($msg!=""){echo $msg;}
          ?>
            <form method="post" action="editar_insumoAlmacen.php">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b class="text-left"><i class="fa fa-medkit text-info"> GESTION DE ALMACEN</i></b>

                </div>
                <div class="panel-body">
                    <div class="col-md-3">
                        <img class="pic" src="../img/medicamento.jpg">
                    </div>
                    <div class="col-md-9">
                        <input type="hidden" name="ins_almacen" value="<?php echo $id_ins_almacen;?>">
                        <label>Seleccione el insumo</label>
                        <select name="insumo" class='form-control selectpicker' data-live-search='true' required="true">
                            <option value="">--SELECCIONE EL INSUMO--</option>
                            <?php 
                                for ($i = 0; $i < count($lista_insumos); $i++) 
                                {
                                    $id_insumo=$lista_insumos[$i]->getIdInsumo();
                                    $nombre_insumo=$lista_insumos[$i]->getNombre();
                                    $selected="";
                                    if($id_insumo==$p_id_insumo){$selected="selected='selected'";}
                                    echo "<option value='$id_insumo' $selected>$nombre_insumo</option>";
                                }
                            ?>
                        </select>
                        <label>Cantidad</label>
                        <input type="text" name="cantidad" class="form-control" value="<?php echo $p_cantidad;?>" required="true">
                        <label>Precio de Compra</label>
                        <input type="text" name="precio_compra" class="form-control" value="<?php echo $p_precio;?>" required="">
                        <label>Precio de Venta</label>
                        <input type="text" name="precio_venta" class="form-control" value="<?php echo $p_precio_venta;?>">
                        <label>Fecha de Compra</label>
                        <input type="date" name="fecha_compra" class="form-control" value="<?php echo $p_fecha_compra;?>">
                        <label>Fecha de Vencimiento</label>
                        <input type="date" name="fecha_vencimiento" class="form-control" value="<?php echo $p_fecha_vencimiento;?>">
                        <label>Lote</label>
                        <input type="text" name="lote" class="form-control" value="<?php echo $p_lote;?>" style='text-transform:uppercase;' required="">
                        <label>Proveedor</label>
                        <select name="proveedor" class='form-control selectpicker' data-live-search='true'>
                            <option value="">--SELECCIONE EL PROVEEDOR--</option>
                            <?php 
                                for ($i = 0; $i < count($lista_proveedores); $i++) 
                                {
                                    $id_prov=$lista_proveedores[$i]->getIdProveedor();
                                    $nombre_prov=$lista_proveedores[$i]->getNombre();
                                    $selected="";
                                    if($id_prov==$p_id_proveedor){$selected="selected='selected'";}
                                    echo "<option value='$id_prov' $selected>$nombre_prov</option>";
                                }
                            ?>
                        </select>
                        <br><br>
                    </div>
                    <br><br>
                    <div class="pull-right">
                        <a href="almacen_gestion.php" class="btn btn-danger"> Volver</a>
                        <button type="submit" class="btn btn-success"> Editar</button>
                    </div>
                </div>
            </div>
           
                
           </form>
        </div>
    </div>
</section>

