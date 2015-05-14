$(document).ready(function () {
    $("#signin").click(function () {
        window.location.href = "signin.php";
    })

    $("#register").click(function () {
        window.location.href = "register.php";
    })
    

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
});