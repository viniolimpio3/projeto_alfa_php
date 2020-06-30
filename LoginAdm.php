<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>
<?php 
if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado')){//se a query valor existir...
    $controller = $_POST ["btnController"]; 

    if ($controller =="Logar"){
        session_start();
        $_SESSION["controleAdm"] = "logado";
        include "LogadoAdm.php";
        
    }
    if ($controller == "Cadastrar"){
        session_start();
        $_SESSION["controleAdm"] = "novo";
        //Será marcado como novo para sabermos que o user não tem cadastro
        echo "<a href=\"CadastroAdm.php\">Novo Usuário</a>"; 
    }
}else{
?> 
    <form action="LoginAdm.php?valor=enviado" method ="POST">
        <label for="usuario_login"> Usuário: <BR>  </label>
        <INPUT type="text" placeholder="Preencher E-mail" name="usuario_login"><BR><p>

        <label for=""> Senha: <BR></label>
        <INPUT type="password" placeholder="Preencher Senha" name="senha_login" maxlength="8" ><BR><p>

        <input name="btnController" type="submit" value="Cadastrar">
        <input name="btnController" type="submit" value="Logar">
    </form>
<?php 
}
?>
    
      
  
</body>
</html>