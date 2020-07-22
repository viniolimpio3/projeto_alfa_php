<?php

if(!(include 'isLogged.php')){
    echo '
        <h1> Você precisa estar logado para acessar esta área</h1> <br> <br>
        <a href="login.php">Ir para o login</a> <br>  <br>
        <a href="vitrine.php">Voltar para a Vitrine</a>
    
    ';
}

include 'conexao.php';

$nomeProduto;//select da table prodto
$descProduto;//select da table prodto

$valorProduto;//select da table pedido

$nomeCliente = $_SESSION['cliente']['name'];
$endeCliente = $_SESSION['cliente']['ende'];
$idCliente = $_SESSION['cliente']['id'];

$numParcelas;
$formaPagamento;
$valorParcela;

//arrays
$nomesProdutos = array();
$descsProdutos = array();

$valoresProdutos = array();

$numerosParcelas = array();
$formasPagamento = array();
$valoresParcelas = array();
$idProdutos = array();

//pegando os valores de 'pedidos'
$query_pedido = "select * FROM pedido WHERE fk_id_cliente=?";
$cmd=$conexao->prepare($query_pedido);
$cmd->bindParam(1, $idCliente);
try{
    if($cmd->execute()){
        if($cmd->rowCount() > 0){

            while($row = $cmd->fetch(PDO::FETCH_OBJ)){
                $valorProduto = $row->valor_pedido;
                array_push($valoresProdutos, $valorProduto);

                $numParcelas = $row->n_parcelas;
                array_push($numerosParcelas, $numParcelas);

                $formaPagamento = $row->forma_pag;
                array_push($formasPagamento, $formaPagamento);

                $valorParcela = $row->valor_parcelas;
                array_push($valoresParcelas, $valorParcela);
                
                $idProduto = $row->fk_id_prod;
                array_push($idProdutos, $idProduto); 
            }
            $pedidosExibir = array(
                'valoresProds'=> $valoresProdutos,
                'numsParcelas' => $numerosParcelas,
                'formasPag' => $formasPagamento,
                'valoresParcelas' => $valoresParcelas,
                'idProdutos' => $idProdutos
            );

        }else{
            echo "Deu ruim <br> <br>"; 
            echo "<A class='btn btn-dark' href=\"vitrine.php\">Retornar à vitrine</A>";
        }
    }

}catch(Exception $err){
    echo "<script> alert('Ocorreu alguma falha na conexão com o Banco!\nErro: ".$err."')</script>"; 
    echo "<A href=\"vitrine.php\">Retornar à vitrine</A>";
}

?>


<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GERENCIAR PEDIDOS | Projeto Alpha</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <h1>Olá <?php echo $nomeCliente ?>, seus Pedidos: </h1>

            <table class="table">
                <thead>
                    <tr>
                        <td>Valor Produto</td>
                        <td>Número de Parcelas</td>
                        <td>Valor Parcelas</td>
                        <td>Forma de Pagamento</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($pedidosExibir)): ?>
                        <?php foreach ($pedidosExibir as $pedido):?>
                            <tr>
                                <?php
                                    echo  $pedido[0];
                                ?>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>

            </table>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>