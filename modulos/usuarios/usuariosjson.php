<?php
include ("../../data/Conexion.php");

error_reporting(0);

$table = 'usuarios';
$primaryKey = 'u.id_consecutivo';

$columns = array(
	array(
		'db' => 'u.id_consecutivo',
		'dt' => 'DT_RowId', 'field' => 'id_consecutivo',
		'formatter' => function( $d, $row ) {
			return 'row_'.$d;
		}
    ),
    array(
		'db' => 'u.id_consecutivo',
		'dt' => 'UD_Id', 'field' => 'id_consecutivo',
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
        array( 'db' => 'u.id_consecutivo', 'dt' => 'Codigo', 'field' => 'id_consecutivo' ),

		array('db'  => 'u.nombres','dt' => 'nombre', 'field' => 'nombres'),
		
		array('db'  => 'u.apellidos','dt' => 'apellidos', 'field' => 'apellidos'),

        array('db'  => 'u.email','dt' => 'email', 'field' => 'email'),

		array('db'  => 'u.telefono','dt' => 'telefono', 'field' => 'telefono'),
		
		array('db'  => 'u.celular','dt' => 'celular', 'field' => 'celular'),

		array('db'  => 'u.cargo','dt' => 'cargo', 'field' => 'cargo'), 
);

$sql_details = array(
	'user' => 'root',
	'pass' => '',
	'db'   => 'bdpruebatecnica',
	'host' => 'localhost'
);

require( '../../data/ssp.class.php' );
$whereAll ="";
$groupBy = '';
$with = '';
$joinQuery = "from usuarios u";

$extraWhere ="";


echo json_encode(
	SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy,$with )
);