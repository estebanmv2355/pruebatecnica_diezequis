   var selected = [];
   console.log("Hola");
  

 
    console.log("Entro por aca");
    var ti = $('#tbtinformes').attr('data-tipo');
    var obras = [];
	var objCBarray = document.getElementsByName('multiselect_busobra');
	var o = 0;
	for (i = 0; i < objCBarray.length; i++) 
	{
		if (objCBarray[i].checked) 
		{
            obras[o]= objCBarray[i].value ;
            o++;
	    }
    }
    
    var col_6 =true ;
    var col_7 = true;
  
    if (ti == 1) {
        col_6 = false;
        col_7 = false;
    }

    if(obras.length<=0)
    {
        obras = "";
    }

		
	var nomarc = form1.busnombrearchivo.value;
	var nomane = form1.busnombreanexo.value;
	var ley = form1.busleyenda.value;
    console.log(ti);
    var table2 = $('#tbtinformes').DataTable( {
    "columnDefs":[
        { "targets":[6],"visible":col_6},
        { "targets":[7],"visible":col_7}
    ], 
    //"dom": '<"top"i>rt<"bottom"lp><"clear">',
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "responsive": true,
    "pagingType": "simple_numbers",
    "lengthMenu": [[100 ,10,15,20,-1], [100,10,15,20,"Todos"]],
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
                "url": "../../modulos/informes/informesjson.php",
                "data": {ti:ti,obras:obras,nomarc:nomarc,nomane:nomane,ley:ley},
                "type":"POST"
            },
    "columns": [					
        { "data" : "nombrearchivo","className" : "dt-left " },
        { "data" : "obra",         "className" : "dt-left " },
        { "data" : "fechacrea",    "className" : "dt-left" },
        { "data" : "usucrea",      "className" : "dt-center" },
        { "data" : "veronline",    "className" : "dt-left" },			
        { "data" : "veranexo",     "className" : "dt-center dt-anexo","orderable" : false },
        { "data" : "descarga",     "className" : "dt-center","orderable" : false},			
        { "data" : "descargazip",  "className" : "dt-center","orderable" : false},
    ],
    "order": [[0, 'desc'],[2, 'desc']]
    } );

    var table2 = $('#tbtinformes').DataTable();

    var detailRows = [];

    $('#tbtinformes tbody').on( 'click', 'tr td.dt-anexo', function () {
        var tr = $(this).closest('tr');
        var row = table2.row( tr );
        var idc = tr.attr('id')
        var n=idc.split("rowi_");
       //var idx = $.inArray( tr.attr('id'), detailRows );
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            tr.addClass( 'shown' );
            var table1 = "<div class='row'><div class='col-md-1'></div><div class='col-md-11'>"+
            "<table width='100%' id='tbanexos"+n[1]+"'  class='table table-striped table-condensed table-bordered' style='font-size:11px'>"+
            "<thead>"+
            "<tr>"+		
                "<th class='dt-head-center'>NOMBRE DEL ANEXO</th>"+   
                "<th class='dt-head-center'>VER</th>"+
                "<th class='dt-head-center'>DESCARGAR</th>"+
            "</tr>"+
           "</thead>"+
                "<tfoot>"+
                    "<tr>"+
                        "<th></th>"+
                        "<th></th>"+
                        "<th></th>"+
                    "</tr>"+
               " </tfoot>"+
            "<tbody>";	
            table1+="</tbody></table></div></div>";	
           row.child( table1 ).show();
            detalleanexo(n[1]);
           tr.addClass('shown');
        }
} );

    // Apply the search
     table2.columns().every( function () {
        var that = this;

          $( 'input', this.footer() ).on( 'keyup change', function () {
            that
                .search( this.value )
                .draw();
        } );
    } );




///JS ANEXO
function detalleanexo(ida)
{

    var table3 = $('#tbanexos'+ida).DataTable( {    
       "dom": '<"top"i>rt<"bottom"lp><"clear">',
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
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
                "url": "../../modulos/informes/anexosjson.php",
                "data": {ida:ida},
                "type":"POST"
            },
    "columns": [	
        {"data" : "nombre","className" : "dt-left"},
        {"data" : "ver","className" : "dt-left"},
        {"data" : "descarga","className" : "dt-left"},
    ],
    "order": [[0, 'asc']],
    fnDrawCallback:function(row,data,index){
       // $('.selectpicker').selectpicker();
    }
} );
 

 var table3 = $('#tbanexos'+ida).DataTable();

// Apply the search
 table3.columns().every( function () {
    var that = this;

      $( 'input', this.footer() ).on( 'keyup change', function () {
        that
            .search( this.value )
            .draw();
    } );
} );

}


