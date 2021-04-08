<html lang="fr">
<form method="post">
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3"><img src="assets/images/logo.png" width="130px"></a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <input name="searchbar" class="form-control form-control-dark w-100" type="search" placeholder="Effectuer une recherche dans les '<?= $_GET["loc"] ?>'" aria-label="Search">
    <input style="display:none;" type="submit" name="search">
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link" href="deconnexion.php?id=<?= $_SESSION["id"] ?>&lastpage=<?= $_GET["loc"] ?>">Déconnexion</a>
      </li>
    </ul>
  </header>
</form>