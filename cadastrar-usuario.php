<?php
include_once 'include/login/db_connect.php';
include_once 'include/login/functions.php';
include_once 'include/login/registrausuario.inc.php';
sec_session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
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
            <div class="col-sm-12">
              <form ui-jp="parsley" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="registration_form">
                <div class="box">
                  <div class="box-header">
                    <h2>Cadastro de usuários</h2>
                  </div>
                  <div class="box-body">
                    <p class="text-muted">Preecha todos os campos do formulário</p>
                    <div class="row m-b">
                      <div class="col-sm-4">
                        <input type="text" name='username' id='username' placeholder="Somente 1º nome do usuário" value="" required="required" class="form-control">
                      </div>
                      <div class="col-sm-4">
                        <input type="text" name='nome' id='nome' placeholder="Nome Completo do Usuario" value="" required="required" class="form-control">
                      </div>
                      <div class="col-sm-4">
                        <input type="text" name="email" id="email" placeholder="E-mail do usuário" value="" required="required" class="form-control">
                        <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>" />
                      </div>
                    </div>
                    <div class="row m-b">
                      <div class="col-sm-3">
                        <input type="text" name="login" id='login' placeholder="Matrícula/Loguin" required="required" class="form-control">
                      </div>
                      <div class="col-sm-3">
                        <select name="statususuario" id='statususuario' class="form-control" required="required">
                          <option value="">Status</option>
                          <option value="Ativo">Ativo</option>
                          <option value="Inativo">Inativo</option>
                        </select>
                      </div>
                      <div class="col-sm-3">
                        <select name="perfil" id='perfil' class="form-control" required="required">
                          <option value="">Perfil</option>
                          <option value="Operador">Operador</option>
                          <option value="Supervisor">Supervisor</option>
                        </select>
                      </div>
                      <div class="col-sm-3">
                        <select name="ilha" id='ilha' class="form-control" required="required">
                          <option value="">Skill</option>
                          <option value="Consumidor.gov.br">Consumidor.gov.br</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="dker p-a">
                    <input type="button" class="btn btn btn-success" value="CADASTRAR USUARIO" onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd,
                                   this.form.login,
                                   this.form.perfil,
                                   this.form.ilha,
                                   this.form.nome,
                                   this.form.statususuario);" />
                  </div>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
    <?php include_once("include/estrutura/seletorTemas.php"); ?>

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