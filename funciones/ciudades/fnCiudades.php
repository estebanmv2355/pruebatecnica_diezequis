<?php
include ("../../data/Conexion.php");
error_reporting(0);
date_default_timezone_set('America/Bogota');
$fecha=date("Y/m/d H:i:s");
$opcion = $_POST['opcion'];

$login= isset($_SESSION['persona']);
$usuario= $_SESSION['usuario'];
$idUsuario= $_COOKIE["usIdentificacion"];
$clave= $_COOKIE["clave"];
		

$con = mysqli_query($conectar,"select * from usuario u inner join perfil p on (p.prf_clave_int = u.prf_clave_int) where u.usu_usuario = '".$usuario."'");
$dato = mysqli_fetch_array($con);
$perfil = $dato['prf_descripcion'];
$claveperfil = $dato['prf_clave_int'];
$claveusuario = $dato['usu_clave_int'];
$ultimaobra = $dato['obr_clave_int'];


if ($opcion == "NUEVACIUDAD"){
    ?>
       <form data-parsley-validate class="form-horizontal form-label-left" name="formciudad" id="formciudad">
            <div class="row">
                <div class="col-md-12">
                    <label for="txtinicial">Ciudad</label>
                    <input type="text" class="form-control input-sm" id="ciudad1" name="ciudad1" required  data-parsley-error-message="Diligenciar el nombre de la ciudad" data-parsley-errors-container="#msg-error1"><br>
                    <span id="msg-error1"></span><br>
                    Activa:<input class="" name="activo1" id="activo1" type="checkbox" value="1"   />
                </div>
            </div>
       </form>
    <?php
}else if ($opcion == "GUARDARCIUDAD") {

    $ciu = $_POST['ciu'];
    $swact = $_POST['act'];

    $sql = mysqli_query($conectar,"select * from ciudad where (UPPER(ciu_nombre) = UPPER('".$ciu."'))");
    $dato = mysqli_fetch_array($sql);
    $conciu = $dato['ciu_nombre'];
    
    if(STRTOUPPER($conciu) == STRTOUPPER($ciu))
    {
        $res = "error";
        $msn = "La ciudad ingresada ya existe";
    }else {
        
        $con = mysqli_query($conectar,"insert into ciudad(ciu_nombre,ciu_sw_activo,ciu_usu_actualiz,ciu_fec_actualiz) values('".$ciu."','".$swact."','".$usuario."','".$fecha."')");

        if ($con > 0) {
            $res = "ok";
            $msn = "Insertado correctamente";
        }else {
            $res = "error";
            $msn = "Ocurrio un problema con la base de datos";
        }
    }

    $datos[] = array("res"=>$res,"msn"=>$msn);
	echo json_encode($datos);
}else if ($opcion == "LISTARCIUDADES") {
    $estado = $_POST['est'];

    ?>
    <table class="table table-striped" id="tblciudades"style="width:100%" data-estado = "<?php echo $estado; ?>" >
        <thead>
            <tr>
                <th class="dt-head-center">Ciudad</th>
                <th class="dt-head-center">Usuario</th>   
                <th class="dt-head-center">Actualización</th>
                <th class="dt-head-center">Activo</th>
                <th class="dt-head-center"></th> 
                <th class="dt-head-center"></th>          
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th class="dt-head-center"></th>
                <th class="dt-head-center"></th>   
                <th class="dt-head-center"></th>
                <th class="dt-head-center"></th>
                <th class="dt-head-center"></th>
                <th class="dt-head-center"></th> 
            </tr>
        </tfoot>
    </table>
    <script src="js/Ciudad/jsciudades.js" type="text/javascript"></script>
    <?php
}else if ($opcion == "EDITARCIUDAD"){

    $id = $_POST['id'];
    $sql = mysqli_query($conectar,"SELECT
	ci.ciu_clave_int,
	ci.ciu_nombre,
	ci.ciu_fec_actualiz,
	ci.ciu_usu_actualiz,
	ci.ciu_sw_activo
    FROM ciudad ci
    WHERE ci.ciu_clave_int = '".$id."'");

    $dat = mysqli_fetch_array($sql);
	$ciu_clave_int = $dat['ciu_clave_int'];
	$ciu_nombre = $dat['ciu_nombre'];
	$ciu_fec_actualiz = $dat['ciu_fec_actualiz'];
	$ciu_usu_actualiz = $dat['ciu_usu_actualiz'];
    $ciu_sw_activo = $dat['ciu_sw_activo'];

    ?>
        <form data-parsley-validate class="form-horizontal form-label-left" name="formciudad" id="formciudad">
            <div class="row">
                <div class="col-md-12">
                    <label for="txtinicial">Ciudad</label>
                    <input type="text" class="form-control input-sm" id="ciudad1" name="ciudad1" value="<?php echo $ciu_nombre;?>"><br>
                    Activa:<input class="" name="activo1" id="activo1" type="checkbox" <?php if($ciu_sw_activo == 1 ){echo "checked"; } ?> value="1" />
                </div>
            </div>
        </form>
    <?php
}else if ($opcion == "GUARDAREDICIONCIUDAD") {

    $ciu = $_POST['ciu'];
    $swact = $_POST['act'];
    $id = $_POST['id'];

    $sql = mysqli_query($conectar,"select * from ciudad where (UPPER(ciu_nombre) = UPPER('".$ciu."')) and ciu_clave_int != '".$id."'");
    $dato = mysqli_fetch_array($sql);
    $conciu = $dato['ciu_nombre'];
    
    if(STRTOUPPER($conciu) == STRTOUPPER($ciu))
    {
        $res = "error";
        $msn = "La ciudad ingresada ya existe";
    }else {
        
        $con = mysqli_query($conectar,"UPDATE ciudad SET ciu_nombre='".$ciu."',ciu_sw_activo='".$swact."',ciu_usu_actualiz='".$usuario."',ciu_fec_actualiz='".$fecha."' WHERE ciu_clave_int = '".$id."'");

        if ($con > 0) {
            $res = "ok";
            $msn = "Actualizado correctamente";
        }else {
            $res = "error";
            $msn = "Ocurrio un problema con la base de datos";
        }
    }

    $datos[] = array("res"=>$res,"msn"=>$msn);
	echo json_encode($datos);
}else if ($opcion== "ELIMINARCIUDAD") {

    $id = $_POST['id'];
    $delet = mysqli_query($conectar,"DELETE FROM ciudad WHERE ciu_clave_int= '".$id."'");

    if ($delet > 0) {
        $res = "ok";
        $msn = "Eliminado correctamente";
    }else {
        $res = "error";
        $msn = "Ocurrio un problema con la base de datos";
    }
    $datos[] = array("res"=>$res,"msn"=>$msn);
	echo json_encode($datos);
}
