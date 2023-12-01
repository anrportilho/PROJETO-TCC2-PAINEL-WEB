<?php
include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';
 
$error_msg = "";
 
if (isset($_POST['username'], $_POST['email'], $_POST['p'], $_POST['login'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING); 
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING); 
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING); 
    $statususuario = filter_input(INPUT_POST, 'statususuario', FILTER_SANITIZE_STRING);
    $perfil = filter_input(INPUT_POST, 'perfil', FILTER_SANITIZE_STRING);
    $ilha = filter_input(INPUT_POST, 'ilha', FILTER_SANITIZE_STRING);
    $Empresa = "Não informado";
    $supervisor = "Não informado";
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
 
        $error_msg .= '<p class="error">O endereço de email digitado não é válido</p>';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }
    $prep_stmt = "SELECT id FROM members WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // Um usuário com esse email já esixte
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
        }
    } else {
        $error_msg .= '<p class="error">Database error</p>';
    }
 
    if (empty($error_msg)) {
       
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
 
       
        $password = hash('sha512', $password . $random_salt);
 
    
        if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, nome, email, password, salt, login, statususuario, perfil, ilha, Empresa, supervisor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
            $insert_stmt->bind_param('sssssssssss', $username, $nome, $email, $password, $random_salt, $login, $statususuario, $perfil, $ilha, $Empresa, $supervisor);
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Registration failure: INSERT');
            }
        }
        header('Location: ./dashboard.php');
    }
}