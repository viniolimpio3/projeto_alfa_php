
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>

<?php
if(!isset($_SESSION))
	session_start();

if( include 'isLogged.php'){
	echo "Você já está logado. <br>";
	echo "<a href='vitrine.php'> Voltar para a vitrine </a>";
	exit();
}

if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado') ){ 
	//POSTS VINDOS DO FORM LOGO ABAIXO
	$Botao = $_POST["btnController"];

	$nome = $_POST["nome_cadastro"];
	$email = $_POST["email"];
	$endereco = $_POST['ende'];

	$senha = sha1($_POST["senha_cadastro"]);
	$senha_confirma = sha1($_POST['senha_confirma']);
	include "conexao.php";
	if ($Botao == "Cadastrar"){ 
		try{
			if ($senha == $senha_confirma){
				$query = "INSERT INTO cliente (name_cliente, end_cliente, user_cliente,senha_cliente)
				 VALUES ( ?, ?, ?, ?)";
				$Comando= $conexao->prepare($query);
		
				$Comando->bindParam(1, $nome);
				$Comando->bindParam(2, $endereco);
				$Comando->bindParam(3, $email);
				$Comando->bindParam(4, $senha);

				
				if ($Comando->execute()){
					if ($Comando->rowCount () >0){
						echo "<script> alert('Cadastro Realizado com Sucesso!')</script>"; 
						$nome = null; 
						$email = null;
						$endereco = null;
						$senha = null;
						$_SESSION["controleAdm"] = "cadastrado";	

						echo "<a href=\"login.php\">Ir para o Login</a>";							
			
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
			echo"Erro " . $erro->getMessage();
			
		}	
	}

}else { // Se usuário ainda não clicou no botão "Inserir", mostra o formulário na página:
	?>
	<h2>Cadastro Sistema Projeto Alpha</h2>

	<form name="form" id="form" action="cadastro.php?valor=enviado" method="POST">
		<div class="input-group">
			<label for="nome_cadastro"> Nome: <br> </label>
			<input class="input" required type="text" id ="nome_cadastro" placeholder="Preencher Nome" name="nome_cadastro"><BR><p>
		</div>

		<div class="input-group">
			<label for="email"> Usuário:(Email) <br> </label>
			<input class="input" required type="email" placeholder="Preencher E-mail" name="email"><br><p>
		</div>

		<div class="input-group">
			<label for="ende"> Endereço: <br> </label>
			<input class="input" required type="text" placeholder="Preencher E-mail" name="ende"><br><p>
		</div>


		<div class="input-group">
			<label for="senha_cadastro"> Senha:<br> </label>
			<input class="input" id="senha" type="password" placeholder="Preencher Senha" name="senha_cadastro"  required><BR><p>
		</div>

		<div class="input-group">
			<label for="senha_confirma"> Confirmar Senha:<br></label>
			<input class="input" id="senha_conf" type="password" placeholder="Confirmar Senha" name="senha_confirma"  required><BR><p>
		</div>	
		
		<input name="btnController" type="submit" value="Cadastrar"><br>
		
		

		<label style="display: none; font-size:20px; color:red;" id="aviso">Preenchar os campos, para enviar!<br></label>	


	
	</form>
	<br> <br>
	<a href="login.php">Voltar Para o login</a>	
	<script>
		const form = document.querySelector("#form");
		const senha = document.querySelector('#senha');
		const senhaConf = document.querySelector('#senha_conf');

		const divAviso = document.querySelector('#aviso');

		form.onsubmit = function(){
			if(senha.value !== senhaConf.value){
				divAviso.style.display='block';
				divAviso.innerHTML = 'Senhas não conferem'
				setTimeout(() => {
					divAviso.style = 'display:none';
				},4000)

				return false;
			}else{
				return true;
			}
		}
	</script>

<?php
}//fimElse
?>
</body>
</html>
