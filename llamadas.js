function redirect(url){
	window.location.href="principal.php#/"+url;	
}
function ajaxFunction(){
  var xmlHttp;
  try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    return xmlHttp;
    }
  catch (e)
    {
    // Internet Explorer
    try
      {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      return xmlHttp;
      }
    catch (e)
      {
      try
        {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        return xmlHttp;
        }
      catch (e)
        {
        alert("Your browser does not support AJAX!");
        return false;
        }
      }
    }
}
function verihoras(hi,hf){
  var hin = $('#'+hi).val();
  $('#'+hf).attr('min',hin);
}
function alertas(){
  var msn ="";
  jError(msn,"Mensaje de Error HD");
}
function notificacion(msn){
  alertify.notify(msn); 
  return false;
}
function alertaok(msn){
  alertify.alert(msn, function(){ 		
    //alertify.message('OK');
    });
}
function ok(msn){
  alertify.success('<i class="icon fa fa-check"></i>Alerta!<br>'+msn); 
  return false;
}
function error(msn){
  alertify.error('<i class="icon fa fa-ban"></i>Alerta!<br>'+msn); 
  return false; 
} 
function iniValidar(form) {
    autosize($('textarea'));
    //$(".select2_single").select2();
    //init_icheck();
    $('.dropify').dropify()
    $('.selectpicker').selectpicker({
      liveSearch: true,
      hideDisabled: true
  
    }).on('change', function () {
      $(this).parsley().validate()
      ////console.log("Por aca");	
    });
    $('#' + form).parsley();
  
    $('.collapse-link').on('click', function () {
      var $BOX_PANEL = $(this).closest('.x_panel'),
        $ICON = $(this).find('i'),
        $BOX_CONTENT = $BOX_PANEL.find('.x_content');
  
      // fix for some div with hardcoded fix class
      if ($BOX_PANEL.attr('style')) {
        $BOX_CONTENT.slideToggle(200, function () {
          $BOX_PANEL.removeAttr('style');
        });
      } else {
        $BOX_CONTENT.slideToggle(200);
        $BOX_PANEL.css('height', 'auto');
      }
  
      $ICON.toggleClass('fa-chevron-up fa-chevron-down');
    });
  
  
    $('.close-link').click(function () {
      var $BOX_PANEL = $(this).closest('.x_panel');
      $BOX_PANEL.remove();
    });
  
    $('[data-toggle="tooltip"]').tooltip({
      container: 'body'
    });
    $('[data-toggle2="tooltip"]').tooltip({
      container: 'body'
    });
    $('.currency').formatCurrency({ symbol: '$', eventOnDecimalsEntered: true, roundToDecimalPlace: 0 });
  
    $('.currency2').blur(function () {
      //$('.currency').html(null);
      $(this).formatCurrency({
        symbol: '',
        eventOnDecimalsEntered: true,
        roundToDecimalPlace: 0
      });
    })
    .focus(function () {
      $(this).formatCurrency({
        symbol: '',
        eventOnDecimalsEntered: true,
        roundToDecimalPlace: 0,
        digitGroupSymbol: '',
      });
    })
    .bind('decimalsEntered', function (e, cents) {
      var errorMsg = 'Please do not enter any cents (0.' + cents + ')';
      //console.log('Event on decimals entered: ' + errorMsg);
    });
    //initFile();
  
    $('.currency').blur(function() {
      //$('.currency').html(null);
      $(this).formatCurrency({ roundToDecimalPlace: 0, eventOnDecimalsEntered: true,roundToDecimalPlace: 0 });
    })
    .focus(function(){
      $(this).formatCurrency({ symbol: '', eventOnDecimalsEntered: true, roundToDecimalPlace: 0, digitGroupSymbol: '', });           
    })
    .bind('decimalsEntered', function(e, cents) {
      var errorMsg = 'Please do not enter any cents (0.' + cents + ')';               
      //console.log('Event on decimals entered: ' + errorMsg);
    });   
    
    $('.timepicker2').timepicker({
      autoclose: true,
      minuteStep: 1,
      showMeridian: false
    });
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd'
    });
}
function INICIALIZARLISTAS()
{
	$(".dropify").dropify({
        messages: {
            'default': 'Arrastre imagen o haga click aqui',
            'replace': 'Arrastre y suelte o haga clic para reemplazar',
            'remove':  'Eliminar',
            'error':   'Ooops, algo pasó mal'
        }
    });


     $('a.fullsizable').fullsizable();

	//$(".select2").select2();
	
	//$("select[data-role=multiselect]").fSelect();
	
	autosize($('textarea'));
	$('.selectpicker').selectpicker({
      liveSearch: true,
	  hideDisabled: true
     
    }).on('change',function(){
	   // $(this).selectpicker('toggle');	
		////console.log("Por aca");	
	});
	
	$('#correoprincipal').on('keyup',function(e)
	{
	   if(e.keyCode==13)
	   {
		   CRUDCONTRATOS('GUARDARALERTAS','','','');
		  //$("#emails").append( "<li>"+$(this).val()+"</li>" ); 
	   }
	});
	$('#correoprincipal2').on('keyup',function(e)
	{
	   if(e.keyCode==13)
	   {
		   CRUDLICENCIAS('GUARDARALERTAS','','','');
		  //$("#emails").append( "<li>"+$(this).val()+"</li>" ); 
	   }
	});
	$('#correoprincipal3').on('keyup',function(e)
	{
	   if(e.keyCode==13)
	   {
		   CRUDMANTENIMIENTOS('GUARDARALERTAS','','');
		  //$("#emails").append( "<li>"+$(this).val()+"</li>" ); 
	   }
	});


	 $('.daterange').daterangepicker({timePicker: false, timePickerIncrement: 1, format: 'MM/DD/YYYY',minYear: 1901,},);
	 $('.daterange').on('apply.daterangepicker', function(ev, picker) {
	 	$(this).attr('data-fi',picker.startDate.format('YYYY-MM-DD'));
	 	$(this).attr('data-ff',picker.endDate.format('YYYY-MM-DD'));
  		 //console.log(picker.startDate.format('YYYY-MM-DD'));
 		 //console.log(picker.endDate.format('YYYY-MM-DD'));
	});

	   /*$('.currency').formatCurrency({
        colorize: true
    });*/

/*	$('.onlynumber').inputmask("numeric", {
    radixPoint: ".",
    groupSeparator: ",",
    digits: 2,
    autoGroup: true,
    prefix: '$', //No Space, this will truncate the first character
    rightAlign: false,
    oncleared: function () { self.Value(''); }
});*/
	
	//autosize.update($('textarea'))
	$('[data-toggle="tooltip"]').tooltip(); 
	$('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    //startDate: '-3d',
    clearBtn:true,
    todayBtn:'linked',
    language:'es',
    autoclose: true
	}).inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});


}

