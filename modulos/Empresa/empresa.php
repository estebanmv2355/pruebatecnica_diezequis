

<style type="text/css">

  p {
    list-style-position: inside; 
    padding-left: .4em; 
    font-weight: bold; 
  }
  p.verde {
    background: 
      linear-gradient(315deg, white, white .42em, transparent .43em, transparent 100%), 
      linear-gradient(225deg, white, white .42em, lime .43em, lime 100%); 

    background-repeat: no-repeat; 
  }
  #texto3:required:invalid + input {
    pointer-events: none; 
    opacity: .3; 
    /*cursor: not-allowed; */
  }
</style>

<div class="row">
  <div class="col-md-6">
    <p> Existencia. ¿Por qué surgen las empresas? ¿Por qué no todas las transacciones de la economía están mediadas por el mercado? </p>
    <p> Límites ¿Por qué el límite entre las empresas y el mercado se sitúa exactamente allí en relación con el tamaño y la variedad de la producción? ¿Qué transacciones se realizan internamente y cuáles se negocian en el mercado?  </p>
    <p> TOrganización. ¿Por qué las empresas están estructuradas de una manera específica, por ejemplo en lo que respecta a la jerarquía o descentralización? ¿Cuál es la interacción de las relaciones formales e informales? </p>
    <p> Heterogeneidad de las acciones/actuaciones de la empresa. ¿Qué impulsa las diferentes acciones y actuaciones de las empresas?</p>
    <p> Evidencia. ¿Qué pruebas existen para las respectivas teorías de la empresa?  </p>
  </div>
  <div class="col-md-6">
  <div class="row">
    <div class="col-md-6">
        <input type="text" class="form-control input-sm" id="texto3" name="texto3" >
    </div>
    <div class="col-md-6">
        <a role="button" class="btn btn-secondary" id="btnnuevaentrevista"onclick="busca()"  style="display: inline-block;" id="texto3" name="texto3">BUSCAR</a>
    </div>
  </div>
  </div>
</div>




    

    
