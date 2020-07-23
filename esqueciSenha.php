<!DOCTYPE html>
<html>
<head>
	<title></title>
    <meta charset="utf-8">
    

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
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
?> <div class="form-page"> 
    <h2>Esqueceu senha</h2>
<p>Informe-nos seu email, para que possamos entrar em contato.</p>
<form action="esqueciSenha.php?enviou=sim" method ="POST">
    <label for="email"> Email: <br>  </label>
    <input type="text" required placeholder="Preencher E-mail" name="email"><br><p>
    <center>
    <input class="btn btn-dark" name="btnController" type="submit" value="Enviar">
    </center>
</form><br><br>
<a href="login.php">Voltar para o Login</a>
</div>

<?php 
}
?>
    
      
  
</body>
</html>