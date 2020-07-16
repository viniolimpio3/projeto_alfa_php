<?php   
$nome = $_SESSION['nomeContato'];
$email = $_SESSION['emailContato'];
$telefone = $_SESSION['foneContato'];
$opcoes = $_SESSION['assuntoContato'];
$mensagem = $_SESSION['msgContato'];
$corpo = $_SESSION['respContato']; 

$data_envio = date('d/m/Y');
$hora_envio = date('H:i:s'); 

require_once("phpmailer/class.phpmailer.php");

include "SenhaEmail.php";  
$para = $email; 
$de = 'cleiton.patricio@etec.sp.gov.br';
$de_nome = 'Cleiton Fabiano Patricio';
$assunto = $opcoes; 


function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
  global $error;
  $mail = new PHPMailer();
  $mail->IsSMTP();    // Ativar SMTP
  $mail->SMTPDebug = 0;   // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
  $mail->SMTPAuth = true;   // Autenticação ativada
  $mail->SMTPSecure = 'tls';  // Padrão de segurança
  $mail->Host = 'smtp.office365.com'; // SMTP utilizado
  $mail->Port = 587;      // A porta 587 deverá estar aberta em seu servidor
  $mail->Username = USER;
  $mail->Password = PWD;
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
//o nome do email que envia a mensagem, o Assunto da mensagem e por último a variável com o corpo do email.
$Vai    = "Nome: $nome\n\nE-mail: $email\n\nTelefone: $telefone\n\nMensagem: $mensagem\n\nResposta: $corpo";

 if (smtpmailer($email, 'cleiton.patricio@etec.sp.gov.br', 'Cleiton Fabiano Patricio', 'Resposta do Contato', $Vai)) {

  echo ('Sucesso enviado, '); // Redireciona para uma página de obrigado.
  $_SESSION['controleResp'] = "enviado";
  header('location:FaleConoscoAdm.php');
}
if (!empty($error)) echo $error;
?>