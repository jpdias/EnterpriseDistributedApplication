<?php
include "check_login.php";
$default_from_email = "newsletter@keepem.pt";
$default_subject_email = "Informações sobre novas oportunidades para clientes fidelizados";
?><!DOCTYPE html>
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
            var default_subject = "<?php echo $default_subject_email ?>";
            var default_from = "<?php echo $default_from_email ?>";
            var familias = null;
            var descontosPontos = null;
            var count = 0;
            function loadDefaultValues() {


                $('#subject').val(default_subject);
                $('#from').val(default_from);
                var content = getEmailContent();
                $('#content').val(content.text);
                $('#content').attr('rows', content.lines);
                $('.loading_icon').hide();

                $('form').show();
            }


            function loadPromotionData() {

                $.ajax({
                    type: "GET",
                    url: "http://localhost:49822/api/descontosdiretos/",
                    dataType: "json",
                    success: function (resp) {

                        console.log("Ddiretos: " + resp);
                        familias = resp;
                        $.ajax({
                            type: "GET",
                            url: "http://localhost:49822/api/descontospontos/",
                            dataType: "json",
                            success: function (resp) {

                                console.log("Dpontos: " + resp);
                                descontosPontos = resp;
                                if ($("#checkbox1").is(":checked"))
                                    loadDefaultValues();



                            },
                            error: function (e) {
                                alert("Erro ao recolher dados dos pontos!");
                            }
                        });

                    },
                    error: function (e) {
                        alert("Erro ao recolher dados dos descontos por famílias!");
                    }
                });







            }

            function getEmailContent() {
                var email = []
                var linecounter = 8;

                email.push("Aproveite todas a promoções exclusivas a clientes fidelizados!");
                email.push("Este mês, todos os artigos da categorias seguintes têm desconto direto em cartão:");
                email.push("");
                if (familias == null || descontosPontos == null) return {text: "", lines: 0};

                if (familias.lenght == 0)  {
                    linecounter++;
                    email.push("Nenhuma categoria em desconto"); 
                }
                else {
                    familias.forEach(function (familia) {
                        linecounter++;
                        email.push(familia.DescriFamilia + " - " + familia.DescFamilia + " %" );
                    });
                }
                email.push("");

                email.push("Use também os seu pontos para obter descontos no valor total duma compra. Neste momento tem <CAMPOPONTOS>");
                email.push("");
                if (descontosPontos.lenght == 0)  {
                    linecounter++;
                    email.push("Nenhum desconto em pontos disponível"); 
                }
                else {
                    descontosPontos.forEach(function (pontos) {
                        linecounter++;
                        console.log(pontos);
                        email.push(pontos.pontos + " pontos - " + pontos.desconto + " %" );
                    });
                }
                email.push(""); 
                email.push("Venha visitar-nos e aproveite!"); 





                return {text: email.join('\n'), lines: linecounter};
            }


            function updateProgressBar(current,total) {
                $('.progress-bar').attr('aria-valuemax',total)
                .attr('aria-valuenow',current).css('width', (100 * current/total) + "%").text(current + "/" + total);


            }
            $(document).ready(function () {
                var emails_sent = 0;
                var total_emails;
                $('form').attr('hidden',true);
                $('.progress').hide();
                $('.success').hide();
                $('.success').click(function() {
                    $(this).hide(600);
                });
                $('#checkbox1').change(function() {

                    var ischecked = $(this).is(":checked");
                    $(".email_field").attr("disabled", ischecked);

                    if (ischecked) {
                        loadDefaultValues();
                    }

                });

                $('#checkbox1').attr("checked", true);
                loadPromotionData();

                $('.confirm-send').click(function() {
                    $('.open-confirm').attr("disabled", "disabled");
                    $('.open-confirm').hide();
                    $('.progress').show();
                    var content = $('#content').val();
                    var from = $('#from').val();
                    var subject = $('#subject').val();

                    if (content.indexOf("<CAMPOPONTOS>") == -1) {
                        alert("O email deve conter o <CAMPOPONTOS> para ser preenchido com os pontos de cada cliente");  
                        $('.submit').attr("disabled", false);  
                        return false; 
                    }
                    else {

                        $.ajax({
                            type: "GET",
                            url: "http://localhost:49822/api/clientes/",
                            dataType: "json",
                            success: function (resp) {
                                total_emails = 0;
                                resp.forEach(function (client) {
                                    if (client.CDU_Email != "" && client.CDU_idCartaoCliente && client.CDU_Subscribed) total_emails++;
                                });
                                updateProgressBar(emails_sent, total_emails);
                                if (total_emails != 0)
                                    resp.forEach(function (client) {
                                        if (client.CDU_Email != "" && client.CDU_idCartaoCliente && client.CDU_Subscribed)
                                            $.ajax({
                                                type: "GET",
                                                url: "http://localhost:49822/api/clientes/" +  client.CodCliente ,
                                                dataType: "json",
                                                success: function (resp) {
                                                    console.log(resp);
                                                    var campo_pontos = "0 pontos"
                                                    var to = resp.CDU_Email;
                                                    if (resp.Pontos != 0) {
                                                        campo_pontos = resp.Pontos + " pontos dos quais " + resp.PontosProximaExpiracao + " expiram a " + (resp.DataProximaExpiracao.split(' '))[0];

                                                    }
                                                    var body = content.replace("<CAMPOPONTOS>",campo_pontos); 
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "send_email.php",
                                                        dataType: "json",
                                                        data: {to: to, from:from, subject: subject, content: body },
                                                        success: function (resp) {
                                                            console.log(resp);
                                                            emails_sent++;
                                                            updateProgressBar(emails_sent, total_emails);
                                                            if (emails_sent == total_emails) $('.success').show(600);
                                                        },
                                                        error: function (e) {
                                                            console.log(e);
                                                            alert("Erro ao enviar email (verifique o acesso ao servidor smtp)");
                                                        }
                                                    });  

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

                });

                $("#logout").click(function () {
                    window.location.href = "logout.php";
                });

            });
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
            <form class="form-horizontal" role="form"  >
                <h3>Newsletter  </h3>

                <div class="col-sm-12" style="padding:0">
                    <div class="col-sm-10 col-sm-offset-1" style="padding:0">
                        <div class="success alert alert-info " role="alert">Newsletter enviada com <strong>sucesso</strong>!</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" >De</label>
                    <div class="col-sm-10">
                        <input type="email" id="from" class="form-control email_field" id="from" placeholder="Enter email" value="" disabled>
                    </div>
                </div>
                <div class="form-group">

                    <label class="col-sm-1 control-label" >Assunto</label>
                    <div class="col-sm-10">
                        <input type="text" id="subject" class="form-control email_field" placeholder="Subject" value="" disabled>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-1 control-label" >Conteúdo</label>
                    <div class="col-sm-10">
                        <textarea id="content" class="form-control email_field" rows="0" disabled></textarea>
                        <p class="help-block">Utilize esta área para personalizar o email a enviar</p>

                    </div>
                </div>
                <div class="checkbox form-group">
                    <div class="col-sm-offset-1 col-sm-10">
                        <label class="control-label">
                            <input id="checkbox1" type="checkbox"> Enviar email pré-defenido
                        </label>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-10">
                        <span data-toggle="modal" data-target=".confirm-newsletter"class="open-confirm btn btn-info"  class="btn btn-default">Enviar Newsletter</span>
                    </div>
                </div>
                <div class="col-sm-offset-1 col-sm-10"  style="padding:0">

                    <div class="progress ">

                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="0" style="width: 0%;">

                        </div>
                    </div>
                </div>
            </form>
        </div>


        <div class="modal fade confirm-newsletter" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Confirmação do envio</h4>
                    </div>
                    <div class="modal-body">
                        <p>Tem a certeza que deseja enviar esta mensagem para todos os clientes subscritos?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary confirm-send" data-dismiss="modal">Enviar</button>
                    </div>

                </div>
            </div>
        </div>

    </body>
</html>
