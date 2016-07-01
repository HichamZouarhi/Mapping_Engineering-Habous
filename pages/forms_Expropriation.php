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

	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>

	<!-- Datetimepicker javascript -->
	<script type="text/javascript" src="../js/Moment.js"></script>
	<script type="text/javascript" src="../js/bootstrap-datetimepicker.js"></script>

</head>

<body>

	<div id="wrapper">
		<?php session_start(); ?>
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
						<li>
							<a href="#">
								<div>
									<i class="fa fa-comment fa-fw"></i> New Comment
									<span class="pull-right text-muted small">4 minutes ago</span>
								</div>
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="#">
								<div>
									<i class="fa fa-twitter fa-fw"></i> 3 New Followers
									<span class="pull-right text-muted small">12 minutes ago</span>
								</div>
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="#">
								<div>
									<i class="fa fa-envelope fa-fw"></i> Message Sent
									<span class="pull-right text-muted small">4 minutes ago</span>
								</div>
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="#">
								<div>
									<i class="fa fa-tasks fa-fw"></i> New Task
									<span class="pull-right text-muted small">4 minutes ago</span>
								</div>
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="#">
								<div>
									<i class="fa fa-upload fa-fw"></i> Server Rebooted
									<span class="pull-right text-muted small">4 minutes ago</span>
								</div>
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a class="text-center" href="#">
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
						<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
						</li>
						<li class="divider"></li>
						<li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
									<a href="map_Terrain.html"><i class="fa fa-map-marker fa-fw"></i> Terrains</a>
								</li>
								<li>
									<a href="map_Ribaa.html"><i class="fa fa-key fa-fw"></i> Ribaa</a>
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
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							Ajouter une expropriation
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-6">
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
								<div class="col-lg-6">
									<h1>Form filling help</h1>
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

	</div>
	<!-- /#wrapper -->

<script type="text/javascript">
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
	
</script>
   
</body>

</html>