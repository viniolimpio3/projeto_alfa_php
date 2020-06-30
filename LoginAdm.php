
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>
<?php 
if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado'))
{
    $Botao = $_POST ["Botao"]; 

    if ($Botao =="Logar"){
        session_start();
        $_SESSION["controleAdm"] = "logado";
        include "LogadoAdm.php";
        

    }
    if ($Botao =="Cadastro"){
        session_start();
        $_SESSION["controleAdm"] = "novo";
        //Será marcado como novo para sabermos que o usuario não tem cadastro
        echo "<A href=\"CadastroAdm.php\">Novo</A>"; 
    }
}
else{
?> 
    <FORM action="LoginAdm.php?valor=enviado" method ="POST">
        Usuário: <BR>  
        <INPUT type="text" placeholder="Preencher E-mail" name="usuario_login"><BR><p>

        Senha: <BR>
        <INPUT type="password" placeholder="Preencher Senha" name="senha_login" maxlength="8" ><BR><p>

        <input name="Botao" type="submit" value="Cadastro">
        <input name="Botao" type="submit" value="Logar">
    </FORM>
    <?php 
}
?>
    
      
  
</body>
</html>