


var latitud = $('#latitud');
var longitud = $('#longitud');
var geocoder = new google.maps.Geocoder;

const provider = new L.GeoSearch.Provider.Google();
/*
const searchControl = new window.GeoSearch.GeoSearchControl({
  provider: provider,
  style: 'bar',
  retainZoomLevel: true,
  autoComplete: true,
  autoClose:true,
  searchLabel: 'Ingresa tu dirección',
  keepResult: true,
  showMarker: false,
  animateZoom: true,
  useMapBounds:12,
  countries:['COL','CO']

})

const provider = new GoogleProvider({ params: {
  key: 'AIzaSyCLQTtkGTPtDiq1fAEa7A6HEKj4B_sTekM',
} });*/

var map = L.map('map');
var cityBounds = new google.maps.LatLngBounds(
  new google.maps.LatLng(6.217, -75.567),//limites geograficos de medellin
  //new google.maps.LatLng(25.450715, 68.428345)
  );


 const searchControl  = new L.Control.GeoSearch({
        provider: provider,//  new L.GeoSearch.Provider.OpenStreetMap({ params: { countrycodes: 'COL' }, }),
        style: 'bar',
        retainZoomLevel: true,
        autoComplete: true,
        autoClose:true,
        searchLabel: 'Ingresa tu dirección',
        popupFormat: ({ query, result }) => result.label, 
        keepResult: true,
        showMarker: false,
        animateZoom: true,
        useMapBounds:12,
        strictbounds: true,
        bounds: cityBounds,

        countries:['COL','CO']
    });//.addTo(map);

map.addControl(searchControl);
/*
 var searchControl = L.esri.Geocoding.geosearch().addTo(map);

 var results = L.layerGroup().addTo(map);

  searchControl.on('results', function(data){
    results.clearLayers();
    for (var i = data.results.length - 1; i >= 0; i--) {
      results.addLayer(L.marker(data.results[i].latlng));
    }
  });
*/
/*const searchControl2 = new GeoSearchControl({
  provider: provider,                               // required
  showMarker: true,                                   // optional: true|false  - default true
  showPopup: false,                                   // optional: true|false  - default false
  marker: {                                           // optional: L.Marker    - default L.Icon.Default
    icon: new L.Icon.Default(),
    draggable: false,
  },
  popupFormat: ({ query, result }) => result.label,   // optional: function    - default returns result label
  maxMarkers: 1,                                      // optional: number      - default 1
  retainZoomLevel: false,                             // optional: true|false  - default false
  animateZoom: true,                                  // optional: true|false  - default true
  autoClose: false,                                   // optional: true|false  - default false
  searchLabel: 'Enter address',                       // optional: string      - default 'Enter address'
  keepResult: false                                   // optional: true|false  - default false
});*/

//map.addControl(searchControl);
// Add OSM layer
var OpenStreetMap_Mapnik = L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="#"></a>'
});
OpenStreetMap_Mapnik.addTo(map);

/*
var geoSearchController = new L.Control.GeoSearch({
    provider:provider
}).addTo(map);*/

$('#leaflet-control-geosearch-qry').appendTo('#divtrasladar');
$('#leaflet-control-geosearch-qry').addClass('form-control');
if($('#geoubicacioncorta').val()!="")
{
  $('#leaflet-control-geosearch-qry').val($('#geoubicacioncorta').val());
}
//$('.glass').addClass('form-control')

 var geocodeService = L.esri.Geocoding.geocodeService();


  var placeSearch, autocomplete;
  var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
  };

  
  //function initAutocomplete() {

  // Crear el objeto autocompletado, restringiendo la búsqueda a geográfico
  // tipos de ubicación.
  autocomplete = new google.maps.places.Autocomplete(
    /** @type {!HTMLInputElement} */(document.getElementById('leaflet-control-geosearch-qry')),
    {
      bounds: cityBounds,
      types: ['geocode'],
      strictbounds: true,
      componentRestrictions: {country: 'co'}
    });

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  //autocomplete.addListener('place_changed', fillInAddress);
  //}

  function fillInAddress() 
  {
        // Obtener los detalles del lugar del objeto autocompletar.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        
        // Obtener cada componente de la dirección de los detalles del lugar
        // y rellene el campo correspondiente en el formulario.

        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
  }
/*
//Check if the lat and lng parameters are set:
var params = location.search.substring(1);
if( params.length > 0 && params.indexOf("lat") > -1 ){
  marker_from_url(params);
} else {
  center_map_on_location();
}

var loadedLocation = false;
function center_map_on_location(){
  //Hack for Geolocation in Firefox
  // https://github.com/Leaflet/Leaflet/issues/1070
  var isFirefox = typeof InstallTrigger !== 'undefined';

  if( isFirefox ){
    navigator.geolocation.getCurrentPosition(firefox_success, firefox_error);
    setTimeout(function(){
      if( !loadedLocation ){
        //use_geoip_plugin();
      }
    }, 3000);
  } else {
    // Center on current location
    console.log("Set ubicacion")
    map.locate({setView: true});

    //If we can't find our current location, try the plugin:
    map.on('locationerror', function(){
      //use_geoip_plugin();
    });
  }
}

function firefox_success(position){
  loadedLocation = true;
  document.getElementById("latitud").value = position.coords.latitude;
  document.getElementById("longitud").value = position.coords.longitude;
  map.setView(
    [position.coords.latitude, position.coords.longitude],
    15
  );
}

function firefox_error(error){
  use_geoip_plugin();
}

function use_geoip_plugin(){
  console.log("Location not found, trying GeoIP");
  //L.GeoIP.centerMapOnPosition(map, 15);
}*/
// Add/remove marker on click
marker = L.marker([0,0], {draggable: true});
$(".glass").on("click", function(e){
  e.stopPropagation();
});

