<?php
  $navMaster = array(1 => 'Clients', 2 => 'Commandes', 3 => 'Fournisseurs', 4 => 'Marges');
  $navAdmin = array(1 => 'Comptes', 2 => 'Historique');
?>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
      <?php
        foreach ($navMaster as $valueMaster) {
          if($_GET['loc'] == $valueMaster){ $active = 'active'; }else{ $active = ''; }
          ?>  
            <li class="nav-item">
              <a class="nav-link <?= $active ?>" href="<?= $valueMaster ?>.php?id=<?php echo $_SESSION["id"].'&loc='.$valueMaster;?>">
                <span data-feather="home"></span>
                <?= $valueMaster ?>
              </a>
            </li>
          <?php
        }
        unset($valueMaster);
      ?>
    </ul>
    <?php
      $reqPerms = $bdd->query("SELECT * FROM admins_perms WHERE idAdmin = ".$infoAdmin['id']);
      $Perms = $reqPerms->fetch();
      if($Perms['p_admin']){
        echo '<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Administratif</span>
                <span data-feather="plus-circle"></span>
              </h6>
              <ul class="nav flex-column mb-2">';
        foreach ($navAdmin as $valueAdmin) {
          if($_GET['loc'] == $valueAdmin){ $active = 'active'; }else{ $active = ''; }
          ?>  
            <li class="nav-item">
              <a class="nav-link <?= $active ?>" href="<?= $valueAdmin ?>.php?id=<?php echo $_SESSION["id"].'&loc='.$valueAdmin;?>">
                <span data-feather="file-text"></span>
                <?= $valueAdmin ?>
              </a>
            </li>
          <?php
          unset($valueAdmin);
        }
      }
    ?>
    </ul>
  </div>
</nav>