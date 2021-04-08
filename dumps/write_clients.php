<?php 
include('../includes/bdd.php');

$reqClients = $bdd->query("SELECT * FROM clients");

$fp = fopen('dump_clients.txt', 'w');
fwrite($fp, "");
fclose($fp);

while($repClients = $reqClients->fetch()){
	$data = $repClients["cde"].';'.$repClients["nom"].';'.$repClients["prenom"].';';

	$fp = fopen('dump_clients.txt', 'a+');
	fwrite($fp, utf8_decode($data)."\n");
	fclose($fp);
}

header('Location:pdf_clients.php');
?>