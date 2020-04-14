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
$table = 'carga';
// Table's primary key
$primaryKey = 'car_clave_int';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes + the primary key column for the id
$columns = array(
    array(
        'db' => 'c.car_clave_int',
        'dt' => 'DT_RowId','field' => 'car_clave_int',
        'formatter' => function( $d, $row ) {
            // Technically a DOM id cannot start with an integer, so we prefix
            // a string. This can also be useful if you have multiple tables
            // to ensure that the id is unique with a different prefix
            return 'row_'.$d;
        }
    ),
    array( 'db' => 'c.car_clave_int', 'dt' => 'CLAVE', 'field' => 'car_clave_int' ),
    array( 'db' => 'c.car_nombre', 'dt' => 'NOMBRE', 'field' => 'car_nombre' ),
    array( 'db' => 'o.obr_nombre',  'dt' => 'OBRA', 'field' => 'obr_nombre' ),
    array( 'db' => 'c.car_fecha_creacion',  'dt' => 'FECHACREACION', 'field' => 'car_fecha_creacion' ),
    array( 'db' => 'c.car_usu_actualiz',  'dt' => 'USUARIOACTUALIZ', 'field' => 'car_usu_actualiz' ),
    array( 'db' => 'c.car_fec_actualiz',  'dt' => 'FECHAACTUALIZ', 'field' => 'car_fec_actualiz' ),
    array( 'db' => 'c.car_estado',  'dt' => 'ESTADO', 'field' => 'car_estado' ),//7
    array( 'db' => '"'.$descripcionperfil.'"',  'dt' => 'PERFIL', 'field' => 'PERFIL', 'as' => 'PERFIL' ),//8
    array( 'db' => '"'.$aprueba.'"',  'dt' => 'APRUEBA', 'field' => 'APRUEBA', 'as' => 'APRUEBA' ),//9
    array( 'db' => 'c.car_clave_int', 'dt' => 'EDITAR', 'field' => 'car_clave_int', 'formatter' => function($d, $row){
	    if(($row[7] == '1' and strtoupper($row[8]) == strtoupper('Administrador')) or ($row[7] == '0'))
		{
			return '<img src="../../images/editar.png" alt="" height="30" width="29" onclick="EDITAR('.$d.')" style="cursor:pointer" title="EDITAR" />';
		}
		else
		{
			return "";
		}
	}),
	array( 'db' => 'c.car_clave_int', 'dt' => 'VERFOTOS', 'field' => 'car_clave_int', 'formatter' => function($d, $row){
		return '<div onclick=parent.mostrarVentana('.$row[1].') class="btn btn-info btn-xs" id="verocultofotos'.$row[1].'" style="text-shadow: 1px 1px 1px #aaa">VER FOTOS</div><input name="ocultofotos'.$row[1].'" id="ocultofotos'.$row[1].'" value="0" type="hidden" />';
	}),
	array( 'db' => 'c.car_clave_int', 'dt' => 'ZIP', 'field' => 'car_clave_int', 'formatter' => function($d, $row){
		return '<a href="descargarregistrofotograficozip.php?clacar='.$row[1].'" target="_blank"><img style="cursor:pointer" src="../../images/zip.png" title="Descargar todo" height="30" width="35"></a>';
	}),
	array( 'db' => 'c.car_clave_int', 'dt' => 'APROBAR', 'field' => 'car_clave_int', 'formatter' => function($d, $row){
		if($row[7] == '0' and $row[9] == 1)
		{
			return '<img style="cursor:pointer" src="../../images/aprobar.png" title="Aprobar" onclick=APROBARCOMITE('.$row[1].',"FOTO") height="30" width="29">';
		}					
	}),
	array( 'db' => 'c.car_clave_int', 'dt' => 'ELIMINAR', 'field' => 'car_clave_int', 'formatter' => function($d, $row){
		if(($row[7] == '1' and strtoupper($row[8]) == strtoupper('Administrador')) or ($row[7] == '0'))
		{
			return '<img style="cursor:pointer" src="../../images/delete.png" height="30" width="29" title="ELIMINAR" onclick=ELIMINARARCHIVO('.$row[1].',"FOTO") >';
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
$joinQuery = ' FROM carga c inner join obra o on (o.obr_clave_int = c.obr_clave_int) inner join tipo_informe ti on (ti.tii_clave_int = c.tii_clave_int)';

if($listaobras <> '')
{
	if($nomley <> '')
	{
		if($ultimoestado == "TODOS")
		{
			$extraWhere = "c.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and c.obr_clave_int in (".$listaobras.") and (c.car_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and c.car_clave_int in (select car_clave_int from carga_foto where caf_leyenda LIKE REPLACE('%".$nomley."%',' ','%') OR '".$nomley."' IS NULL OR '".$nomley."' = '')";
		}
		else
		if($ultimoestado == "PENDIENTES")
		{
			$extraWhere = "c.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and car_estado = 0 and c.obr_clave_int in (".$listaobras.") and (c.car_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and c.car_clave_int in (select car_clave_int from carga_foto where caf_leyenda LIKE REPLACE('%".$nomley."%',' ','%') OR '".$nomley."' IS NULL OR '".$nomley."' = '')";
		}
		else
		if($ultimoestado == "APROBADOS")
		{
			$extraWhere = "c.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and car_estado = 1 and c.obr_clave_int in (".$listaobras.") and (c.car_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and c.car_clave_int in (select car_clave_int from carga_foto where caf_leyenda LIKE REPLACE('%".$nomley."%',' ','%') OR '".$nomley."' IS NULL OR '".$nomley."' = '')";
		}
	}
	else
	{
		if($ultimoestado == "TODOS")
		{
			$extraWhere = "c.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and c.obr_clave_int in (".$listaobras.") and (c.car_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '')";
		}
		else
		if($ultimoestado == "PENDIENTES")
		{
			$extraWhere = "c.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and car_estado = 0 and c.obr_clave_int in (".$listaobras.") and (c.car_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '')";
		}
		else
		if($ultimoestado == "APROBADOS")
		{
			$extraWhere = "c.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and car_estado = 1 and c.obr_clave_int in (".$listaobras.") and (c.car_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '')";
		}
	}
}
else
{
	if($nomley <> '')
	{
		if($ultimoestado == "TODOS")
		{
			$extraWhere = "c.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and (c.car_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and c.car_clave_int in (select car_clave_int from carga_foto where caf_leyenda LIKE REPLACE('%".$nomley."%',' ','%') OR '".$nomley."' IS NULL OR '".$nomley."' = '') and o.obr_clave_int = '".$ultimaobra."'";
		}
		else
		if($ultimoestado == "PENDIENTES")
		{
			$extraWhere = "c.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and car_estado = 0 and (c.car_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and c.car_clave_int in (select car_clave_int from carga_foto where caf_leyenda LIKE REPLACE('%".$nomley."%',' ','%') OR '".$nomley."' IS NULL OR '".$nomley."' = '') and o.obr_clave_int = '".$ultimaobra."'";
		}
		else
		if($ultimoestado == "APROBADOS")
		{
			$extraWhere = "c.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and car_estado = 1 and (c.car_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and c.car_clave_int in (select car_clave_int from carga_foto where caf_leyenda LIKE REPLACE('%".$nomley."%',' ','%') OR '".$nomley."' IS NULL OR '".$nomley."' = '') and o.obr_clave_int = '".$ultimaobra."'";
		}
	}
	else
	{
		if($ultimoestado == "TODOS")
		{
			$extraWhere = "c.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and (c.car_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and o.obr_clave_int = '".$ultimaobra."'";
		}
		else
		if($ultimoestado == "PENDIENTES")
		{
			$extraWhere = "c.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and car_estado = 0 and (c.car_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and o.obr_clave_int = '".$ultimaobra."'";
		}
		else
		if($ultimoestado == "APROBADOS")
		{
			$extraWhere = "c.obr_clave_int in (select obr_clave_int from usuario_obra where usu_clave_int = ".$claveusuario.") and car_estado = 1 and (c.car_nombre LIKE REPLACE('%".$nomarc."%',' ','%') OR '".$nomarc."' IS NULL OR '".$nomarc."' = '') and o.obr_clave_int = '".$ultimaobra."'";
		}
	}
}

$groupBy ="";
require( '../data/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy )
);

?>