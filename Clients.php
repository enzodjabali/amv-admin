<!DOCTYPE html>
<?php
	session_start();
	include("includes/bdd.php");
 	include("includes/footer.php");
  	include("includes/id_checker.php");

	$newClientForm = '<form method="post">
						<div id="new" class="reveal-1">
				    		<h4>Création d\'un nouveau client</h4>
				    		<div class="mb-2">
						    	<input name="insNom" type="text" class="form-control" id="exampleInputPassword1" placeholder="Nom">
						  	</div>
						  	<div class="mb-2">
						    	<input name="insPrenom" type="text" class="form-control" id="exampleInputPassword1" placeholder="Prénom">
						  	</div>
						  	<button name="insClient" type="submit" class="btn btn-primary">Créer</button>
                <button name="anClient" type="submit" class="btn btn-primary">Annuler</button>
				    	</div>
				    </form>';

	if(isset($_POST["new"])){ $new = $newClientForm; }elseif(isset($_POST["anClient"])){ $new = ""; }

	if(isset($_POST["insClient"])){
		$newNom = htmlspecialchars($_POST['insNom']);
		$newPrenom = htmlspecialchars($_POST['insPrenom']);

		if(!empty($newNom) AND !empty($newPrenom)){
			if(strlen($newNom) < 50){
				if(strlen($newPrenom) < 50){
					$insertNewClient = $bdd->prepare("INSERT INTO clients(nom, prenom) VALUES(?, ?)");
	    		$insertNewClient->execute(array($newNom, $newPrenom));

          $codeAct = $bdd->query("SELECT MAX(cde) FROM clients");
          $codeAct->execute();
          $codeActReturn = $codeAct->fetch();
          $newInfo = "<div class='reveal-1'><br><h5>Le client ".$newNom." ".$newPrenom." à bien été créer. Le code ".$codeActReturn['MAX(cde)']." lui à été attribuer.</h5></div>";
				}
			}
		}
	}
  include("includes/head_content.php");
?>
<body>
	<style type="text/css">
		.containerc {
		  display: flex;
		  flex-wrap: wrap;
		}
	</style>
  <?php include("includes/header.php"); ?>
  <div class="container-fluid">
    <div class="row">
     <?php include("includes/nav_content.php"); ?>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      	<?= $new ?>
        <?= $newInfo ?>
      	<?php
      	if($edit == true){
      		echo $editClientForm;
      	}

        $reqPerms = $bdd->query("SELECT * FROM admins_perms WHERE idAdmin = ".$_SESSION['id']);
        $Perms = $reqPerms->fetch();
      	?>

      	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Liste des clients</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <div class="containerc">
                <div style="margin-right:5px;"><h5>Trié par :</h5></div>
                <div style="margin-right:5px;"><form method="post"><button type="submit" name="12" class="btn btn-sm btn-outline-secondary">Code</button></form></div>
                <div style="margin-right:10px;"><form method="post"><button type="submit" name="az" class="btn btn-sm btn-outline-secondary">Nom</button></form></div>
                <div style="margin-right:5px;"><h5>Actions :</h5></div>
                <?php if($Perms['p_write']) echo "<div style='margin-right:5px;'><form method='post'><button type='submit' name='new' class='btn btn-sm btn-outline-secondary'>Nouveau</button></form></div>"; ?>
                <div style="margin-right:5px;"><form method="post"><button onclick="window.open('dumps/write_clients.php', '_blank')"  type="submit" class="btn btn-sm btn-outline-secondary">Imprimer</button></form></div>
                <div style="margin-right:5px;"><form method="post"><button type="submit" class="btn btn-sm btn-outline-secondary">Actualiser</button></form></div>
              </div>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>Prénom</th>
                <?php if($Perms['p_write']) echo "<th>Modifier</th><th>Supprimer</th>"; ?>
              </tr>
            </thead>
            <tbody>
              <?php
                $allClients = $bdd->query('SELECT * FROM clients');

                if(isset($_POST["search"])){
                  $allClients = $bdd->query("SELECT * FROM clients WHERE CONCAT(cde, nom, prenom) LIKE '%".$_POST["searchbar"]."%'");
                }
                if(isset($_POST["az"])){
                  $allClients = $bdd->query("SELECT * FROM clients ORDER BY nom");
                }
                if(isset($_POST["12"])){
                  $allClients = $bdd->query("SELECT * FROM clients ORDER BY cde");
                }

                while($infoClient = $allClients->fetch())
  		          {
                  $clientCde = $infoClient["cde"];
              ?>
                <tr>
                  <td><?= $infoClient["cde"] ?></td>
                  <td><?= $infoClient["nom"] ?></td>
                  <td><?= $infoClient["prenom"] ?></td>
                  <?php
                  if($Perms['p_write']){
                    ?>
                    <td><form method="post"><input style="border:none" type="submit" name="edit<?= $infoClient['cde'] ?>" value="Modifier"></form></td>
                    <td><form method="post"><input style="border:none" type="submit" name="delete<?= $infoClient['cde'] ?>" value="Supprimer"></form></td>
                    <?php
                  }
                  ?>
                </tr>
              <?php
              	if(isset($_POST["edit".$infoClient['cde']])){
                  $older = $infoClient["cde"];
  	            	$oldername = $infoClient["nom"];
                  $olderprenom = $infoClient["prenom"];

                  echo '<form method="post">
                  <div id="new" class="reveal-1">
                      <h4>Modification du client '.$clientCde.'</h4>
                      <div class="mb-2">
                        <input name="editNom" type="text" class="form-control" id="exampleInputPassword1" placeholder="Nom" value="'.$oldername.'">
                      </div>
                      <div class="mb-2">
                        <input name="editPrenom" type="text" class="form-control" id="exampleInputPassword1" placeholder="Prénom" value="'.$olderprenom.'">
                      </div>
                      <button name="editClient'.$clientCde.'" type="submit" class="btn btn-primary">Modifier</button>
                      <button name="anClient" type="submit" class="btn btn-primary">Annuler</button>
                    </div>
                  </form><br>';
  	            }
                  if (isset($_POST["editClient".$clientCde])) {
                    if (!empty($_POST["editNom"]) AND !empty($_POST["editPrenom"])) {
                      $editnom = htmlspecialchars($_POST["editNom"]);
                      $editprenom = htmlspecialchars($_POST["editPrenom"]);

                      if (strlen($editnom) < 50){
                        if (strlen($editprenom) < 50){
                          $inseditclient = $bdd->prepare("UPDATE clients SET nom = ?, prenom = ? WHERE cde = ".$clientCde);
                          $inseditclient->execute(array($editnom, $editprenom));
                        }
                      }
                    }
                    //echo "<script>location.reload();</script>";
                  }

                if (isset($_POST["delete".$infoClient['cde']])) {
                  $deleteClient = $bdd->prepare('DELETE FROM clients WHERE cde = '.$infoClient['cde']);
                  $deleteClient->execute();
                  echo "<script>location.reload();</script>";
                }
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
            </tbody>
          </table>
        </div>
        <?= $noResult ?>
      </main>
    </div>
  </div>
	<?php include("includes/scripts_list.php"); ?>
</body>
</html>