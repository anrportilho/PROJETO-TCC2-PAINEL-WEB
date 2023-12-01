<?php
include_once 'include/login/db_connect.php';
include_once 'include/login/functions.php';
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
<div class="p-a white lt box-shadow">
	<div class="row">
	<div class="col-xs-3">
  <form  action="gov-problema.php" method="get" enctype="multipart/form-data">      
            </div>
            <div class="col-xs-3">
                <select name="uf" class="form-control" required="required" >
                    <option value="%">Selecione o Estado</option>
                    <option value="%">Todos</option>
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espirito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
                </select>
            </div>
            <div class="col-xs-3">
                <select name="periodo" class="form-control" required="required">
                    <option value="180">Selecione o período de encerramento</option>
                    <option value="7">Encerrados nos últimos 7 dias</option>
                    <option value="15"> Encerrados nos últimos 15 dias</option>
                    <option value="30"> Encerrados nos últimos30 dias</option>
                    <option value="60">Encerrados nos últimos 60 dias</option>
                    <option value="90">Encerrados nos últimos 90 dias</option>
                    <option value="180">Encerrados nos últimos 180 dias</option>
                </select>
            </div>
			<div class="col-xs-3">
			<button class="btn btn-outline rounded b-primary text-primary">Atualizar</button>
            </div>
  </form>
	</div>
</div>
<?php             
     if (empty($_GET['idFornecedor'])) {
           $idFornecedor = '20140206';
		   }else{             
           $idFornecedor = $_GET["idFornecedor"];
      }

      if (empty($_GET['periodo'])) {
        $periodo = '180';
      }else{             
        $periodo = $_GET["periodo"];
    }
    if (empty($_GET['uf'])) {
      $uf = 'RJ';
      }else{             
      $uf = $_GET["uf"];
      }
      ?>

<div class="padding">
    <?php include_once("include/estrutura/welcome.php"); ?>
    <div class="row">
	    <div class="col-md-12 col-xl-12">
	        <div class="box">
	          <div class="box-header">
	            <h3>INDICES POR PROBLEMA E UF <?php if ($idFornecedor=="20140206"){
                echo "MÓVEL";
              }
              elseif($idFornecedor=="20140206"){
                echo "  ";
              }
              else{
                echo "TODAS";
              }; 
              ?></h3>
	            <small>Baseado no resultado das reclamações finalizadas | Periodo: <?php echo $periodo;?> dias</small>
	          </div>
	          <div class=" b-t">
	            <div class="row-col">
                <div class="box">
                    <?php
                $sql = "SELECT *
                from tblproblema WHERE clienteId LIKE '".$idFornecedor."' and periodo = $periodo and uf LIKE '".$uf."'
                order by problema ASC";
                $result = mysqli_query($mysqli, $sql);
                        if(mysqli_num_rows($result) > 0){
                        date_default_timezone_set('America/Sao_Paulo');
                            $date = date('d');
        
       ?>
                    <table class="table table-striped b-t">
                    <thead>
                        <tr>
                        <th>PROBLEMA</th>
                        <th>UF</th>
                        <th>FINALIZADO AVALIADO</th>
                        <th>FINALIZADO NÃO AVALIADO</th>
                        <th>TOTAL FINALIZADOS</th>
                        <th>AVALIADO COMO RESOLVIDA</th>
                        <th>AVALIADO COMO NÃO RESOLVIDA</th>
                        <th>ÍNDICE DE SOLUÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                 <?php
                        while($row = mysqli_fetch_array($result)){
                            ?>
                        <tr>
                        <?php 
                        $FinResolvida = $row["resolvida"];
                        $FinaNaoAvaliada =  $row["finalizadaNaoAvaliada"];
                        $FinAvaliada = $row["finalizadaAvaliada"];
                        $FinalizadasTotal = $row["finalizadaNaoAvaliada"]+$row["finalizadaAvaliada"];
                        ?>
                        <td><?php echo $row["problema"]?></td>
                        <td><?php echo $row["uf"]?></td>
                        <td><?php echo $row["finalizadaAvaliada"]?></td>
                        <td><?php echo $row["finalizadaNaoAvaliada"]?></td>
                        <td><?php echo $FinalizadasTotal ?></td>
                        <td><?php echo $row["resolvida"]?></td>
                        <td><?php echo $row["naoResolvida"]?></td>
                        <td>
                          <?php
                          if ($FinalizadasTotal > 0):
                              $resultado = number_format( ($FinResolvida +$FinaNaoAvaliada )/($FinalizadasTotal)*100,0);
                            elseif ($FinalizadasTotal == 0): 
                              $resultado = "Sem dados";
                              else:
                              $resultado = 0;
                          endif;

                          if ($resultado > 85):
                                ?>
                                <span class="label label-lg primary pos-rlt m-r-xs"><b class="arrow left b-primary"></b><?php echo $resultado ?> % </span>
                                <?php
                            elseif ($resultado == "Sem dados"): 
                              ?>
                              <span class="label label-lg warning pos-rlt m-r-xs"><b class="arrow left b-warning"></b><?php echo $resultado ?></span>
                              <?php
                            else:
                              ?>
                              <span class="label label-lg danger pos-rlt m-r-xs"><b class="arrow left b-danger"></b><?php echo $resultado ?> % </span>
                              <?php
                          endif;  
                          ?>  
                        </td>
                        </tr>
                        <?php
                    }
                }
                
                    ?>    
                    </tbody>
                    </table>
      </div>
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

