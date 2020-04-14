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

$con = mysqli_query($conectar,"select * from usuario u inner join perfil p on (p.prf_clave_int = u.prf_clave_int) where u.usu_usuario = '".$usuario."'");
$dato = mysqli_fetch_array($con);
$perfil = $dato['prf_descripcion'];
$claveperfil = $dato['prf_clave_int'];
$claveusuario = $dato['usu_clave_int'];
$ultimaobra = $dato['obr_clave_int'];
$aprueba = $dato['prf_sw_aprobar'];
$ultimoestado = $dato['usu_ultimo_estado'];//Todo o aprobados

$act = $_POST['act'];
$usu = $_POST['usu'];
$ven = $_POST["ven"];
$fi = $_POST["fi"];
$ff = $_POST["ff"];

$seleccionados = explode(',',$act);
$num = count($seleccionados);
$actividades = array();
for($i = 0; $i < $num; $i++)
{
	if($seleccionados[$i] != '')
	{
		$actividades[$i]=$seleccionados[$i];
	}
}
$listaactividades=implode(',',$actividades);

$seleccionados1 = explode(',',$usu);
$num = count($seleccionados1);
$usuarios = array();
for($i = 0; $i < $num; $i++)
{
	if($seleccionados1[$i] != '')
	{
		$usuarios[$i]=$seleccionados1[$i];
	}
}
$listausuarios=implode(',',$usuarios);

$seleccionados3 = explode(',',$ven);
$num = count($seleccionados3);
$ventanas = array();
for($i = 0; $i < $num; $i++)
{
	if($seleccionados3[$i] != '')
	{
		$ventanas[$i]=$seleccionados3[$i];
	}
}
$listaventanas=implode(',',$ventanas);
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
$table = 'log_actividades';
// Table's primary key
$primaryKey = 'loa_clave_int';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes + the primary key column for the id
$columns = array(
    array(
        'db' => 'la.loa_clave_int',
        'dt' => 'DT_RowId','field' => 'loa_clave_int',
        'formatter' => function( $d, $row ) {
            // Technically a DOM id cannot start with an integer, so we prefix
            // a string. This can also be useful if you have multiple tables
            // to ensure that the id is unique with a different prefix
            return 'row_'.$d;
        }
    ),
    array( 'db' => 'la.loa_clave_int', 'dt' => 'Clave', 'field' => 'loa_clave_int' ),
    array( 'db' => 'v.ven_nombre', 'dt' => 'Ventana', 'field' => 'ven_nombre'),
    array( 'db' => 'ta.tia_nombre',  'dt' => 'Actividad', 'field' => 'tia_nombre' ),
    array( 'db' => 'la.loa_registro',  'dt' => 'Registro', 'field' => 'loa_registro' ),
    array( 'db' => 'la.loa_usu_actualiz',  'dt' => 'Creado', 'field' => 'loa_usu_actualiz' ),
    array( 'db' => 'la.loa_fec_actualiz',  'dt' => 'FechaCreacion', 'field' => 'loa_fec_actualiz' ),
   
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
$joinQuery = ' FROM log_actividades la inner join usuario u on (u.usu_usuario = la.loa_usu_actualiz) inner join tipo_actividad ta  on (ta.tia_clave_int = la.tia_clave_int) left outer join ventana v on (v.ven_clave_int = la.ven_clave_int)';

$extraWhere = '';
if($listaactividades != ''){ 
	if($sql1 == '')
	{	
		$sql1 = " ta.tia_clave_int in (".$listaactividades.")"; }else{ $sql1 = $sql1." and ta.tia_clave_int in (".$listaactividades.")"; 
	} 
}
if($listausuarios != ''){ 
	if($sql1 == '')
		{	
			$sql1 = " u.usu_clave_int in (".$listausuarios.")"; }else{ $sql1 = $sql1." and u.usu_clave_int in (".$listausuarios.")"; 
		} 
	}
if($listaventanas != ''){ 
	if($sql1 == ''){	
		$sql1 = "v.ven_clave_int in (".$listaventanas.")"; }else{ $sql1 = $sql1." and v.ven_clave_int in (".$listaventanas.")"; 
	} 
}
if($sql1 == ''){ 
	$sql1 = "((la.loa_fec_actualiz BETWEEN '".$fi." 00:00:00' AND '".$ff." 23:59:59') or ('".$fi."' Is Null and '".$ff."' Is Null) or ('".$fi."' = '' and '".$ff."' = ''))"; 
}
else
{ 
	$sql1 = $sql1." and ((la.loa_fec_actualiz BETWEEN '".$fi." 00:00:00' AND '".$ff." 23:59:59') or ('".$fi."' Is Null and '".$ff."' Is Null) or ('".$fi."' = '' and '".$ff."' = ''))"; 
}
if(strtoupper($perfil) == strtoupper('Administrador'))
{
	$extraWhere = $sql1;
}
else
{
	$extraWhere = $sql1." and la.loa_usu_actualiz = '".$usuario."'";
	
}
$groupBy = "";
require( '../data/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy )
);

?>