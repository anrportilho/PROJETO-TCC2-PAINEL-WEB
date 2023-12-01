<?php 

  if($_SESSION["perfil"] == "supervisor"){
    include_once 'include/estrutura/menu-supervisor.php';

  }else{
    echo'Acesso não autorizado';
  }
                                  
 ?>