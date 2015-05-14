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
            var descontos = null;

            function loadData() {

                $.ajax({
                    type: "GET",
                    url: "http://localhost:49822/api/descontospontos/",
                    dataType: "json",
                    success: function (resp) {

                        //console.log(resp);
                        descontos = resp;
                        $('.loading_icon').hide();
                        resp.forEach(function(desconto) {

                            add_new_row([desconto.pontos, desconto.desconto],false);

                        });
                        $('#data').show();
                    },
                    error: function (e) {
                        alert("Erro ao recolher dados dos descontos por famílias!");
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

                $(tr).find("td button.row-remove").on("click", function() {
                    $(this).closest("tr").remove();
                    var data = getDescontosData();
                    //console.log(data);
                    $.ajax({
                        type: "POST",
                        url: "http://localhost:49822/api/descontospontos/",
                        data: JSON.stringify(data),
                        contentType: 'application/json; charset=utf-8', 
                        processData: false,
                        success: function (resp) {
                            console.log(resp);
                            if (resp == "Sucesso") set_valueMode(button.closest("tr"));
                            button.attr("disabled",false);
                            tr.find('input').attr("disabled",false);


                        },
                        error: function (e) {
                            console.log(e);
                            console.log(e.responseText);

                            alert("Erro ao editar familia");
                            button.attr("disabled",false);
                            tr.find('input').attr("disabled",false);

                        }
                    });                  });

                $(tr).find("td button.row-edit").on("click", function() {
                    set_editMode($(this).closest("tr"));
                });

                $(tr).find("td button.row-save").on("click", function() {
                    var button = $(this);
                    button.attr("disabled",true);


                    var valid = check_input(tr);
                    if (valid){
                        tr.find('input').attr("disabled",true);
                        var data = getDescontosData();
                        //console.log(data);
                        $.ajax({
                            type: "POST",
                            url: "http://localhost:49822/api/descontospontos/",
                            data: JSON.stringify(data),
                            contentType: 'application/json; charset=utf-8', 
                            processData: false,
                            success: function (resp) {
                                console.log(resp);
                                if (resp == "Sucesso") set_valueMode(button.closest("tr"));
                                button.attr("disabled",false);
                                tr.find('input').attr("disabled",false);


                            },
                            error: function (e) {
                                console.log(e);
                                console.log(e.responseText);

                                alert("Erro ao editar Descontos");
                                button.attr("disabled",false);
                                tr.find('input').attr("disabled",false);

                            }
                        });  

                    }
                    else {
                        alert("Por favor introduza valores válidos nos campos antes de gravar");   
                        button.attr("disabled", false);

                    }
                });





            }

            function getDescontosData() {

                var descontos = [];
                var count = 0;
                $('tr:not(.hidden)').each(function() {
                    var visible = $(this).find('input').is(":visible") && (count != 0); 
                    if (count != 0) {
                        var vals = {};
                        if (visible) {
                            var count2 = 0;
                            $(this).find('input').each(function () {
                                if (count2 == 0) vals.pontos = $(this).val();
                                if (count2 == 1) vals.desconto = $(this).val();
                                count2++;
                            })

                        }
                        else {
                            var count2 = 0;
                            $(this).find('div.value').each(function () {
                                if (count2 == 0) vals.pontos = $(this).text();
                                if (count2 == 1) vals.desconto = $(this).text();
                                count2++;
                            })  

                        }

                        descontos.push(vals); 
                    }
                    count++;
                });
                return descontos;
            }


            function check_input(tr) {
                var input = true;

                $.each((tr).find('td input.positive_value'), function() {
                    input = input & isNormalInteger($(this).val());

                });

                $.each((tr).find('td input.less_hundred'), function() {
                    input = input & isNormalInteger($(this).val()) & $(this).val() <= 100;

                });

                $.each((tr).find('td input.req_string'), function() {
                    input = input & ($(this).val() != "");
                });

                return input;
            }

            function isNormalInteger(str) {
                return /^\+?(0|[1-9]\d*)$/.test(str);
            }

            $(document).ready(function () {

                $('#data').attr('hidden',true);
                loadData();

                $("#logout").click(function () {
                    window.location.href = "logout.php";
                });

                $("#add_row").on("click", function() {

                    add_new_row(["",""],true);

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
                <h1>Descontos por Pontos  </h1>
                <div class="row clearfix">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered table-hover" id="tab_logic">
                            <thead>
                                <tr >
                                    <th class="text-center">
                                        Pontos
                                    </th>
                                    <th class="text-center">
                                        Desconto (%)
                                    </th>
                                    <th class="text-center">
                                        Editar
                                    </th>
                                    <th class="text-center">
                                        Apagar
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id='addr0' data-id="0" class="hidden">
                                    <td data-name="cod">
                                        <div class="value text-center"></div>
                                        <input type="text" name='cod'  placeholder='Pontos' class="form-control positive_value" style="display:none" />
                                    </td>
                                    <td data-name="desc">
                                        <div class="value text-center"></div>

                                        <input type="text" name='descri' placeholder='Desconto %' class="form-control positive_value less_hundred" style="display:none"/>
                                    </td>
                                    <td data-name="ed">

                                        <div class="row text-center" >
                                            <p class="edit-button" style="margin-bottom:0"><button  class='btn btn-info btn-sm row-edit'><span class="glyphicon glyphicon-pencil"></span></button></p>
                                            <p class="save-button" style="display:none; margin-bottom:0"><button  class='btn btn-success btn-sm row-save'><span class="glyphicon glyphicon-ok"></span></button></p>

                                        </div>

                                    </td>
                                    <td data-name="del">
                                        <div class="row text-center" >
                                            <p style=" margin-bottom:0"> <button  class='btn btn-danger btn-sm row-remove'><span class="glyphicon glyphicon-trash"></span></button></p>
                                        </div>
                                    </td>


                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <a id="add_row" class="btn btn-default pull-right">Adicionar Desconto Direto</a>    

            </div>
        </div>



    </body>
</html>
