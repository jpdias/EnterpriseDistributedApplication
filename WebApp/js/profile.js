$(document).ready(function () {
    var codCliente = getParameterByName('codCliente');
	
    $("#cartaoClienteH4").hide();
    $("#criarCartaoCliente").hide();
    $("#pontosH4").hide();
	
    $.ajax({
        type: "GET",
        url: "http://localhost:46615/StoreService.svc/api/customer/" + codCliente,
        dataType: "json",
		cache: false,
        success: function (resp) {
            $("#name").append(resp.Name);
            $("#address").append(resp.Address);
			$("#email").append(resp.Email);
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