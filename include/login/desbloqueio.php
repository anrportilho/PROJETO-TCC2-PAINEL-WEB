<?php
include_once 'db_connect.php';
include_once 'functions.php';
sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
        } else {
         $msg = base64_encode("Atenção: Necessário realizar login");
         header("location:./index.php?msg=".$msg);
        }
    $id = $_POST["id"]; 
     $sql = "DELETE FROM login_attempts where user_id  = ".$id;
        if (mysqli_query($mysqli,$sql)){      
          $msg = base64_encode("ACESSO DESBLOQUEADO");
            header("location:./index.php?msg=".$msg);
        } else {
            $msg = base64_encode("FALHA AO REGISTRAR DESBLOQUEIO");
            header("location:./index.php?msg=".$msg);
        }
            
        mysqli_close($mysqli);
?>