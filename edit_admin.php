<?php
	include("includes/bdd.php");
	extract($_POST);

	$nom = htmlspecialchars($nom);
	$prenom = htmlspecialchars($prenom);
	$email = htmlspecialchars($email);
	$id = htmlspecialchars($id);

	if($mdp == '●●●●●●●●'){
		if(isset($nom) && isset($prenom) && isset($email) && isset($id) && !empty($nom) && !empty($prenom) && !empty($email) && !empty($id)){
			if(strlen($nom) < 16){
				if(strlen($prenom) < 16){
					if(strlen($email) < 29){
						$reqEdit = $bdd->prepare("UPDATE admins SET nom = ?, prenom = ?, email = ? WHERE id = '".$id."'");
						$reqEdit->execute(array($nom, $prenom, $email));
						echo "ok";
					}else{ echo "L'adresse email ne peut dépasser 29 caractères"; }
				}else{ echo "Le prenom ne peut dépasser 16 caractères"; }
			}else { echo "Le nom ne peut dépasser 16 caractères"; }
		}else{ echo "Des champs sont manqants"; }
	}else{
		if(isset($nom) && isset($prenom) && isset($email) && isset($id) && isset($mdp) && !empty($nom) && !empty($prenom) && !empty($email) && !empty($id) && !empty($mdp)){
			if(strlen($nom) < 16){
				if(strlen($prenom) < 16){
					if(strlen($email) < 29){
						$mdp = sha1($mdp);
						$reqEdit = $bdd->prepare("UPDATE admins SET nom = ?, prenom = ?, email = ?, password = ? WHERE id = '".$id."'");
						$reqEdit->execute(array($nom, $prenom, $email, $mdp));
						echo "ok";
					}else{ echo "L'adresse email ne peut dépasser 29 caractères"; }
				}else{ echo "Le prenom ne peut dépasser 16 caractères"; }
			}else { echo "Le nom ne peut dépasser 16 caractères"; }
		}else{
			echo "Des champs sont manqants";
		}
	}
	if($p_write == "nochecked"){
		$reqp_write = $bdd->prepare("UPDATE admins_perms SET p_write = ? WHERE idAdmin = '".$id."'");
		$reqp_write->execute(array(false));
	}else{
		$reqp_write = $bdd->prepare("UPDATE admins_perms SET p_write = ? WHERE idAdmin = '".$id."'");
		$reqp_write->execute(array(true));
	}
	if($p_admin == "nochecked"){
		$reqp_admin = $bdd->prepare("UPDATE admins_perms SET p_admin = ? WHERE idAdmin = '".$id."'");
		$reqp_admin->execute(array(false));
	}else{
		$reqp_admin = $bdd->prepare("UPDATE admins_perms SET p_admin = ? WHERE idAdmin = '".$id."'");
		$reqp_admin->execute(array(true));
	}
?>