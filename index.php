<?php
	session_start();
	include("includes/bdd.php");
	include("includes/config.php");
	
	if (isset($_POST["connect"])) {

		$name = htmlspecialchars($_POST["name"]);
		$password = sha1($_POST["password"]);

		if (!empty($name) AND !empty($password)) {
			$reqAdmin = $bdd->prepare("SELECT * FROM admins WHERE nom = ? AND password = ?");
			$reqAdmin->execute(array($name, $password));
			$existAdmin = $reqAdmin->rowCount();

			if ($existAdmin == 1) {
				$infoAdmin = $reqAdmin->fetch();
				$_SESSION["id"] = $infoAdmin["id"];

				$insNewHist = $bdd->prepare("INSERT INTO historique(idAdmin, type_action, date_action, heure_action) VALUES(?, ?, ?, ?)");
				$insNewHist->execute(array($infoAdmin['id'], '2', $date_action, $heure_action));

				$reqLastHist = $bdd->query("SELECT MAX(id) FROM historique");
				$LastId = $reqLastHist->fetch();
				$idHistorique = $LastId['MAX(id)'];

				$ip = htmlspecialchars($_SERVER['REMOTE_ADDR']);
				$insNewLog = $bdd->prepare("INSERT INTO logs_type2(idHistorique, ip) VALUES(?, ?)");
				$insNewLog->execute(array($idHistorique, $ip));

				header("Location:Clients.php?id=".$_SESSION["id"]."&loc=Clients");
			} else {
				$error = "Le nom ou le mot de passe est invalide";
			}
		} else {
			$error = "Tous les champs ne sont pas complétés";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>AVM | Espace administration</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/css/login.css">
</head>
<body>
  <div class="logo"><img src="assets/images/logo.png"></div>
  <div class="login">
    <form method="post">
      <center><h1>Connectez-vous</h1></center>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Votre nom *" value="" name="name" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Votre mot de passe *" value="" name="password" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btnSubmit" value="Connexion" name="connect">
        </div>
        <div class="form-group">
            <a href="#" class="ForgetPwd">Mot de passe oublié?</a>
        </div>
    </form>
    <center><i><font color="red"><b><?= $error ?></b></font></i></center>
  </div>
  <div class="wave">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#0062cc" fill-opacity="1" d="M0,224L60,202.7C120,181,240,139,360,128C480,117,600,139,720,170.7C840,203,960,245,1080,240C1200,235,1320,181,1380,154.7L1440,128L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path></svg>
  </div>
  <div class="under-wave"></div>
</body>
</html>