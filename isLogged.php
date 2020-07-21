<?php
session_start();
if(isset($_SESSION['controleAdm']) and $_SESSION['controleAdm'] === 'logado'){
    return true;
}else{
    return false;
}
?>