<?php
include ("../../data/Conexion.php");

error_reporting(0);
$table = 'producto';
$primaryKey = 'p.id_producto';

$columns = array(
	array(
		'db' => 'p.id_producto',
		'dt' => 'DT_RowId', 'field' => 'id_producto',
		'formatter' => function( $d, $row ) {
			return 'row_'.$d;
		}
    ),
    array(
		'db' => 'p.id_producto',
		'dt' => 'UD_Id', 'field' => 'id_producto',
		'formatter' => function( $d, $row ) {
			return $d;
		}
	),
        array( 'db' => 'p.id_producto', 'dt' => 'Codigo', 'field' => 'id_producto' ),

        array('db'  => 'p.nombre','dt' => 'Nombre', 'field' => 'nombre'),

        array('db'  => 'p.refencia','dt' => 'Refencia', 'field' => 'refencia'),

        array('db'  => 'p.cantidad','dt' => 'Cantidad', 'field' => 'cantidad'),

		array('db'  => 'p.id_producto','dt' => 'Modificar', 'field' => 'id_producto','formatter'    =>function($d,$row ){

            return '<a class="btn btn-block btn-warning btn-xs" role="button" onclick=CRUDUPRODUCTO("EDITARPRODUCTO","'.$d.'") style="cursor:pointer;width:20px; height:20px;" data-toggle="modal" data-target="#modalregistro"><i class="fa fa-edit"></i></a>';

        }),
 
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
$joinQuery = "from producto p";

$extraWhere ="";

echo json_encode(
	SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy,$with )
);