<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>
<?php 
session_start();
echo "Dados do Usuário Administrativo:<br><br>";
echo "Nome: " . $_SESSION['nomeAdm'] . "<br>";
echo "Usuario: " . $_SESSION['emailAdm'] . '<BR>'.'<BR>';

if ($_SESSION ['controleAdm'] == 'alterado' )
{
	echo "Cadastro atualizado com sucesso:". '<br>'.'<br>';
}
else
{
	echo "Preencha o campo desejado para ser alterado:". '<br>'.'<br>';
}

if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado'))
{
    $Botao = $_POST ["Botao"]; 

    if ($Botao =="Alterar")
    {
        include "AlteradoAdm.php";   
    }
    if ($Botao =="Gerenciar")
    {
        $_SESSION['controleResp'] = "gerenciar";
        header('location:FaleConoscoAdm.php'); 
    }
}
else 
{
    ?> 
    <form name="form1" action="AlterarAdm.php?valor=enviado" method="POST">
  		Nome: <br>
  		<input class="input" type="text" id ="nome_cadastro" placeholder="Preencher Nome" name="nome_cadastro"><BR><p>
 		  Usuário:(Email) <br>
  		<input class="input" type="text" placeholder="Preencher E-mail" name="usuario_cadastro"><BR><p>
 		  Senha:<br>
  		<input class="input" type="password" placeholder="Preencher Senha" name="senha_cadastro" maxlength="8" required><BR><p>
 		  Confirmar Senha:<br>
 		  <input class="input" type="password" placeholder="Preencher Senha" name="senha_confirma" maxlength="8" required><BR><p>
 
 		  <input name="Botao" type="submit" value="Alterar">
 		  <input name="Botao" type="submit" value="Gerenciar"><br><p>

		  </p>
		</form>
    </body>
  <?php 
}
?>