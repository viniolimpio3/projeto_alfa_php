<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>
<?php 
if(isset($_REQUEST['enviou']) and ($_REQUEST['enviou'] == 'sim') and isset($_POST['email']) )  { //se a query valor existir...
    if(!isset($_SESSION))
        session_start();

    $email = $_POST ["email"]; 
    // header('location:sendMail.php');
    if(include 'sendMail.php'){
        $_SESSION['email_recover'] = $email;
        $_SESSION['auth_update_pass'] = true;
        echo '
            <script> alert("Um email foi enviado para '.$email.' "); </script>
        ';
        echo '<a href="vitrine.php">Voltar para a vitrine</a>';

        //controller que vai ser usado na pagina updatePass.php, como autorização 
        // se esse controller existir, o user poderá trocar a senha dele
        // header('location:vitrine.php');

    }else{
        $_SESSION['auth_update_pass'] = false;

        echo '
            <script> alert("Não foi possível enviar um email para '.$email.'". Tente novamente mais tarde.); </script>
        ';

    }

    

}else{
?> 
<h2>Esqueceu senha</h2>
<p>Informe-nos seu email, para que possamos entrar em contato.</p>
<form action="esqueciSenha.php?enviou=sim" method ="POST">
    <label for="email"> Email: <br>  </label>
    <input type="text" required placeholder="Preencher E-mail" name="email"><br><p>

    <input name="btnController" type="submit" value="Enviar">

</form><br><br>
<a href="login.php">Voltar para o Login</a>
<?php 
}
?>
    
      
  
</body>
</html>