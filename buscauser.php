<?php
include_once 'include/login/db_connect.php';
include_once 'include/login/functions.php';
include_once 'include/login/registrausuario.inc.php';
sec_session_start();
if (login_check($mysqli) == true) {
    $logged = 'in';
        } else {
         $msg = base64_encode("Atenção: Necessário realizar login");
         header("location:../painel/index.php?msg=".$msg);
        }
?>
<!DOCTYPE html>
<html lang="en">
<script type="text/JavaScript" src="js/sha512.js"></script> 
<script type="text/JavaScript" src="js/forms.js"></script>
<?php include_once("include/estrutura/titulo.php"); ?>
<body>
  <div class="app" id="app">
<?php include_once("include/estrutura/menuLateral.php"); ?>
  <div id="content" class="app-content box-shadow-z0" role="main">
    <div class="app-header white box-shadow navbar-md">
        <div class="navbar navbar-toggleable-sm flex-row align-items-center">
            <a data-toggle="modal" data-target="#aside" class="hidden-lg-up mr-3">
              <i class="material-icons">&#xe5d2;</i>
            </a>
            <div class="mb-0 h5 no-wrap" ng-bind="$state.current.data.title" id="pageTitle"></div>
            <div class="collapse navbar-collapse" id="collapse">
              <?php include_once("include/estrutura/menu2.php"); ?>
            </div>
            <?php include_once("include/estrutura/navbarRight.php"); ?>
        </div>
    </div>
    <div class="app-footer">
      <div class="p-2 text-xs">
        <div class="pull-right text-muted py-1"><span class="hidden-xs-down"><?php include_once("include/estrutura/footer.php"); ?></span>
          <a ui-scroll-to="content"><i class="fa fa-long-arrow-up p-x-sm"></i></a>
        </div>
        <div class="nav">
        </div>
      </div>
    </div>
    <div ui-view class="app-body" id="view">
<div class="padding">
    <?php include_once("include/estrutura/welcome.php"); ?>
              <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                           Digite a matrícula do usuário
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">  
                                    <form id="consulta" action="buscauser.php" class="form-inline" role="form" method="get" enctype="multipart/form-data" id="fcadastro">
                            <input type="text" name="busca" class="form-control" placeholder="LOGIN DO USUÁRIO" required="require" id="numprotocolo">
                    <input type="submit" value="Consultar" class="btn btn-info">
                    </form><br><br>
                        <?php
                          if(!empty($_GET["busca"])){
                                    $busca= $mysqli->real_escape_string(strip_tags(trim($_GET['busca'])));
                        $sql = "SELECT * FROM members                
                    WHERE login like '".$busca."%'";
                    $result = mysqli_query($mysqli, $sql);
                    if(mysqli_num_rows($result) > 0){
                    ?>
                    <table class="table table-striped table-hover" width="900px">
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>EMAIL </th>
                            <th>PERFIL </th>
                            <th>LOGIN</th>
                            <th>STATUS</th>
                            <th></th>
                             <th></th>
                        </tr>
                    <?php
                    while($row = mysqli_fetch_array($result)){
                        ?>
                        <tr>
                            <td><?php echo $row["id"]?></td>
                            <td><?php echo $row["nome"]?></td>
                            <td><?php echo $row["email"]?></td>
                            <td><?php echo $row["perfil"]?></td>
                            <td><?php echo $row["login"]?></td>
                            <td><?php echo $row["statususuario"]?></td>
                            <td><a href="usereditar.php?id=<?php echo $row["id"]?>"><input type="submit" class="btn btn-default" value="Editar Usuário"</a></td>
                            <td><a href="desbloqueio.php?id=<?php echo $row["id"]?>"><input type="submit" class="btn btn-warning" value="Desbloquear"</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </table>
                    <?php
                              }else{
                                  echo "Nenhum cliente encontrado!";
                              }
                          }
                      ?>
                                </div>
                                     </div>
                             </div>
                         </div>
                     </div>
              </div>
    </div>
  </div>
<?php include_once("include/estrutura/seletorTemas.php");?>
  </div>
  <script src="lib/jquery/jquery/dist/jquery.js"></script>
  <script src="libs/jquery/tether/dist/js/tether.min.js"></script>
  <script src="libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
  <script src="libs/jquery/underscore/underscore-min.js"></script>
  <script src="libs/jquery/jQuery-Storage-API/jquery.storageapi.min.js"></script>
  <script src="libs/jquery/PACE/pace.min.js"></script>
  <script src="scripts/config.lazyload.js"></script>
  <script src="scripts/palette.js"></script>
  <script src="scripts/ui-load.js"></script>
  <script src="scripts/ui-jp.js"></script>
  <script src="scripts/ui-include.js"></script>
  <script src="scripts/ui-device.js"></script>
  <script src="scripts/ui-form.js"></script>
  <script src="scripts/ui-nav.js"></script>
  <script src="scripts/ui-scroll-to.js"></script>
  <script src="scripts/ui-toggle-class.js"></script>
  <script src="scripts/app.js"></script>
  <script src="libs/jquery/jquery-pjax/jquery.pjax.js"></script>
  <script src="scripts/ajax.js"></script>
</body>
</html>

