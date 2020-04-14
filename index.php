<?php
  session_start();// activa la variable de sesion
  require_once 'data/conexion.php';   
  error_reporting(0);    

  header();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="dist/img/favicon2.ico?<?php echo time();?>" rel="shortcut icon"> 
    <title>PRUEBA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="dist/cdn/angular.min.js"></script>
    <script src="dist/js/angular-ui-router.js"></script> 
    <script src="dist/js/ocLazyLoad.js"></script>  
    <script src="dist/js/rutas.js?<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.css?<?php echo time();?>">
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="dist/css/fuente.css?<?php echo time();?>"/>
    <link rel="stylesheet" href="dist/css/bootstrapds.css?<?php echo time();?>"/>
    <link rel="stylesheet" href="dist/font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.css?<?php echo time();?>"/>
    <link rel="stylesheet" type="text/css" href="dist/DataTables-1.10.10/media/css/dataTables.bootstrap.css?<?php echo time(); ?>"/>
    <link rel="stylesheet" type="text/css" href="dist/DataTables-1.10.10/extensions/Responsive/css/responsive.dataTables.css?<?php echo time();?>"/>
    <link rel="stylesheet" type="text/css" href="dist/DataTables-1.10.10/extensions/ColReorder/css/colReorder.dataTables.min.css?<?php echo time();?>"/>
    <link rel="stylesheet" type="text/css" href="dist/DataTables-1.10.10/extensions/FixedColumns/css/fixedColumns.dataTables.min.css?<?php echo time();?>"/>
    <link rel="stylesheet" type="text/css" href="dist/DataTables-1.10.10/extensions/FixedHeader/css/fixedHeader.dataTables.min.css?<?php echo time();?>"/>
    <link href="dist/DataTables-1.10.10/extensions/rowGroup.dataTables.min.css?<?php echo time(); ?>"/>
    <link rel="stylesheet" href="dist/dropify-master/dist/css/dropify.css?<?php echo time();?>"/>
    <link rel="stylesheet" href="dist/sweetalert/sweetalert2.css?<?php echo time ();?>"/>
    <link rel="stylesheet" href="dist/css/dropdown.css?<?php echo time();?>"/>
    <link type="text/css" rel="stylesheet" href="dist/multiple-emails.js-master/multiple-emails.css?<?php echo time();?>"/>
    <link rel="stylesheet" href="dist/alertify.js/css/alertify.css?<?php echo time(); ?>"/>
    <link rel="stylesheet" href="dist/openstreet/css/style.css?<?php echo time();?>"/>
    <link rel="stylesheet" href="dist/bootstrap-select-1.13.9/dist/css/bootstrap-select.css?<?php echo time();?>"/>
  </head>
  <body class="hold-transition sidebar-mini layout-fixed" ng-app="myApp">
    <div class="wrapper">

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-light navbar-white">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
        </ul>
      </nav>
      <aside class="main-sidebar elevation-4 sidebar-light-success">
        <a class="brand-link navbar-white" ui-sref="Home" ui-sref-opts="{reload: true}">
          <span class="brand-text font-weight-light">HOME</span>
        </a>
        <div class="sidebar">
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">MENU PRINCIPAL</li>     
                <li><a  class="nav-header" ui-sref="Empresa" ui-sref-opts="{reload: true}"></i>EMPRESA</a></li>
                  <li><a  class="nav-header" ui-sref="Producto" ui-sref-opts="{reload: true}"></i>PRODUCTOS</a></li>
                  <li><a  class="nav-header" ui-sref="Usuarios" ui-sref-opts="{reload: true}"></i>CONTACTOS</a></li> 
            </ul>
          </nav>
        </div>
      </aside>
      <div class="content-wrapper ">
        <div class="content-header hide">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content" ui-view="">
        </section>
      </div>
      <footer class="main-footer">
        <strong>Copyright &copy; <?PHP echo date('Y');?> <a href="#">DANIEL MONSALVE</a></strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
          <b>Version</b> 0.0.1
        </div>
      </footer>
      <aside class="control-sidebar control-sidebar-dark">
      </aside>
    </div>
    <div id="modallogin" class="modal login fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success">
            
            <h4 class="modal-title" id="titlelogin"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body" id="divlogin">
          </div>    
        </div>
      </div>
    </div>
    <div id="modalregistro" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="titlemodal">Modal title</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body" id="contenidomodal">
            <p>One fine body&hellip;</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" id="btnguardar" class="btn btn-primary">Guardar Cambios</button>
          </div>
        </div>
      </div>
    </div>
    <div id="modalinfo" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success">
            <h4 class="modal-title" id="titleinfo">Modal title</h4> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body" id="contenidomodalinfo">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button data-loading-text="Enviando..." type="button" id="btnenviar" class="btn btn-primary">Hacer Pedido</button>
          </div>
        </div>
      </div>
    </div>
      <div class="modal left fade" id="modalleft" tabindex="-1" role="dialog" aria-labelledby="titleleft">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-success">
              <h4 class="modal-title" id="titleleft"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="contenidomodalleft">
            </div>
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
      </div><!-- modal -->
      
      <!-- Modal -->
      <div class="modal right fade" id="modalright" tabindex="-1" role="dialog" aria-labelledby="titleright">
        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header bg-success">
              
              <h4 class="modal-title" id="titleright"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body" id="contenidomodalright">
              
            </div>

          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
      </div><!-- modal -->

      <div class="modal pedido fade" id="modalpedido" tabindex="-1" role="dialog" aria-labelledby="titlepedido">
        <div class="modal-dialog rotateOutDownLeft animate" role="document">
          <div class="modal-content">

            <div class="modal-header bg-success">
            
              <h4 class="modal-title" id="titlepedido"></h4> 
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body" id="contenidopedido">
              <input type="hidden" name="" id="inismart" value="0">
                <form action="modulos/pedidos/guardarpedido.php" id="formpedido" name="formpedido" method="POST"> 
                  <!-- SmartCart element -->
                  <div id="smartcart" ></div>
                  <div class="panel panel-default sc-cart sc-theme-default" id="divdetallepedido">
                    
                  </div>

              </form>
            </div>

          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
      </div><!-- modal -->

    <div class="modal custom" id="modalcustom" tabindex="-1" role="dialog" aria-labelledby="titlecustom" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-success">
              
                  <h4 class="modal-title" id="titlecustom"></h4> 
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>

                <div class="modal-body" id="contenidomodalcustom">
                <p></p>
                </div>

                <div class="modal-footer">
                    <div class="btnmodal" data-dismiss="modal">Cerrar &#10006;</div>

                </div>
            </div>
        </div>
    </div>
    <a class="btn" href="#" id="back-to-top" title="Back to top">
      <i class="fa fa-chevron-circle-up "></i>
    </a>

    <script src="plugins/jquery/jquery.min.js"></script>

    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrapds.js?<?php echo time();?>"></script>
    <script src="plugins/bootstrap/js/bootstrap3-typeahead.min.js?<?php echo time();?>"></script>
    <script src="plugins/bootstrap/js/validator.js?<?php echo time();?>"></script>
    <script src="plugins/timepicker/bootstrap-timepicker.js?<?php echo time();?>"></script>
    <script src="dist/dropify-master/dist/js/dropify.js?<?php echo time();?>"></script>
    <script  type="text/javascript" src="dist/sweetalert/sweetalert2.js?<?php echo time();?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@7.1.0/dist/promise.min.js"></script>
    <script type="text/javascript" src="dist/DataTables-1.10.10/media/js/jquery.dataTables.js?<?php echo time();?>"></script>
    <script type="text/javascript" src="dist/DataTables-1.10.10/media/js/dataTables.bootstrap.min.js?<?php echo time();?>"></script>
    <script type="text/javascript" src="dist/DataTables-1.10.10/media/js/ColReorderWithResize.js?<?php echo time();?>"></script>
    <script type="text/javascript" src="dist/DataTables-1.10.10/extensions/Responsive/js/dataTables.responsive.js?<?php echo time();?>"></script>
    <script type="text/javascript" src="dist/DataTables-1.10.10/extensions/FixedColumns/js/dataTables.fixedColumns.min.js?<?php echo time();?>"></script>
    <script type="text/javascript" src="dist/DataTables-1.10.10/extensions/FixedHeader/js/dataTables.fixedHeader.min.js?<?php echo time();?>"></script>
    <script src="dist/DataTables-1.10.10/extensions/dataTables.rowGroup.min.js?<?php echo time(); ?>"></script>
    <script type="text/javascript" src="dist/alertify.js/lib/alertify.js?<?php echo time();?>"></script>
    <link rel="stylesheet" href="dist/alertify.js/themes/alertify.core.css?<?php echo time();?>" />
    <link rel="stylesheet" href="dist/alertify.js/css/themes/default.css?<?php echo time();?>" />
    <script src="dist/jquery.formatCurrency-1.4.0/jquery.formatCurrency-1.4.0.min.js?<?php echo time();?>"></script>
    <script src="dist/jquery.formatCurrency-1.4.0/i18n/jquery.formatCurrency.all.js?<?php echo time();?>"></script>
    <script src="dist/Parsley.js-2.8.1/dist/parsley.js?<?php echo time();?>" type="text/javascript" charset="utf-8"></script>
    <link href="dist/Parsley.js-2.8.1/dist/parsley.css?<?php echo time();?>" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="dist/js/autosize.js?<?php echo time();?>"></script>
    <link href="dist/tooltipster-master/css/tooltipster.css?<?php echo time(); ?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="dist/tooltipster-master/css/themes/tooltipster-light.css?<?php echo time(); ?>" />
    <link rel="stylesheet" type="text/css" href="dist/tooltipster-master/css/themes/tooltipster-noir.css?<?php echo time(); ?>" />
    <link rel="stylesheet" type="text/css" href="dist/tooltipster-master/css/themes/tooltipster-punk.css?<?php echo time(); ?>" />
    <link rel="stylesheet" type="text/css" href="dist/tooltipster-master/css/themes/tooltipster-shadow.css?<?php echo time(); ?>" />
    <script src="dist/tooltipster-master/js/jquery.tooltipster.js?<?php echo time();?>"></script>
    <script src="plugins/inputmask/inputmask/inputmask.js?<?php echo time();?>"></script>
    <script type="text/javascript" src="dist/clipboard.js-master/dist/clipboard.js?<?php echo time();?>"></script>
    <script type="text/javascript" src="dist/multiple-emails.js-master/multiple-emails.js?<?php echo time();?>"></script>
    <script src="dist/js/adminlte.js"></script>
    <script src="dist/js/pages/dashboard.js"></script>
    <script src="dist/js/demo.js"></script>
    <script type="text/javascript" src="dist/bootstrap-select-1.13.9/dist/js/bootstrap-select.js?<?php echo time();?>"></script>
    <script src="llamadas.js?<?php echo time();?>" type="text/javascript"></script>
    <script type="text/javascript">

      function busca(){
        var misListas = document.querySelectorAll("p"); 
        var miTexto = document.getElementById("texto3").value; 
          //alert(miTexto)
        var miExpReg = new RegExp(miTexto,"i"); 

        for(s=0; s<misListas.length; s++){
          var miAcierto = misListas[s].textContent.search(miExpReg); 
            //alert( (s+1) +". → "+ miAcierto ); 
          if(miAcierto == -1) misListas[s].className = ""; 
          else misListas[s].className = "verde"; 
        }
      }
    </script>

  </body>
</html>

