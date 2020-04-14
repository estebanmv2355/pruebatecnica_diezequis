<?php
include ("../../data/Conexion.php");
date_default_timezone_set('America/Bogota');
$fecha=date("Y/m/d H:i:s");
$opcion = $_POST['opcion'];

if ($opcion == "NUEVOUSUARIO"){
    ?>
       <form data-parsley-validate class="form-horizontal form-label-left" name="formusuarios" id="formusuarios">
            <div class="row">
                <div class="col-md-12">
                    <label for="txtinicial">Nombres</label>
                    <input type="text" class="form-control input-sm" id="txtnombre" name="txtnombre" required  data-parsley-error-message="Diligenciar el nombre" data-parsley-errors-container="#msg-error1"><br>
                    <span id="msg-error1"></span><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="txtinicial">Apellidos</label>
                    <input type="text" class="form-control input-sm" id="txtapellido" name="txtapellido" required  data-parsley-error-message="Diligenciar el apellido" data-parsley-errors-container="#msg-error2"><br>
                    <span id="msg-error2"></span><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="txtinicial">Email</label>
                    <input type="text" class="form-control input-sm" id="txtemail" name="txtemail" required  data-parsley-error-message="Diligenciar el email" data-parsley-errors-container="#msg-error3"><br>
                    <span id="msg-error3"></span><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="txtinicial">Telefono</label>
                    <input type="text" class="form-control input-sm" id="txttelefono" name="txttelefono" required  data-parsley-error-message="Diligenciar el telefono" data-parsley-errors-container="#msg-error4"><br>
                    <span id="msg-error4"></span><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="txtinicial">Celular</label>
                    <input type="text" class="form-control input-sm" id="txtcelular" name="txtcelular" required  data-parsley-error-message="Diligenciar el celular" data-parsley-errors-container="#msg-error5"><br>
                    <span id="msg-error5"></span><br>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label for="txtinicial">Cargo</label>
                    <input type="text" class="form-control input-sm" id="txtcargo" name="txtcargo">
                </div>
            </div>
            
       </form>
    <?php
}else if ($opcion == "GUARDARUSUARIO") {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $celular = $_POST['celular'];
    $cargo = $_POST['cargo'];

    if($cargo == ""||$cargo == null){
        $res="error";
        $msn = "Digite el cargo por favor";
    }else{
        $sql = mysqli_query($conectar,"INSERT INTO usuarios(nombres,apellidos,email,telefono,celular,cargo) VALUES ('".$nombre."','".$apellido."','".$email."','".$telefono."','".$celular."','".$cargo."')");

        if ($sql>0) {
            $res = "ok";
            $msn = "Usuario insertado correctamente";
        }else {
            $res = "error";
            $msn = "Ocurrio un problema con la base de datos ";
        }
    }


    $datos[] = array("res"=>$res,"msn"=>$msn);
	echo json_encode($datos);
}else if ($opcion == "LISTARUSUARIOS") {

    ?>
    <script src="js/Usuario/jsusuario.js" type="text/javascript"></script>
    <table class="table table-striped" id="tblusuario"style="width:100%">
        <thead>
            <tr>
                <th class="dt-head-center">Nombre</th>
                <th class="dt-head-center">Apellidos</th>   
                <th class="dt-head-center">Email</th>
                <th class="dt-head-center">Telefono</th> 
                <th class="dt-head-center">Celular</th>
                <th class="dt-head-center">Cargo</th>              
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
