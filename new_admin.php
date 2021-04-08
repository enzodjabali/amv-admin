<?php
	include("includes/bdd.php");
	extract($_POST);

	$nom = htmlspecialchars($nom);
	$prenom = htmlspecialchars($prenom);
	$email = htmlspecialchars($email);

	if($p_write == "nochecked"){
		$p_write = false;
	}else{
		$p_write = true;
	}
	if($p_admin == "nochecked"){
		$p_admin = false;
	}else{
		$p_admin = true;
	}

	if(isset($nom) && isset($prenom) && isset($email) && isset($mdp) && !empty($nom) && !empty($prenom) && !empty($email) && !empty($mdp)){
		if(strlen($nom) < 16){
			if(strlen($prenom) < 16){
				if(strlen($email) < 29){
					$mdp = sha1($mdp);
					$reqNew = $bdd->prepare("INSERT INTO admins (nom, prenom, email, password) VALUES (?,?,?,?)");
					$reqNew->execute(array($nom, $prenom, $email, $mdp));

					$qAdmin = $bdd->query("SELECT MAX(id) FROM admins");
					$currentAdmin = $qAdmin->fetch();

					$reqPerms = $bdd->prepare("INSERT INTO admins_perms (idAdmin, p_write, p_admin) VALUES (?,?,?)");
					$reqPerms->execute(array($currentAdmin['MAX(id)'], $p_write, $p_admin));

					echo "ok";
				}else{ echo "L'adresse email ne peut dépasser 29 caractères"; }
			}else{ echo "Le prenom ne peut dépasser 16 caractères"; }
		}else{ echo "Le nom ne peut dépasser 16 caractères"; }
	}else{ echo "Des champs sont manqants"; }