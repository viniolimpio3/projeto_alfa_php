<?php

if(!(include 'isLogged.php')){
    header('location:vitrine.php');
}

include 'conexao.php';

$valorProduto;//select da table pedido

$nomeCliente = $_SESSION['cliente']['name'];
$endeCliente = $_SESSION['cliente']['ende'];
$idCliente = $_SESSION['cliente']['id'];

$numParcelas;
$formaPagamento;
$valorParcela;





//pegando os valores de 'pedidos'
$query_pedido = "select * FROM pedido WHERE fk_id_cliente=?";
$cmd=$conexao->prepare($query_pedido);
$cmd->bindParam(1, $idCliente);
try{
    if($cmd->execute()){
        if($cmd->rowCount() > 0){
            $numPedidos = $cmd->rowCount();
            $arrPedidos = array();
            while($row = $cmd->fetch(PDO::FETCH_OBJ)){
                $valorProduto = $row->valor_pedido;
                // array_push($valoresProdutos, $valorProduto);

                $numParcelas = $row->n_parcelas;
                // array_push($numerosParcelas, $numParcelas);

                $formaPagamento = $row->forma_pag;
                // array_push($formasPagamento, $formaPagamento);

                $valorParcela = $row->valor_parcelas;
                // array_push($valoresParcelas, $valorParcela);
                
                $idProduto = $row->fk_id_prod;
                // array_push($idProdutos, $idProduto); 

                $pedidos = array(
                    'valorProduto' =>$valorProduto,
                    'numParcelas' => $numParcelas,
                    'valorParcela' => $valorParcela,
                    'formaPagamento' => $formaPagamento,
                    'idProduto' =>$idProduto
                );
                array_push($arrPedidos, $pedidos);
                
            }
            


            // echo $arrPedidos[0]['valorProduto']."<br>";
            // echo $arrPedidos[1]['valorProduto']."<br>";



            // foreach($arrPedidos as $key => $value){
            //     for($i = 0; $i < $numPedidos; $i++){
            //         echo $arrPedidos[$i][$key];
            //     }
                
            // }
           



        }else{
            // echo "<A class='btn btn-dark' href=\"vitrine.php\">Retornar à vitrine</A>";
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
            <h1>Olá <?php echo $nomeCliente ?>, você possui um total de <?=  isset($numPedidos) ? "$numPedidos":"0"  ?> pedidos </h1>
            <br>
            <h3>Seus dados:</h3>
            <form action="pedidos.php?update=ok" method="POST">
                <label for="nome">Seu Nome:</label>
                <input type="text" name="nome" id="nome" value="<?php echo $nomeCliente ?>" readonly="readonly"> <br> <br>

                <label for="ende">Seu Endereço:</label>
                <input type="text" name="ende" id="ende" value="<?php echo $endeCliente ?>" readonly="readonly"><br><br>

                <button id="alterar" type="button">Alterar</button>
                
                <input type="submit" style="display: none;" name="submit" id="submit" value="Registrar novos dados"><br>
                <button type="button" style="display: none;" id="cancel">Cancelar</button>


            </form>

            <a href="vitrine.php">Voltar para a Vitrine</a>

            <br><br>
            <h3>Seus Pedidos:</h3>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <strong>
                            <td>Valor Produto</td>
                            <td>Número de Parcelas</td>
                            <td>Valor Parcelas</td>
                            <td>Forma de Pagamento</td>
                            <td>ID Produto</td>
                        </strong>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($arrPedidos)): ?>
                        
                        <?php for ($i=0; $i < $numPedidos; $i++):?>
                            <tr>
                                <td>
                                    <?php
                                        echo $arrPedidos[$i]['valorProduto'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $arrPedidos[$i]['numParcelas'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $arrPedidos[$i]['valorParcela'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $arrPedidos[$i]['formaPagamento'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $arrPedidos[$i]['idProduto'];
                                    ?>
                                </td>
                            </tr>
                        <?php endfor ?>
                    <?php endif ?>
                </tbody>

            </table>
        </div>

        <script>
            const btnAlterar = document.querySelector('#alterar');
            const btnSubmit = document.querySelector('#submit');
            const btnCancelar = document.querySelector('#cancel');

            const inputName = document.querySelector('#nome');
            const inputEnde = document.querySelector('#ende');
            btnAlterar.onclick = () =>{
                btnAlterar.style = "display:none";
                btnSubmit.style = "display:block";
                btnCancelar.style = "display:block";

                inputName.removeAttribute('readonly')
                inputEnde.removeAttribute('readonly')
            }

            btnCancelar.onclick = () =>{
                btnAlterar.style = "display:block";
                btnSubmit.style = "display:none";
                btnCancelar.style = "display:none";

                inputName.setAttribute('readonly','readonly')
                inputEnde.setAttribute('readonly','readonly')
            }
            

        </script>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>