<?php
if(!isset($_SESSION))
    session_start();

$email = $_SESSION['email_recover'];



// $Nome		= $_POST["Nome"];	// Pega o valor do campo Nome
// $Fone		= $_POST["Fone"];	// Pega o valor do campo Telefone
// $Email		= $_POST["Email"];	// Pega o valor do campo Email
// $Mensagem	= $_POST["Mensagem"];	// Pega os valores do campo Mensagem

include "env_mail.php";  

$para = $email; 
$de = GUSER;
$de_nome = 'Sistema Projeto Alpha';
$assunto = '[Projeto Alpha] | Recuperação de Senha'; 

$corpo="
    <h1>Recuperação de senha do sistema Projeto alpha</h1>
    <p>Para cadastrar uma nova senha, entre no link abaixo</p>
    <a href='https://localhost/etec/php_aulas/updatePass.php'>Clique aqui</a>
";


require_once("phpmailer/class.phpmailer.php");



function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP();		// Ativar SMTP
	$mail->SMTPDebug = 1;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	$mail->SMTPAuth = true;		// Autenticação ativada
	$mail->SMTPSecure = 'tls';	// SSL REQUERIDO pelo GMail
	$mail->Host = 'smtp.gmail.com';	// SMTP utilizado
	$mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
	$mail->Username = 'drive.teologia@gmail.com';
	$mail->Password = 'Chaves__654';
	$mail->SetFrom($de, $de_nome);
	$mail->Subject = $assunto;
	$mail->Body = $corpo;
	$mail->AddAddress($para);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Mensagem enviada!';
		return true;
	}
}

// Insira abaixo o email que irá receber a mensagem, o email que irá enviar (o mesmo da variável GUSER), 
// o nome do email que envia a mensagem, o Assunto da mensagem e por último a variável com o corpo do email.

$enviou = smtpmailer($email, 'drive.teologia@gmail.com', 'Vinícius Olímpio', 'Projeto Alpha | Recuperação de senha ', $corpo);


 if ($enviou) {

	Header("location:http://www.dominio.com.br/obrigado.html"); // Redireciona para uma página de obrigado.

}
if (!empty($error)) echo $error;