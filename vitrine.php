
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <!-- Meta tags Obrigatórias -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <title>VITRINE | Projeto Alpha</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark " style="background-color: #222;">

             <div class="container">
                 
                <a href="#" class="navbar-brand h1 mb-0">Projeto Alpha</a><!--mb-0 = margin-bottom:0 -->
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSite"><!-- data-target é o id do toggle-->
                    <span class="navbar-toggler-icon"></span>
                    
                </button>

                <div class="navbar-collapse collapse" id="navbarSite">
                    
                    <ul class="navbar-nav mr-auto"><!-- mr : margin right!!! -->
                        <li class="nav-item">
                            <a class="nav-link" href="vitrine.php">Vitrine</a>
                        </li>
                        <?php if(include 'isLogged.php'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="pedidos.php">Meus Pedidos</a>
                            </li>
                        <?php endif?>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <div class="login" style="color: #fff !important;">

                            <?php 
                             if(include 'isLogged.php' ){ //se o retorno do arquivo isLogged for true...?>
                                <p>Cliente Logado: <?php echo($_SESSION['cliente']['name']); ?> </p>
                                <form method="POST" action="doLogout.php">
                                    <input class="btn btn-dark" type="submit" value="Logout">
                                </form>
                            <?php }else{ ?>
                                <a class="btn btn-dark" href="./login.php">Entrar</a>
                            <?php }?>
                        </div>
                    </ul>

                </div>


             </div>

        </nav>
        
        <!-- CONTEÚDO -->

        <div class="container">

            <div class="row">
            
                <div class="col text-center">
                    
                    <h1 class=" mt-3 mb-3 display-5">Vitrine de Produtos</h1>

                </div>

            </div>
            <?php
                
                if(isset($_REQUEST['selecionouProduto']) and $_REQUEST['selecionouProduto'] === 'sim' and isset($_POST['controllerProduto']) ){
                    
                    $_SESSION['selectedProduct'] = $_POST['controllerProduto'];//sessão para levar ao arquivo 'productDetail.php'
                    
                    header('Location:productDetail.php');

                }else{

            ?>
            
                <div class="row mb-5">
                    <form 
                        method="POST"
                        style="width: 100% !important;display: flex;" 
                        action="vitrine.php?selecionouProduto=sim"
                    >
                        <div class="col-lg-4 col-sm-6">
                            
                            <div class="card">

                                <img src="img/img1.jpg" class="card-img-top">
                                <div class="card-body">

                                    <h4 class="card-title">Notebook HP</h4>   
                                    <h6 class="card-subtitle text-muted mb-2">Especificação do Produto</h6>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam.</p>
                                
                                </div>
                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item">Descrição 1</li>
                                    <li class="list-group-item">Descrição 2</li>
                                    <li class="list-group-item">Descrição 3</li>

                                </ul>
                                <div class="card-body">
                                    
                                    <input name='controllerProduto' type="submit" class="btn btn-dark" href="" value="Notebook HP">                            
                                </div>
                                

                            </div>

                        </div>

                        <div class="col-lg-4 col-sm-6 ">
                            
                            <div class="card">

                                <img src="img/img2.jpg" class="card-img-top">
                                <div class="card-body">

                                    <h4 class="card-title">Televisão Samsung</h4>   
                                    <h6 class="card-subtitle text-muted mb-2">Especificação do Produto</h6>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam.</p>
                                
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Descrição 1</li>
                                    <li class="list-group-item">Descrição 2</li>
                                    <li class="list-group-item">Descrição 3</li>
                                </ul>
                                <div class="card-body">
                                    <input name="controllerProduto" type="submit" class="btn btn-dark" href="" value="TV Samsung">
                                </div>
                                

                            </div>

                        </div>

                        <div class="col-lg-4 col-sm-6">
                            
                            <div class="card">

                                <img src="img/img3.jpg" class="card-img-top">
                                <div class="card-body">

                                    <h4 class="card-title">Toddy</h4>   
                                    <h6 class="card-subtitle text-muted mb-2">Especificação do Produto</h6>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam.</p>
                                
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Descrição 1</li>
                                    <li class="list-group-item">Descrição 2</li>
                                    <li class="list-group-item">Descrição 3</li>
                                </ul>
                                <div class="card-body">
                                    <input name="controllerProduto" type="submit" class="btn btn-dark" href="" value="Toddy">                            
                                </div>
                                

                            </div>

                        </div>
                    </form>
                </div><!--FIM ROW!! -->

            <?php } //fim ELSE?>

        </div><!--CONTAINER!! -->
        
        <!-- JavaScript (Opcional) -->
        <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>