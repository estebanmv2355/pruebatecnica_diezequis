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
$descripcionperfil = $dato['prf_descripcion'];
$claveperfil = $dato['prf_clave_int'];
$claveusuario = $dato['usu_clave_int'];
$ultimaobra = $dato['obr_clave_int'];
$aprueba = $dato['prf_sw_aprobar'];
$ultimoestado = $dato['usu_ultimo_estado'];//Todo o aprobados

$obr = $_GET['obras'];
$inf = $_GET['informes'];
$nomarc = $_GET['nomarc'];
$nomane = $_GET['nomane'];
$nomley = $_GET['nomley'];
$nomcom = $_GET['nomcom'];

$seleccionados = explode(',',$obr);
$num = count($seleccionados);
$obras = array();
for($i = 0; $i < $num; $i++)
{
	if($seleccionados[$i] != '')
	{
		$obras[$i]=$seleccionados[$i];
	}
}
$listaobras=implode(',',$obras);

$seleccionados = explode(',',$inf);
$num = count($seleccionados);
$informes = array();
for($i = 0; $i < $num; $i++)
{
	if($seleccionados[$i] != '')
	{
		$informes[$i]=$seleccionados[$i];
	}
}

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
        'db' => 'ca.caa_clave_int',
        'dt' => 'DT_RowId','field' => 'caa_clave_int',
        'formatter' => function( $d, $row ) {
            // Technically a DOM id cannot start with an integer, so we prefix
            // a string. This can also be useful if you have multiple tables
            // to ensure that the id is unique with a different prefix
            return 'row_'.$d;
        }
    ),
    array( 'db' => 'ca.caa_clave_int', 'dt' => 'CLAVE', 'field' => 'caa_clave_int' ),
    array( 'db' => 'ca.caa_nombre', 'dt' => 'NOMBRE', 'field' => 'caa_nombre', 'formatter' => function($d, $row){
    $array_nombre = explode('.',$row[8]);
	$cuenta_arr_nombre = count($array_nombre);
	$extension = strtolower($array_nombre[--$cuenta_arr_nombre]);
    return $d.".".$extension; } ),
    array( 'db' => 'o.obr_nombre',  'dt' => 'OBRA', 'field' => 'obr_nombre' ),
    array( 'db' => 'ca.caa_comentarios',  'dt' => 'COMENTARIOS', 'field' => 'caa_comentarios' ),
    array( 'db' => 'ca.caa_fecha_creacion',  'dt' => 'FECHACREACION', 'field' => 'caa_fecha_creacion' ),
    array( 'db' => 'ca.caa_usu_actualiz',  'dt' => 'USUARIOACTUALIZ', 'field' => 'caa_usu_actualiz' ),
    array( 'db' => 'ca.caa_fec_actualiz',  'dt' => 'FECHAACTUALIZ', 'field' => 'caa_fec_actualiz' ),
    array( 'db' => 'ca.caa_ruta',  'dt' => 'RUTA', 'field' => 'caa_ruta' ),
    array( 'db' => 'ca.caa_estado',  'dt' => 'ESTADO', 'field' => 'caa_estado' ),
    array( 'db' => '"'.$descripcionperfil.'"',  'dt' => 'PERFIL', 'field' => 'PERFIL', 'as' => 'PERFIL' ),//10
    array( 'db' => '"'.$aprueba.'"',  'dt' => 'APRUEBA', 'field' => 'APRUEBA', 'as' => 'APRUEBA' ),//11
    array( 'db' => 'ca.caa_clave_int', 'dt' => 'EDITAR', 'field' => 'caa_clave_int', 'formatter' => function($d, $row){
	    if(($row[9] == '1' and strtoupper($row[10]) == strtoupper('Administrador')) or ($row[9] == '0'))
		{
			return '<img src="../../images/editar.png" alt="" height="30" width="29" onclick="EDITARARCHIVO('.$d.')" style="cursor:pointer" title="EDITAR" />';
		}
		else
		{
			return "";
		}
	}),
	array( 'db' => 'ca.caa_clave_int', 'dt' => 'VERONLINE', 'field' => 'caa_clave_int', 'formatter' => function($d, $row){
		if($row[8] != ''){ $accion1 = "iframecargar/".$row[8].""; }else{ $accion2 = "ALERTASINADJUNTO()"; }
		return "<a class='btn btn-info btn-xs' href='".$accion1."' onclick='".$accion2."' target='_blank' style='color:white;text-decoration:none;text-shadow: 1px 1px 1px #aaa;cursor:pointer'>VER ONLINE</a>";
	}),
	array( 'db' => 'ca.caa_clave_int', 'dt' => 'VERANEXOS', 'field' => 'caa_clave_int', 'formatter' => function($d, $row){
		$conane = mysqli_query($conectar,"select * from anexos_archivo where caa_clave_int = '".$row[1]."'");
		$numane = mysqli_num_rows($conane);
		
		if($numane > 0)
		{
			return '<div class="btn btn-info btn-xs" id="verocultaranexo'.$row[1].'" style="text-shadow: 1px 1px 1px #aaa">VER ANEXOS</div>';
		}
		else
		{
			return "";
		}
	}),
	array( 'db' => 'ca.caa_clave_int', 'dt' => 'DESCARGAR', 'field' => 'caa_clave_int', 'formatter' => function($d, $row){
		return '<a class="btn btn-info btn-xs" href="descargar.php?clacaa='.$row[1].'" target="_blank" style="color:white;text-decoration:none;text-shadow: 1px 1px 1px #aaa">DESCARGAR</a>';
	}),
	array( 'db' => 'ca.caa_clave_int', 'dt' => 'ZIP', 'field' => 'caa_clave_int', 'formatter' => function($d, $row){
		return '<a href="descargarcomitezip.php?clacaa='.$row[1].'" target="_blank"><img style="cursor:pointer" src="../../images/zip.png" title="Descargar todo" height="30" width="35"></a>';
	}),
	array( 'db' => 'ca.caa_clave_int', 'dt' => 'APROBAR', 'field' => 'caa_clave_int', 'formatter' => function($d, $row){
		if($row[9] == '0' and $row[11] == 1)
		{
			return '<img style="cursor:pointer" src="../../images/aprobar.png" title="Aprobar" onclick=APROBARCOMITE('.$row[1].',"COMITEOBRA") height="30" width="29">';
		}					
	}),
	array( 'db' => 'ca.caa_clave_int', 'dt' => 'ELIMINAR', 'field' => 'caa_clave_int', 'formatter' => function($d, $row){
		if(($row[9] == '1' and strtoupper($row[10]) == strtoupper('Administrador')) or ($row[9] == '0'))
		{
			return '<img style="cursor:pointer" src="../../images/delete.png" height="30" width="29" title="ELIMINAR" onclick=ELIMINARARCHIVO('.$row[1].',"COMITEOBRA") >';
		}					
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
$joinQuery = ' FROM carga_archivo ca inner join obra o on (o.obr_clave_int = ca.obr_clave_int) inner join tipo_informe ti on (ti.tii_clave_int = ca.tii_clave_int)';
if($listaobras <> '')
{
	if($nomane <> '')
	{
		if($ultimoestado == "TODOS")
		{
			$extraWhere = "ca.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and ca.tii_clave_int = 2 and ca.obr_clave_int in (".$listaobras.") and (ca.caa_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and ca.caa_clave_int in (select caa_clave_int from anexos_archivo where ana_nombre LIKE REPLACE('%".$nomane."%',' ','%') OR '".$nomane."' IS NULL OR '".$nomane."' = '') and (ca.caa_comentarios LIKE REPLACE('%".$nomcom."%',' ','%') OR '".$nomcom."' IS NULL OR '".$nomcom."' = '')";
		}
		else
		if($ultimoestado == "PENDIENTES")
		{
			$extraWhere = "ca.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and ca.caa_estado = 0 and ca.tii_clave_int = 2 and ca.obr_clave_int in (".$listaobras.") and (ca.caa_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and ca.caa_clave_int in (select caa_clave_int from anexos_archivo where ana_nombre LIKE REPLACE('%".$nomane."%',' ','%') OR '".$nomane."' IS NULL OR '".$nomane."' = '') and (ca.caa_comentarios LIKE REPLACE('%".$nomcom."%',' ','%') OR '".$nomcom."' IS NULL OR '".$nomcom."' = '')";
		}
		else
		if($ultimoestado == "APROBADOS")
		{
			$extraWhere = "ca.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and ca.caa_estado = 1 and ca.tii_clave_int = 2 and ca.obr_clave_int in (".$listaobras.") and (ca.caa_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and ca.caa_clave_int in (select caa_clave_int from anexos_archivo where ana_nombre LIKE REPLACE('%".$nomane."%',' ','%') OR '".$nomane."' IS NULL OR '".$nomane."' = '') and (ca.caa_comentarios LIKE REPLACE('%".$nomcom."%',' ','%') OR '".$nomcom."' IS NULL OR '".$nomcom."' = '')";
		}
	}
	else
	{
		if($ultimoestado == "TODOS")
		{
			$extraWhere = "ca.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and ca.tii_clave_int = 2 and ca.obr_clave_int in (".$listaobras.") and (ca.caa_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and (ca.caa_comentarios LIKE REPLACE('%".$nomcom."%',' ','%') OR '".$nomcom."' IS NULL OR '".$nomcom."' = '')";
		}
		else
		if($ultimoestado == "PENDIENTES")
		{
			$extraWhere = "ca.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and ca.caa_estado = 0 and ca.tii_clave_int = 2 and ca.obr_clave_int in (".$listaobras.") and (ca.caa_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and (ca.caa_comentarios LIKE REPLACE('%".$nomcom."%',' ','%') OR '".$nomcom."' IS NULL OR '".$nomcom."' = '')";
		}
		else
		if($ultimoestado == "APROBADOS")
		{
			$extraWhere = "ca.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and ca.caa_estado = 1 and ca.tii_clave_int = 2 and ca.obr_clave_int in (".$listaobras.") and (ca.caa_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and (ca.caa_comentarios LIKE REPLACE('%".$nomcom."%',' ','%') OR '".$nomcom."' IS NULL OR '".$nomcom."' = '')";
		}
	}
}
else
{
	if($nomane <> '')
	{
		if($ultimoestado == "TODOS")
		{
			$extraWhere = "ca.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and ca.tii_clave_int = 2 and (ca.caa_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and ca.caa_clave_int in (select caa_clave_int from anexos_archivo where ana_nombre LIKE REPLACE('%".$nomane."%',' ','%') OR '".$nomane."' IS NULL OR '".$nomane."' = '') and (ca.caa_comentarios LIKE REPLACE('%".$nomcom."%',' ','%') OR '".$nomcom."' IS NULL OR '".$nomcom."' = '') and o.obr_clave_int = '".$ultimaobra."'";
		}
		else
		if($ultimoestado == "PENDIENTES")
		{
			$extraWhere = "ca.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and ca.caa_estado = 0 and ca.tii_clave_int = 2 and (ca.caa_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and ca.caa_clave_int in (select caa_clave_int from anexos_archivo where ana_nombre LIKE REPLACE('%".$nomane."%',' ','%') OR '".$nomane."' IS NULL OR '".$nomane."' = '') and (ca.caa_comentarios LIKE REPLACE('%".$nomcom."%',' ','%') OR '".$nomcom."' IS NULL OR '".$nomcom."' = '') and o.obr_clave_int = '".$ultimaobra."'";
		}
		else
		if($ultimoestado == "APROBADOS")
		{
			$extraWhere = "ca.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and ca.caa_estado = 1 and ca.tii_clave_int = 2 and (ca.caa_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and ca.caa_clave_int in (select caa_clave_int from anexos_archivo where ana_nombre LIKE REPLACE('%".$nomane."%',' ','%') OR '".$nomane."' IS NULL OR '".$nomane."' = '') and (ca.caa_comentarios LIKE REPLACE('%".$nomcom."%',' ','%') OR '".$nomcom."' IS NULL OR '".$nomcom."' = '') and o.obr_clave_int = '".$ultimaobra."'";
		}
	}
	else
	{
		if($ultimoestado == "TODOS")
		{
			$extraWhere = "ca.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and ca.tii_clave_int = 2 and (ca.caa_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and (ca.caa_comentarios LIKE REPLACE('%".$nomcom."%',' ','%') OR '".$nomcom."' IS NULL OR '".$nomcom."' = '') and o.obr_clave_int = '".$ultimaobra."'";
		}
		else
		if($ultimoestado == "PENDIENTES")
		{
			$extraWhere = "ca.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and ca.caa_estado = 0 and ca.tii_clave_int = 2 and (ca.caa_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and (ca.caa_comentarios LIKE REPLACE('%".$nomcom."%',' ','%') OR '".$nomcom."' IS NULL OR '".$nomcom."' = '') and o.obr_clave_int = '".$ultimaobra."'";
		}
		else
		if($ultimoestado == "APROBADOS")
		{
			$extraWhere = "ca.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and ca.caa_estado = 1 and ca.tii_clave_int = 2 and (ca.caa_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and (ca.caa_comentarios LIKE REPLACE('%".$nomcom."%',' ','%') OR '".$nomcom."' IS NULL OR '".$nomcom."' = '') and o.obr_clave_int = '".$ultimaobra."'";
		}
	}
}

$groupBy ="";
require( '../data/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy )
);

?>