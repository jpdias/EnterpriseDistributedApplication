$(document).ready(function () {
	
	var codCliente = getParameterByName("codCliente");
	
	$('#orders_table').dataTable({
		"searching": false
	});
	
	$.ajax({
        type: "GET",
        url: "http://localhost:46615/StoreService.svc/api/orders/" + codCliente,
        dataType: "json",
		cache: false,
        success: function (resp) {
			
			var table = $("#orders_table").DataTable();
			
			for (var key in resp) {
			  if (resp.hasOwnProperty(key)) {
				table.row.add([resp[key].Book.Title, resp[key].Quantity, resp[key].State.CurrentState]).draw();
			  }
			}
        },
        error: function (e) {
            alert("Error collecting user data!");
        }
    });
});

function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}