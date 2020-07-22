<?php
session_start();



if(isset($_SESSION['selectedProduct']) and $_SESSION['selectedProduct'] !== ''){
    $produto_vitrine = $_SESSION['selectedProduct'];


    //select produto
    include 'conexao.php';
    $query = "select value_prod, desc_prod,id_prod FROM produto WHERE name_prod=? LIMIT 1";
    $cmd=$conexao->prepare($query);		
    $cmd->bindParam(1, $produto_vitrine);
    try{

    
        if ($cmd->execute()){
            if ($cmd->rowCount () >0) {// se o resultado trazer mais de uma linha ...
                while ($row = $cmd->fetch(PDO::FETCH_OBJ)) {
                    
                    $valorProd = $row->value_prod;
                    $descProd = $row->desc_prod;
                    $idProd = $row->id_prod;
                    $produto = array(
                        'nome' => $_SESSION['selectedProduct'],
                        'valor' => $valorProd,
                        'desc' =>$descProd,
                        'id'=> $idProd
                    ); 
                    $_SESSION['produto'] = $produto;
                }

            }else{
                echo "<script> alert('Ocorreu alguma falha na conexão com o Banco!')</script>"; 
                echo "<A href=\"vitrine.php\">Retornar à vitrine</A>";
            }
        }
    }catch(Exception $err){
        echo "<script> alert('Ocorreu alguma falha na conexão com o Banco!\nErro: ".$err."')</script>"; 
        echo "<A href=\"vitrine.php\">Retornar à vitrine</A>";
    }
    if(isset($_REQUEST['comprar']) and $_REQUEST['comprar'] === 'sim'){
        //ir para login
        if(include 'isLogged.php'){//se o user estiver logado...
            header('location:pagamento.php');
        }else{
            header('location:login.php');
        }
    }else{

    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>DETALHE PRODUTO | Projeto Alpha</title>
        </head>
        <body>
            <h1>Nome do Produto: <?php echo $produto_vitrine ?> </h1>
            <h2>Descrição Produto: <?php echo $produto['desc'] ?></h2>
            <h2>Valor Produto: <?php echo $produto['valor'] ?></h2>

            <!-- EXIBIR IMAGEM DO PRODUTO !!!! GALERA DO FRONTEND!!!!!!!!!!!! -->
            <?php if($produto_vitrine==='Toddy'):?>

                <!-- HTML PARA EXIBIR IMAGEM DO TODDY -->

            <?php endif ?>
            <?php if($produto_vitrine === 'Notebook HP'): ?>
                <!-- HTML PARA EXIBIR IMAGEM DO NOTEBOOK -->
            <?php endif ?>
            <?php if($produto_vitrine === 'TV Samsung'): ?>
                <!-- HTML PARA EXIBIR IMAGEM DA TV -->
            <?php endif ?>

            <form action="productDetail.php?comprar=sim" method="POST">

                <input type="submit" name="comprarController" value="comprar"/>

            </form>
        </body>
    </html>

    <?php
    }//fim
}else{//fim isset produto vitrine

    echo '<h1>Nenhum Produto selecionado</h1> <br>';
    echo '
        <form action="vitrine.php">
            <button type="submit" id="volta">Voltar para a Vitrine</button>
        </form>
    ';
    


}
    
    ?>


