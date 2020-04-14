var app = angular.module('myApp', [
	'ui.router',
	//'ui.bootstrap',
	'oc.lazyLoad'
	//,
	//'angularFileUpload'
	
])

app.config(['$stateProvider', '$urlRouterProvider', '$ocLazyLoadProvider', 'JS_REQUIRES', function($stateProvider, $urlRouterProvider, $ocLazyLoadProvider, jsRequires){
	
	// LAZY MODULES
    $ocLazyLoadProvider.config({
        debug: false,
        events: true,
        modules: jsRequires.modules
    });
	
	$urlRouterProvider.otherwise("index");
	
    $stateProvider
    
		.state('Ciudades', {
			url: '/Ciudades',
            templateUrl: 'modulos/ciudades/ciudades.php'
        })
        
		.state('Obras', {
			url: '/Obras',
            templateUrl: 'modulos/obras/obras.php',
            controller: function($scope, $stateParams) {
                iniValidar('')
              }
            
        })
        		
		.state('Perfiles', {
			url: '/secure/Perfiles',
			templateUrl: 'modulos/perfiles/perfiles.php'
        })


        .state('Usuarios', {
			url: '/secure/Usuarios',
			templateUrl: 'modulos/usuarios/usuarios.php'
        })

        .state('Home', {
			url: '/secure/Home',
			templateUrl: 'modulos/home/home.php'
        })

        .state('Empresa', {
			url: '/secure/Empresa',
			templateUrl: 'modulos/Empresa/empresa.php'
        })

        .state('Producto', {
			url: '/secure/Producto',
			templateUrl: 'modulos/productos/productos.php'
        })//Producto

        .state('TipoInforme',{
            url: '/TipoInforme',
			templateUrl: 'modulos/tipoinforme/tipoinforme.php'
        })
        		
		.state('cambiocontrasena', {
			url: '/InformacionPerfil',
			templateUrl: 'modulos/cambiarcontrasena/cambiocontrasena.php'
        })
        		
		.state('Festivos', {
			url: '/Festivos',
			templateUrl: 'modulos/festivos/calendario.php'
		})	

        .state('Pqr', {
            url: '/acount/PQR',
            templateUrl: 'modulos/pqr/pqr.php'
        })

		// Generates a resolve object previously configured in constant.JS_REQUIRES (config.constant.js)
        function loadSequence() {
            var _args = arguments;
            return {
                deps: ['$ocLazyLoad', '$q',
                    function ($ocLL, $q) {
                        var promise = $q.when(1);
                        for (var i = 0, len = _args.length; i < len; i++) {
                            promise = promiseThen(_args[i]);
                        }
                        return promise;

                        function promiseThen(_arg) {
                            if (typeof _arg == 'function')
                                return promise.then(_arg);
                            else
                                return promise.then(function () {
                                    var nowLoad = requiredData(_arg);
                                    if (!nowLoad)
                                        return $.error('Route resolve: Bad resource name [' + _arg + ']');
                                    return $ocLL.load(nowLoad);
                                });
                        }

                        function requiredData(name) {
                            if (jsRequires.modules)
                                for (var m in jsRequires.modules)
                                    if (jsRequires.modules[m].name && jsRequires.modules[m].name === name)
                                        return jsRequires.modules[m];
                            return jsRequires.scripts && jsRequires.scripts[name];
                        }
                    }]
            };
        }
}]);

app.constant('JS_REQUIRES', {
    //*** Scripts
    scripts: {
        //*** Javascript Plugins
        /*'multiselect': [
        	'dist/js/prettify.js',
        	'dist/css/bootstrap-multiselect.css',
        	'dist/js/bootstrap-multiselect.js',
        	'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'],*/
        /*'multiselect': ['dist/css/checklist/jquery.multiselect.css',
        'dist/css/checklist/jquery.multiselect.filter.css',
        'dist/css/checklist/styleselect.css',
        'dist/css/checklist/prettify.css',
        'dist/css/checklist/jquery-ui.css',
        'http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js',
        'dist/js/checklist/jquery.multiselect.js',
        'dist/js/checklist/jquery.multiselect.filter.js',
        'dist/js/checklist/prettify.js']*/
    }
});

app.controller('TabsDemoCtrl', function ($scope, $window) {
  $scope.tabs = [
    { title:'Dynamic Title 1', content:'Dynamic content 1' },
    { title:'Dynamic Title 2', content:'Dynamic content 2', disabled: true }
  ];
	$scope.alertSector = function(g) {
	setTimeout(function() {
		CRUDSECTOR('',g,'');
	});
	};
});
/*
 app.controller('AppController', ['$scope', 'FileUploader', function($scope, FileUploader) {
        var uploader = $scope.uploader = new FileUploader({
            url: 'modulos/actividades/upload.php'
        });

        // FILTERS

        uploader.filters.push({
            name: 'customFilter',
            fn: function(item , options) {
                return this.queue.length < 10;
            }
        });

        // CALLBACKS

        uploader.onWhenAddingFileFailed = function(item , filter, options) {
            console.info('onWhenAddingFileFailed', item, filter, options);
			$
        };
        uploader.onAfterAddingFile = function(fileItem) {
            console.info('onAfterAddingFile', fileItem);
			
        };
        uploader.onAfterAddingAll = function(addedFileItems) {
            console.info('onAfterAddingAll', addedFileItems);
			
        };
        uploader.onBeforeUploadItem = function(item) {
            console.info('onBeforeUploadItem', item);
			
        };
        uploader.onProgressItem = function(fileItem, progress) {
            console.info('onProgressItem', fileItem, progress);
			
        };
        uploader.onProgressAll = function(progress) {
            console.info('onProgressAll', progress);
			
        };
        uploader.onSuccessItem = function(fileItem, response, status, headers) {
            console.info('onSuccessItem', fileItem,response, status, headers);
			$('#archivo').replaceWith( $('#archivo').val('').clone( true ) );
        };
        uploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
			
        };
        uploader.onCancelItem = function(fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
			$('file').replaceWith( $('file').val('').clone( true ) );
        };
        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
			$('file').replaceWith( $('file').val('').clone( true ) );
        };
        uploader.onCompleteAll = function() {
            console.info('onCompleteAll');
			$('file').replaceWith( $('file').val('').clone( true ) );
        };

        console.info('uploader', uploader);
    }]);
*/	
	
	
	
	app.controller('ProgressCtrl', function ($scope) {
  
  	$scope.max = 100;

 	 $scope.cargar = function(v) {
    var value = v;// Math.floor(Math.random() * 100 + 1);
    var type;

    if (value < 25) {
      type = 'success';
    } else if (value < 50) {
      type = 'info';
    } else if (value < 75) {
      type = 'warning';
    } else {
      type = 'danger';
    }

    $scope.showWarning = type === 'danger' || type === 'warning';

    $scope.dynamic = value;
    $scope.type = type;
  };
  

});
	
	



