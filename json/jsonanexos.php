<?php
error_reporting(0);
session_start();
include('../data/Conexion.php');

// variable login que almacena el login o nombre de usuario de la persona logueada
$login= isset($_SESSION['persona']);
// cookie que almacena el numero de identificacion de la persona logueada
$usuario= $_SESSION['usuario'];
$idUsuario= $_COOKIE["usIdentificacion"];
$clave= $_COOKIE["clave"];
$id = $_GET['id'];

$con = mysqli_query($conectar,"select * from usuario u inner join perfil p on (p.prf_clave_int = u.prf_clave_int) where u.usu_usuario = '".$usuario."'");
$dato = mysqli_fetch_array($con);
$descripcionperfil = $dato['prf_descripcion'];
$claveperfil = $dato['prf_clave_int'];
$claveusuario = $dato['usu_clave_int'];
$ultimaobra = $dato['obr_clave_int'];
$aprueba = $dato['prf_sw_aprobar'];

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
$table = 'carga_archivo';
// Table's primary key
$primaryKey = 'caa_clave_int';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes + the primary key column for the id
$columns = array(
    array(
        'db' => 'ana_clave_int',
        'dt' => 'DT_RowId','field' => 'ana_clave_int',
        'formatter' => function( $d, $row ) {
            // Technically a DOM id cannot start with an integer, so we prefix
            // a string. This can also be useful if you have multiple tables
            // to ensure that the id is unique with a different prefix
            return 'row_'.$d;
        }
    ),
    array( 'db' => 'ana_clave_int', 'dt' => 'CLAVE', 'field' => 'ana_clave_int' ),
    array( 'db' => 'ana_ruta', 'dt' => 'RUTA', 'field' => 'ana_ruta' ),
    array( 'db' => 'ana_nombre',  'dt' => 'NOMBREARCHIVO', 'field' => 'ana_nombre' ),
    array( 'db' => 'ana_clave_int', 'dt' => 'VERONLINE', 'field' => 'ana_clave_int', 'formatter' => function($d, $row){
		if($row[2] != ''){ $accion1 = "iframecargar/".$row[2].""; }else{ $accion2 = "ALERTASINADJUNTO()"; }
		return "<a class='btn btn-info btn-xs' href='".$accion1."' onclick='".$accion2."' target='_blank' style='color:white;text-decoration:none;text-shadow: 1px 1px 1px #aaa;cursor:pointer'>VER ONLINE</a>";		
	}),
	array( 'db' => 'ana_clave_int', 'dt' => 'DESCARGAR', 'field' => 'ana_clave_int', 'formatter' => function($d, $row){
		return '<a class="btn btn-info btn-xs" href="descargar.php?claana='.$row[1].'" target="_blank" style="color:white;text-decoration:none;text-shadow: 1px 1px 1px #aaa">DESCARGAR</a>';
	})
);
 
// SQL server connection information
/*$sql_details = array(
    'user' => 'usrpavas',
    'pass' => '9A12)WHFy$2p4v4s',
    'db'   => 'bdservicio',
    'host' => 'localhost'
);*/

$sql_details = array(
    'user' => 'usrpavas',
    'pass' => '9A12)WHFy$2p4v4s',
    'db'   => 'zonaclientes',
    'host' => '127.0.0.1'
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
$joinQuery = ' FROM anexos_archivo';
$extraWhere = "caa_clave_int = '".$id."'";
$groupBy ="";
require( '../data/ssp.class.php');
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy )
);

?>