function CRUDUSUARIOS(opt,id) {
  if (opt == "NUEVOUSUARIO") {
    $('#titlemodal').html("Crear Usuario");
    $('#modalregistro > .modal-dialog').removeClass('modal-lg');
    $('#btnguardar').attr('onclick',"CRUDUSUARIOS('GUARDARUSUARIO')");
    $('')
          
    $.post('funciones/usuarios/fnUsuarios.php', {
          opcion: opt
      }, function(data, textStatus, xhr) {
        $('#contenidomodal').html(data);
    });
  }else if (opt ==  "GUARDARUSUARIO" ) {
    var nombre = $('#txtnombre').val();
    var apellido = $('#txtapellido').val();
    var email = $('#txtemail').val();  
    var telefono = $('#txttelefono').val();
    var celular = $('#txtcelular').val();
    var cargo = $('#txtcargo').val(); 
    $('#formusuarios').parsley().validate();
    if($('#formusuarios').parsley().isValid()){
      $.post('funciones/usuarios/fnUsuarios.php', {
        opcion:opt,
        nombre:nombre,
        apellido:apellido,
        email:email,
        telefono:telefono,
        celular:celular,
        cargo:cargo
        
      },function (data){
        var res = data[0].res;
        var msn = data[0].msn;
        if (res == "error") 
        {
          error(msn);
        }else {
          ok(msn); 
          var table = $('#tblusuario').DataTable();
          table.draw('full-hold');      
        }
      }, "json");
    }


  }else if (opt == "LISTARUSUARIOS") {
		$.post('funciones/usuarios/fnUsuarios.php', {
			opcion: opt
		}, function (data) {
			$('#divusiarios').html(data);
		})
  }
}
function CRUDUPRODUCTO(opt,id){
  if (opt=="GUARDARPRODUCTO"){
    var txtnombre = $('#txtnombre').val();
    var txtreferencia = $('#txtreferencia').val();
    var txtcantidad = $('#txtcantidad').val();
    $.post('funciones/productos/fnProductos.php', {
      opcion:opt,
      txtnombre:txtnombre,
      txtreferencia:txtreferencia,
      txtcantidad:txtcantidad
    },
    function (data) 
    {
      var res = data[0].res;
      var msn = data[0].msn;
      if (res == "error") 
      {
        error(msn);
      }else {
        ok(msn);
        var table = $('#tblproductos').DataTable();
        table.draw('full-hold');
        $('#txtnombre').val('');
        $('#txtreferencia').val('');
        $('#txtcantidad').val('');      
      }
    }, "json");

  }else if (opt=="LISTARPRODUCTOS"){
    $.post('funciones/productos/fnProductos.php', {
			opcion: opt
		}, function (data) {
			$('#tablaproducto').html(data);
		})

  }else if(opt == "EDITARPRODUCTO"){
    $('#titlemodal').html("Editar producto");
    $('#modalregistro > .modal-dialog').removeClass('modal-lg');
    $('#btnguardar').attr('onclick',"CRUDUPRODUCTO('GUARDAREDICION',"+id+")");
    $('')
    $.post('funciones/productos/fnProductos.php', {
          opcion: opt,
          id:id
      }, function(data, textStatus, xhr) {
        $('#contenidomodal').html(data);
    });
  }else if (opt == "GUARDAREDICION"){
    var txtnombre1 = $('#txtnombre1').val();
    var txtreferencia1 = $('#txtreferencia1').val();
    var txtcantidad1 = $('#txtcantidad1').val();
    $.post('funciones/productos/fnProductos.php', {
      opcion:opt,
      txtnombre:txtnombre1,
      txtreferencia:txtreferencia1,
      txtcantidad:txtcantidad1,
      id:id
    },
    function (data) 
    {
      var res = data[0].res;
      var msn = data[0].msn;
      if (res == "error") 
      {
        error(msn);
      }else {
        ok(msn);  
        var table =$('#tblproductos').DataTable();
        table.row('#row_'+id).draw(false); 
      }
    }, "json");

  }

}