<?php
class InsumoAlmacen
{
    private $id_insumo_almacen;
    private $id_insumo;
    private $cantidad;
    private $precio_compra;
    private $fecha_compra;
    private $precio_venta;
    private $lote;
    private $fecha_vencimiento;
    private $id_proveedor;
    
            
    function __construct($id_insumo_almacen, $id_insumo, $cantidad, $precio_compra, $fecha_compra, $precio_venta, $lote, $fecha_vencimiento, $id_proveedor) {
        $this->id_insumo_almacen = $id_insumo_almacen;
        $this->id_insumo = $id_insumo;
        $this->cantidad = $cantidad;
        $this->precio_compra = $precio_compra;
        $this->fecha_compra = $fecha_compra;
        $this->precio_venta = $precio_venta;
        $this->lote = $lote;
        $this->fecha_vencimiento = $fecha_vencimiento;
        $this->id_proveedor = $id_proveedor;
    }
  

        function getId_insumo_almacen() {
        return $this->id_insumo_almacen;
    }

    function getId_insumo() {
        return $this->id_insumo;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getPrecio_compra() {
        return $this->precio_compra;
    }

    function getFecha_compra() {
        return $this->fecha_compra;
    }

    function getPrecio_venta() {
        return $this->precio_venta;
    }

    function getLote() {
        return $this->lote;
    }

    function getFecha_vencimiento() {
        return $this->fecha_vencimiento;
    }

    function getId_proveedor() {
        return $this->id_proveedor;
    }



}

