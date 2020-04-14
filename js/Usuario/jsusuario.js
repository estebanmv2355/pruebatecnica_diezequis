$(document).ready(function(e) {
    var selected = [];
    var table2 = $('#tblusuario').DataTable( {       
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
                "url": "modulos/usuarios/usuariosjson.php",
                "data": {},
                "type":"POST"
            },
    "columns": [					
        { "data" : "nombre","className" : "dt-left" },
        { "data" : "apellidos","className" : "dt-left" },
        { "data" : "email","className" : "dt-left"},
        { "data" : "telefono","className" : "dt-left"},
        { "data" : "celular","className" : "dt-left"},
        { "data" : "cargo","className" : "dt-left"},
    ],
    "order": [[0, 'asc']],
    
} );

 $('#tblusuario tbody').on('click', 'tr', function () {
    var id = this.id;
    var index = $.inArray(id, selected);
    

    if ( index === -1 ) {
        selected.push( id );
    } else {
        selected.splice( index, 1 );
    }

    $(this).toggleClass('selected');
} );	

 var table2 = $('#tblusuario').DataTable();

});

