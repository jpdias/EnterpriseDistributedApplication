var codCliente = getParameterByName("codCliente");
var codFatura = getParameterByName("codFatura");

$(document).ready(function () {
	

	
	$('#fatura_table').dataTable({
		"searching": false,
		"columns": [
			{
				"data": "DescArtigo"
			},
			{
				"data": "Quantidade"
			},
			{
				"data": "PrecoInicial"
			},
			{
				"data": "PrecoFinal"
			},
			{
				"data": "Desconto"
			},
			{
				"data": "Poupanca"
			}
	    ]
	});
	
	
	$.ajax({
		type: "GET",
		url: "http://localhost:49822/api/docvenda/" + codFatura,
		dataType: "json",
		success: function (resp) {
			
			var table = $('#fatura_table').DataTable();
			
			if(resp == null)
				console.log("null");
				//redirecionar pagina erro
			else{
				if(resp.Entidade != codCliente){
					//redirecionar pagina erro
				}
				else{
					//fatura e deste cliente
					console.log(resp);
					$("#total_fatura").text(resp.PrecoFinal.toFixed(2));
					
					for(var i=0; i < resp.LinhasDoc.length; i++){
					
						//resp[i].Data = datasplit[0] + " | " + horassplit[0] + ":" + horassplit[1];
						//resp[i].Poupanca = Math.abs((resp[i].PrecoFinal - resp[i].PrecoInicial).toFixed(2));
						
						//console.log(num);
						//console.log(data);
						resp.LinhasDoc[i].PrecoInicial = (parseFloat(resp.LinhasDoc[i].TotalILiquido) * (1.0 + 23/100.0)).toFixed(2) + "€";
						resp.LinhasDoc[i].PrecoFinal = (parseFloat(resp.LinhasDoc[i].PrecoInicial) * (1.0 - parseFloat(resp.LinhasDoc[i].Desconto)/100.0)).toFixed(2) + "€";
						resp.LinhasDoc[i].Desconto += "%";						
						resp.LinhasDoc[i].Poupanca = parseFloat(resp.LinhasDoc[i].DescontoFidelizacao).toFixed(2) + "€";
						table.row.add(resp.LinhasDoc[i]).draw();
					}
					
					if(resp.PontosUsados > 0){
						$("#desconto_pontos").show();
						$("#pontos_cliente").text(resp.PontosUsados);
						$("#desconto_cliente").text(resp.DescontoFidelizacao.toFixed(2));
					}
						
				}
	
			}
			/*
			for(var i=0; i < resp.length; i++){
				num = resp[i].NumDoc;
				data = resp[i].Data;
				var datasplit = data.split("T");
				var horassplit = datasplit[1].split(":");
				
				resp[i].Data = datasplit[0] + " | " + horassplit[0] + ":" + horassplit[1];
				resp[i].Poupanca = Math.abs((resp[i].PrecoFinal - resp[i].PrecoInicial).toFixed(2));
				
				//console.log(num);
				//console.log(data);
				
				table.row.add(resp[i]).draw();
					
			}
			*/
			
		},
		error: function (e) {
			alert("Erro ao recolher documento de venda do cliente");
		}
	});
});

function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}