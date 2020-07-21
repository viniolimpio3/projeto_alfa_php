<?php 
// as variáveis login e senha recebem os dados digitados na página anterior (LoginAdm.php)
$login = $_POST['usuario_login'];
$senha = sha1($_POST['senha_login']); 
// as próximas 3 linhas são responsáveis em se conectar com o bando de dados.

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

      echo("Parabéns " .$cliente['name'].", você logou com sucesso! <br> <br> <br>");
      echo('<a style="text-decoration:none; background:#cecece; padding:20px" href="PAGAMENTO.php"> Prosseguir para a forma de pagamento do produto: ' . $_SESSION['produto']['nome']);
      // header('location:AlterarAdm.php'); - IR PARA forma de pagamento depois
    }
  }else{
    unset ($_SESSION['controle']);
    echo "<script> alert('Usuário e/ou senha não confere!')</script>"; 
    echo "<A href=\"LoginAdm.php\">Retornar para o Login</A>";
  }
}
?>