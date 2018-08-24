function CancelarColor()
{
    var input_color=document.getElementById('muestrario');
    input_color.value="#FFFFFF";
    
}

function InputVisible()
{
    var checkbox_color=document.getElementById('p_color');
    var input_color=document.getElementById('select_color');
    if(checkbox_color.checked==false)
    {
        
        input_color.setAttribute("class","hidden ");
    }
    else
    {
        input_color.setAttribute("class","text-left ");
    }
    
    
}

function Msg()
{
    alert("¡¡¡Esta funcionalidad aun se encuentra en desarrollo!!!");
}

function EnviarTipoUsuario()
{
    var f_user=document.getElementById('f_user');
    var h_u=document.getElementById('hu');
  
   /***/
    h_u.value=1;    
    f_user.submit();
}

function SinIMg()
{
    if(confirm("Esta Seguro que desea enviar el formulario sin imagen")){}
}

function Tarea()
{
    var f=document.getElementById('tarea');
    var h_u=document.getElementById('h');
  
    if(confirm("Esta Seguro que desea ELIMINAR la tarea"))
    {
        h_u.value=1;
        f.submit();
    }
}

function TareaA()
{
   /**para aprobar la tarea*/
    var f=document.getElementById('tarea');
    var h_u=document.getElementById('h');
    
    if(confirm("Esta Seguro que desea Aprobar la tarea"))
    {
        h_u.value=2;
        f.submit();
    }
}

function SendFormEstadistica()
{
    var f=document.getElementById('f_per');
    var h_u=document.getElementById('ah');
    h_u.value=2;
    f.submit();
}


function CargarPorEspecialidad(id)
{
    
    $.ajax({
        type: "POST",
        url: 'consultaMedEsp.php',
        data: 'idproovedor='+id,
        success: function(resp){
            $('#medicos_select').html(resp);
            $('#respuesta').html("");
        }
    });
   
}

function SubmitConsulta()
{
     var f=document.getElementById('cc');
    var hidden=document.getElementById('consulta_hidden');
    hidden.value=1;
    f.submit();
}

function SubmitCirugia()
{
    var f=document.getElementById('cirugia_form');
    var hidden=document.getElementById('cirugia_hidden');
    hidden.value=1;
    f.submit();
}
function SubmitRadiologia()
{
    var f=document.getElementById('rad_form');
    var hidden=document.getElementById('radiologia_hidden');
    hidden.value=1;
    f.submit();
}

function AddInsumos()
{
    var tabla=document.getElementById('tabla_insumos');
    var rowCount = tabla.rows.length;
    var row = tabla.insertRow(rowCount);
    var valor=document.getElementById('insumo').value;
    if(valor!="")
    {
        row.id=rowCount;
    var cell2 = row.insertCell(0);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.className="form-control";
    element2.value=valor;
    element2.name="insumo"+rowCount;
    element2.setAttribute("readonly","readonly");
    cell2.appendChild(element2);
    
    /**cantidad*/
    var cell2 = row.insertCell(1);
    var element2 = document.createElement("input");
    element2.type = "number";
    element2.className="form-control";
    element2.value=1;
    element2.name="cantidad"+rowCount;
    element2.min=1;
    cell2.appendChild(element2);
    
    /**agregar el boton Eliminar*/
    var cell2 = row.insertCell(2);
    var element2 = document.createElement("button");
    element2.type = "button";
    element2.className="btn btn-danger btn-xs  fa fa-close"; 
    element2.title="Eliminar Insumo";
    element2.onclick = function(){deleteRow(rowCount);}
    cell2.appendChild(element2);
    
    var cantidad_hiden=document.getElementById('cantidad_insumos');
    cantidad_hiden.value=rowCount;
 
 /**enviar el formulario para cargar los valores*/
    var f=document.getElementById('cirugia_form');
    var hidden=document.getElementById('cirugia_hidden');
    hidden.value=1;
    f.submit();
 /**cerrar modal*/
    var bot = document.getElementById("m_em");
    bot.click();
    }
    else
    {
        alert("Usted debe de seleccionar el insumo");
    }
    
 }
 function AddInsumosHosp()
{
    var tabla=document.getElementById('tabla_insumosH');
    var rowCount = tabla.rows.length;
    var row = tabla.insertRow(rowCount);
    var valor=document.getElementById('insumoH').value; alert(valor);
    if(valor!="")
    {
        row.id=rowCount;
    var cell2 = row.insertCell(0);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.className="form-control";
    element2.value=valor;
    element2.name="insumo"+rowCount;
    element2.setAttribute("readonly","readonly");
    cell2.appendChild(element2);
    
    /**cantidad*/
    var cell2 = row.insertCell(1);
    var element2 = document.createElement("input");
    element2.type = "number";
    element2.className="form-control";
    element2.value=1;
    element2.name="cantidad"+rowCount;
    element2.min=1;
    cell2.appendChild(element2);
    
    /**agregar el boton Eliminar*/
    var cell2 = row.insertCell(2);
    var element2 = document.createElement("button");
    element2.type = "button";
    element2.className="btn btn-danger btn-xs  fa fa-close"; 
    element2.title="Eliminar Insumo";
    element2.onclick = function(){deleteRow(rowCount);}
    cell2.appendChild(element2);
    
    var cantidad_hiden=document.getElementById('cantidad_insumosH');
    cantidad_hiden.value=rowCount;
 
 /**enviar el formulario para cargar los valores*/
    var f=document.getElementById('hosp_form');
    var hidden=document.getElementById('hospitalizacion_hidden');
    hidden.value=1;
    
    f.submit();
 /**cerrar modal*/
    var bot = document.getElementById("m_em");
    bot.click();
    }
    else
    {
        alert("Usted debe de seleccionar el insumo");
    }
    
 }

