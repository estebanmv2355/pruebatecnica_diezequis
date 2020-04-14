<?php
	include('../../data/Conexion.php');
	session_start();
    error_reporting(0);
	echo "<style onload=CRUDUSUARIOS('LISTARUSUARIOS','Todos')></style>";
   ?>
  
<section>

    <div class="row" style="padding-left:1%; padding-right:1%">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" onclick="CRUDUSUARIOS('LISTARUSUARIOS','Todos')">Todos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="CRUDUSUARIOS('LISTARUSUARIOS','Activos')">Activos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="CRUDUSUARIOS('LISTARUSUARIOS','Inactivos')">Inactivos</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row" style="padding-left:1%; padding-right:1%" id="divfiltros">  
        <div class="col-md-4" >
            <a role="button" class="btn btn-secondary" id="btnnuevaentrevista" tabindex="-1" data-toggle="modal" data-target="#modalregistro" onclick="CRUDUSUARIOS('NUEVOUSUARIO','')" style="display: inline-block;">Crear nueva usuario</a>
        </div>          
	</div>
    <br>
    <div class="box" style="padding-left:1%; padding-right:1%" >
        <div class="box-body">                           
            <div id="divusiarios"></div>
        </div>
    </div> 

</section>
<script>
    $(document).ready(function(){
        $('#busciudad').keypress(function(){
        });
    });
</script>



