<?php

	session_start();
	$db = pg_connect('host=localhost dbname=MHAI_DH user=postgres password=P0stgres');
	if (!$db){
		die("no connection to database ". pg_last_error());
	}
	$ID=pg_escape_string($_POST['ID']);
	$Superficie=pg_escape_string($_POST['Superficie']);
	$wkt=pg_escape_string($_POST['Geometry']);
	$userID=$_SESSION['userID'];

	$query = "update terrain set superficie = '".$Superficie."', geometry = ST_GeomFromText('".$wkt."') where ( id='" . $ID . "')";
	$result = pg_query($query);
	if (!$result) {
		die("Error with query: " . pg_last_error());
	}

	$querylog = "INSERT INTO operation (utilisateur_id, description, time, entite_id, table_op) VALUES('" . $userID . "', 'Terrain modifié', localtimestamp, '".$ID."', 'terrain')";
	$resultlog = pg_query($querylog);
	if (!$resultlog) {
		$errormessage = pg_last_error();
		echo "Error with query: " . $errormessage;
		exit();
	}

	pg_close();
?> 
