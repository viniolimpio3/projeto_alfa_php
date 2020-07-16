<?php

$IdContato = $_SESSION['IdContato'];
$RespContato = $_SESSION['respContato'];
include "conexao.php";
try
{  
  
  $AtualizarContato=$conexao->prepare("UPDATE TB_FALECONOSCO SET RESP_CONTATO=? WHERE ID_CONTATO=?");   
  $AtualizarContato->bindParam(1, $RespContato);
  $AtualizarContato->bindParam(2, $IdContato); 

  if ($AtualizarContato->execute())
  {
    if ($AtualizarContato->rowCount() >0) 
    { 
      $_SESSION['controleResp'] = "respondido";
      header('location:FaleConoscoAdm.php');
    }
                        
    
  }
} 
catch (PDOException $erro)
{
    echo"Erro" . $erro->getMessage();
}
     
?>