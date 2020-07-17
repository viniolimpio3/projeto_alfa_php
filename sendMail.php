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

include "env_mail.php";  

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
  $mail->Host = 'smtp.gmail.com'; // SMTP utilizado
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
$Vai = "
    <div style='text-center'>
        <h1>Mensagem enviada por usuário do sistema ProjetoAlpha</h1>
        Nome: $nome\n\n
        E-mail: $email\n\n
        Telefone: $telefone\n\n
        Mensagem: $mensagem\n\n
        Resposta: $corpo
    </div>
";

$enviou = smtpmailer($email,
'cleiton.patricio@etec.sp.gov.br', 
'Cleiton Fabiano Patricio',
'Resposta do Contato', 
$Vai);


if ($enviou){
   // Redireciona para uma página de obrigado.
    echo('Email enviado com sucesso!');
    $_SESSION['controleResp'] = "enviado";
    header('location:FaleConoscoAdm.php');
}
if (!empty($error)) echo $error;
?>