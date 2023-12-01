<?php
include_once 'include/login/db_connect.php';
include_once 'include/login/functions.php';
sec_session_start();
$_SESSION["token"] = (!isset($_SESSION["token"]) )? base64_encode( openssl_random_pseudo_bytes(32)) : $_SESSION["token"];
       

if (login_check($mysqli) == true) {
    $logged = 'in';
        } else {
         $logged = 'out';
        }
?>

<!DOCTYPE html>
<html lang="pt-br">
<script type="text/JavaScript" src="js/sha512.js"></script> 
<script type="text/JavaScript" src="js/forms.js"></script>
<?php include_once("include/estrutura/titulo.php"); ?>
<body>
  <div class="app" id="app">
<div class="center-block w-xxl w-auto-xs p-y-md">
    <div class="navbar">
      <div class="">
      <div class="m-b text-sm">
      </div>
      </div>
    </div>
    <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
      <div class="m-b text-sm">
        <h6><b>ORQUESTRA</b> | GOV</h6>
      </div>
      <form role="form" action="include/login/process_login.php" method="post">
          <fieldset>
              <div class="form-group">
                  <input class="form-control" placeholder="Usuario" name="login" type="text" autofocus required="required"  autocomplete="off">
              </div>
              <div class="form-group">
                  <input class="form-control" placeholder="Senha" name="password" id="password" type="password" value="" required="required"  autocomplete="off">
              </div>
                <div class="form-group">
                    <img src="include/login/captcha.php" class="img-responsive" alt="código captcha" />
                      <input type="text" class="form-control" placeholder="Digite o Código de Segurança" name="captcha" id="captcha" required="required" maxlength="9" autocomplete="off"/>
                      <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>" />
                </div>
                  <button type="button" class="btn btn-lg btn-success btn-block" onclick="formhash(this.form, this.form.password);"/>Acessar</button>
              <div class="checkbox">
                  <label>
                      <?php
                  if (isset($_GET['error'])) {
                      echo '<p class="error"><strong>Atenção:</strong> Dados incorretos</p>';
                  }
                  ?> 
                        <?php
                  if(isset($_GET["msg"])){
                      echo base64_decode($_GET["msg"]);
                  }
                  ?>    
                  </label>
              </div>
          </fieldset>
      </form>
    </div>

  </div>
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

