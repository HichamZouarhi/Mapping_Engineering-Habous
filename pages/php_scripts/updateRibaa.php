<?php

	session_start();
	$db = pg_connect('host=localhost dbname=MHAI_DH user=postgres password=P0stgres');
	if (!$db){
		die("no connection to database ". pg_last_error());
	}
	$ID=pg_escape_string($_POST['ID']);
	$ID_Expropriation=pg_escape_string($_POST['ID_Expropriation']);
	$Type=pg_escape_string($_POST['Type']);
	$Num_Foncier=pg_escape_string($_POST['Num_Foncier']);
	$Description=pg_escape_string($_POST['Description']);
	$Superficie=pg_escape_string($_POST['Superficie']);
	$Commune=pg_escape_string($_POST['Commune']);
	$Province=pg_escape_string($_POST['Province']);
	$Region=pg_escape_string($_POST['Region']);
	$wkt=pg_escape_string($_POST['Geometry']);
	$userID=$_SESSION['userID'];

	$query = "update ribaa set id_expropriation = '".$ID_Expropriation."', type = '".$Type."', num_foncier = '".$Num_Foncier."', superficie = '".$Superficie."', description = '".$Description."', commune = '".$Commune."', province = '".$Province."', region = '".$Region."', geometry = ST_GeomFromText('".$wkt."') where ( id='" . $ID . "')";
	$result = pg_query($query);
	if (!$result) {
		die("Error with query: " . pg_last_error());
	}

	$querylog = "INSERT INTO operation (utilisateur_id, description, time, entite_id, table_op) VALUES('" . $userID . "', 'Ribaa mise à jour', localtimestamp, '".$ID."', 'ribaa')";
	$resultlog = pg_query($querylog);
	if (!$resultlog) {
		$errormessage = pg_last_error();
		echo "Error with query: " . $errormessage;
		exit();
	}

	pg_close();
?> 
