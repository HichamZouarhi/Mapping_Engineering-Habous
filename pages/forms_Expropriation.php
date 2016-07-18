<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Prototype Habous - add exportation form</title>

	<!-- Bootstrap Core CSS -->
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../dist/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<!-- MetisMenu CSS -->
	<link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

	<!-- DataTables CSS -->
	<link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

	<!-- DataTables Responsive CSS -->
	<link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="../dist/css/sb-admin-2.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- jQuery -->
	<script src="../bower_components/jquery/dist/jquery.min.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<!-- Metis Menu Plugin JavaScript -->
	<script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

	<!-- DataTables JavaScript -->
	<script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>

	<!-- Datetimepicker javascript -->
	<script type="text/javascript" src="../js/Moment.js"></script>
	<script type="text/javascript" src="../js/bootstrap-datetimepicker.js"></script>

</head>

<body>

	<div id="wrapper">
		<?php session_start();?>
		<!-- Navigation -->
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">MHAI-DH</a>
			</div>
			<!-- /.navbar-header -->

			<ul class="nav navbar-top-links navbar-right">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-alerts">
						<?php 
							$conn=pg_connect("host=localhost port=5432 dbname=MHAI_DH user=postgres password=P0stgres");
							if (!$conn){
								die('Error: Could not connect: ' . pg_last_error());
							}
							$result = pg_query($conn, "SELECT table_op, description, to_char(time, 'HH12:MI AM') as time_log from operation");
							if (!$result) {
								die("An error occurred." . pg_last_error());
							}
							$i = 0;
							while ($row = pg_fetch_row($result)){
								$description=pg_fetch_result($result,$i,'description');
								$time=pg_fetch_result($result,$i,'time_log');
								$table_op=pg_fetch_result($result,$i,'table_op');
								$i = $i + 1;
								if($table_op=="expropriation"){
									echo '<li>'
										.'<a href="#">'
											.'<div>'
												.'<i class="fa fa-folder-open fa-fw"></i> '.$description
												.'<span class="pull-right text-muted small">'.$time.'</em>'
												.'</span>'
											.'</div>'
										.'</a>'
										.'</li>'
									.'<li class="divider"></li>';
								}
								if($table_op=="terrain"){
									echo '<li>'
										.'<a href="#">'
											.'<div>'
												.'<i class="fa fa-map-marker fa-fw"></i> '.$description
												.'<span class="pull-right text-muted small">'.$time.'</em>'
												.'</span>'
											.'</div>'
										.'</a>'
										.'</li>'
									.'<li class="divider"></li>';
								}
								if($table_op=="ribaa"){
									echo '<li>'
										.'<a href="#">'
											.'<div>'
												.'<i class="fa fa-key fa-fw"></i> '.$description
												.'<span class="pull-right text-muted small">'.$time.'</em>'
												.'</span>'
											.'</div>'
										.'</a>'
										.'</li>'
									.'<li class="divider"></li>';
								}
								if($table_op=="exploitation_terrain" || $table_op=="exploitation_ribaa"){
									echo '<li>'
										.'<a href="#">'
											.'<div>'
												.'<i class="fa fa-file-text fa-fw"></i> '.$description
												.'<span class="pull-right text-muted small">'.$time.'</em>'
												.'</span>'
											.'</div>'
										.'</a>'
										.'</li>'
									.'<li class="divider"></li>';
								}
							}
							pg_close($conn);
							?>
						<li>
							<a class="text-center" href="#" data-toggle="modal" data-target="#Log_Modal">
								<strong>See All Alerts</strong>
								<i class="fa fa-angle-right"></i>
							</a>
						</li>
					</ul>
					<!-- /.dropdown-alerts -->
				</li>
				<!-- /.dropdown -->
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="#"><i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['userName']; ?></a>
						</li>
						<li><a href="#"><i class="fa fa-gear fa-fw"></i> <?php echo $_SESSION['userFunction']; ?></a>
						</li>
						<li class="divider"></li>
						<li><a id="logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
						</li>
					</ul>
					<!-- /.dropdown-user -->
				</li>
				<!-- /.dropdown -->
			</ul>
			<!-- /.navbar-top-links -->

			<div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
						<li>
							<a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
						</li>
						<li>
							<a href="#"><i class="fa fa-folder-open fa-fw"></i> Expropriations<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="tables_Expropriation.php"><i class="fa fa-table fa-fw"></i> Données éxistantes</a>
								</li>
								<li>
									<a href="forms_Expropriation.php"><i class="fa fa-edit fa-fw"></i> Ajouter expropriation</a>
								</li>
							</ul>
							<!-- /.nav-second-level -->
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text fa-fw"></i> Exploitations<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="#"><i class="fa fa-map-marker fa-fw"></i> Terrains <span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="tables_Exploitation_Terrain.php"><i class="fa fa-table fa-fw"></i> Données éxistantes</a>
										</li>
										<li>
											<a href="forms_Exploitation_Terrain.php"><i class="fa fa-edit fa-fw"></i> Ajouter éxploitation</a>
										</li>
									</ul>
									<!-- /.nav-third-level -->
								</li>
								<li>
									<a href="#"><i class="fa fa-key fa-fw"></i> Ribaa <span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="tables_Exploitation_Ribaa.php"><i class="fa fa-table fa-fw"></i> Données éxistantes</a>
										</li>
										<li>
											<a href="forms_Exploitation_Ribaa.php"><i class="fa fa-edit fa-fw"></i> Ajouter éxploitation</a>
										</li>
									</ul>
									<!-- /.nav-third-level -->
								</li>
							</ul>
							<!-- /.nav-second-level -->
						</li>
						<li>
							<a href="#"><i class="fa fa-location-arrow fa-fw"></i> La carte<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="map_Terrain.php"><i class="fa fa-map-marker fa-fw"></i> Terrains</a>
								</li>
								<li>
									<a href="map_Ribaa.php"><i class="fa fa-key fa-fw"></i> Ribaa</a>
								</li>
							</ul>
							<!-- /.nav-second-level -->
						</li>
					</ul>
				</div>
				<!-- /.sidebar-collapse -->
			</div>
			<!-- /.navbar-static-side -->
		</nav>

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Edition des expropriations</h1>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
			<div class="row">
				<div class="col-lg-7">
					<div class="panel panel-default">
						<div class="panel-heading">
							Ajouter une expropriation
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<form role="form">
					<div class="form-group">
												<label>Identifiant de l'expropriation</label>
												<input class="form-control" id="ID" type="text" placeholder="ID est attribué automatiquement" disabled>
										</div>

						<div class="form-group">
						<label>Date de correspondance</label>
								<div class='input-group date' id='datetimepicker1'>
									<input id='Date_Correspondance' name='Date_Correspondance' type='text' class="form-control" />
									<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
						</div>
										<div class="form-group">
						<label>Numéro du bulletin officiel</label>
											<input id='Num_BO' name='Num_BO' class="form-control" placeholder="Enter text">
										</div>
										<div class="form-group">
						<label>Date du bulletin officiel</label>
								<div class='input-group date' id='datetimepicker2'>
									<input id='Date_BO' name='Date_BO' type='text' class="form-control" />
									<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
						</div>
										<div class="form-group">
						<label>Description de l'exproptiation</label>
											<textarea id='Description' name='Description' class="form-control" rows="3"></textarea>
										</div>										
										<input id="Add_Expropriation" type="submit" class="btn btn-default" value="Valider">
										<input type="reset" class="btn btn-default" value="Annuler">
									</form>
								</div>
								
								<!-- /.col-lg-6 (nested) -->
							</div>
							<!-- /.row (nested) -->
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /#page-wrapper -->
	<div class="modal fade" id="Log_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Opérations récentes</h4>
					</div>
					<div class="modal-body">
						<div class="dataTable_wrapper">
							<?php 
								$conn=pg_connect("host=localhost port=5432 dbname=MHAI_DH user=postgres password=P0stgres");
								if (!$conn){
									die('Error: Could not connect: ' . pg_last_error());
								}
								$result = pg_query($conn, "SELECT a.id, a.description, to_char(time, 'YYYY-MM-DD HH12:MM AM') as time_log, a.entite_id, b.nom, b.prenom from operation as a, utilisateur as b where a.utilisateur_id=b.id");
								if (!$result) {
									die("An error occurred." . pg_last_error());
								}
								$i = 0;
							?>
							<table class="table table-striped table-bordered table-hover" style="width:100%;" id="dataTable_logs">
								<thead>
									<tr>
										<th>Identifiant</th>
										<th>Description</th>
										<th>Temps</th>
										<th>Entité</th>
										<th>Nom</th>
										<th>Prénom</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$i = 0;
										while ($row = pg_fetch_row($result)){
											echo '<tr class="gradeA">';
											$count = count($row);
											$y = 0;
											while ($y < $count){
												$c_row = current($row);
												echo '<td>' . $c_row . '</td>';
												next($row);
												$y = $y + 1;
											}
											echo '</tr>';
											$i = $i + 1;
										}
										pg_free_result($result);
										pg_close($conn);
									?>
								</tbody>
							</table>
						</div>
						<!-- /.table-responsive -->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
		<!-- /.modal-dialog -->
		</div>

	</div>
	<!-- /#wrapper -->

