<?php 
include ("../../data/Conexion.php");
error_reporting(0);
date_default_timezone_set('America/Bogota');
$fecha=date("Y/m/d H:i:s");
$opcion = $_POST['opcion'];
if($opcion == "GUARDARPRODUCTO"){
    
    $txtnombre = $_POST['txtnombre'];
    $txtreferencia = $_POST['txtreferencia'];
    $txtcantidad = $_POST['txtcantidad'];

    $sql = mysqli_query($conectar,"INSERT INTO producto (nombre,refencia,cantidad) VALUES('".$txtnombre."','".$txtreferencia."','".$txtcantidad."')");

    if ($sql > 0){
        $res = "ok";
        $msn = "producto insertado correctamente";

    }else{
        $res = "error";
        $msn = "ocurrio un problema con la base de datos";
    }

    $datos[] = array("res"=>$res,"msn"=>$msn);
	echo json_encode($datos);
}else if ($opcion == "LISTARPRODUCTOS"){
    ?>
        <table class="table table-striped" id="tblproductos" name = "tblproductos"style="width:100%"  >
        <thead>
            <tr>
                <th class="dt-head-center">Nombre</th>
                <th class="dt-head-center">Referencia</th>   
                <th class="dt-head-center">Cantidad</th>
                <th class="dt-head-center"></th>         
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th class="dt-head-center"></th>
                <th class="dt-head-center"></th>   
                <th class="dt-head-center"></th>
                <th class="dt-head-center"></th>
            </tr>
        </tfoot>
    </table>
    <script src="js/Productos/jsproductos.js" type="text/javascript"></script>
    <?php
}else if ($opcion == "EDITARPRODUCTO"){
    $id= $_POST['id'];
    $sql = mysqli_query($conectar,"SELECT nombre,refencia,cantidad FROM producto WHERE id_producto = '".$id."'");
    $date = mysqli_fetch_array($sql);
    $nombre = $date['nombre'];
    $refencia = $date['refencia'];
    $cantidad = $date['cantidad'];
?>
<div class="row">
    <div class="col-md-5">
        <label for="txtinicial">Nombre del producto</label><br>
        <label for="txtinicial">Referencia del produto</label><br>
        <label for="txtinicial">Cantidad del producto</label>
    </div>
    <div class="col-md-7">
        <input type="text" class="form-control input-sm" id="txtnombre1" name="txtnombre1" value= "<?php echo $nombre; ?>">
        
        <input type="text" class="form-control input-sm" id="txtreferencia1" name="txtreferencia1" value= "<?php echo $refencia; ?>">
        
        <input type="text" class="form-control input-sm" id="txtcantidad1" name="txtcantidad1" value= "<?php echo $cantidad; ?>">
        
    </div>
</div>

<?php
}else if($opcion == "GUARDAREDICION"){
    $txtnombre = $_POST['txtnombre'];
    $txtreferencia = $_POST['txtreferencia'];
    $txtcantidad = $_POST['txtcantidad'];
    $id = $_POST['id'];

    $sql = mysqli_query($conectar,"UPDATE producto SET nombre='".$txtnombre."',refencia='".$txtreferencia."',cantidad='".$txtcantidad."' WHERE id_producto ='".$id."'");

    if($sql > 0){
        $res = "ok";
        $msn = "Actulizado correctamente";
    }else{
        $res = "error";
        $msn = "Ocurrio un problema con la base de datos";
    };
    $datos[] = array("res"=>$res,"msn"=>$msn);
	echo json_encode($datos);

}

?>