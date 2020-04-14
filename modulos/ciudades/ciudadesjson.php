<?php
include ("../../data/Conexion.php");

$login= isset($_SESSION['persona']);
$usuario= $_COOKIE['usuario'];
$idUsuario = $_COOKIE["usIdentificacion"];
$clave= $_COOKIE["clave"];
$con = mysqli_query($conectar,"select * from usuario u inner join perfil p on (p.prf_clave_int = u.prf_clave_int) where u.usu_usuario = '".$usuario."'");
$dato = mysqli_fetch_array($con);
$perfil = $dato['prf_descripcion'];
$percla = $dato['prf_clave_int'];
$emaillogin = $dato['usu_email'];
$claveusuario = $dato['usu_clave_int'];
$nombre = $dato['usu_nombre'];
$empcla = $dato['epr_clave_int'];

error_reporting(0);
$est = $_POST['est'];
$busciudad = $_POST['busciudad']; 
$estado = $_POST['estado'];

//include('../../data/permisosstatus.php');



$table = 'ciudad';
$primaryKey = 'ci.ciu_clave_int';

$columns = array(
	array(
		'db' => 'ci.ciu_clave_int',
		'dt' => 'DT_RowId', 'field' => 'ciu_clave_int',
		'formatter' => function( $d, $row ) {
			return 'row_'.$d;
		}
    ),
    array(
		'db' => 'ci.ciu_clave_int',
		'dt' => 'UD_Id', 'field' => 'ciu_clave_int',
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
        array( 'db' => 'ci.ciu_clave_int', 'dt' => 'Codigo', 'field' => 'ciu_clave_int' ),

        array('db'  => 'ci.ciu_nombre','dt' => 'Ciudad', 'field' => 'ciu_nombre'),

        array('db'  => 'ci.ciu_usu_actualiz','dt' => 'Usiario', 'field' => 'ciu_usu_actualiz'),

        array('db'  => 'ci.ciu_fec_actualiz','dt' => 'Actualizacion', 'field' => 'ciu_fec_actualiz'),

		array('db'  => 'ci.ciu_sw_activo','dt' => 'Activo', 'field' => 'ciu_sw_activo','formatter'    =>function($d,$row ){
            return ;
        }),
		array('db'  => 'ci.ciu_clave_int','dt' => 'Modificar', 'field' => 'ciu_clave_int','formatter'    =>function($d,$row ){

            return '<a class="btn btn-block btn-warning btn-xs" role="button" onclick=CRUDCIDADES("EDITARCIUDAD","'.$d.'") style="cursor:pointer;width:20px; height:20px;" data-toggle="modal" data-target="#modalregistro"><i class="fa fa-edit"></i></a>';

        }),
        array('db'  => 'ci.ciu_clave_int','dt' => 'Eliminar', 'field' => 'ciu_clave_int','formatter'    =>function($d,$row ){

            return '<a class="btn btn-block btn-danger btn-xs" onclick=CRUDCIDADES("ELIMINARCIUDAD","'.$d.'") style="width:20px; height:20px;"><i class="fa fa-trash-o" aria-hidden="true"></i></a>' ;

        }),       
);

$sql_details = array(
	'user' => 'usrpavas',
	'pass' => '9A12)WHFy$2p4v4s',
	'db'   => 'iayc',
	'host' => '127.0.0.1'
);

require( '../../data/ssp.class.php' );
$whereAll ="";
$groupBy = '';
$with = '';
$joinQuery = "from ciudad ci";

$extraWhere = "(ci.ciu_nombre LIKE REPLACE('%".$busciudad."%',' ','%') OR '".$busciudad."' IS NULL OR '".$busciudad."' = '')";

if($estado == 'Todos'){
    $extraWhere .= "";
}else if ($estado ==  'Activos'){
    $extraWhere .= " and ci.ciu_sw_activo = 1";
}else if ($estado ==  'Inactivos'){
    $extraWhere .= " and ci.ciu_sw_activo = 0";
}

echo json_encode(
	SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy,$with )
);