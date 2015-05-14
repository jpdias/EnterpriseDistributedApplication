<?php include("navbar.php"); ?>
<script src="js/fatura.js"></script>

<div class="container">

    <h2 class="center-middle margin-bottom" > Fatura <span><?php echo $_GET["codFatura"];?></span> <span class="pull-right">Valor: <span id="total_fatura"></span>€ </span></h2>
	
    <div class="table-responsive center-middle">
        <table class="table text-center" id="fatura_table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th class="nosort">Preço Inicial</th>
					<th class="nosort">Preço Final</th>
					<th class="nosort">Desconto</th>
					<th class="nosort">Poupança</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
	
	<div class="jumbotron center-middle" style="margin-top: 50px; display:none" id="desconto_pontos">
        <p class="text-center">Com <span id="pontos_cliente"></span> pontos</p>
        <div class="text-center">poupou uns adicionais <span id="desconto_cliente"></span>€</div>
    </div>
	
</div>


</body>

</html>