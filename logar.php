<?php 
session_start();
// as variáveis login e senha recebem os dados digitados na página anterior (LoginAdm.php)
$login = $_SESSION['usuario_login'];
$senha = $_SESSION['senha_login']; 
// as próximas 3 linhas são responsáveis em se conectar com o bando de dados.
//session_start();
include "conexao.php";
 
// A variavel $result pega as varias $login e $senha, faz uma 
//pesquisa na tabela de usuarios
$query = "select id_cliente, name_cliente, end_cliente FROM cliente
WHERE user_cliente=? AND senha_cliente=?";
$cmd=$conexao->prepare($query);		
$cmd->bindParam(1, $login);
$cmd->bindParam(2, $senha);
   
if ($cmd->execute()){
  if ($cmd->rowCount () >0) {	// se o resultado trazer mais de uma linha ...

    while ($row = $cmd->fetch(PDO::FETCH_OBJ)) {
      $id_cliente = $row->id_cliente;
      $name_cliente = $row->name_cliente;
      $end_cliente = $row->end_cliente;//endereço

      $cliente = array(
        'id' => $id_cliente,
        'name' => $name_cliente,
        'ende' => $end_cliente,
        'email' => $login,
        'senha' => $senha
      );
      $_SESSION['cliente'] = $cliente;
      
      $_SESSION["controleAdm"] = "logado";

      echo("Parabéns " .$cliente['name'].", você logou com sucesso! <br> <br> <br>");
      if(isset($_SESSION['produto'])){//se existir a sessão de produto - ir para pagamento.php
        echo('<a style="text-decoration:none; background:#cecece; padding:20px" href="pagamento.php"> Prosseguir para a forma de pagamento do produto: ' . $_SESSION['produto']['nome'] .'</a>');
        echo '<br> <br><br> ou <br><br><br>  ';
        echo('<a style="text-decoration:none; background:#cecece; padding:20px" href="vitrine.php"> Voltar para a Vitrine. </a>');


      }else{//se não, ir para a vitrine
        echo('<a style="text-decoration:none; background:#cecece; padding:20px" href="vitrine.php"> Voltar para a Vitrine. </a>');
      }

    }
  }else{
    unset ($_SESSION['controle']);
    echo "<script> alert('Usuário e/ou senha não confere!')</script>"; 
    echo "<A href=\"login.php\">Retornar para o Login</A>";
  }
}
?>