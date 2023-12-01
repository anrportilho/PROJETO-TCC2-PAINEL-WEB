<div class="p-a white lt box-shadow">
	<div class="row">
		<div class="col-xs-3">
			<form action="dashboard.php" method="get" enctype="multipart/form-data">
		</div>
		<div class="col-xs-3">
			<select name="idFornecedor" class="form-control" required="required">
				<option value="">Selecione um departamento</option>
				<option value="20140206">Matriz</option>
			</select>
		</div>
		<div class="col-xs-3">
			<select name="ano" class="form-control" required="required">
				<option value="">Selecione o ano de referência</option>
				<option value="2023">2023</option>
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
	$ano = '2023';
} else {
	$idFornecedor = $_GET["idFornecedor"];
	$ano = $_GET["ano"];
}
?>
<div class="padding">
	<?php include_once("include/estrutura/welcome.php"); ?>
	<?php
	$sql1 = "SELECT * FROM tblresumo
						left JOIN
						tblentradasmes ON tblresumo.clienteId = tblentradasmes.clienteId
						left JOIN
						tblfinalizadasmes ON tblresumo.clienteId = tblfinalizadasmes.clienteId
						left JOIN
						tblemanalisefornecedor ON tblresumo.clienteId = tblemanalisefornecedor.clienteId
						left JOIN
						tblemanalisegestor ON tblresumo.clienteId = tblemanalisegestor.clienteId
						WHERE tblresumo.clienteId = $idFornecedor 
						AND tblresumo.ano = $ano
						AND tblentradasmes.ano = $ano 
						AND tblfinalizadasmes.ano = $ano 
						AND tblemanalisefornecedor.ano = $ano
						AND tblemanalisegestor.ano = $ano";
	$result1 = mysqli_query($mysqli, $sql1);
	if (mysqli_num_rows($result1) > 0) {
		date_default_timezone_set('America/Sao_Paulo');
		$date = date('d');
		while ($row1 = mysqli_fetch_array($result1)) {
	?>
			<div class="row">
				<div class="col-sm-12 col-md-5 col-lg-4">
					<div class="row">
						<div class="col-sm-6">
							<div class="box p-a black bg">
								<div class="pull-left m-r">
									<i class="fa fa-circle-o text-2x text-accent m-y-sm"></i>
								</div>
								<div class="clear">
									<div class="text-muted">Em Aberto | Ano atual</div>
									<h4 class="m-0 text-md _600"><a href><?php echo $row1["emAberto"] ?></a></h4>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="box p-a black bg">
								<div class="pull-left m-r">
									<i class="fa  fa-search text-2x text-accent m-y-sm"></i>
								</div>
								<div class="clear">
									<div class="text-muted">Em análise | Ano atual</div>
									<h4 class="m-0 text-md _600"><?php echo $row1["emAnaliseFornecedor"] ?></a></h4>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="box p-a black bg">
								<div class="pull-left m-r">
									<i class="fa fa-refresh text-2x text-accent m-y-sm"></i>
								</div>
								<div class="clear">
									<div class="text-muted">Em análise Gestor</div>
									<h4 class="m-0 text-md _600"><?php echo $row1["emAnaliseGestor"] ?></a></h4>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="box p-a black bg">
								<div class="pull-left m-r">
									<i class="fa  fa-share-square-o text-2x text-accent m-y-sm"></i>
								</div>
								<div class="clear">
									<div class="text-muted">Respondida</div>
									<h4 class="m-0 text-md _600"><?php echo $row1["respondida"] ?></a></h4>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="box p-a black bg">
								<div class="pull-left m-r">
									<i class="fa fa-square text-2x text-accent m-y-sm"></i>
								</div>
								<div class="clear">
									<div class="text-muted">Fin. Avaliada</div>
									<h4 class="m-0 text-md _600"><?php echo $row1["finalizadaAvaliada"] ?></a></h4>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="box p-a black bg">
								<div class="pull-left m-r">
									<i class="fa  fa-square-o text-2x text-accent m-y-sm"></i>
								</div>
								<div class="clear">
									<div class="text-muted">Fin. Não avaliada</div>
									<h4 class="m-0 text-md _600"><?php echo $row1["finalizadaNaoAvaliada"] ?></a></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-7 col-lg-8">
					<div class="row no-gutter box black bg">
						<div class="col-sm-8">
							<div class="box-header">
								<h3>Volume de reclamações registradas</h3>
								<small>Ano: <?php echo $ano ?></small>
							</div>
							<div class="box-body">
								<div ui-jp="plot" ui-refresh="app.setting.color" ui-options="
									[
										{ 
										data: [[1, <?php echo $row1["e1"] ?>], [2, <?php echo $row1["e2"] ?>], [3, <?php echo $row1["e3"] ?>], [4, <?php echo $row1["e4"] ?>], [5, <?php echo $row1["e5"] ?>], [6, <?php echo $row1["e6"] ?>], [7, <?php echo $row1["e7"] ?>], [8, <?php echo $row1["e8"] ?>],[9, <?php echo $row1["e9"] ?>], [10, <?php echo $row1["e10"] ?>], [11, <?php echo $row1["e11"] ?>], [12, <?php echo $row1["e12"] ?>]], 
										points: { show: true, radius: 0}, 
										splines: { show: false, tension: 0.45, lineWidth: 2, fill: 0 } 
										},
										
									], 
									{
								bars: { show: true, fill: true,  barWidth: 0.3, lineWidth: 1, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 1}] }, align: 'center' },
										colors: ['#0cc2aa','#fcc100'],
										series: { shadowSize: 3 },
										xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
										yaxis:{ show: true, font: { color: '#ccc' }},
										grid: { hoverable: true, clickable: true, borderWidth: 0, color: 'rgba(120,120,120,0.5)' },
										tooltip: true,
										tooltipOpts: { content: 'mês %x: %y reclamações',  defaultTheme: false, shifts: { x: 0, y: -40 } }
									}
									" style="height:162px">
								</div>
							</div>
						</div>

						<div class="col-sm-4 dker">
							<div class="box-header">
								<h3>Observação</h3>
							</div>
							<div class="box-body">
								<p class="text-muted">A base contém <?php echo $row1["totalEntrada"] ?> reclamações registradas no ano de <?php echo $ano ?>.</p>

							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">

				<div class="col-sm-12 col-md-5 col-lg-4">
					<div class="row">
						<div class="col-sm-6">
							<div class="box p-a black bg">
								<div class="pull-left m-r">
									<i class="fa fa-square text-2x text-accent m-y-sm"></i>
								</div>
								<div class="clear">
									<div class="text-muted">% Fin. Avaliada</div>
									<h4 class="m-0 text-md _600">
										<?php
											if (empty($row1["finalizadaAvaliada"])) {
												echo "0";
											} else {
												echo number_format((($row1["finalizadaAvaliada"]) / ($row1["finalizadaAvaliada"] + $row1["finalizadaNaoAvaliada"]) * 100));
											} 
										?>
									</a>%</h4>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="box p-a black bg">
								<div class="pull-left m-r">
									<i class="fa  fa-square-o text-2x text-accent m-y-sm"></i>
								</div>
								<div class="clear">
									<div class="text-muted">% Fin. Não avaliada</div>
									<h4 class="m-0 text-md _600">
										<?php
										if (empty($row1["finalizadaNaoAvaliada"])) {
											echo "0";
										} else {
											echo number_format((($row1["finalizadaNaoAvaliada"]) / ($row1["finalizadaAvaliada"] + $row1["finalizadaNaoAvaliada"]) * 100));
										}
										?></a>%</h4>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="box p-a black bg">
								<div class="pull-left m-r">
									<i class="fa fa-times text-2x text-accent m-y-sm"></i>
								</div>
								<div class="clear">
									<div class="text-muted">Cancelada</div>
									<h4 class="m-0 text-md _600"><?php echo $row1["cancelada"] ?></a></h4>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="box p-a black bg">
								<div class="pull-left m-r">
									<i class="fa fa-times-circle text-2x text-accent m-y-sm"></i>
								</div>
								<div class="clear">
									<div class="text-muted">Encerrada</div>
									<h4 class="m-0 text-md _600"><?php echo $row1["encerrada"] ?></a></h4>
								</div>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="row no-gutter box-color text-center black">
								<div class="col-sm-6 p-a black bg">
									Total de entradas <?php echo $ano ?>
									<h4 class="m-0 text-md _600"><a href><?php echo $row1["totalEntrada"] ?></a></h4>
								</div>
								<div class="col-sm-6 p-a dker black bg">
									Total de finalizadas <?php echo $ano ?>
									<h4 class="m-0 text-md _600"><a href><?php echo $row1["finalizadaNaoAvaliada"] + $row1["finalizadaAvaliada"] ?></a></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-7 col-lg-8">
					<div class="row no-gutter box black bg">
						<div class="col-sm-8">
							<div class="box-header">
								<h3>Volume de reclamações finalizadas</h3>
								<small>Ano: <?php echo $ano ?></small>
							</div>
							<div class="box-body">
								<div ui-jp="plot" ui-refresh="app.setting.color" ui-options="
								[
									{ 
									data: [[1, <?php echo $row1["f1"] ?>], [2, <?php echo $row1["f2"] ?>], [3, <?php echo $row1["f3"] ?>], [4, <?php echo $row1["f4"] ?>], [5, <?php echo $row1["f5"] ?>], [6, <?php echo $row1["f6"] ?>], [7, <?php echo $row1["f7"] ?>], [8, <?php echo $row1["f8"] ?>],[9, <?php echo $row1["f9"] ?>], [10, <?php echo $row1["f10"] ?>], [11, <?php echo $row1["f11"] ?>], [12, <?php echo $row1["f12"] ?>]], 
									points: { show: true, radius: 0}, 
									
									},
									
								], 
								{
							bars: { show: true, fill: true,  barWidth: 0.3, lineWidth: 1, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 1}] }, align: 'center' },
									colors: ['#fcc100'],
									series: { shadowSize: 3 },
									xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
									yaxis:{ show: true, font: { color: '#ccc' }},
									grid: { hoverable: true, clickable: true, borderWidth: 0, color: 'rgba(120,120,120,0.5)' },
									tooltip: true,
									tooltipOpts: { content: 'mês %x: %y reclamações',  defaultTheme: false, shifts: { x: 0, y: -40 } }
								}
								" style="height:162px">
								</div>
							</div>
						</div>

						<div class="col-sm-4 dker">
							<div class="box-header">
								<h3>Observação</h3>
							</div>
							<div class="box-body">
								<p class="text-muted"><strong>Total de Reclamações Finalizadas:</strong> Corresponde ao total de reclamações que já tiveram os prazos de resposta da empresa e de avaliação do consumidor finalizados (Finalizada Avaliada e Finalizada Não Avaliada)</p>

							</div>
						</div>

					</div>
				</div>
			</div>
	<?php
		}
	} else {
		echo "Selecione o departamento e o ano ou aguarde o carregamento dos dados no sistema.";
	}


	?>
	<!-- ############ INDICES DE SOLUÇÃO-->
	<?php

	$sql1 = "SELECT * from tblindicedesolucao WHERE clienteId = $idFornecedor AND periodo = '30'";

	$result1 = mysqli_query($mysqli, $sql1);
	if (mysqli_num_rows($result1) > 0) {
		date_default_timezone_set('America/Sao_Paulo');
		$date = date('d');
		while ($row1 = mysqli_fetch_array($result1)) {
	?>
			<div class="row">
				<div class="col-sm-6 col-md-4 col-lg-3">
					<div class="box p-a black">
						<div class="pull-left m-r">
							<span class="w-40 warn text-center rounded">
								<i class="material-icons">thumb_up</i>
							</span>
						</div>
						<div class="clear">
							<h4 class="m-0 text-md"><a href>
									<?php

									if (empty($row1["resolvida"] + $row1["finalizadaNaoAvaliada"])) {
										echo "0";
									} else {
										echo number_format(($row1["resolvida"] + $row1["finalizadaNaoAvaliada"]) / ($row1["finalizadaNaoAvaliada"] + $row1["finalizadaAvaliada"]) * 100, 1);
									}
									?>%<span class="text-sm"> ÍNDICE DE SOLUÇÃO</span></a></h4>
							<small class="text-muted">Período: 30 dias | Ano atual</small>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-4 col-lg-3">
					<div class="box p-a black">
						<div class="pull-left m-r">
							<span class="w-40 warn text-center rounded">
								<i class="material-icons">favorite_border</i>
							</span>
						</div>
						<div class="clear">
							<?php
							if (empty($row1["nota1"])) {
							?>
								<h4 class="m-0 text-md"><a href><?php echo "0"; ?><span class="text-sm"> NOTA DE SATISFAÇÃO</span></a></h4>
							<?php
							} else {
								$nota1 = $row1["nota1"];
								$nota2 = $row1["nota2"];
								$nota3 = $row1["nota3"];
								$nota4 = $row1["nota4"];
								$nota5 = $row1["nota5"];
								$nota =
									number_format(($nota1 * 1 + $nota2 * 2 + $nota3 * 3 + $nota4 * 4 + $nota5 * 5) / ($nota1 + $nota2 + $nota3 + $nota4 + $nota5), 1);

							?>
								<h4 class="m-0 text-md"><a href><?php echo $nota; ?><span class="text-sm"> NOTA DE SATISFAÇÃO</span></a></h4>
							<?php
							}
							?>
							<small class="text-muted">Nota 1 a 5 | Período: 30 dias | Ano atual</small>
						</div>
					</div>
				</div>


		<?php
		}
	}
		?>
		<?php

		$sql1 = "SELECT * from tblindicedesolucao WHERE clienteId = $idFornecedor AND periodo = '7'";

		$result1 = mysqli_query($mysqli, $sql1);
		if (mysqli_num_rows($result1) > 0) {
			date_default_timezone_set('America/Sao_Paulo');
			$date = date('d');
			while ($row1 = mysqli_fetch_array($result1)) {
		?>
				<div class="col-sm-6 col-md-4 col-lg-3">
					<div class="box p-a black">
						<div class="pull-left m-r">
							<span class="w-40 warn text-center rounded">
								<i class="material-icons">thumb_up</i>
							</span>
						</div>
						<div class="clear">
							<h4 class="m-0 text-md"><a href>
									<?php

									if (empty($row1["resolvida"] + $row1["finalizadaNaoAvaliada"])) {
										echo "0";
									} else {
										echo number_format(($row1["resolvida"] + $row1["finalizadaNaoAvaliada"]) / ($row1["finalizadaNaoAvaliada"] + $row1["finalizadaAvaliada"]) * 100, 1);
									}
									?>%<span class="text-sm"> ÍNDICE DE SOLUÇÃO</span></a></h4>
							<small class="text-muted">Período: 7 dias | Ano atual</small>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-4 col-lg-3">
					<div class="box p-a black">
						<div class="pull-left m-r">
							<span class="w-40 warn text-center rounded">
								<i class="material-icons">favorite_border</i>
							</span>
						</div>
						<div class="clear">
							<?php
							if (empty($row1["nota1"])) {
							?>
								<h4 class="m-0 text-md"><a href><?php echo "0"; ?><span class="text-sm"> NOTA DE SATISFAÇÃO</span></a></h4>
							<?php
							} else {
								$nota1 = $row1["nota1"];
								$nota2 = $row1["nota2"];
								$nota3 = $row1["nota3"];
								$nota4 = $row1["nota4"];
								$nota5 = $row1["nota5"];
								$nota =
									number_format(($nota1 * 1 + $nota2 * 2 + $nota3 * 3 + $nota4 * 4 + $nota5 * 5) / ($nota1 + $nota2 + $nota3 + $nota4 + $nota5), 1);

							?>
								<h4 class="m-0 text-md"><a href><?php echo $nota; ?><span class="text-sm"> NOTA DE SATISFAÇÃO</span></a></h4>
							<?php
							}
							?>
							<small class="text-muted">Nota 1 a 5 | Período: 7 dias | Ano atual</small>
						</div>
					</div>
				</div>
		<?php
			}
		}

		?>
			</div>
			<?php
			$sql1 = "SELECT * FROM tblentradasdiaria WHERE ano = $ano and clienteId = 20140206";

			$result1 = mysqli_query($mysqli, $sql1);
			if (mysqli_num_rows($result1) > 0) {
				date_default_timezone_set('America/Sao_Paulo');
				$date = date('d');

			?>

				<div class="row">

					<div class="col-sm-12 ">
						<div class="box black bg">
							<div class="box-header">
								<h3>ENTRADAS DIÁRIAS POR DEPARTAMENTO</h3>
								<small class="block text-muted">Mês atual | Ano <?php echo $ano; ?></small>
							</div>
							<div class="box-body">
								<div ui-jp="chart" ui-options="{
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:['Matriz']
                },
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : false,
                        data : ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31']
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                grid : {
                  x2 : 10
                },
                series : [

					<?php


					while ($row1 = mysqli_fetch_array($result1)) {

					?>
							
                    {
                        name:'Matriz',
                        type:'line',
                        stack: 'total',
                        data:[<?php if ($row1["dia1"] > 0) {
									echo $row1["dia1"];
								} else {
									echo "";
								} ?>, <?php if ($row1["dia2"] > 0) {
											echo $row1["dia2"];
										} else {
											echo "";
										} ?>, <?php if ($row1["dia3"] > 0) {
													echo $row1["dia3"];
												} else {
													echo "";
												} ?>, <?php if ($row1["dia4"] > 0) {
															echo $row1["dia4"];
														} else {
															echo "";
														} ?>, <?php if ($row1["dia5"] > 0) {
																	echo $row1["dia5"];
																} else {
																	echo "";
																} ?>, <?php if ($row1["dia6"] > 0) {
																			echo $row1["dia6"];
																		} else {
																			echo "";
																		} ?>, <?php if ($row1["dia7"] > 0) {
																					echo $row1["dia7"];
																				} else {
																					echo "";
																				} ?>, <?php if ($row1["dia8"] > 0) {
																							echo $row1["dia8"];
																						} else {
																							echo "";
																						} ?>, <?php if ($row1["dia9"] > 0) {
																									echo $row1["dia9"];
																								} else {
																									echo "";
																								} ?>, <?php if ($row1["dia10"] > 0) {
																											echo $row1["dia10"];
																										} else {
																											echo "";
																										} ?>,
						<?php if ($row1["dia11"] > 0) {
							echo $row1["dia11"];
						} else {
							echo "";
						} ?>, <?php if ($row1["dia12"] > 0) {
										echo $row1["dia12"];
									} else {
										echo "";
									} ?>, <?php if ($row1["dia13"] > 0) {
												echo $row1["dia13"];
											} else {
												echo "";
											} ?>, <?php if ($row1["dia14"] > 0) {
														echo $row1["dia14"];
													} else {
														echo "";
													} ?>, <?php if ($row1["dia15"] > 0) {
																echo $row1["dia15"];
															} else {
																echo "";
															} ?>, <?php if ($row1["dia16"] > 0) {
																		echo $row1["dia16"];
																	} else {
																		echo "";
																	} ?>, <?php if ($row1["dia17"] > 0) {
																				echo $row1["dia17"];
																			} else {
																				echo "";
																			} ?>, <?php if ($row1["dia18"] > 0) {
																						echo $row1["dia18"];
																					} else {
																						echo "";
																					} ?>, <?php if ($row1["dia19"] > 0) {
																								echo $row1["dia19"];
																							} else {
																								echo "";
																							} ?>, <?php if ($row1["dia20"] > 0) {
																										echo $row1["dia20"];
																									} else {
																										echo "";
																									} ?>,
						<?php if ($row1["dia21"] > 0) {
							echo $row1["dia21"];
						} else {
							echo "";
						} ?>, <?php if ($row1["dia22"] > 0) {
										echo $row1["dia22"];
									} else {
										echo "";
									} ?>, <?php if ($row1["dia23"] > 0) {
												echo $row1["dia23"];
											} else {
												echo "";
											} ?>, <?php if ($row1["dia24"] > 0) {
														echo $row1["dia24"];
													} else {
														echo "";
													} ?>, <?php if ($row1["dia25"] > 0) {
																echo $row1["dia25"];
															} else {
																echo "";
															} ?>, <?php if ($row1["dia26"] > 0) {
																		echo $row1["dia26"];
																	} else {
																		echo "";
																	} ?>, <?php if ($row1["dia27"] > 0) {
																				echo $row1["dia27"];
																			} else {
																				echo "";
																			} ?>, <?php if ($row1["dia28"] > 0) {
																						echo $row1["dia28"];
																					} else {
																						echo "";
																					} ?>, <?php if ($row1["dia29"] > 0) {
																								echo $row1["dia29"];
																							} else {
																								echo "";
																							} ?>, <?php if ($row1["dia30"] > 0) {
																										echo $row1["dia30"];
																									} else {
																										echo "";
																									} ?>, <?php if ($row1["dia31"] > 0) {
																										echo $row1["dia31"];
																									} else {
																										echo "";
																									} ?>]
                    },
					
                    
                    
                    
                    
                ]
            }" style="height:300px">
							<?php
						}
					} else {
						echo "";
					}

							?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				$sql1 = "SELECT * FROM tblresumo

							inner JOIN
							tblemanalisefornecedor ON tblresumo.clienteId = tblemanalisefornecedor.clienteId
							inner JOIN
							tblemanalisegestor ON tblresumo.clienteId = tblemanalisegestor.clienteId
							inner JOIN
							tblfinalizadasavaliadasmes ON tblresumo.clienteId = tblfinalizadasavaliadasmes.clienteId

							WHERE tblresumo.clienteId = $idFornecedor
							AND tblresumo.ano = $ano
							AND tblemanalisefornecedor.ano = $ano
							AND tblemanalisegestor.ano = $ano
							AND tblfinalizadasavaliadasmes.ano = $ano";

				$result1 = mysqli_query($mysqli, $sql1);
				if (mysqli_num_rows($result1) > 0) {
					date_default_timezone_set('America/Sao_Paulo');
					$date = date('d');
					while ($row1 = mysqli_fetch_array($result1)) {
				?>
						<div class="row">
							<div class="col-sm-12 col-md-6 col-lg-4">
								<div class="row no-gutter box light bg">
									<div class="col-sm-12">
										<div class="box-header">
											<h3>EM ANALISE PELO FORNECEDOR </h3>
											<small>Prazo expirando nos próximos 12 dias.</small>
										</div>
										<div class="box-body">
											<div ui-jp="plot" ui-refresh="app.setting.color" ui-options="
																	[
																		{ 
																		data: [[0,  <?php echo $row1["fo1"] ?>], [1, <?php echo $row1["fo2"] ?>], [2, <?php echo $row1["fo3"] ?>], [3, <?php echo $row1["fo4"] ?>], [4, <?php echo $row1["fo5"] ?>], [5, <?php echo $row1["fo6"] ?>], [6, <?php echo $row1["fo7"] ?>], [7, <?php echo $row1["fo8"] ?>], [8, <?php echo $row1["fo9"] ?>], [9, <?php echo $row1["fo10"] ?>], [10, <?php echo $row1["fo11"] ?>], [11, <?php echo $row1["fo12"] ?>]], 
																		points: { show: true, radius: 0}, 
																		splines: { show: false, tension: 0.45, lineWidth: 2, fill: 0 } 
																		},
																		
																	], 
																	{
																bars: { show: true, fill: true,  barWidth: 0.3, lineWidth: 1, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 1}] }, align: 'center' },
																		colors: ['#0cc2aa','#0cc2aa'],
																		series: { shadowSize: 3 },
																		xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
																		yaxis:{ show: true, font: { color: '#ccc' }},
																		grid: { hoverable: true, clickable: true, borderWidth: 0, color: 'rgba(120,120,120,0.5)' },
																		tooltip: true,
																		tooltipOpts: { content: 'Em %x dias: %y reclamações',  defaultTheme: false, shifts: { x: 0, y: -40 } }
																	}
																	" style="height:162px">
											</div>
										</div>
									</div>

								</div>
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4">
								<div class="row no-gutter box light bg">
									<div class="col-sm-12">
										<div class="box-header">
											<h3>EM ANÁLISE PELO PELO GESTOR</h3>
											<small>Prazo expirando nos próximos 12 dias.</small>
										</div>
										<div class="box-body">
											<div ui-jp="plot" ui-refresh="app.setting.color" ui-options="
																[
																	{ 
																	data: [[0, <?php echo $row1["g1"] ?>], [1, <?php echo $row1["g2"] ?>], [2, <?php echo $row1["g3"] ?>], [3, <?php echo $row1["g4"] ?>], [4, <?php echo $row1["g5"] ?>], [5, <?php echo $row1["g6"] ?>], [6, <?php echo $row1["g7"] ?>], [7, <?php echo $row1["g8"] ?>], [8, <?php echo $row1["g9"] ?>], [9, <?php echo $row1["g10"] ?>], [10, <?php echo $row1["g11"] ?>], [11, <?php echo $row1["g12"] ?>]], 
																	points: { show: true, radius: 0}, 
																	splines: { show: false, tension: 0.45, lineWidth: 2, fill: 0 } 
																	},
																	
																], 
																{
															bars: { show: true, fill: true,  barWidth: 0.3, lineWidth: 1, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 1}] }, align: 'center' },
																	colors: ['#0cc2aa','#0cc2aa'],
																	series: { shadowSize: 3 },
																	xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
																	yaxis:{ show: true, font: { color: '#ccc' }},
																	grid: { hoverable: true, clickable: true, borderWidth: 0, color: 'rgba(120,120,120,0.5)' },
																	tooltip: true,
																	tooltipOpts: { content: 'Em %x dias: %y reclamações',  defaultTheme: false, shifts: { x: 0, y: -40 } }
																}
																" style="height:162px">
											</div>
										</div>
									</div>

								</div>
							</div>

							<div class="col-sm-12 col-md-6 col-lg-4">
								<div class="row no-gutter box light bg">
									<div class="col-sm-12">
										<div class="box-header">
											<h3>FINALIZADAS AVALIADAS POR MÊS</h3>
											<small>Ano: <?php echo $ano ?></small>
										</div>
										<div class="box-body">
											<div ui-jp="plot" ui-refresh="app.setting.color" ui-options="
			              [
			                { 
			                  data: [[1, <?php echo $row1["fa1"] ?>], [2, <?php echo $row1["fa2"] ?>], [3, <?php echo $row1["fa3"] ?>], [4, <?php echo $row1["fa4"] ?>], [5, <?php echo $row1["fa5"] ?>], [6, <?php echo $row1["fa6"] ?>], [7, <?php echo $row1["fa7"] ?>], [8, <?php echo $row1["fa8"] ?>],[9, <?php echo $row1["fa9"] ?>], [10, <?php echo $row1["fa10"] ?>], [11, <?php echo $row1["fa11"] ?>], [12, <?php echo $row1["fa12"] ?>]], 
			                  points: { show: true, radius: 0}, 
			                  splines: { show: false, tension: 0.45, lineWidth: 2, fill: 0 } 
			                },
			                
			              ], 
			              {
                      bars: { show: true, fill: true,  barWidth: 0.3, lineWidth: 1, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 1}] }, align: 'center' },
			                colors: ['#A9A9A9'],
			                series: { shadowSize: 3 },
			                xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
			                yaxis:{ show: true, font: { color: '#ccc' }},
			                grid: { hoverable: true, clickable: true, borderWidth: 0, color: 'rgba(120,120,120,0.5)' },
			                tooltip: true,
			                tooltipOpts: { content: 'No mês %x: %y avaliadas',  defaultTheme: false, shifts: { x: 0, y: -40 } }
			              }
			            " style="height:162px">
											</div>
										</div>
									</div>

								</div>
							</div>

						</div>

				<?php
					}
				}

				?>





				<?php

				$sql1 = "SELECT * from tblindicedesolucao WHERE clienteId = $idFornecedor AND periodo = '7'";

				$result1 = mysqli_query($mysqli, $sql1);
				if (mysqli_num_rows($result1) > 0) {
					date_default_timezone_set('America/Sao_Paulo');
					$date = date('d');
		

					while ($row1 = mysqli_fetch_array($result1)) {

				?>


						<div class="row">
							<div class="col-md-12 col-xl-4">
								<div class="box">
									<div class="box-header">
										<h3>RESULTADO DAS AVALIAÇÕES</h3>
										<small>Periodo: Últimos 7 dias.</small>
									</div>
									<div class="box-tool">
										<ul class="nav">
											<li class="nav-item inline">
												<a class="nav-link">
													<i class="material-icons md-18">&#xe863;</i>
												</a>
											</li>
											<li class="nav-item inline dropdown">
												<a class="nav-link" data-toggle="dropdown">
													<i class="material-icons md-18">&#xe5d4;</i>
												</a>

											</li>
										</ul>
									</div>
									<div class="text-center b-t">
										<div class="row-col">
											<div class="row-cell p-a">
												<div class="inline m-b">
													<div ui-jp="easyPieChart" class="easyPieChart" ui-refresh="app.setting.color" data-redraw='true' data-percent="
																
																<?php
																if (empty($row1["resolvida"])) {
																	echo "0";
																} else {
																	echo number_format($row1["resolvida"] / $row1["finalizadaAvaliada"] * 100, 0);
																} ?>" ui-options="{
																	lineWidth: 8,
																	trackColor: 'rgba(0,0,0,0.05)',
																	barColor: '#0cc2aa',
																	scaleColor: 'transparent',
																	size: 100,
																	scaleLength: 0,
																	animate:{
																		duration: 3000,
																		enabled:true
																	}
																	}">
														<div>
															<h5><?php
																if (empty($row1["resolvida"])) {
																	echo "0";
																} else {
																	echo number_format($row1["resolvida"] / $row1["finalizadaAvaliada"] * 100, 0);
																} ?>%</h5>
														</div>
													</div>
												</div>
												<div>
													Resolvida
													<small class="block m-b"><?php
																				if (empty($row1["resolvida"])) {
																					echo "0";
																				} else {
																					echo $row1["resolvida"];
																				} ?></small>
													<a href class="btn btn-sm white rounded">Ver detalhes</a>
												</div>
											</div>
											<div class="row-cell p-a dker">
												<div class="inline m-b">
													<div ui-jp="easyPieChart" class="easyPieChart" ui-refresh="app.setting.color" data-redraw='true' data-percent="
																<?php
																if (empty($row1["naoresolvida"])) {
																	echo "0";
																} else {
																	echo number_format($row1["naoresolvida"] / $row1["finalizadaAvaliada"] * 100, 0);
																} ?>" ui-options="{
																		lineWidth: 8,
																		trackColor: 'rgba(0,0,0,0.05)',
																		barColor: '#fcc100',
																		scaleColor: 'transparent',
																		size: 100,
																		scaleLength: 0,
																		animate:{
																			duration: 3000,
																			enabled:true
																		}
																		}">
														<div>
															<h5><?php
																if (empty($row1["naoresolvida"])) {
																	echo "0";
																} else {
																	echo number_format($row1["naoresolvida"] / $row1["finalizadaAvaliada"] * 100, 0);
																} ?>%</h5>
														</div>
													</div>
												</div>
												<div>
													Não resolvida
													<small class="block m-b"><?php if (empty($row1["naoresolvida"])) {
																					echo "0";
																				} else {
																					echo $row1["naoresolvida"];
																				} ?></small>
													<a href class="btn btn-sm white rounded">Ver detalhes</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-md-4">
								<div class="box">
									<div class="box-header">
										<h3>QUANTIDADE DE AVALIAÇÕES POR NOTA</h3>
										<small>Nota 1 a 5 de satisfação | Periodo: Últimos 7 dias.</small>
									</div>
									<div class="box-body">
										<div ui-jp="plot" ui-refresh="app.setting.color" ui-options="
              [
                { data: [[<?php echo $row1["nota1"] ?>, 1], [<?php echo $row1["nota2"] ?>, 2], [<?php echo $row1["nota3"] ?>, 3], [<?php echo $row1["nota4"] ?>, 4], [<?php echo $row1["nota5"] ?>, 5]] }
              ], 
              {
                bars: { horizontal: true, show: true, fill: true,  barWidth: 0.3, lineWidth: 1, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 1}] }, align: 'center' },
                colors: ['#A9A9A9'],
                series: { shadowSize: 3 },
                xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
                yaxis:{ show: true, font: { color: '#ccc' }},
                grid: { hoverable: true, clickable: true, borderWidth: 0, color: 'rgba(120,120,120,0.5)' },
                tooltip: true,
                tooltipOpts: { content: '%x clientes avaliaram com nota %y',  defaultTheme: false, shifts: { x: 0, y: -40 } }
              }
            " style="height:200px">
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-6 col-md-4">
								<div class="box">
									<div class="box-header">
										<h3>% DE AVALIAÇÕES POR NOTA</h3>
										<small>Nota 1 a 5 de satisfação | Periodo: Últimos 7 dias.</small>
									</div>
									<div class="box-body">
										<div ui-jp="plot" ui-refresh="app.setting.color" ui-options="
              [
                { data: [[<?php
							if (empty($row1["nota1"])) {
								echo "0";
							} else {
								echo number_format($row1["nota1"] / $row1["finalizadaAvaliada"] * 100, 2);
							} ?>, 1], [<?php
												if (empty($row1["nota2"])) {
													echo "0";
												} else {
													echo number_format($row1["nota2"] / $row1["finalizadaAvaliada"] * 100, 2);
												} ?>, 2], [<?php
															if (empty($row1["nota3"])) {
																echo "0";
															} else {
																echo number_format($row1["nota3"] / $row1["finalizadaAvaliada"] * 100, 2);
															} ?>, 3], [<?php
																		if (empty($row1["nota4"])) {
																			echo "0";
																		} else {
																			echo number_format($row1["nota4"] / $row1["finalizadaAvaliada"] * 100, 2);
																		} ?>, 4], [<?php
																					if (empty($row1["nota5"])) {
																						echo "0";
																					} else {
																						echo number_format($row1["nota5"] / $row1["finalizadaAvaliada"] * 100, 2);
																					} ?>, 5]] }
              ], 
              {
                bars: { horizontal: true, show: true, fill: true,  barWidth: 0.3, lineWidth: 1, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 1}] }, align: 'center' },
                colors: ['#A9A9A9'],
                series: { shadowSize: 3 },
                xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
                yaxis:{ show: true, font: { color: '#ccc' }},
                grid: { hoverable: true, clickable: true, borderWidth: 0, color: 'rgba(120,120,120,0.5)' },
                tooltip: true,
                tooltipOpts: { content: '%x% dos clientes avaliaram com nota %y',  defaultTheme: false, shifts: { x: 0, y: -40 } }
              }
            " style="height:200px">
										</div>
									</div>
								</div>
							</div>





						</div>
				<?php
					}
				}

				?>
</div>
