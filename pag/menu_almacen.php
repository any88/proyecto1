<div class="nav-side-menu" >
    <div class="brand" style="background-color: #0098C9;">MENU DE ALMACEN</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
                <li>
                    <a href="almacen_gestion.php">
                  <i class="fa fa-medkit fa-lg"></i> ALMACEN
                  </a>
                </li>

                <li  data-toggle="collapse" data-target="#products" >
                    <a href="#"><i class="fa fa-book"></i>NOMENCLADORES <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="products">
                    <li class="active"><a href="listar_insumos.php" >INSUMOS</a></li>
                    <li class="active"><a href="categorias_almacen.php" >CATEGORIAS</a></li>
                    <!--<li class="active"><a href="#" onclick="Msg();">UNIDAD DE MEDIDA</a></li>-->
                </ul>

                  <li  data-toggle="collapse" data-target="#estadisticas" >
                    <a href="#"><i class="fa fa-glass"></i>ESTADISTICAS <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="estadisticas">
                    <li class="active"><a href="#" onclick="Msg();">FLUJO DE INSUMOS (ABC)</a></li>
                    <li class="active"><a href="necesidad_productos.php" >NECESIDAD DE PRODUCTOS</a></li>
                   
                </ul>
                  <li>
                      <a href="#" onclick="Msg();"> <i class="fa fa-search"></i> FILTROS</a>
                  </li>
                  <li>
                      <a href="listar_proveedores.php"> <i class="fa fa-truck"></i> PROVEEDORES</a>
                  </li>
                
                  
                
                
            </ul>
     </div>
</div>

