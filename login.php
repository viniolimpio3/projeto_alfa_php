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
if(isset($_REQUEST['enviou']) and ($_REQUEST['enviou'] == 'sim') and isset($_POST['usuario_login']) and isset($_POST['senha_login'])  )  { //se a query valor existir...
    $controller = $_POST ["btnController"]; 
    session_start();
    if ($controller =="Logar"){
        
        // include 'logar.php';
        $_SESSION['usuario_login'] = $_POST['usuario_login'];
        $_SESSION['senha_login'] = sha1($_POST['senha_login']);
         header('location:logar.php');
    }
    if ($controller == "Cadastrar"){
        $_SESSION["controleAdm"] = "novo";
        header('location:cadastro.php');
    }
    if($controller === 'Esqueci minha Senha'){
        $_SESSION['controleAdm'] = "esqueceu";
        header('location:esqueciSenha.php');
    }

}else{
?> 
<div class="form-page">
<h2>Login Sistema Projeto Alpha</h2>
<form action="login.php?enviou=sim" method ="POST">
    <label for="usuario_login"> Usuário: <br>  </label>
    <input type="text" placeholder="Preencher E-mail" name="usuario_login"><br><p>

    <label for=""> Senha: <br></label>
    <input type="password" placeholder="Preencher Senha" name="senha_login" maxlength="8" ><br><p>

    <button class="btn btn-dark"name="btnController" type="submit" value="Logar"> Logar </button>
    <button class="btn btn-dark"name="btnController" type="submit" value="Cadastrar"> Cadastrar</button>
    <button class="btn btn-dark"name="btnController" type="submit" value="Esqueci minha Senha"> Esqueci minha senha</button>


</form>
<a href="vitrine.php">Voltar para a vitrine</a>

</div>

<?php 
}
?>
    
      
  
</body>

</html>