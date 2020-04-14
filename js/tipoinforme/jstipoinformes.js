$(document).ready(function(e) {

    var selected = [];
    var busciudad = $('#busciudad').val();
    var estado = $('#tbltipoinforme').attr('data-estado');
    console.log(estado);
    var table2 = $('#tbltipoinforme').DataTable( {       
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
                "url": "modulos/tipoinforme/tipoinformejson.php",
                "data": {busciudad:busciudad,estado:estado},
                "type":"POST"
            },
    "columns": [					
        { "data" : "Nombre",           "className" : "dt-left"},
        { "data" : "Png",              "className" : "dt-left","orderable":false},
        { "data" : "Jpg",              "className" : "dt-left","orderable":false},
        { "data" : "Jpeg",             "className" : "dt-left","orderable":false},
        { "data" : "gif",              "className" : "dt-left","orderable":false},
        { "data" : "dwg",              "className" : "dt-left","orderable":false},
        { "data" : "mpp",              "className" : "dt-left","orderable":false},
        { "data" : "tif",              "className" : "dt-left","orderable":false},
        { "data" : "pdf",              "className" : "dt-left","orderable":false},
        { "data" : "docx",             "className" : "dt-left","orderable":false},
        { "data" : "xls",              "className" : "dt-left","orderable":false},
        { "data" : "xlsx",             "className" : "dt-left","orderable":false},
        { "data" : "Usuactualizacion", "className" : "dt-left","orderable":false},
        { "data" : "Fechactualizacion","className" : "dt-left","orderable":false},
        { "data" : "Activo",           "className" : "dt-left","orderable":false},
        { "data" : "Modificar",        "className" : "dt-left","orderable":false},
        { "data" : "Eliminar",         "className" : "dt-left","orderable":false},
    ],
    "order": [[0, 'asc']],
} );

 $('#tbltipoinforme tbody').on('click', 'tr', function () {
    var id = this.id;
    var index = $.inArray(id, selected);
    

    if ( index === -1 ) {
        selected.push( id );
    } else {
        selected.splice( index, 1 );
    }

    $(this).toggleClass('selected');
} );	

 var table2 = $('#tbltipoinforme').DataTable();

});