$("#leaflet-control-geosearch-qry").on("click", function(e){
  e.stopPropagation();
});


$(".reset").on("click", function(e){
e.stopPropagation();
});

map.on('click', function(e){
  console.info("Coordenada 3");

  marker.setLatLng(e.latlng).addTo(map);
  map_sharing_link(e.latlng,1);
  //var html = map_sharing_link(e.latlng);
  //marker.bindPopup(html).openPopup();
});

marker.on("mouseup", function(e) {
   var marker = e.target;
   var position = marker.getLatLng();
    map.panTo(new L.LatLng(position.lat, position.lng));
    $('.leaflet-marker-icon').attr('src','dist/openstreet/js/images/marker-icon-green.png')

   map_sharing_link(marker.getLatLng(),1);
});

marker.on('mousedown',function(e){
   $('.leaflet-marker-icon').attr('src','dist/openstreet/js/images/marker-icon-green2.png')
})

function map_sharing_link(latlng,op){
  console.info("Coordenada 1");
  var re = /LatLng\((-?[0-9\.]+),\s(-?[0-9\.]+)\)/;
  var coords = re.exec(latlng);
  var lat = coords[1];
  var long = coords[2];
  document.getElementById("latitud").value = lat;
  document.getElementById("longitud").value = long;
  var page_url =  window.location.protocol + "//" + window.location.host + window.location.pathname;
  var link = page_url + "?lat=" + lat + "&lng=" + long;

  /*geocodeService.reverse().latlng(latlng).run(function(error, result) {

    $('#geoubicacion').val(result.address.Match_addr);
    //marker.bindPopup(result.address.Match_addr).openPopup();
    $('.glass').val(result.address.Match_addr);

   });*/

  var latlng = {lat: parseFloat(lat), lng: parseFloat(long)};
  geocoder.geocode({'location': latlng}, function(results, status) 
  {
    if (status === 'OK') 
    {
      if (results[1]) 
      {
        /*map.setZoom(11);
        var marker = new google.maps.Marker({
          position: latlng,
          map: map
        });*/
        var ciudad = "";
        var barrio = "";
        var sector = "";
        var pais = "";
        var corta = "";
        var larga = "";
        var ciudades = [];
        var paises = [];
        var barrios = [];

        for (var i = 0; i < results.length; i++) 
        {
          console.log(results[i].address_components[0].short_name);
            if (results[i].types[0] === "locality") 
            {
              ciudades.push(results[i].address_components[0].short_name);
              paises.push(results[i].address_components[2].short_name);

              ciudad = results[i].address_components[0].short_name;
              pais = results[i].address_components[2].short_name;
              //$("input[name='location']").val(city + ", " + state);
            }
            else if(results[i].types[0]=="political" || results[i].types[0]=="neighborhood")
            {
              barrio = results[i].address_components[0].short_name;
              barrios.push(results[i].address_components[0].short_name);
            }
        }
        console.log(results[0].formatted_address);//direccion completa
       
        /*for (var ac = 0; ac < results[0].address_components.length; ac++) 
        {
          var component = results[0].address_components[ac];
          console.log(component.long_name);

          switch(component.types[0]) {
              case 'locality':
                  ciudad = component.long_name;
                  //break; 
              case 'sublocality':
                barrio = component.long_name;
                //break;            
              case 'political':
              //case 'neighborhood ':
                  barrio = component.long_name;
                  break;
              case 'country':
                  pais = component.long_name;
                  //break;
          }
        }*/

        //$('#leaflet-control-geosearch-qry').val(results[0].formatted_address);
        if(($('#leaflet-control-geosearch-qry').val()=="" || $('#leaflet-control-geosearch-qry').val()==null || $('#leaflet-control-geosearch').val()==undefined))
        {
           $('#leaflet-control-geosearch-qry').val(results[0].formatted_address);
        }
        else if($('#leaflet-control-geosearch-qry').val()!="")
        {
          $('#leaflet-control-geosearch-qry').val(results[0].formatted_address);
        }


        $('#geoubicacion').val(results[0].formatted_address);
        //$('#geoubicacioncorta').val('');
        console.log("Ciudad:" + ciudad);
        console.log("Barrio:" + barrio);
        console.log("Sector:" + sector);

        console.log("Ciudades:" + ciudades);
        console.log("Barrios:" + barrios);

        console.log("Sector:" + sector);
        setTimeout(function(){
          selectDatosDireccion(ciudad,barrio,sector,ciudades,barrios);
        },1000);

        //infowindow.setContent(results[0].formatted_address);
        //infowindow.open(map, marker);
      } 
      else 
      {
        error('No se encontraron resultados');
      }
    } 
    else 
    {
      error('Geocodificador falló debido a: ' + status);
    }
  });



  /* L.esri.Geocoding.reverseGeocode()
  .latlng([lat,  long])
  .run(function(error, result, response){
      // callback is called with error, result, and raw response.
      // result.latlng contains the coordinates of the located address
      // result.address contains information about the match
      $('#leaflet-control-geosearch-qry').val(result.address.Match_addr);
      $('#geoubicacion').val(result.address.Match_addr);
      $('#geoubicacioncorta').val(result.address.ShortLabel);
      console.log("Ciudad:" + result.address.City);
      console.log("Barrio:" + result.address.Neighborhood);
      console.log("Sector:" + result.address.District);
      setTimeout(function(){
        selectDatosDireccion(result.address.City,result.address.Neighborhood,result.address.District);
      },1000)

  });*/


  

  //var html = "<a href='#'>Esta Es tu posicion actual</a>";
  //return html;
  $('.onload').hide('slow');
  if(op==2)
  {
    map.setView([lat, long],17);
  }
}

