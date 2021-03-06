<!DOCTYPE html>
<html>
<head>
	<title></title>
    <meta charset="utf-8">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>

<?php

// Contato com banco
if(include 'isLogged.php'){
    if(isset($_SESSION['produto'])){
        $price = $_SESSION['produto']['valor'];
        $name = $_SESSION['produto']['nome'];

        if(isset($_REQUEST['confirma']) ) { 

            $data_atual = date('Y-m-d H:i:s');

            $produto = $_SESSION['produto'];
            $cliente = $_SESSION['cliente'];

            $formaPagamento = $_POST['forma_pag'];
            $numeroParcelas = $_POST['n_parcelas'];
            $valorParcela = $_POST['valorParcela'];
            $valorTotal = $_POST['valorTotal'];

            $pedido = array(
                'forma_pag' => $formaPagamento,
                'n_parcelas' => $numeroParcelas,
                'valor_parcela' => $valorParcela,
                'valor_total' => $valorTotal,
                'data_compra' => $data_atual,
                'status' => 'ok'
            );

            $_SESSION['pedido'] = $pedido;
            
            include "conexao.php";
            try{
                
                echo '<script>console.log("FOI") </script>';
                $id_cliente = $cliente['id'];
                $valorProd = $produto['valor'];
                $id_prod = $produto['id'];
                
                $query = "INSERT INTO pedido 
                (data_pedido, valor_pedido, status_pedido, fk_id_cliente, fk_id_prod, forma_pag, n_parcelas, valor_parcelas) 
                VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";


                $command=$conexao->prepare($query);                
                $command->bindParam(1, $data_atual);
                $command->bindParam(2, $valorProd);
                $command->bindParam(3, $pedido['status']);
                $command->bindParam(4, $id_cliente);
                $command->bindParam(5, $id_prod);
                $command->bindParam(6, $pedido['forma_pag']);
                $command->bindParam(7, $pedido['n_parcelas']);
                $command->bindParam(8, $pedido['valor_parcela']);

                
                                    
                if ($command->execute()){
                    
                    if ($command->rowCount () >0) {

                        $produto_s = $_SESSION['produto'];
                        $pedido_s = $_SESSION['pedido'];


                        echo "<script> alert('Pedido resgistrado com sucesso!')</script>";
                        //ESSA É A TELA "pagamentos"
                        echo ' <div class="productDetail"> <h1>Detalhes do pedido:</h1>';
                        echo '
                            
                                <p> <b>Nome do Produto:</b> '.$produto_s['nome'].'</p> <br>
                                <p> <b> Descrição do Produto:</b> '.$produto_s['desc'].' </p> <br>
                                <p> <b>Valor Total do Produto:</b> '.$produto_s['valor'].' </p> <br>
                                <p> <b>Número de Parcelas:</b> '.$pedido_s['n_parcelas'].' </p> <br>
                                <p> <b>Valor da Parcela:</b> '.$pedido_s['valor_parcela'].' </p> <br>
                                <p> <b>Status do Pedido:</b> ' .$pedido_s['status'].' </p> <br>
                                <p> <b>Forma de Pagamento:</b> ' .$pedido_s['forma_pag'].' </p> <br>
                            
 
                        ';

                        echo ('<a style="margin-top: 40px;" class="btn btn-dark" href="pedidos.php">Gerenciar pedidos</a> </div>'); 

                    } else{
                        echo "Erro ao confirmar pedido";
                    }

                }else { 
                
                    throw new PDOException("Erro: Não foi possivel executar a declaração sql.");
                    
                }      
            }catch (PDOException $erro){
                echo"Erro" . $erro->getMessage();
            }
        } else { // Se usuário ainda não clicou no botão de enviar, mostra o formulário na página:
            ?>
            <div class="form-page pagamento">
                <form id="form" action="pagamento.php?confirma=ok" method="POST">
                    <h2>Produto: <?php echo $name?></h2>
                    <div class="input-group">
                        <label for="forma_pag">Forma de Pagamento:</label>
                        <select required name="forma_pag" id="forma_pag">
                            <option value="default">-</option>
                            <option value="boleto">BOLETO</option>
                            <option value="credito">CARTÃO DE CRÉDITO</option>
                            <option value="debito">CARTÃO DE DÉBITO</option>

                        </select>
                    </div> <br>


                    <div style="display: none;" id="parcelasGroup" class="input-group">
                        <label for="n_parcelas">Número de Parcelas:</label>
                        <select name="n_parcelas" id="n_parcelas">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        
                    </div> <br>

                    <label for="valorParcela" >Valor da Parcela:</label>
                    <input type="text" readonly value="<?php echo $price ?>" id="valorParcela" name="valorParcela"  > <br> <br>

                    <label for="valorTotal" >Valor Total:</label>
                    <input type="text" readonly value="<?php echo $price ?>" id="valorTotal" name="valorTotal"  > <br> <br>

                    <center>
                    <button style="width: 400px; margin-bottom: 0;" class="btn btn-dark" type="submit" name="confirma" value="Confirmar Pagamento">Confirmar Pagamento </button> <br> <br>
                            
                    <button style="width: 400px; margin-top: 0;" class="btn btn-dark" type="reset" name="Limpar" value="Redefinir"> Redefinir </button> <br>
                    </center>
                    <label style="display: none;" id="aviso">Preenchar os campos, para enviar! </label> <br> <br>	

                    <a href="vitrine.php">Voltar para a vitrine</a>

                </form>
            </div>
            
        <?php
        }//fim else - "user não clicou no botão confirma"
    }else{//fim se o produto existir na session
        echo "Você precisa selecionar um produto antes de selecionar o modo de pagamento, " . $_SESSION['cliente']['name'] . " <br> <br> <br>";
        echo('<a style="text-decoration:none; background:#cecece; padding:20px" href="vitrine.php"> Voltar para a Vitrine. </a>');

    }    
}else{//se user não estiver logado

    echo 'Você precisa ter um cadastro para fazer uma compra! <br> <br>';
    echo'<a href="login.php"> Ir para o Login </a>';

}

