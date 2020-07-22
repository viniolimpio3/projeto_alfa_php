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


function updateCliente($id, $conexao){
    $select = "SELECT * from cliente WHERE id_cliente=?";
    $other = $conexao->prepare($select);
    $other->bindParam(1,$id);
    echo "<script> console.log('chegou')</script>"; 

    if($other->execute()){
        if($other->rowCount()>0){
            while($row = $other->fetch(PDO::FETCH_OBJ)){
                $id_cliente = $row->id_cliente;
                $name_cliente = $row->name_cliente;
                $end_cliente = $row->end_cliente;//endereço
                $login = $row->user_cliente;
                $senha = sha1($row->senha_cliente);
                $cliente = array(
                    'id' => $id_cliente,
                    'name' => $name_cliente,
                    'ende' => $end_cliente,
                    'email' => $login,
                    'senha' => $senha
                );
                $_SESSION['cliente'] = $cliente;
            }
        }
    }else{
        echo "<script> console.log('não executou 2º Select.')</script>"; 

    }
}





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

                $status = $row->status_pedido;

                $idPedido = $row->id_pedido;

                $pedidos = array(
                    'valorProduto' =>$valorProduto,
                    'numParcelas' => $numParcelas,
                    'valorParcela' => $valorParcela,
                    'formaPagamento' => $formaPagamento,
                    'idProduto' =>$idProduto,
                    'status' => $status,
                    'id'=> $idPedido
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


//Rota de update dos campos "name_cliente" e "end_cliente" em "cliente"
if(isset($_REQUEST['update']) and $_REQUEST['update'] === 'ok' and isset($_POST['nome']) and isset($_POST['ende'])){

    $newName = $_POST['nome'];
    $newAddress = $_POST['ende'];

    $query_update = 'UPDATE cliente SET name_cliente=?, end_cliente=? WHERE id_cliente=?';
    $command=$conexao->prepare($query_update);
    $command->bindParam(1, $newName);
    $command->bindParam(2, $newAddress);
    $command->bindParam(3, $idCliente);

    try{
        if($command->execute()){
            if($command->rowCount() > 0){

                updateCliente($idCliente, $conexao);
                echo "<script> alert('Dados atualizados com sucesso.')</script>"; 
                
            }else{
                echo "<script> console.log('não retornou linhas.')</script>"; 
            }
        }else{
            echo "<script> alert('Não foi possível atualizar seus dados!\nTente novamente mais tarde.')</script>"; 
        }
    }catch(Exception $e){
        echo "$e"; 
        
    }


}

//ROTA DELETE DE PEDIDOS
function deletePedido($id_pedido, $conn){
    $query_delete = "DELETE FROM pedido WHERE id_pedido =?";
    $cmd = $conn->prepare($query_delete);
    $cmd->bindParam(1, $id_pedido);
    if($cmd->execute()){
        if($cmd->rowCount() > 0){
            echo "<script> console.log('foi.')</script>"; 
            echo "<script> alert('Pedido deletado com sucesso.')</script>"; 
            header('location:pedidos.php');
        }else{
            echo "<script> console.log('não retornou linhas.')</script>"; 
        }
    }else{
        echo "<script> console.log('não executou.')</script>"; 

    }
}

if(isset($_REQUEST['delete'])){
    deletePedido($_REQUEST['delete'], $conexao);
}




?>
<script>    
    //RETIRAR QUERIES QUANDO DER UM REFRESH
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    }
</script>


<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GERENCIAR PEDIDOS | Projeto Alpha</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <h1>Olá <?php echo $_SESSION['cliente']['name'] ?>, você possui um total de <?=  isset($numPedidos) ? "$numPedidos":"0"  ?> pedidos </h1>
            <br>
            <h3>Seus dados:</h3>
            <form action="pedidos.php?update=ok" method="POST">
                <label for="nome">Seu Nome:</label>
                <input type="text" name="nome" id="nome" value="<?php echo $_SESSION['cliente']['name'] ?>" readonly="readonly"> <br> <br>

                <label for="ende">Seu Endereço:</label>
                <input type="text" name="ende" id="ende" value="<?php echo $_SESSION['cliente']['ende'] ?>" readonly="readonly"><br><br>

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
                        
                        <th scope="col">Nome Produto</th>
                        <th scope="col">Valor Produto (R$)</th>
                        <th scope="col">Número de Parcelas</th>
                        <th scope="col">Valor Parcelas(R$)</th>
                        <th scope="col">Forma de Pagamento</th>
                        <th scope="col">ID Produto</th>
                        <th scope="col">Status do Pedido</th>
                        <th scope="col">Deletar</th>


                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($arrPedidos)): ?>
                        
                        <?php for ($i=0; $i < $numPedidos; $i++):?>
                            <tr>
                                <td>
                                    <?php 
                                        if($arrPedidos[$i]['idProduto'] === '1')
                                            echo 'Toddy';
                                        if($arrPedidos[$i]['idProduto'] === '2')
                                            echo 'Notebook HP';
                                        if($arrPedidos[$i]['idProduto'] === '3')
                                            echo 'Tv Samsung';

                                    ?>
                                </td>
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
                                <td>
                                    <?php
                                        echo $arrPedidos[$i]['status'];
                                    ?>
                                </td>
                                <td>
                                    <a 
                                        class="btn btn-danger"
                                        href="pedidos.php?delete=<?php echo $arrPedidos[$i]['id']?>" 
                                        id="delete_id_<?php echo $arrPedidos[$i]['id']?>"
                                    >
                                        <span class="fa fa-trash" style="color:#fff">
                                            
                                        </span>
                                    </a>
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