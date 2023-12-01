<?php
include_once 'include/login/db_connect.php';
include_once 'include/login/functions.php';
sec_session_start();
if (login_check($mysqli) == true) {
	$logged = 'in';
} else {
	$msg = base64_encode("Atenção: Necessário realizar login");
	header("location:../painel/index.php?msg=" . $msg);
}
?>
<!DOCTYPE html>
<html lang="en">
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
			<?php 
                                    if($_SESSION["perfil"] == "supervisor"){
                                      include_once 'include/estrutura/dashboard-adm.php';
                                    }elseif($_SESSION["perfil"] == "operador"){
                                        include_once 'include/estrutura/dashboard-operador.php';
                                    }                   
 ?>
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