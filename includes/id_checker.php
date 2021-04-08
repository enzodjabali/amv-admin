<?php
if(isset($_GET["id"]) AND $_GET["id"] > 0){
	$seeid = intval($_GET["id"]);
	$reqAdmin = $bdd->prepare("SELECT * FROM admins WHERE id = ?");
	$reqAdmin->execute(array($seeid));
	$infoAdmin = $reqAdmin->fetch();

    if (isset($_SESSION["id"]) AND $infoAdmin["id"] === $_SESSION["id"]){
    }else{ header("Location:index.php"); }
}else{ header("Location:index.php"); }
?>