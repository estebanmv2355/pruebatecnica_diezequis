<?php
	include('../../data/Conexion.php');
	session_start();
    error_reporting(0);
	//include('../../data/permisos.php');
	echo "<style onload=CRUDCIDADES('LISTARCIUDADES','Todos')></style>";
   ?>
  
<section>

    <div class="row" style="padding-left:1%; padding-right:1%">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" onclick="CRUDCIDADES('LISTARCIUDADES','Todos')">Todos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="CRUDCIDADES('LISTARCIUDADES','Activos')">Activos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="CRUDCIDADES('LISTARCIUDADES','Inactivos')">Inactivos</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row" style="padding-left:1%; padding-right:1%" id="divfiltros">
        <div class="col-md-4">
            <strong>Buscar por ciudad:</strong>
            <input class="form-control input-sm"  name="busciudad" id="busciudad" onchange="CRUDCIDADES('LISTARCIUDADES')"  type="text" value="" placeholder="Ciudad"/>
        </div>  
        <div class="col-md-4" >
            <strong>Crear nueva ciudad:</strong><br>
            <a role="button" class="btn btn-secondary" id="btnnuevaentrevista" tabindex="-1" data-toggle="modal" data-target="#modalregistro" onclick="CRUDCIDADES('NUEVACIUDAD','')" style="display: inline-block;">Añadir</a>
        </div>          
	</div>
    <br>
    <div class="box" style="padding-left:1%; padding-right:1%" >
        <div class="box-body">                           
            <div id="divciudades"></div>
        </div>
    </div> 

</section>
<script>
    $(document).ready(function(){
        $('#busciudad').keypress(function(){
            console.log('123');
        });
    });
</script>



