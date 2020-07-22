<?php 
if(isset($_SESSION['auth_update_pass']) and $_SESSION['auth_update_pass'] ){


    echo 'enviou email';


}else{//se o controller de autenticação, que permite que o user troque de senha, não for válido, desloga...
    session_destroy();
    header('location:login.php');
}

?>