<script type="text/javascript">

	$('#dataTable_logs').DataTable({
		responsive: true,
		"columnDefs": [
			{
				"targets": [ 0 ],
				"visible": false
			}
		]
	});

	$('#datetimepicker1').datetimepicker({
		format : 'YYYY-MM-DD'
	});
	$('#datetimepicker2').datetimepicker({
		format : 'YYYY-MM-DD',
		useCurrent: false //Important! See issue #1075
	});
	$("#datetimepicker1").on("dp.change", function (e) {
		$('#datetimepicker2').data("DateTimePicker").minDate(e.date);
	});
	$("#datetimepicker2").on("dp.change", function (e) {
		$('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
	});
	$("#Add_Expropriation").click(function(e){
		e.preventDefault();
		$.ajax({
			url: 'php_scripts/addExpropriation.php',
			type: 'POST',
			data: {
				Date_Correspondance: $('#Date_Correspondance').val(),
				Num_BO: $('#Num_BO').val(),
				Date_BO: $('#Date_BO').val(),
				Description: $('#Description').val()
			},
			success:function(response){
				alert("Expropriation insérée dans la base de données");
				window.location.reload();
			}
		});
	});
	
	$('#logout').click(function(){
		$.ajax({
			url: 'php_scripts/Logout.php',
			type: 'POST',
			success:function(response){
				window.location="login.html";
			}
		});
	});
	
</script>
   
</body>

</html>
