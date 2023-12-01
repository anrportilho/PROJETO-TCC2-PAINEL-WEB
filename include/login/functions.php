<?php
include_once 'psl-config.php';
include_once 'feriado.php';

function sec_session_start() {
    $session_name = 'sec_session_id';  
    $secure = SECURE;
    $httponly = true;
   if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    session_name($session_name);
    session_start();           
    session_regenerate_id();   
}
function login($login, $password, $mysqli) {
  
    if ($stmt = $mysqli->prepare("SELECT id, username, nome, password, salt, perfil, ilha, supervisor, Empresa, login, statususuario
        FROM members
             WHERE login = ?
             AND statususuario = 'ativo'
        LIMIT 1")) {
        $stmt->bind_param('s', $login); 
        $stmt->execute(); 
        $stmt->store_result();
        $stmt->bind_result($user_id, $username, $nome, $db_password, $salt, $perfil, $ilha, $supervisor, $Empresa, $login, $statususuario);
        $stmt->fetch();
 
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
 
            if (checkbrute($user_id, $mysqli) == true) {

                header("location:../alerta.php");
                exit();
                
            } else {

                if ($db_password == $password) {

                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;

                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                               $username);
                    $_SESSION['id'] = $user_id;                                           
                    $_SESSION['username'] = $username;
                    $_SESSION["nome"] = $nome;
                    $_SESSION['perfil'] = $perfil;
                    $_SESSION['login'] = $login;
                    $_SESSION['ilha'] = $ilha;
                    $_SESSION['supervisor'] = $supervisor;
                    $_SESSION['Empresa'] = $Empresa;
                    $_SESSION['login_string'] = hash('sha512', 
                              $password . $user_browser);                    
                    $now = time();
                    $mysqli->query("INSERT INTO log_login(user_id)
                                    VALUES ('$user_id')");
                    
                    return true;
                } else {
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}

    function checkbrute($user_id, $mysqli) {
    $now = time();
    $valid_attempts = $now - (1 * 60 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time
                             FROM login_attempts
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 2) {
            return true;
               
        } else {
            return false;
        }
    }
}

function login_check($mysqli) {
    if (isset($_SESSION['user_id'], 
                        $_SESSION['username'], 
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $mysqli->prepare("SELECT password 
                                      FROM members 
                                      WHERE id = ? LIMIT 1")) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();  
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {             
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if ($login_check == $login_string) {
                 
                    return true;
                } else {
                   
                    return false;
                }
            } else {
                
                return false;
            }
        } else {
            
            return false;
        }
    } else {
        
        return false;
    }
}

function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        return '';
    } else {
        return $url;
    }
}

function anti_injection($input){
$clean=strip_tags(addslashes(trim($input)));
$clean=str_replace('"','\"',$clean);
$clean=str_replace(';','\;',$clean);
$clean=str_replace('--','\--',$clean);
$clean=str_replace('+','\+',$clean);
$clean=str_replace('(','\(',$clean);
$clean=str_replace(')','\)',$clean);
$clean=str_replace('=','\=',$clean);
$clean=str_replace('>','\>',$clean);
$clean=str_replace('<','\<',$clean);
return $clean;
}

function isValidFileName($file) {
    return preg_match('/^(((?:\.)(?!\.))|\w)+$/', $file); }

function inverteData($data){
    if(count(explode("/",$data)) > 1){
        return implode("-",array_reverse(explode("/",$data)));
    }elseif(count(explode("-",$data)) > 1){
        return implode("/",array_reverse(explode("-",$data)));
    }
}


function somar_dias_uteis($str_data,$int_qtd_dias_somar,$feriados) {

   $str_data = substr($str_data,0,10);

	if ( preg_match("@/@",$str_data) == 1 ) {

		$str_data = implode("-", array_reverse(explode("/",$str_data)));

	}
	
	$pascoa_dt = dataPascoa(date('Y'));
	$aux_p = explode("/", $pascoa_dt);
	$aux_dia_pas = $aux_p[0];
	$aux_mes_pas = $aux_p[1];
	$pascoa = "$aux_mes_pas"."-"."$aux_dia_pas";
	
	$carnaval_dt = dataCarnaval(date('Y'));
	$aux_carna = explode("/", $carnaval_dt);
	$aux_dia_carna = $aux_carna[0];
	$aux_mes_carna = $aux_carna[1];
	$carnaval = "$aux_mes_carna"."-"."$aux_dia_carna"; 

	$CorpusChristi_dt = dataCorpusChristi(date('Y'));
	$aux_cc = explode("/", $CorpusChristi_dt);
	$aux_cc_dia = $aux_cc[0];
	$aux_cc_mes = $aux_cc[1];
	$Corpus_Christi = "$aux_cc_mes"."-"."$aux_cc_dia"; 

	$sexta_santa_dt = dataSextaSanta(date('Y'));
	$aux = explode("/", $sexta_santa_dt);
	$aux_dia = $aux[0];
	$aux_mes = $aux[1];
	$sexta_santa = "$aux_mes"."-"."$aux_dia"; 

   $feriados = array("01-01", $carnaval, $sexta_santa, $pascoa, $Corpus_Christi, "04-21", "05-01", "06-12" ,"07-09", "07-16", "09-07", "10-12", "11-02", "11-15", "12-24", "12-25", "12-31");

	$array_data = explode('-', $str_data);
	$count_days = 0;
	$int_qtd_dias_uteis = 0;



	while ( $int_qtd_dias_uteis < $int_qtd_dias_somar ) {

		$count_days++;
		$day = date('m-d',strtotime('+'.$count_days.'day',strtotime($str_data))); 
		
		if(($dias_da_semana = gmdate('w', strtotime('+'.$count_days.' day', gmmktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0]))) ) != '0' && $dias_da_semana != '6' && !in_array($day,$feriados)) {

			$int_qtd_dias_uteis++;
		}

	}
         return gmdate('Y-m-d',strtotime('+'.$count_days.' day',strtotime($str_data)));

}

;?>