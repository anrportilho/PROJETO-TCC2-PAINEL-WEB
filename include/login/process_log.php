<?php
include_once 'db_connect.php';
include_once 'functions.php';
sec_session_start();

if (isset($_POST['login'], $_POST['p'])) {
    $login = $_POST['login'];
    $password = $_POST['p']; 
    $token= $_POST['token'];
    $regralogin = "/^(?=.*[A-Z]{2})(?=.*[0-9]{6}).{8}$/";
    $regrasenha = "/^[A-Za-z0-9]{128}$/";

    $flag = 0;
    if(!preg_match($regralogin, $login)){
        // Falha de login 
        header('Location: ../index.php?error=1');
        $flag = 1;
    }

    if(!preg_match($regrasenha, $password)){
       // Falha de login 
        header('Location: ../index.php?error=1');
        $flag = 1;
    }

   if( $_SESSION['captcha'] !== $_POST['captcha']){
       // Falha de login 
        header('Location: ../index.php?error=1');
        $flag = 1;
    }
    
    if( $_SESSION['token'] != $_POST['token']){
        // Falha de login 
        header('Location: ../index.php?error=1');
        $flag = 1;
        
    }
    
    if($flag == 0){
        
    if (login($login, $password, $mysqli) == true) {
        // Login com sucesso 
        header('Location: ../painel/index.php');
    } else {
        // Falha de login 
        header('Location: ../index.php?error=1');
    }
     
} else {
  
    echo 'Requisição inválida.';
}
}else{
    // Falha de login 
        header('Location: ../index.php?error=1');
}
?>