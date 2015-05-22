$(document).ready(function () {
	
	var id = getParameterByName("id");
	
	$('#orders_table').dataTable({
		"searching": false
	});
	
	$.ajax({
        type: "GET",
        url: "http://localhost:46615/StoreService.svc/api/orders/" + id,
        dataType: "json",
		cache: false,
        success: function (resp) {
			
			var table = $("#orders_table").DataTable();
			
			for (var key in resp) {
			  if (resp.hasOwnProperty(key)) {
				var currentState;  
				  
				if(resp[key].State.CurrentState == 0)
					currentState = "Waiting expedition";
				else
					if(resp[key].State.CurrentState == 1)
						currentState = "Dispatched";
					else
						if(resp[key].State.CurrentState == 2)
							currentState = "Dispatch will occur";
			  
				table.row.add(
				[resp[key].Book.Title,
				resp[key].Quantity,
				currentState
				]).draw();
			  }
			}
        },
        error: function (e) {
            alert("Error collecting costumer data!");
        }
    });
});

function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}