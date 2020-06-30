
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
		$Botao =$_POST["Botao"];
		$Nome = $_POST["nome_cadastro"];
		$Email = $_POST["usuario_cadastro"];
    	$SenhaAdm = $_POST["senha_cadastro"];
		
		include "conexao.php";
		if ($Botao == "Inserir"){ 
				
			try{
 				if ($_POST["senha_cadastro"] == $_POST["senha_confirma"]){
            

    				$Comando= $conexao->prepare("INSERT INTO user (name_user, mail_user, pass) VALUES ( ?, ?, ?)");
            
					$Comando->bindParam(1, $Nome);
					$Comando->bindParam(2, $Email);
  	    			$Comando->bindParam(3, $SenhaAdm);
             
                        
    				if ($Comando->execute()){
        				if ($Comando->rowCount () >0) 
        				{
         					echo "<script> alert('Cadastro Realizado com Sucesso!')</script>"; 
                                  
            				$Nome = null; 
							$Email = null;
							$Senha = null;
							$_SESSION["controleAdm"] == "cadastrado";	
 				           
                  			echo "<A href=\"LoginAdm.php\">Cadastrado</A>";							
              
            			}
            		else{
                		echo "Erro ao tentar efetivar o contato.";
            		}
        			}
     				else 
        			{ 
           
           				throw new PDOException("Erro: Não foi possivel executar a declaração sql.");
            
        			}
        		}else {
					echo ('Senha não confere').'<BR>';
         			echo "<A href=\"CadastroAdm.php\">Cadastro</A>";
				}     
    		} catch (PDOException $erro){
        		echo"Erro" . $erro->getMessage();
    		}
			
		}

 	}

else { 
// Se usuário ainda não clicou no botão de enviar, mostra o formulário na página:
?>
 <form name="form1" action="CadastroAdm.php?valor=enviado" method="POST">
  Nome: <br>
  <input class="input" type="text" id ="nome_cadastro" placeholder="Preencher Nome" name="nome_cadastro"><BR><p>
 Usuário:(Email) <br>
  <input class="input" type="text" placeholder="Preencher E-mail" name="usuario_cadastro"><BR><p>
 Senha:<br>
  <input class="input" type="password" placeholder="Preencher Senha" name="senha_cadastro" maxlength="8" required><BR><p>
 Confirmar Senha:<br>
 <input class="input" type="password" placeholder="Preencher Senha" name="senha_confirma" maxlength="8" required><BR><p>
 
 
 <input name="Botao" type="submit" value="Inserir"><br><p>
</p>
	
	<label id="aviso">Preenchar os campos, para enviar!<br>	
 
 
 </p>
</form>
<?php
 }
?>
</body>
</html>
