$(document).ready(function () {
    
	var id = getParameterByName("id");
	
    $.ajax({
        type: "GET",
        url: "http://localhost:46615/StoreService.svc/api/customer/" + id,
        dataType: "json",
		cache: false,
        success: function (resp) {
            $("#name").append(resp.Name);
            $("#address").append(resp.Address);
			$("#email").append(resp.Email);
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