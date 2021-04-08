<!DOCTYPE html>
<?php
	session_start();
	include("includes/bdd.php");
	include("includes/footer.php");
	include("includes/id_checker.php");
	$p_admin = $bdd->query("SELECT * FROM admins_perms WHERE idAdmin = ".$infoAdmin['id']);
	$checkAdmin = $p_admin->fetch();
	if(!$checkAdmin['p_admin']){ header('Location:index.php'); }
	include("includes/head_content.php"); 
?>
<body>
	<?php include("includes/header.php"); ?>
	<div class="container-fluid">
	  <div class="row">
	    <?php include("includes/nav_content.php"); ?>
	    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
	      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	        <h1 class="h2">Historique</h1>
	        <div class="btn-toolbar mb-2 mb-md-0">
	          <div class="btn-group me-2">
	            <form method="post"><button type="submit" name="date" class="btn btn-sm btn-outline-secondary">Date</button></form>
	            &nbsp;&nbsp;
	            <form method="post"><button type="submit" name="admin" class="btn btn-sm btn-outline-secondary">Admin</button></form>
	            &nbsp;&nbsp;
	            <form method="post"><button type="submit" class="btn btn-sm btn-outline-secondary">Actualiser</button></form>
	          </div>
	        </div>
	      </div>
		    <?php

				function historique($type, $date, $heure){
					$qAdmin = $bdd->query("SELECT nom, prenom FROM admins WHERE id = ".$infoHist['idAdmin']);
					$rAdmin = $qAdmin->fetch();

					switch ($type) {
						case '1': // deconnexion
							$color = '245,227,0,0.5';
							$symb = "[\]";
							switch ($_SESSION["id"]) {
								case $infoHist["idAdmin"]:
									$sujet = "Vous vous êtes";
									break;
								default:
									$sujet = $rAdmin["nom"]." ".$rAdmin["prenom"]." s'est";
									break;
							}
							$phrase = $sujet." déconnecter le ".$date." à ".$heure;
							break;
					}
					echo $phrase;
				}
			$allHist = $bdd->query('SELECT * FROM historique');

			while($infoHist = $allHist->fetch()){
				historique($infoHist['type_action'], $infoHist['date_action'], $infoHist['heure_action']);

				echo $infoHist["date_action"];
			}	


		      $nbrClients = $allClients->rowCount();
		      if($nbrClients == 0){
		        $noResult = "<div class='reveal-1'><br><br><center><h5>Aucun résultat n'as été trouver...</h5></center><br></div>
		                      <div class='reveal-2'><p>Conseils à la recherche :<ul>
		                      <li>Ne rechercher qu'un code, nom ou prénom,</li>
		                      <li>Éviter les espaces dans votre recherche,</li>
		                      <li>Vérifier la catégorie de votre recherche.</li></ul></p></div>";
		      }
		    ?>
	      <?= $noResult ?>

	    </main>
	  </div>
	</div>
	<?php include("includes/scripts_list.php"); ?>
</body>
</html>