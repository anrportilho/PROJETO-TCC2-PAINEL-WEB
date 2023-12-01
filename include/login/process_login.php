<?php
include_once 'db_connect.php';
include_once 'functions.php';
sec_session_start(); 


if (isset($_POST['login'], $_POST['p'])) {
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING); 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING); 
    $token= $_POST["token"];
    $regralogin = "/^(?=.*[A-Z]{2})(?=.*[0-9]{6}).{8}$/";
    $regrasenha = "/^[A-Za-z0-9]{128}$/";
    $flag = 0;
    
    if(!preg_match($regralogin, $login)){
        $flag = 1;
    }

    if(!preg_match($regrasenha, $password)){
        $flag = 1;
    }

   if( $_SESSION['captcha'] !== $_POST['captcha']){
        header('Location: ../index.php?error=1');
        $flag = 1;
    }
    
    if( $_SESSION["token"] !== $_POST["token"]){
        header('Location: ../index.php?error=1');
        $flag = 1;
    }
    
    if($flag == 0){
        
    if (login($login, $password, $mysqli) == true) {
        header('Location: ../../dashboard.php');
    } else {
        header('Location: ../../index.php?error=1');
    }
     
} else {
    header('Location: ../../index.php?error=1');
}
}else{
        header('Location: ../../index.php?error=1');
}
?>