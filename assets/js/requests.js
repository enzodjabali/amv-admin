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