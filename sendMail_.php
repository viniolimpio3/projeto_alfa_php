<?php   
$email = $_SESSION['email_recover'];

$data_envio = date('d/m/Y');
$hora_envio = date('H:i:s'); 

require_once("phpmailer/class.phpmailer.php");

if(!isset($_SESSION)){
  session_start();
}

include "env_mail.php";  

$para = $email; 
$de = USER;
$de_nome = 'Sistema Projeto Alpha';
$assunto = '[Projeto Alpha] | Recuperação de Senha'; 

$corpo="
  <h1>Recuperação de senha do sistema Projeto alpha</h1>
  <p>Para cadastrar uma nova senha, entre no link abaixo</p>
  <a href='https://localhost/etec/php_aulas/updatePass.php'>Clique aqui</a>
";


function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
  global $error;
  $mail = new PHPMailer();
  $mail->IsSMTP();    // Ativar SMTP
  $mail->SMTPDebug = 0;   // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
  $mail->SMTPAuth = true;   // Autenticação ativada
  $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

  $mail->SMTPSecure = 'tls';  // Padrão de segurança
  $mail->Host = 'smtp.gmail.com'; // SMTP utilizado
  $mail->Port = 587;      // A porta 587 deverá estar aberta em seu servidor
  $mail->Username = USER;
  $mail->Password = PASS;
  $mail->SetFrom($de, $de_nome);
  $mail->Subject = $assunto;
  $mail->Body = $corpo;
  $mail->AddAddress($para);
  $mail->Send();

  if(!$mail->Send()) {
    $error = 'Mail error: '.$mail->ErrorInfo; 
    return false;
  } else {

    $error = 'Mensagem enviada!';
    return true;
  }
}

$enviou = smtpmailer($email,
'viniolimpio3@gmail.com', 
'Vinícius Olímpio',
'Projeto Alpha|Recupueração de Senha', 
$corpo);


if ($enviou){
   // Redireciona para uma página de obrigado.
    echo('Email enviado com sucesso!');
    $_SESSION['controleResp'] = "enviado";
    header('location:FaleConoscoAdm.php');
    return true;
}else{
  return false;
}
if (!empty($error)) echo $error;
?>