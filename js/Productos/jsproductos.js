$(document).ready(function(e) {

    var selected = [];
    var table2 = $('#tblproductos').DataTable( {       
    "dom": '<"top"i>rt<"bottom"lp><"clear">',
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "responsive": true,
    "paging": true,
    "pagingType": "simple_numbers",
    "lengthMenu": [[10,15,20,-1], [10,15,20]],
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
                "url": "modulos/productos/productosjson.php",
                "data": {},
                "type":"POST"
            },
    "columns": [					
        { "data" : "Nombre","className" : "dt-left" },
        { "data" : "Refencia","className" : "dt-left" ,"orderable":false},
        { "data" : "Cantidad","className" : "dt-left","orderable":false},
        { "data" : "Modificar","className" : "dt-left","orderable":false},
    ],
    "order": [[0, 'asc']],
    
} );

 $('#tblproductos tbody').on('click', 'tr', function () {
    var id = this.id;
    var index = $.inArray(id, selected);
    

    if ( index === -1 ) {
        selected.push( id );
    } else {
        selected.splice( index, 1 );
    }

    $(this).toggleClass('selected');
} );	

 var table2 = $('#tblproductos').DataTable();

});


