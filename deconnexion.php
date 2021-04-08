<?php
	session_start();
	include("includes/bdd.php");
	include("includes/id_checker.php");
	include("includes/config.php");

	$insNewHist = $bdd->prepare("INSERT INTO historique(idAdmin, type_action, date_action, heure_action) VALUES(?, ?, ?, ?)");
	$insNewHist->execute(array($infoAdmin['id'], '1', $date_action, $heure_action));

	$reqLastHist = $bdd->query("SELECT MAX(id) FROM historique");
	$LastId = $reqLastHist->fetch();
	$idHistorique = $LastId['MAX(id)'];

	$last_page = htmlspecialchars($_GET['lastpage']);
	$insNewLog = $bdd->prepare("INSERT INTO logs_type1(idHistorique, last_page) VALUES(?, ?)");
	$insNewLog->execute(array($idHistorique, $last_page));

	session_destroy();
	header("Location:index.php");
?>