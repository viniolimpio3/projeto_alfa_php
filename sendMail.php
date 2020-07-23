<?php
if(!isset($_SESSION))
    session_start();

$email = $_SESSION['email_recover'];



include "env_mail.php";  

$para = $email; 
$de = GUSER;
$de_nome = 'Sistema Projeto Alpha ';
$assunto = '[Projeto Alpha] | Recuperação de Senha '; 

$corpo="
	<head> 
		<meta charset='utf-8' >
	</head>

	<body>
		<div class='container'>
			<h1>Recuperação de senha do sistema Projeto alpha</h1>
			<p>Para cadastrar uma nova senha, entre no link abaixo</p>
			<a href='http://localhost/etec/php_aulas/projetoAlfa/updatePass.php'>Clique aqui</a>
			
			<br>

			<p>Caso você não tenha feito essa requisição, desconsidere este email.</p>
		</div>
	</body>
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
	$mail->Username = GUSER;
	$mail->Password = GPWD;
	$mail->SetFrom($de, $de_nome);
	$mail->Subject = $assunto;
	$mail->Body = $corpo;
	$mail->CharSet="UTF-8";
	$mail->AddAddress($para);
	$mail->IsHTML(true);
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

$enviou = smtpmailer($email, GUSER, 'Vinícius Olímpio', $assunto, $corpo);


 if ($enviou) {
	return true;
	// Header("location:vitrine.php"); // Redireciona para uma página de obrigado.

}else{
	return false;
}
if (!empty($error)) echo $error;