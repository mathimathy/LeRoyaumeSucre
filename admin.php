<?php
error_reporting(E_ALL & ~ E_NOTICE);
session_start();
if(isset($_SESSION['id'])) {
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=leroyaumesucre;charset=utf8', 'root', '');
	$req = $bdd->prepare('SELECT * FROM membres WHERE id=?');
	$req->execute(array($_SESSION['id']));
	$userinfo=$req->fetch();
	$req1 = $bdd->query('SELECT * FROM membres');
	$req2 = $bdd->query('SELECT * FROM articles');
}
if($userinfo['Droit']==2) {
?>
<?php require 'topbar/nav.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Le Royaume Sucré</title>
	<link rel="stylesheet" href="nav.css">
</head>
<body>
	<h1>Panneau de commande</h1>
	<ul>
	<?php while($m = $req1->fetch()) {?>
	<li><?=$m['name']?> : <a href="php/supprimer.php?id=<?=$m['id']?>">supprimer</a><?php if($m['vérifier']==0) { ?> : <a href="php/confirmer.php?id=<?=$m['id']?>">confirmer</a><?php } ?></li>
	<?php }?>
	</ul>
	<br><br>
	<ul>
	<?php while($a = $req2->fetch()) {?>
	<li><?=$a['titre']?> : <a href="php/supprimer_art.php?id=<?=$a['id']?>">supprimer</a></li>
	<?php } ?>
	</ul>

	<a style="text-decoration: none;background-color: #e00000;color: white;" href="http://localhost/phpmyadmin/db_structure.php?server=1&db=leroyaumesucre">Base de donnée</a>
</body>
</html>
<?php
} else {
	header('Location: login.php');
}
?>