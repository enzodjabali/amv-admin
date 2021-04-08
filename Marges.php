<!DOCTYPE html>
<?php
	session_start();
	include("includes/bdd.php");
  include("includes/footer.php");
  include("includes/id_checker.php");

	$newMargeForm = '<form method="post">
						<div id="new" class="reveal-1">
				    		<h4>Création d\'une nouvelle marge</h4>
				    		<div class="mb-2">
						    	<input name="inscdeClient" type="text" class="form-control" id="exampleInputPassword1" placeholder="Code client">
						  	</div>
						  	<div class="mb-2">
						    	<input name="insmontantht_vente" type="text" class="form-control" id="exampleInputPassword1" placeholder="Montant HT Vente">
						  	</div>
						  	<div class="mb-2">
						    	<input name="insmontantht_achat" type="text" class="form-control" id="exampleInputPassword1" placeholder="Montant HT Achat">
						  	</div>
                <button name="insMarge" type="submit" class="btn btn-primary">Créer</button>
						  	<button name="anMarge" type="submit" class="btn btn-primary">Annuler</button>
				    	</div>
				    </form>';

	if(isset($_POST["new"])){ $new = $newMargeForm; }elseif(isset($_POST["anMarge"])){ $new = ""; }

	if(isset($_POST["insMarge"])){
		$inscdeClient = htmlspecialchars($_POST['inscdeClient']);
		$insmontantht_vente = htmlspecialchars($_POST['insmontantht_vente']);
		$insmontantht_achat = htmlspecialchars($_POST['insmontantht_achat']);

		if(!empty($inscdeClient) AND !empty($insmontantht_vente) AND !empty($insmontantht_achat)){
			if(strlen($inscdeClient) < 11){
				if(strlen($insmontantht_vente) < 11){
					if(strlen($insmontantht_achat) < 11){
						$insertNewMarge = $bdd->prepare("INSERT INTO marge_brute(cdeClient, montantht_vente, montantht_achat) VALUES(?, ?, ?)");
	    				$insertNewMarge->execute(array($inscdeClient, $insmontantht_vente, $insmontantht_achat));
	    			}
				}
			}
		}
	}
  include("includes/head_content.php");
?>
<body>
	<?php include("includes/header.php"); ?>
  <div class="container-fluid">
    <div class="row">
      <?php include("includes/nav_content.php"); ?>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      	<?= $new ?>
      	<?php
      	if($edit == true){
      		echo $editClientForm;
      	}
      	?>
      	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Liste des marges</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
            	<?php if($Perms['p_write']) echo "<form method='post'><button type='submit' name='new' class='btn btn-sm btn-outline-secondary'>Nouvelle</button></form>"; ?>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>Code Client</th>
                <th>Montant HT Vente</th>
                <th>Montant HT Achat</th>
                <th>Marge Brute Résultat</th>
                <?php if($Perms['p_write']) echo "<th>Modifier</th><th>Supprimer</th>"; ?>
              </tr>
            </thead>
            <tbody>
              <?php
                $allMarges = $bdd->query('SELECT * FROM marge_brute');
                while($infoMarge = $allMarges->fetch())
  		          { 
                  $resultat = $infoMarge["montantht_achat"] / $infoMarge["montantht_vente"] * 100;
                  $resultat = round($resultat,'2');

                  $qClient = $bdd->query("SELECT * FROM clients WHERE cde = '".$infoMarge["cdeClient"]."';");
                  $qClient->execute();
                  $qClientO = $qClient->fetch();
              ?>
              <tr>
                <td><?php echo $infoMarge["cdeClient"].' ('.$qClientO["nom"].' '.$qClientO["prenom"].')'; ?></td>
                <td><?= $infoMarge["montantht_vente"].' €' ?></td>
                <td><?= $infoMarge["montantht_achat"].' €' ?></td>
                <td><?= $resultat.' %' ?></td>
                <?php
                  if($Perms['p_write']){
                    ?>
                    <td><form method="post"><input type="submit" name="edit<?= $infoClient['cde'] ?>" value="Modifier"></form></td>
                    <td><form method="post"><input type="submit" name="delete<?= $infoCommande['cde'] ?>" value="Supprimer"></form></td>
                    <?php
                  }
                ?>
              </tr>
              <?php
              		if(isset($_POST["edit".$infoClient['cde']])){
  	            		$edit = true;
  	            	}
                  if (isset($_POST["delete".$infoMarge['cde']])) {
                    $deleteMarge = $bdd->prepare('DELETE FROM marge_brute WHERE cde = '.$infoMarge['cde']);
                    $deleteMarge->execute();
                    echo "<script>document.location.reload();</script>";
                  }	
          		}
              ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
	<?php include("includes/scripts_list.php"); ?>
</body>
</html>