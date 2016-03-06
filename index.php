<?php
include('navbar.html');
require_once('requisicao.php');

// GET DRS //
  $jsonCalDRS = getValor('queryValorDRS');
  $itensCalDRS = $jsonCalDRS->results->bindings;
  
  foreach ($itensCalDRS as $d) {
    $drs[] = $d->drs->value;
    $valor[] = $d->valorcal->value;
  }

// GET DRS //
  $jsonCurados = getValor('queryTopCuradosPlace');
  $itensCurados = $jsonCurados->results->bindings;
  
  foreach ($itensCurados as $i) {
    $place[] = $i->place->value;
    $qtdcurados[] = $i->qtdcurados->value;
  }


?>

<html>
<body>
 	<div class="container">
   		<div class="row"><br>
			  <div class="col-md-12">
				<div class="panel-group">
				  <div class="panel panel-primary">
				  	<div class="panel-heading"><i class="fa fa-info-circle"></i> SOBRE O PROJETO</div>
				    <div class="panel-body">
				    <p>Este projeto busca melhorar o Ambiente de Negócios por Meio da Transparência no Estado de São Paulo. O projeto é uma parceria entre a Embaixada Britânica no Brasil, o Governo do Estado de São Paulo, por meio da Unidade de Inovação em Governo (iGovSP) da Subsecretaria de Parcerias e Inovação da Secretaria de Governo, e o Comitê Gestor da Internet (CGI.br) / Núcleo de Informação e Coordenação do Ponto BR (NIC.br), por meio o Ceweb.br (Centro de Estudos sobre Tecnologias Web) como agente implementador. Ele busca reforçar a política de uso de dados abertos, baseando-se na experiência do Reino Unido.</p> 
					<h4> Objetivos </h4>	
					<p>Os objetivos são: o Governo do Estado de São Paulo aumentar em pelo menos 70% o número de bases de dados em formato aberto, plenamente acessíveis e disponibilizadas em linguagem compreensível para qualquer cidadão; e ter um mínimo de 3% das bases abertas com dados estruturados em conformidade com os preceitos da Web Semântica, no site <a href="http://www.governoaberto.sp.gov.br/" target="_blank">Governo Aberto SP</a>.
					</p> 
					<h4> Ontologia </h4>
					<p>Foi criada uma Ontologia que descreve os conceitos relacionados à descrição de dados e indicadores da área de Saúde.
						Na versão atual da ontologia foi contemplado o indicador que diz respeito à proporção do número de casos de pacientes curados até 31 de dezembro do ano de avaliação em relação ao número de casos diagnosticados de determinada doença identificada a partir do código CID10. Os indicadores são avaliados anualmente de acordo com espaço geográfico municipal do estado de São Paulo, dando a possibilidade de recuperação dos dados por Departamento Regional de Saúde (DRS) e Redes Regionais de Atenção à Saúde (RRAS), abrangendo informações demográficas municipais. 
					</p>
					 <img id='ontologia' src='img/ontologia.jpg'/><br>
					<a class="btn btn-default" id="visualizar"><i class="fa fa-search"></i> Visualizar Ontologia </a>
					<a class="btn btn-default" id="fechar"><i class="fa fa-search"></i> Fechar Ontologia </a>
					
					</div>
				  </div>
				</div>
		
			  </div>
			<div class="col-md-8">
				<div class="panel-group">
				  <div class="panel panel-default" style="height: 460px;">
				  	<div class="panel-heading"><center><p style="text-transform: uppercase;margin-bottom: 0;font-weight: bold;color: #31708F;">% Média de Curados por DRS</p></center></div>
					 <div class="panel-body">
						<div class="box-chart">
						  <canvas id="GraficoBarra" style="width:50%;"></canvas>
						  <div id="legendDiv"></div>
						</div>
					</div>
				  </div>
				</div>
			</div>

			<div class='col-md-4'>
			<div class="panel-group">
			  <div class="panel panel-default">
			  	<div class="panel-heading"><center><p style="text-transform: uppercase;margin-bottom: 0;font-weight: bold;color: #31708F;">Top 10 Cidades</p></center></div>
			  	<div class="panel-body">
			  		<p>Ranking das 10 cidades com maior número de pessoas curadas</p>
	  				<?php	  			
	  					$cont = 1;
	  					for($i=0; $i<count($place); $i++) {	
	  						echo "<p><strong>". $cont . "º</strong> - ". "<a href='place.php?name=".$place[$i]."'>". $place[$i] . "</a> com ".$qtdcurados[$i] ." pessoas curadas</p>";
	  						$cont++;	  									  						
	  					}	  					 		  							  					
	  				?>

			  	</div>
			  </div>
			</div>
		</div>

					
		</div>
	<div>
		<style >
ul {
    list-style: none;
}
ul li {
    display: block;
    padding-left: 30px;
    position: relative;
    margin-bottom: 4px;
    border-radius: 5px;
    padding: 2px 8px 2px 28px;
    font-size: 14px;
    cursor: default;
    -webkit-transition: background-color 200ms ease-in-out;
    -moz-transition: background-color 200ms ease-in-out;
    -o-transition: background-color 200ms ease-in-out;
    transition: background-color 200ms ease-in-out;
}
li span {
    display: block;
    position: absolute;
    left: 0;
    top: 0;
    width: 20px;
    height: 100%;
    border-radius: 5px;
}

</style>

	  <script type="text/javascript">
		  	var options = {
   				responsive:true,
   				
		    };
		    var data = {
		    labels: [
				<?php 
		        	foreach($drs as $d){
		        		echo "'" . $d . "',";
		        	}
		        ?>
		        ],
		    datasets: [
		        {
		            label: "Porcentagem Curados x DRS",
		            fillColor: "rgba(117,157,193,1)",
            	 	strokeColor: "rgba(117,157,193,1)",
           			highlightFill: "rgba(117,157,193,0.8)",
          			highlightStroke: "rgba(117,157,193,0.8)",
		            data: [
		            <?php 
		            	foreach($valor as $v){
		            		echo $v . ",";
		            	}
		            ?>
		          ]
		        }
		    ]
		};  

		 var ctx = document.getElementById("GraficoBarra").getContext("2d");
  		 var BarChart = new Chart(ctx).Bar(data, options);
		
		  </script>
</body>

</html>