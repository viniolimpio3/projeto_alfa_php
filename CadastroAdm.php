
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>

<?php
session_start();

if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado')){ 
	//POSTS VINDOS DO FORM LOGO ABAIXO
	$Botao = $_POST["btnController"];

	$Nome = $_POST["nome_cadastro"];
	$Email = $_POST["usuario_cadastro"];

	$SenhaAdm = $_POST["senha_cadastro"];
	
	include "conexao.php";
	if ($Botao == "insert"){ 
			
		try{
			if ($_POST["senha_cadastro"] == $_POST["senha_confirma"]){
				$query = "INSERT INTO user (name_user, mail_user, pass) VALUES ( ?, ?, ?)";
				$Comando= $conexao->prepare($query);
		
				$Comando->bindParam(1, $Nome);
				$Comando->bindParam(2, $Email);
				$Comando->bindParam(3, $SenhaAdm);
				
				if ($Comando->execute()){
					if ($Comando->rowCount () >0){
						echo "<script> alert('Cadastro Realizado com Sucesso!')</script>"; 
								
						$Nome = null; 
						$Email = null;
						$Senha = null;
						$_SESSION["controleAdm"] = "cadastrado";	
						
						echo "<a href=\"LoginAdm.php\">Ir para o Login</a>";							
			
					}else{
						echo "Erro ao tentar efetivar o contato.";
					}
				}else { 
					throw new PDOException("Erro: Não foi possivel executar a declaração sql.");
				}
			}else {
				echo ('Senha não confere').'<BR>';
				echo "<a href=\"CadastroAdm.php\">Cadastro</a>";
			}     
		} catch (PDOException $erro){
			echo"Erro" . $erro->getMessage();
		}	
	}

}else { // Se usuário ainda não clicou no botão "Inserir", mostra o formulário na página:
	?>
	<form name="form1" action="CadastroAdm.php?valor=enviado" method="POST">
		<div class="input-group">
			<label for="nome_cadastro"> Nome: <br> </label>
			<input class="input" type="text" id ="nome_cadastro" placeholder="Preencher Nome" name="nome_cadastro"><BR><p>
		</div>

		<div class="input-group">
			<label for="usu_cadastrado"> Usuário:(Email) <br> </label>
			<input class="input" type="text" placeholder="Preencher E-mail" name="usuario_cadastro"><br><p>
		</div>

		<div class="input-group">
			<label for="senha_cadastro"> Senha:<br> </label>
			<input class="input" type="password" placeholder="Preencher Senha" name="senha_cadastro" maxlength="8" required><BR><p>
		</div>

		<div class="input-group">
			<label for="senha_confirma"> Confirmar Senha:<br></label>
			<input class="input" type="password" placeholder="Confirmar Senha" name="senha_confirma" maxlength="8" required><BR><p>
		</div>	
		
		<input name="btnController" type="submit" value="insert"><br>
		
		<label id="aviso">Preenchar os campos, para enviar!<br>	
	
	</form>
<?php
}//fimElse
?>
</body>
</html>
