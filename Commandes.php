<!DOCTYPE html>
<?php
  session_start();
  include("includes/bdd.php");
  include("includes/footer.php");
  include("includes/id_checker.php");

  $newCommandeForm = '<form method="post">
            <div id="new" class="reveal-1">
                <h4>Création d\'une nouvelle commande</h4>
                <div class="mb-2">
                  <input name="insCdeCommande" type="text" class="form-control" id="exampleInputPassword1" placeholder="Code de Commande">
                </div>
                <div class="mb-2">
                  <input name="insCdeCli" type="text" class="form-control" id="exampleInputPassword1" placeholder="Code du Client">
                </div>
                <div class="mb-2">
                  <input name="insMontant" type="text" class="form-control" id="exampleInputPassword1" placeholder="Montant">
                </div>
                <button name="insCommande" type="submit" class="btn btn-primary">Créer</button>
                <button name="anCommande" type="submit" class="btn btn-primary">Annuler</button>
              </div>
            </form>';

  if(isset($_POST["new"])){
    $new = $newCommandeForm;
  }elseif(isset($_POST["anCommande"])){
    $new = "";
  }

  if(isset($_POST["insCommande"])){
    $newCdeCli = htmlspecialchars($_POST['insCdeCli']);
    $newMontant = htmlspecialchars($_POST['insMontant']);
    $newCdeCommande = htmlspecialchars($_POST['insCdeCommande']);

    if(!empty($newCdeCli) AND !empty($newMontant) AND !empty($newCdeCommande)){
      if (strlen($newCdeCommande) < 11){
        if(strlen($newCdeCli) < 50){
          if(strlen($newMontant) < 50){
            $insertNewCommande = $bdd->prepare("INSERT INTO commandes(cde, cdeClient, montant_ht) VALUES(?, ?, ?)");
            $insertNewCommande->execute(array($newCdeCommande, $newCdeCli, $newMontant));
          }
        }
      }
    }
  }
?>
<html lang="fr">
<?php include("includes/head_content.php"); ?>
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
                <th>Code Client</th>
                <th>Montant HT</th>
                <?php if($Perms['p_write']) echo "<th>Modifier</th><th>Supprimer</th>"; ?>
              </tr>
            </thead>
            <tbody>
              <?php
                $allCommandes = $bdd->query('SELECT * FROM commandes');
                while($infoCommande = $allCommandes->fetch())
              {
                  $qClient = $bdd->query("SELECT * FROM clients WHERE cde = '".$infoCommande["cdeClient"]."';");
                  $qClient->execute();
                  $qClientO = $qClient->fetch();
              ?>
              <tr>
                <td><?= $infoCommande["cde"] ?></td>
                <td><?php 
                if (!empty($qClientO["nom"])) {
                  echo $infoCommande["cdeClient"].' ('.$qClientO["nom"].' '.$qClientO["prenom"].')';
                }else{
                  echo $infoCommande["cdeClient"].' (introuvable)';
                } ?>
                </td>
                <td><?= $infoCommande["montant_ht"] ?></td>
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
                  if (isset($_POST["delete".$infoCommande['cde']])) {
                    $deleteCommande = $bdd->prepare('DELETE FROM commandes WHERE cde = '.$infoCommande['cde']);
                    $deleteCommande->execute();
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