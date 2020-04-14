$(document).ready(function(e) {

    var selected = [];
    var busciudad = $('#busciudad').val();
    var estado = $('#tblciudades').attr('data-estado');
    console.log(estado);
    var table2 = $('#tblciudades').DataTable( {       
       "dom": '<"top"i>rt<"bottom"lp><"clear">',
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "responsive": true,
    "paging": true,
    "pagingType": "simple_numbers",
    "lengthMenu": [[10,15,20,-1], [10,15,20,"Todos"]],
    "language": {
    "lengthMenu": "Ver _MENU_ registros",
    "zeroRecords": "No se encontraron datos",
    "info": "Resultado _START_ - _END_ de _TOTAL_ registros",
    "infoEmpty": "No se encontraron datos",
    "infoFiltered": "",
    "paginate": {"previous": "Anterior","next":"siguiente"},
    "search":"",
    "sSearchPlaceholder":"Busqueda"
    },	
    "processing": true,
    "serverSide": true,
    "ajax": {
                "url": "modulos/ciudades/ciudadesjson.php",
                "data": {busciudad:busciudad,estado:estado},
                "type":"POST"
            },
    "columns": [					
        { "data" : "Ciudad","className" : "dt-left" },
        { "data" : "Usiario","className" : "dt-left","orderable":false},
        { "data" : "Actualizacion","className" : "dt-left" ,"orderable":false},
        { "data" : "Activo","className" : "dt-left","orderable":false},
        { "data" : "Modificar","className" : "dt-left","orderable":false},
        { "data" : "Eliminar","className" : "dt-left","orderable":false},
    ],
    "order": [[0, 'asc']],
    
} );

 $('#tblciudades tbody').on('click', 'tr', function () {
    var id = this.id;
    var index = $.inArray(id, selected);
    

    if ( index === -1 ) {
        selected.push( id );
    } else {
        selected.splice( index, 1 );
    }

    $(this).toggleClass('selected');
} );	

 var table2 = $('#tblciudades').DataTable();

});


