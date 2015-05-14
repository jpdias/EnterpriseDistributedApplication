$(document).ready(function () {

    $("#formNewCostumer").submit(function (event) {
        event.preventDefault();
        
        if($("#inputPassword").val().length < 6)
		{
			alert("Password must contain at least 6 characters!");
		}
		else
		{
			var data = {}
			var Form = this;

			$.each(this.elements, function (i, v) {
				var input = $(v);
				data[input.attr("name")] = input.val();
				delete data["undefined"];
			});

			$.ajax({
				type: "POST",
				url: "http://localhost:49822/",
				data: JSON.stringify(data),
				contentType: "application/json",
				dataType: "json",
				success: function (resp) {
					alert("Successfully registered!");

					window.location.href = "index.php";
				},
				error: function (e) {
					console.log(JSON.stringify(e));
					alert("Error registering!");
				}
			});
		}
    });
});