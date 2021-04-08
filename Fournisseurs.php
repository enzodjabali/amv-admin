<!DOCTYPE html>
<?php
  session_start();
  include("includes/bdd.php");
  include("includes/footer.php");
  include("includes/id_checker.php");

  $newFournisseurForm = '<form method="post">
            <div id="new" class="reveal-1">
                <h4>Création d\'un nouveau fournisseur</h4>
                <div class="mb-2">
                  <input name="insNom" type="text" class="form-control" id="exampleInputPassword1" placeholder="Nom">
                </div>
                <div class="mb-2">
                  <input name="insDep" type="text" class="form-control" id="exampleInputPassword1" placeholder="Département">
                </div>
                <button name="insFournisseur" type="submit" class="btn btn-primary">Créer</button>
                <button name="anFournisseur" type="submit" class="btn btn-primary">Annuler</button>
              </div>
            </form>';

  if(isset($_POST["new"])){ $new = $newFournisseurForm; }elseif(isset($_POST["anFournisseur"])){ $new = ""; }

  if(isset($_POST["insFournisseur"])){
    $newNom = htmlspecialchars($_POST['insNom']);
    $newDep = htmlspecialchars($_POST['insDep']);

    if(!empty($newNom) AND !empty($newDep)){
      if(strlen($newNom) < 50){
        if(strlen($newDep) < 50){
          $insertNewFournisseur = $bdd->prepare("INSERT INTO fournisseurs(nom, dep) VALUES(?, ?)");
            $insertNewFournisseur->execute(array($newNom, $newDep));
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

        $reqPerms = $bdd->query("SELECT * FROM admins_perms WHERE idAdmin = ".$_SESSION['id']);
        $Perms = $reqPerms->fetch();
        ?>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Liste des fournisseurs</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <?php if($Perms['p_write']) echo "<form method='post'><button type='submit' name='new' class='btn btn-sm btn-outline-secondary'>Nouveau</button></form>"; ?>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>Département</th>
                <?php if($Perms['p_write']) echo "<th>Modifier</th><th>Supprimer</th>"; ?>
              </tr>
            </thead>
            <tbody>
              <?php
                $allFournisseurs = $bdd->query('SELECT * FROM fournisseurs');
                while($infoFournisseur = $allFournisseurs->fetch())
            {
              ?>
              <tr>
                <td><?= $infoFournisseur["cde"] ?></td>
                <td><?= $infoFournisseur["nom"] ?></td>
                <td><?= $infoFournisseur["dep"] ?></td>
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
                  if (isset($_POST["delete".$infoFournisseur['cde']])) {
                    $deleteFournisseur = $bdd->prepare('DELETE FROM fournisseurs WHERE cde = '.$infoFournisseur['cde']);
                    $deleteFournisseur->execute();
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