function deleteRow(rowCount)
{
    var fila=document.getElementById(rowCount);
		
    var table = fila.parentNode;
    table.removeChild(fila);

    var rowCount = table.rows.length;
    /********actualizo el hidden para la cantidad de insumos**********/

    var pos="cantidad_insumos";
    var cantidad_hiden=document.getElementById(pos);
    cantidad_hiden.value=cantidad_hiden.value-1;
    
   
     /**enviar el formulario para cargar los valores
    var f=document.getElementById('cirugia_form');
    var hidden=document.getElementById('cirugia_hidden');
    hidden.value=1;
    f.submit();*/
}
function deleteRowEquipoMedico(rowCount)
{
    var fila=document.getElementById(rowCount);
    var table = fila.parentNode;
    table.removeChild(fila);
    
    var rc = (table.rows.length)-1;
    var cantidad_hiden=document.getElementById('cantidad_med');
    cantidad_hiden.value=rc-1;
    alert(cantidad_hiden.value);
    var ff= document.getElementById('cirugia_form');
    var hidden=document.getElementById('cirugia_hidden');
    
    hidden.value=1;
    ff.submit();
    /*

    
    /********actualizo el hidden para la cantidad de medicos**********/
    /*
   /**enviar el formulario para cargar los valores*/
    /*var form=document.getElementById('cirugia_form');
    var hidden=document.getElementById('cirugia_hidden');
    
    hidden.value=1;
    form.submit();*/
   
}
function AddEquipo()
{
   /**validar nombre del medico y cargo cond datos*/
   var div_medico=document.getElementById('select_med');
   var div_enf=document.getElementById('select_enf');
   var cantidad_hiden=document.getElementById('cantidad_med');
   
   var name="";
   var valor="";
   var cargoId="";
  if(div_medico.className!="hidden")
  {
      var select_med=document.getElementById('pers_med');
      var cargoM=document.getElementById('cargM');
      name="med";
      valor=select_med.value;
      cargoId=cargoM.value;
  }
   if(div_enf.className!="hidden")
        {
            var select_enf=document.getElementById('pers_enf');
            var cargoE=document.getElementById('cargE');
            name="trab";
            valor=select_enf.value;
            cargoId=cargoE.value;
        }
 
  if(valor=="" || cargoId=="")
  {
      alert("Usted debe de seleccionar un trabajador y su cargo antes de adicionarlo al euipo.");
  }
  else
{
    /**buscar que la persona no se ponga doble**/
    var error=0;
    var msj="";
    if(cantidad_hiden==0)
    {
        error=0;
    }
    else
    {
        
        for (var i = 0; i < cantidad_hiden.value; i++) 
        {
            var a=name+cantidad_hiden.value;
            if(document.getElementById(a))
            {
                var inputEscrito=document.getElementById(a);
                if(inputEscrito.value==valor)
                {
                    error++;
                    var categ="";
                    if(name=="med"){categ="medico";}
                    if(name=="trab"){categ="trabajador";}
                    msj="El "+categ+" "+valor+" ya es miembro del equipo.";
                }
            }
            
        }
    }
    
    /**validar que no sea el cirujano principal*/
    if(error==0)
    {
        var tabla=document.getElementById('tabla_med_equipo');
    var rowCount = tabla.rows.length;
    var row = tabla.insertRow(rowCount);
    row.id=rowCount;
    var cell2 = row.insertCell(0);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.className="form-control";
    element2.value=valor;
    element2.name=name+rowCount;
    element2.setAttribute("readonly","readonly");
    element2.setAttribute("id",name+rowCount);
    cell2.appendChild(element2);
    
    /**cantidad*/
    var cell2 = row.insertCell(1);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.className="form-control";
    element2.value=cargoId;
    element2.name="cargo"+rowCount;
    element2.setAttribute("readonly","readonly");
    cell2.appendChild(element2);
    
    /**agregar el boton Eliminar*/
    var cell2 = row.insertCell(2);
    var element2 = document.createElement("button");
    element2.type = "button";
    element2.className="btn btn-danger btn-xs  fa fa-close"; 
    element2.title="Eliminar";
   
    element2.onclick = function(){deleteRowEquipoMedico(rowCount);}
    cell2.appendChild(element2);
    
    
    cantidad_hiden.value=rowCount; 
 /**enviar el formulario para cargar los valores*/
    var f=document.getElementById('cirugia_form');
    var hidden=document.getElementById('cirugia_hidden');
    
    hidden.value=1; 
    f.submit(); 
 /**cerrar modal*/
    var bot = document.getElementById("m_equipoMF");
    bot.click();
    }
    else
    {
        alert(msj);
    }
    
}
  
   
   
}
function MostrarSelect()
{
    var radio_medico=document.getElementById('tipoM');
    var radio_enfermera=document.getElementById('tipoE');
    var imagen=document.getElementById('imagen_modal');
    
    var div_medico=document.getElementById('select_med');
    var div_enf=document.getElementById('select_enf');
    
    if(radio_medico.checked==true)
    {
        div_medico.className="";
        div_enf.className="hidden";
        imagen.src="../img/doctores.png";
    }
    else
    {
        div_enf.className="";
        div_medico.className="hidden";
        imagen.src="../img/enfermero.jpg";
    }
}

