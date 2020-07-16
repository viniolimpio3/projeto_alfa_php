<?php 

// Recebe os valores postados
$IdContato = $_SESSION['IdContato'];

include "conexao.php";
try
{
      
  $SelecaoContato=$conexao->prepare("SELECT * FROM TB_FALECONOSCO WHERE  ID_CONTATO=?");   
  $SelecaoContato->bindParam(1, $IdContato);
            
  if ($SelecaoContato->execute())
  {
    if ($SelecaoContato->rowCount() >0) 
    { 
      while ($Linha = $SelecaoContato->fetch(PDO::FETCH_OBJ)) 
      {
        $id = $Linha->ID_CONTATO;
        $_SESSION['IdContato'] = $id;
                
        $nome = $Linha->NOME_CONTATO;
        $_SESSION['nomeContato'] = $nome;

        $fone = $Linha->FONE_CONTATO;
        $_SESSION['foneContato'] = $fone;

        $email = $Linha->EMAIL_CONTATO;
        $_SESSION['emailContato'] = $email;

        $assunto = $Linha->ASSUNTO_CONTATO;
        $_SESSION['assuntoContato'] = $assunto;

        $msg = $Linha->MSG_CONTATO;
        $_SESSION['msgContato'] = $msg;

        $resp = $Linha->RESP_CONTATO;
        $_SESSION['respContato'] = $resp;

        $_SESSION['controleResp'] = "localizado";
        header('location:FaleConoscoAdm.php');
      }
                        
    }
  }
} 
catch (PDOException $erro)
{
    echo"Erro" . $erro->getMessage();
}
     
?>