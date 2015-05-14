$(document).ready(function () {
	
	var codCliente = getParameterByName("codCliente");
	
	$('#historico_table').dataTable({
		"searching": false
	});
	
	$.ajax({
        type: "GET",
        url: "http://localhost:46615/StoreService.svc/api/books",
        dataType: "json",
		cache: false,
        success: function (resp) {
			
			var table = $("#historico_table").DataTable();
			
			for (var key in resp) {
			  if (resp.hasOwnProperty(key)) {
				table.row.add([resp[key].Title, resp[key].Editor, resp[key].Price, resp[key].Stock]).draw();
			  }
			}
        },
        error: function (e) {
            alert("Erro ao recolher dados!");
        }
    });
});

function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}