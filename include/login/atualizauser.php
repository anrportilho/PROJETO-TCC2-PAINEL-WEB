<?php
include_once 'db_connect.php';
include_once 'functions.php';
sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
        } else {
         $msg = base64_encode("Atenção: Necessário realizar login");
         header("location:../index.php?msg=".$msg);
        }

if ($_SESSION['perfil'] == 'adm'  OR $_SESSION['perfil'] == 'Supervisor' OR $_SESSION['perfil'] == 'coordenador') {
   
 
$error_msg = "";
 
if (isset($_POST['username'], $_POST['email'], $_POST['p'], $_POST['login'])) {

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT); 
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING); 
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING); 
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING); 
    $statususuario = filter_input(INPUT_POST, 'statususuario', FILTER_SANITIZE_STRING);
    $perfil = filter_input(INPUT_POST, 'perfil', FILTER_SANITIZE_STRING);
    $ilha = filter_input(INPUT_POST, 'ilha', FILTER_SANITIZE_STRING);
    $Empresa = filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_STRING);
    $supervisor = filter_input(INPUT_POST, 'supervisor', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      
        $error_msg .= '<p class="error">O endereço de email digitado não é válido</p>';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {

        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }
    if (empty($error_msg)) {
      
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
        $password = hash('sha512', $password . $random_salt);
 
    $sql = "UPDATE members SET username=?, nome=?,  email=?,  password=?, salt=?, login=?, statususuario = ?, perfil = ?, ilha = ?, Empresa = ?, supervisor = ?  WHERE id=?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param('sssssssssssi', $username, $nome, $email, $password, $random_salt, $login, $statususuario, $perfil, $ilha, $Empresa, $supervisor,  $id);
    $stmt->execute();

    if ($stmt->errno) {
  echo "FAILURE!!! " . $stmt->error;
    }
        else $msg = base64_encode("USUARIO ATUALIZADO COM SUCESSO");
                header("location: ../../dashboard.php?msg=".$msg);
$stmt->close();
    
    }
}
} else {
         $msg = base64_encode("Atenção: Necessário realizar login");
         header("location:../../index.php?msg=".$msg);
        }