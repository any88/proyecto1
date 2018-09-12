<div class="nav-side-menu">
    <div class="brand">MENU DE CAJA</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
                <li>
                    <a href="balance_caja.php">
                  <i class="fa fa-dashboard fa-lg"></i>BALANCE DE CAJA
                  </a>
                </li>

                <li  data-toggle="collapse" data-target="#products" >
                    <a href="#"><i class="fa fa-book"></i>GESTION DE COBROS <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="products">
                    <li class="active"><a href="cobros_pendientes.php">Cobros Pendientes</a></li>
                    
                </ul>

                  <li>
                      <a href="ingresos_del_dia.php">
                          <i class="fa fa-user fa-money"></i> INGRESOS DEL DIA
                  </a>
                  </li>
                <li data-toggle="collapse" data-target="#service" class="collapsed">
                  <a href="#"><i class="fa fa-globe fa-lg"></i> GESTION DE CAJA<span class="arrow"></span></a>
                </li>  
                <ul class="sub-menu collapse" id="service">
                    <li class="active" ><a href="caja_declarar_ingreso.php">Declarar Ingreso de Efectivo</a></li>
                    <li><a href="extraccion_efectivo.php" >Extracci&oacute;n de Efectivo</a></li>
                    <li><a href="#" onclick="Msg();">Ver Movimientos de Caja</a></li>
                    
                </ul>
                
            </ul>
     </div>
</div>