function EliminarServicio(id)
{
    var v="f"+id;
    var f=document.getElementById(v);
    var e="estado"+id;
    var estado=document.getElementById(e);
    var ns="nombre_serv"+id;
    var np="nombre_pac"+id;
    var nombre_servoicio=document.getElementById(ns).value;
    var nombre_paciente=document.getElementById(np).value;
    
    /**el estado del servicio no puede ser PAGO*/
    if(estado.value!="PAGO")
    {
        if(confirm("Esta Seguro que desea ELIMINAR el servicio "+nombre_servoicio+" para el paciente "+ nombre_paciente))
        {

            f.submit();
        }
    }
    else
    {
        alert("Lo sentimos, por motivos de seguridad el servicio no puede ser eliminado por esta via pues ya tiene un pago asiciado a él. Usted debe eliminar primero la transacción y luego el servicio.");
    }
   
   
}
function Chequear(id)
    {
        //si se da el caso de que todos estan marcados y se desenmarca una opcion entonces quitar el todos
        var todos=document.getElementById(id);
        var nuevo=document.getElementById("nuevo"+id);
        var editar=document.getElementById("editar"+id);
        var eliminar=document.getElementById("eliminar"+id);
        var listar=document.getElementById("listar"+id);
        var imp=document.getElementById("imp"+id);
        if(nuevo.checked==true && editar.checked==true && eliminar.checked==true && listar.checked==true && imp.checked==true)
        {
            todos.checked=true;
        }
        else{todos.checked=false;}
        
    }
    function MarcarTodos(id)
{
    var todos=document.getElementById(id);
    var nuevo=document.getElementById("nuevo"+id);
    var editar=document.getElementById("editar"+id);
    var eliminar=document.getElementById("eliminar"+id);
    var listar=document.getElementById("listar"+id);
    var imp=document.getElementById("imp"+id);
    
    if(todos.checked==true)
    {
       
       
        nuevo.checked=true;
        editar.checked=true;
        eliminar.checked=true;
        listar.checked=true;
        imp.checked=true;
        
    }
    else
    {
        
        nuevo.checked=false;
        editar.checked=false;
        eliminar.checked=false;
        listar.checked=false;
        imp.checked=false;
        
    }
}

/*** poner en la misma pagina que las tabs
 * 
// Select all tabs
$('.nav-tabs a').click(function(){
    $(this).tab('show');
})

// Select tab by name
$('.nav-tabs a[href="#home"]').tab('show')

// Select first tab
$('.nav-tabs a:first').tab('show')

// Select last tab
$('.nav-tabs a:last').tab('show')

// Select fourth tab (zero-based)
$('.nav-tabs li:eq(3) a').tab('show')

**/