function geocodeLatLng(geocoder, map, infowindow) {
  var input = document.getElementById('latlng').value;
  var latlngStr = input.split(',', 2);
  var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
  geocoder.geocode({'location': latlng}, function(results, status) 
  {
    if (status === 'OK') {
      if (results[0]) {
        map.setZoom(11);
        var marker = new google.maps.Marker({
          position: latlng,
          map: map
        });
        infowindow.setContent(results[0].formatted_address);
        infowindow.open(map, marker);
      } else {
        window.alert('No results found');
      }
    } else {
      window.alert('Geocoder failed due to: ' + status);
    }
  });
}

function marker_from_url(params){
   console.info("Coordenada 2");
  var myIcon = L.icon({
    iconUrl: './js/images/marker-icon-green.png',
    iconRetinaUrl: './js/images/marker-icon-2x-green.png',
    iconSize: [25, 41],
    iconAnchor: [25, 41],
    popupAnchor: [-3, -76],
    shadowUrl: './js/images/marker-shadow.png',
  });
  lat = /lat=(-?[0-9\.]+)/.exec(params)[1];
  long = /lng=(-?[0-9\.]+)/.exec(params)[1];
  document.getElementById("latitud").value = lat;
  document.getElementById("longitud").value = long;  

  map.setView([lat,long], 15);
  marker = L.marker([lat, long], {icon: myIcon}).addTo(map);
}

marker.on('click', function(){
  map.removeLayer(marker);
});


// Add me to map
var fernando = L.icon({
  iconUrl: './js/images/fernando.png',
  iconRetinaUrl: './js/images/marker-icon-2x-green.png',
  iconSize: [22, 32],
  iconAnchor: [22, 32],
  popupAnchor: [-16, -38],
  shadowUrl: './js/images/marker-shadow.png',
});
var options =  {icon: fernando, title: "Fernando"};

//var me = L.marker([-34.90209, -56.17731], options).addTo(map);
//me.bindPopup("Tomando una Stout");


    function onAccuratePositionError (e) {
      addStatus(e.message, 'error');
    }

    function onAccuratePositionProgress (e) {
      var message = 'Progressing … (Accuracy: ' + e.accuracy + ')';
      addStatus(message, 'progressing');
    }

    function onAccuratePositionFound (e) {
      var message = 'Most accurate position found (Accuracy: ' + e.accuracy + ')';
      addStatus(message, 'done');
      console.log(e.latlng);
      marker.setLatLng(e.latlng).addTo(map);
      map_sharing_link(e.latlng,2);
      //marker.bindPopup(html).openPopup();
      //map.setView(e.latlng, 12);
      //var me = L.marker(e.latlng, options).addTo(map);
      //me.bindPopup("Tomando una Stout");
      //L.marker(e.latlng).addTo(map);
    }

    function addStatus (message, className) {
      //var ul = document.getElementById('status'),
      //  li = document.createElement('li');
      //li.appendChild(document.createTextNode(message));
      //ul.className = className;
     /// ul.appendChild(li);
      console.log(message);
    }
    if(latitud.val()!="" && longitud.val()!="")
    {
      $('.onload').show('slow');
      var newLatLng = new L.LatLng(latitud.val(), longitud.val());
      marker.setLatLng(newLatLng).addTo(map);
      map_sharing_link(newLatLng,2);
        
    }
    else
    {

      $('.onload').show('slow');
      map.on('accuratepositionprogress', onAccuratePositionProgress);
      map.on('accuratepositionfound', onAccuratePositionFound);
      map.on('accuratepositionerror', onAccuratePositionError);
    }

    map.findAccuratePosition({
      maxWait: 10000,
      desiredAccuracy: 20
    });