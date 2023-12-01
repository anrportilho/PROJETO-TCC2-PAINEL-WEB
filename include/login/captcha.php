<?php

include_once 'db_connect.php';
include_once 'functions.php';
sec_session_start(); 
$codigoCaptcha = substr(md5( time()) ,0,4);
$_SESSION['captcha'] = $codigoCaptcha;
$imagemCaptcha = imagecreatefrompng("fundocaptch.png");
$fonteCaptcha = imageloadfont("anonymous.gdf");
$corCaptcha = imagecolorallocate($imagemCaptcha,139,131, 134);
imagestring($imagemCaptcha,$fonteCaptcha,13,3,$codigoCaptcha,$corCaptcha);
header("Content-type: image/png");
imagepng($imagemCaptcha);
imagedestroy($imagemCaptcha);

?>