<?php 
// session_start inicia a sessão

// Recebe os valores postados
$Nome = $_POST["nome_cadastro"];
$Email = $_POST["usuario_cadastro"];
$SenhaAdm = $_POST["senha_cadastro"];
$Id =$_SESSION['IdAdm'];

include "conexao.php";
try
{
  if ($_POST["senha_cadastro"] == $_POST["senha_confirma"])
  {
    $AtualizarNovo=$conexao->prepare("UPDATE TB_CADASTRO_ADM SET NOME_ADM=?, EMAIL_ADM=?, SENHA_ADM=? WHERE ID_ADM=?");
    // Caso não foi preenchido campos
    if ($_POST["nome_cadastro"]=="") $Nome= $_SESSION['nomeAdm'] ; 
    if ($_POST["usuario_cadastro"]=="") $Email= $_SESSION['emailAdm'] ;
    if ($_POST["senha_cadastro"]=="") $SenhaAdm = $_SESSION['senhaAdm'] ; 
    
    //Prepara para atualização
    $AtualizarNovo->bindParam(1, $Nome);
    $AtualizarNovo->bindParam(2, $Email);
    $AtualizarNovo->bindParam(3, $SenhaAdm);
    $AtualizarNovo->bindParam(4, $Id);

    if ($AtualizarNovo->execute())
    {
      if ($AtualizarNovo->rowCount() >0) 
      {
        
        $SelecaoNova=$conexao->prepare("SELECT ID_ADM, NOME_ADM, EMAIL_ADM, SENHA_ADM FROM TB_CADASTRO_ADM 
        WHERE  EMAIL_ADM=? AND SENHA_ADM=?");   
        $SelecaoNova->bindParam(1, $Email);
        $SelecaoNova->bindParam(2, $SenhaAdm);
        if ($SelecaoNova->execute())
        {
          if ($SelecaoNova->rowCount() >0) 
          { 
            while ($Linha = $SelecaoNova->fetch(PDO::FETCH_OBJ)) 
            {
              $id = $Linha->ID_ADM;
              $_SESSION['IdAdm'] = $id;
                
              $nome = $Linha->NOME_ADM;
              $_SESSION['nomeAdm'] = $nome;

              $email = $Linha->EMAIL_ADM;
              $_SESSION['emailAdm'] = $email;

              $senha = $Linha->SENHA_ADM;
              $_SESSION['senhaAdm'] = $senha;

              $_SESSION['controleAdm'] = "alterado";
              header('location:AlterarAdm.php');
            }
                        
          }
        }
      }
    }
  }
  else
  {
    echo "<script> alert('Senha não confere')</script>";
  }
} 
catch (PDOException $erro)
{
    echo"Erro" . $erro->getMessage();
}
      
?>