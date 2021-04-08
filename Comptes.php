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
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<style type="text/css">
  	.containerc {
		display: flex;
		flex-wrap: wrap;
	}
	.containerd {
	  display: flex;
	  flex-wrap: wrap;
	}
	.admin {
	  height: auto;
	  width: 200px;
	  background-color: #F2F2F2;
	  margin-right: 5vh;
	  margin-bottom: 5vh;
	  border-radius: 3px;
	  box-shadow: 3px 3px 3px #C1C1C1;
	}
	.perms {
	  padding-left: 10px;
	  padding-top: 5px;
	  padding-bottom: 9px;
	}
	.locker {
	  background-color: 0,0,0,0.0;
	  width: 100px;
	  height: 60px;
	  position: absolute;
	}
	.fade.in {
	  opacity: 1
	}
	.modal.in .modal-dialog {
	  -webkit-transform: translate(0, 0);
	  -ms-transform: translate(0, 0);
	  -o-transform: translate(0, 0);
	  transform: translate(0, 0)
	}
	.modal-backdrop.in {
	  filter: alpha(opacity=50);
	  opacity: .5
	}
  	</style>
	<?php include("includes/header.php"); ?>
	<div class="container-fluid">
	  <div class="row">
	    <?php include("includes/nav_content.php"); ?>
	    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
	      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	        <h1 class="h2">Comptes</h1>
	        <div class="btn-toolbar mb-2 mb-md-0">
	          <div class="btn-group me-2">
	           <div class="containerc">
                <div style="margin-right:5px;"><h5>Trié par :</h5></div>
                <div style="margin-right:5px;"><form method="post"><button type="submit" name="12" class="btn btn-sm btn-outline-secondary">Permissions</button></form></div>
                <div style="margin-right:10px;"><form method="post"><button type="submit" name="az" class="btn btn-sm btn-outline-secondary">Nom</button></form></div>
                <div style="margin-right:5px;"><h5>Actions :</h5></div>
                <?php if($Perms['p_write']) echo "<div style='margin-right:5px;'><button type='submit' name='new' class='btn btn-sm btn-outline-secondary' data-toggle='modal' data-target='#NouvCompte'>Nouveau</button></div>"; ?>
                <div style="margin-right:5px;"><form method="post"><button type="submit" class="btn btn-sm btn-outline-secondary">Actualiser</button></form></div>
              </div>
	          </div>
	        </div>
	      </div>

	      <!-- Modal création d'un nouveau compte -->

	      <div class="modal fade" id="NouvCompte" role="dialog">
		    <div class="modal-dialog">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button style="border-radius:150px;border:none;" type="button" class="close" data-dismiss="modal">&times;</button>
		          <h5><div align="center" id="preview"></div></h5><h5><div align="center" id="preview2"></div></h5><h5 class="namezone">Nouveau compte</h5>
		        </div>
		        <div class="modal-body">
		          <form method="post" id="formnew">
		          	<b><p style="margin-bottom:1px">Informations personnels :</p></b><br>
		          	<input style="display:none" type="text" name="getid" value="<?= $infoAdm['id'] ?>">
		          	<table>
		          		<tr>
		          			<td>Nom : </td>
		          			<td><input type="text" name="newnom" placeholder="Dupond" id="texte" onclick="emptyZone()" onKeyUp="updatePreview2()" required><br></td>
		          		</tr>
		          		<tr>
		          			<td>Prénom : </td>
		          			<td><input type="text" name="newprenom" placeholder="Jean" onKeyUp="updatePreview()" required><br></td>
		          		</tr>
		          		<tr>
		          			<td>Email : </td>
		          			<td><input type="email" name="newemail" placeholder="nom@domaine.ext" required><br></td>
		          		</tr>
		          		<tr>
		          			<td>Mot de passe : </td>
		          			<td><input type="password" name="newmdp" required><br></td>
		          		</tr>
		          	</table>
		          	<br>
		          	<b><p style="margin-bottom:1px">Permissions :</p></b><br>
		          	<input type="checkbox" id="newwrite"> Modification
  					<br>
  					<input type="checkbox" id="newadmin"> Administration
  					<br><br>
  					<input type="submit" value="Créer le compte">
  					<center><div id="loader" style="display:none">
  						<img src="assets/images/ajax-loader.gif" height="15" width="15" alt="Chargement">
  					</div></center>
		          </form>
		          <center><b><i><div style="color:red" class="error"></div></i></b></center>
		          <center><b><i><div style="color:green" class="ajaxresult"></div></i></b></center>
		        </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
		        </div>
		      </div>
		    </div>
		  </div>

		  <script type="text/javascript">
		  	$(function(){
		  		$("#NouvCompte").submit(function(){
		  			$("#loader").show();
		  			nom = $(this).find("input[name=newnom]").val();
		  			prenom = $(this).find("input[name=newprenom]").val();
		  			email = $(this).find("input[name=newemail]").val();
		  			mdp = $(this).find("input[name=newmdp]").val();

		  			if ($("#newwrite").prop("checked") == true) {
					   p_write = $(this).find("input[name=p_write]").val();
					}else{
						p_write = "nochecked";
					}
					if ($("#newadmin").prop("checked") == true) {
					   p_admin = $(this).find("input[name=p_admin]").val();
					}else{
						p_admin = "nochecked";
					}

		  			$.post("new_admin.php", {nom: nom, prenom: prenom, email: email, mdp :mdp, p_write: p_write, p_admin: p_admin}, function(data){
		  			$("#loader").hide();

		  				if(data != "ok"){
		  					$(".error").empty().append(data);
		  				}else{
		  					$(".ajaxresult").empty().hide().append("Le compte de "+nom+" "+prenom+" à bien été créer.").slideDown();
		  					$(".containerd").load(location.href + " .containerd");
		  				}
		  			});
		  			return false;
		  		});
		  	});
		  	</script>

		  <!--  -->

	      <div class="containerd">
		    <?php
		      $allAdmins = $bdd->query('SELECT * FROM admins');

		      if(isset($_POST["search"])){
		        $allHistorique = $bdd->query("SELECT * FROM historique WHERE CONCAT(action, date_action, heure_action) LIKE '%".$_POST["searchbar"]."%'");
		      }
		      if(isset($_POST["az"])){
		        $allHistorique = $bdd->query("SELECT * FROM clients ORDER BY nom");
		      }
		      if(isset($_POST["12"])){
		        $allHistorique = $bdd->query("SELECT * FROM clients ORDER BY cde");
		      }

		      while($infoAdm = $allAdmins->fetch())
		      {
		      	$reqPerms = $bdd->query("SELECT * FROM admins_perms WHERE idAdmin = ".$infoAdm['id']);
		      	$admPerms = $reqPerms->fetch();
		      	$admId = htmlspecialchars($admPerms['idAdmin']);
		      	?>
		      	<div class="admin">
		      		<center>
		      			<img style="padding-top:9px;padding-bottom:9px;opacity:0.40;" src="assets/images/user.png" width="120px"><br>
		      			<?= $infoAdm['nom'] ?> <?= $infoAdm['prenom'] ?><br>
		      			<?= $infoAdm['email'] ?>
		      		</center>
      				<div class="perms">
      				<div class="locker"></div>
      				Permissions :<br>
      				<input type="checkbox" name="modif" <?php if($admPerms['p_write']) echo 'checked'; ?>> Modification
      				<br>
      				<input type="checkbox" name="admin" <?php if($admPerms['p_admin']) echo 'checked'; ?>> Administration
      				<br>
      				</div>
      				<center>
      					<input style="margin-bottom:9px;" type="submit" data-toggle="modal" data-target="#myModal<?= $admId ?>" value="Modifier">
      					<input style="margin-bottom:9px;" type="submit" name="" value="Supprimer">
      				</center>
		      	</div>

		      	<!-- Modal modification d'un compte -->

				  <div class="modal fade" id="myModal<?= $admId ?>" role="dialog">
				    <div class="modal-dialog">
				      <div class="modal-content">
				        <div class="modal-header">
				          <button style="border-radius:150px;border:none;" type="button" class="close" data-dismiss="modal">&times;</button>
				          <h5><?= $infoAdm['nom'] ?> <?= $infoAdm['prenom'] ?></h5>
				        </div>
				        <div class="modal-body">
				          <form method="post" id="formedit<?= $admId ?>">
				          	<b><p style="margin-bottom:1px">Informations personnels :</p></b><br>
				          	<input style="display:none" type="text" name="getid" value="<?= $infoAdm['id'] ?>">
				          	<table>
				          		<tr>
				          			<td>Nom : </td>
				          			<td><input type="text" name="editnom" value="<?= $infoAdm['nom'] ?>" required><br></td>
				          		</tr>
				          		<tr>
				          			<td>Prénom : </td>
				          			<td><input type="text" name="editprenom" value="<?= $infoAdm['prenom'] ?>" required><br></td>
				          		</tr>
				          		<tr>
				          			<td>Email : </td>
				          			<td><input type="email" name="editemail" value="<?= $infoAdm['email'] ?>" required><br></td>
				          		</tr>
				          		<tr>
				          			<td>Mot de passe : </td>
				          			<td><input type="password" name="editmdp" value="●●●●●●●●" required><br></td>
				          		</tr>
				          	</table>
				          	<br>
				          	<b><p style="margin-bottom:1px">Permissions :</p></b><br>
				          	<input type="checkbox" id="write<?= $admId ?>" name="p_write" <?php if($admPerms['p_write']) echo 'checked'; ?>> Modification
	      					<br>
	      					<input type="checkbox" id="admin<?= $admId ?>" name="p_admin" <?php if($admPerms['p_admin']) echo 'checked'; ?>> Administration
	      					<br><br>
	      					<input type="submit" value="Mettre à jour">
	      					<center><div id="loader" style="display:none">
	      						<img src="assets/images/ajax-loader.gif" height="15" width="15" alt="Chargement">
	      					</div></center>
				          </form>
				          <center><b><i><div style="color:red" class="error"></div></i></b></center>
				          <center><b><i><div style="color:green" class="ajaxresult"></div></i></b></center>
				        </div>
				        <div class="modal-footer">
				          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
				        </div>
				      </div>
				    </div>
				  </div>

				  <!--  -->

				  <script type="text/javascript">
			      	$(function(){
			      		$("#formedit<?= $admId ?>").submit(function(){
			      			$("#loader").show();
			      			nom = $(this).find("input[name=editnom]").val();
			      			prenom = $(this).find("input[name=editprenom]").val();
			      			email = $(this).find("input[name=editemail]").val();
			      			id = $(this).find("input[name=getid]").val();
			      			mdp = $(this).find("input[name=editmdp]").val();

			      			if ($("#write<?= $admId ?>").prop("checked") == true) {
							   p_write = $(this).find("input[name=p_write]").val();
							}else{
								p_write = "nochecked";
							}
							if ($("#admin<?= $admId ?>").prop("checked") == true) {
							   p_admin = $(this).find("input[name=p_admin]").val();
							}else{
								p_admin = "nochecked";
							}

			      			$.post("edit_admin.php", {nom: nom, prenom: prenom, email: email, id: id, mdp :mdp, p_write: p_write, p_admin: p_admin}, function(data){
			      			$("#loader").hide();

			      				if(data != "ok"){
			      					$(".error").empty().append(data);
			      				}else{
			      					$(".ajaxresult").empty().hide().append("Le compte de "+nom+" "+prenom+" à bien été mis à jour.").slideDown();
			      					$(".containerd").load(location.href + " .containerd");
			      				}
			      			});
			      			return false;
			      		});
			      	});
			      </script>
		      	<?php
		      }
		      ?>
		  </div>
	    </main>

	  </div>
	</div>

	<script>
	function emptyZone(){
		$(".namezone").empty();
	}

	function updatePreview(){
		var texte = document.getElementById('texte');
		var preview = document.getElementById('preview');
		var preview2 = document.getElementById('preview2');
		preview.innerHTML = texte.value;
		var tmp = texte.value;
		var regExp = new RegExp("(\r\n)|(\r)|(\n)", "g");
		var tmp = texte.value;
		preview2.innerHTML = tmp.replace(regExp, '<br>');
	 }
	 function updatePreview2(){
		var texte = document.getElementById('texte');
		var preview = document.getElementById('preview2');
		var preview2 = document.getElementById('preview3');
		preview.innerHTML = texte.value;
		var tmp = texte.value;
		var regExp = new RegExp("(\r\n)|(\r)|(\n)", "g");
		var tmp = texte.value;
		preview2.innerHTML = tmp.replace(regExp, '<br>');
	 }
	</script>
	<?php include("includes/scripts_list.php"); ?>
</body>
</html>