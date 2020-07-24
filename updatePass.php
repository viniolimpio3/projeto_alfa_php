<?php
if(!isset($_SESSION)) 
    session_start();
if( isset($_SESSION['auth_update_pass']) and $_SESSION['auth_update_pass'] and isset($_SESSION['email_recover']) ){
    //quando terminar  !!!!!

    if(  !( isset($_REQUEST['enviou']) and $_REQUEST['enviou'] === 'sim' and isset($_POST['senha']) and isset($_POST['senha_conf'])  )   ){
        ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <!-- Meta tags Obrigatórias -->
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <!-- Bootstrap CSS -->
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

                <title>Projeto Alpha</title>
            </head>
                <body>
                    <form id="form" action="updatePass.php?enviou=sim" method="POST">
                        <label for="senha">Nova senha:</label>
                        <input type="password" required name="senha" id="senha" > <br> <br>

                        <label for="senha_conf">Repita a senha:</label>
                        <input type="password" required name="senha_conf" id="senha_conf"><br><br>

                        <input type="submit"  value="Verificar">

                    </form>

                    <label style="display: none; color:red;" id="aviso"></label>
                </body>
            </html>
        <?php 
    }else{
        //lógica de update

        include 'conexao.php';
        $newPass = sha1($_POST['senha']);//sempre em hash sha1!!!!!!
        $email = $_SESSION['email_recover'];
        $query_update = 'UPDATE cliente SET senha_cliente=? WHERE user_cliente=?';
        $cmd=$conexao->prepare($query_update);
        $cmd->bindParam(1, $newPass);
        $cmd->bindParam(2, $email);

        try{
            if($cmd->execute()){
                if($cmd->rowCount() > 0){
                    $_SESSION['auth_update_pass'] = false;
                    echo "<script> alert('Senha atualizada com sucesso.')</script>"; 
                    echo '<a href="login.php">Logar</a>';
                    
                }else{
                    echo "<script> alert('Não foi possível cadastrar essa senha.')</script>"; 
                }
            }else{
                echo "<script> alert('Não foi possível atualizar seus dados!\nTente novamente mais tarde.')</script>"; 
            }
        }catch(Exception $e){
            echo "$e"; 
            
        }

    }

}else{//se o controller de autenticação, que permite que o user troque de senha, não for válido, desloga...
                    
    echo 'Você não é permitido aqui <br> <br>  <a href="vitrine.php">Voltar para Vitrine</a>';
}

?>
<script>
    const form = document.querySelector('#form');
    const inputSenha = document.querySelector('#senha');
    const inputConfSenha = document.querySelector('#senha_conf');

    const labelAviso = document.querySelector("#aviso");
    form.onsubmit = () => {
        if(sha1(inputSenha.value) !== sha1(inputConfSenha.value)){
            labelAviso.style.display = 'block';
            labelAviso.innerHTML = 'As senhas devem ser exatamente iguais!';

            setTimeout(()=>{
                labelAviso.style.display='none';
            },4000);
            return false;
        }else{
            return true;
        }
    }

</script>