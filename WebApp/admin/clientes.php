<?php
include "check_login.php";
?>
<!DOCTYPE html>
<html >

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../images/favicon.ico">
        <title>Keep'em</title>

        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="../css/style.css" type="text/css">

        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.js"></script>
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables.bootstrap.js"></script>
        <script>
            var familias = null;
            var current_clients = 0;

            function loadData() {

                $.ajax({
                    type: "GET",
                    url: "http://localhost:49822/api/clientes/",
                    dataType: "json",
                    success: function (resp) {
                        total_clients = 0;
                        resp.forEach(function (client) {
                            if (client.CDU_Email != "" && client.CDU_idCartaoCliente) total_clients++;
                        });
                        if (total_clients != 0)
                            resp.forEach(function (client) {
                                if (client.CDU_Email != "" && client.CDU_idCartaoCliente)
                                    $.ajax({
                                        type: "GET",
                                        url: "http://localhost:49822/api/clientes/" +  client.CodCliente ,
                                        dataType: "json",
                                        success: function (resp) {

                                            console.log(resp);
                                            add_new_row([resp.CodCliente,resp.CDU_idCartaoCliente, resp.NomeCliente,  resp.CDU_Email,resp.Pontos, resp.CDU_Subscribed],false);
                                            current_clients++;
                                            if (total_clients == current_clients) {
                                                $('.loading_icon').hide();
                                                $('#data').show();
                                            }

                                        },
                                        error: function (e) {
                                            alert("Erro ao recolher dados do cliente!");
                                        }
                                    });  
                            });

                    },
                    error: function (e) {
                        alert("Erro ao recolher dados dos clientes!");
                    }
                });  



            }

            add_new_row = function(vals,editMode) {

                // Dynamic Rows Code

                // Get max row id and set new id
                var newid = 0;
                $.each($("#tab_logic tr"), function() {
                    if (parseInt($(this).data("id")) > newid) {
                        newid = parseInt($(this).data("id"));
                    }
                });
                newid++;

                var tr = $("<tr></tr>", {
                    id: "addr"+newid,
                    "data-id": newid
                });

                // loop through each td and create new elements with name of newid
                var count_vals = 0;
                $.each($("#tab_logic tbody tr:nth(0) td"), function() {
                    var cur_td = $(this);

                    var children = cur_td.children();

                    // add new td and element if it has a name
                    if ($(this).data("name") != undefined) {
                        var td = $("<td></td>", {
                            "data-name": $(cur_td).data("name")
                        });

                        var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
                        var c1 = $(cur_td).find($(children[1]).prop('tagName')).clone().val("");

                        c.attr("name", $(cur_td).data("name") + newid);
                        c1.attr("name", $(cur_td).data("name") + newid);
                        c.appendTo($(td));

                        $(c).text(vals[count_vals]);
                        c1.appendTo($(td));
                        td.appendTo($(tr));

                    } else {
                        var td = $("<td></td>", {
                            'text': $('#tab_logic tr').length
                        }).appendTo($(tr));
                    }
                    count_vals++;
                });

                // add the new row
                $(tr).appendTo($('#tab_logic'));
                if (editMode) set_editMode(tr);

            }


            $(document).ready(function () {

                $('#data').attr('hidden',true);
                loadData();

                $("#logout").click(function () {
                    window.location.href = "logout.php";
                });

                $("#add_row").on("click", function() {

                    add_new_row(["","",""],true);

                });





            });

            function set_editMode(tr) {

                $(tr).find("td div.value").hide();
                $.each((tr).find("td input"), function () {
                    $(this).val($(this).siblings().first().text());
                });

                $(tr).find(".edit-button").hide();

                $(tr).find("button.row-remove").attr("disabled",true);
                $(tr).siblings("tr").find("button").attr("disabled",true);
                $("#add_row").attr("disabled",true);

                $(tr).find(".save-button").show();

                $(tr).find("td input").show();


            }

            function set_valueMode(tr) {

                $(tr).find("td div.value").show();

                $.each((tr).find("td div.value"), function () {
                    $(this).text($(this).siblings().first().val());
                });

                $(tr).find(".edit-button").show();

                $(tr).find("button.row-remove").attr("disabled",false);
                $(tr).siblings("tr").find("button").attr("disabled",false);
                $("#add_row").attr("disabled",false);

                $(tr).find(".save-button").hide();

                $(tr).find("td input").hide();


            }

        </script>
    </head>
    <body>
        <?php include_once "nav.php"?>

        <p></p>
        <div class="container">
            <div class="row loading_icon">
                <div class="col-xs-1 col-centered ">
                    <span class="glyphicon glyphicon-repeat glyphicon-repeat-animate"></span> 
                </div>
            </div>
            <div id="data">
                <h1>Clientes Fidelizados </h1>

                <div class="row clearfix">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered table-hover" id="tab_logic">
                            <thead>
                                <tr >
                                    <th class="text-center">
                                        Código Cliente
                                    </th>
                                    <th class="text-center">
                                        ID Cartão
                                    </th>
                                    <th class="text-center">
                                        Nome
                                    </th>
                                    <th class="text-center">
                                        Email
                                    </th>
                                    <th class="text-center">
                                        Pontos
                                    </th>

                                    <th class="text-center">
                                        Subscribed
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr id='addr0' data-id="0" class="hidden">
                                    <td data-name="cod">
                                        <div class="value text-center"></div>
                                    </td>
                                    <td data-name="id">
                                        <div class="value text-center"></div>

                                    </td>
                                    <td data-name="nome">
                                        <div class="value text-center"></div>

                                    </td>
                                    <td data-name="email">
                                        <div class="value text-center"></div>

                                    </td>
                                    <td data-name="pontos">
                                        <div class="value text-center"></div>

                                    </td>
                                    <td data-name="Subscribed">
                                        <div class="value text-center"></div>

                                    </td>


                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <a id="add_row" class="btn btn-default pull-right">Adicionar Família</a> -->

            </div>
        </div>



    </body>
</html>