?>

<script>

    const form = document.querySelector('#form');
    const labelAviso = document.querySelector('#aviso');

    const groupNumeroParcelas = document.querySelector('#parcelasGroup');
    const inputNumeroParcelas = document.querySelector('#n_parcelas');
    const inputSelectPagamento = document.querySelector('#forma_pag');

    const inputValorParcela = document.querySelector('#valorParcela');

    let valorTotal = <?php echo $price ?>;

    let podeAlterarParcelas = false;

    inputSelectPagamento.onchange = () =>{
        if(inputSelectPagamento.value === 'credito'){
            groupNumeroParcelas.style = 'display:block';
            podeAlterarParcelas = true;
        }else{
            groupNumeroParcelas.style = 'display:none';
            podeAlterarParcelas = false;
            zeraParcelas();
        }
    }
    inputNumeroParcelas.onchange = () =>{
        if(podeAlterarParcelas){

            let numeroParcelas = inputNumeroParcelas.value;
            let valorExibe = valorTotal / numeroParcelas;
            inputValorParcela.value = valorExibe;

        }else{
            zeraParcelas();
        }
    }

    function zeraParcelas(){
        inputValorParcela.value = valorTotal;
        inputNumeroParcelas.value = 1;
    }

    form.onsubmit = () =>{
        if(inputSelectPagamento.value === 'default'){
            labelAviso.style = 'color:red;'
            labelAviso.innerHTML = 'Você precisa selecionar um modo de pagamento!';
            setInterval(() => {
                labelAviso.style = 'display:none';
            }, 3000);
            return false
        }else{
            return true;
        }
    }

    


</script>


</body>
</html>
