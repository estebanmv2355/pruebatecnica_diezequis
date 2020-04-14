/* Formatting function for row details - modify as you need */

// JavaScript Document
function format ( d ) {
	return '<div class="row"><div class="col-md-12">'+d+'</div></div>';
}
var selected = [];
$(document).ready(function(e) {
    //var egreso = $('#egreso').val(); 4545 454 54 5 45 4 54 5 4
    var estado = $('#tblobras').attr('data-estado');
    var busobra = $('#busobra').val();
    var busciu = $('#busciu').val();
    var busdireccion = $('#busdireccion').val();
    var busrespon = $('#busrespon').val(); 
	var table2 = $('#tblobras').DataTable( { 
	"dom": '<"top"i>rt<"bottom"flp><"clear">',      
	"searching":false,
	"ordering": true,
	"info": true,
	"autoWidth": true,
	"pagingType": "simple_numbers",
	"lengthMenu": [[20,30,50,-1], [20,30,50,"Todos"]],
	"language": {
		"lengthMenu": "Ver _MENU_ registros",
		"zeroRecords": "No se encontraron datos",
		"info": "Resultado _START_ - _END_ de _TOTAL_ registros",
		"infoEmpty": "No se encontraron datos",
		"infoFiltered": "",
		"paginate": {"previous": "Anterior","next":"Siguiente"},
        "search":"",
        "sSearchPlaceholder":"Busqueda"
	},		
	"processing": true,
    "serverSide": true,
    "ajax": {
                "url": "modulos/obras/obrasjson.php",
                "data": {estado:estado,busobra:busobra,busciu:busciu,busdireccion:busdireccion,busrespon:busrespon},
                "type":"POST"
			},
	"columns": [
		{
    		"class":          "details-control",
    		"orderable":      false,
    		"data":           null,
    		"defaultContent": ""
		},
        { "data" : "Nombre", "className" : "dt-left"},
        { "data" : "Ciudad", "className" : "dt-center"},
        { "data" : "Direccion", "className" : "dt-left"},
        { "data" : "Responsalbe", "className" : "dt-center"},	
        { "data" : "Creadopor", "className" : "dt-left"},
        { "data" : "Actualizacion", "className" : "dt-center"},	
        { "data" : "Estado", "className" : "dt-left"},
        { "data" : "Modificar", "className" : "dt-left","orderable":false },
        { "data" : "Eliminar", "className" : "dt-left","orderable":false },
	],
	"columnDefs": [
		{ "width": "20px", "targets": 0 },
	],
	"order": [[1, 'asc']],
	"rowCallback": function( row, data ) {
        if ( $.inArray(data.DT_RowId, selected) !== -1 ) 
		{
        }		 
    }
} );

	var table2 = $('#tblobras').DataTable();
    var detailRows = [];
 
    $('#tblobras tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table2.row( tr );
		var dat = row.data();
		var id = tr.attr('id')
        var n=id.split("row_");	
        console.log(n[1]);		
        
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else 
		{
            var table1 = "<div class='col-md-12'>"+
            "<div id = 'imagenesobras_"+n[1]+"'></div>"+
            "</div>"+
            "<script>CRUDOBRAS('LISTARIMAGENESOBRA','"+n[1]+"')</script>";
			row.child(table1).show();			
			tr.addClass('shown');
        }
    } );
    table2.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );
});


