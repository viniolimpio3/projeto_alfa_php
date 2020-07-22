<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
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
        //Será marcado como novo para sabermos que o user não tem cadastro
        echo "<a href=\"CadastroAdm.php\">Cadastrar</a>"; 
    }
    if($controller === 'Esqueci minha Senha'){
        $_SESSION['controleAdm'] = "esqueceu";
    }

}else{
?> 
<form action="login.php?enviou=sim" method ="POST">
    <label for="usuario_login"> Usuário: <br>  </label>
    <input type="text" placeholder="Preencher E-mail" name="usuario_login"><br><p>

    <label for=""> Senha: <br></label>
    <input type="password" placeholder="Preencher Senha" name="senha_login" maxlength="8" ><br><p>

    <input name="btnController" type="submit" value="Logar">
    <input name="btnController" type="submit" value="Cadastrar">
    <input name="btnController" type="submit" value="Esqueci minha Senha">


</form>
<a href="vitrine.php">Voltar para a vitrine</a>
<?php 
}
?>
    
      
  
</body>
</html>