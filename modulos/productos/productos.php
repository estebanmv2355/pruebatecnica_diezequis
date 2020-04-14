<?php
    echo "<style onload=CRUDUPRODUCTO('LISTARPRODUCTOS','')></style>"; 
?>
<form data-parsley-validate class="form-horizontal form-label-left" name="formusuarios" id="formusuarios">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <label for="txtinicial">Nombre del producto</label><br>
                    <label for="txtinicial">Referencia del produto</label><br>
                    <label for="txtinicial">Cantidad del producto</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control input-sm" id="txtnombre" name="txtnombre">
                    
                    <input type="text" class="form-control input-sm" id="txtreferencia" name="txtreferencia">
                    
                    <input type="text" class="form-control input-sm" id="txtcantidad" name="txtcantidad">
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a role="button" class="btn btn-success" onclick="CRUDUPRODUCTO('GUARDARPRODUCTO','')" style="display: inline-block;">GUARDAR</a>
                </div>
            </div>
        </div>
        <div class="col-md-6" >
            <div id="tablaproducto"></div>
        </div>
    </div>

</form>