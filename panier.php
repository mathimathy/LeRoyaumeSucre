<?php
require 'topbar/nav.php';
$bdd=new PDO('mysql:host=127.0.0.1;dbname=leroyaumesucre;charset=utf8', 'root', '');
if(isset($_SESSION['id'])) {
	$req=$bdd->prepare('SELECT * FROM panier WHERE id_acheteur=?');
	$req->execute(array($_SESSION['id']));
	$total=0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Le Royaume Sucré</title>
	<link rel="stylesheet" href="nav.css">
</head>
<body>
	<h1 align="center">Le panier</h1>
	<ul>
		<?php
		while($m = $req->fetch()) {
			$req2 = $bdd->prepare('SELECT * FROM articles WHERE id=?');
			$req3 = $bdd->prepare('SELECT * FROM products WHERE id=?');
			$req2->execute(array($m['id_article']));
			$req3->execute(array($m['id_article']));
			$artinfo=$req2->fetch();
			$proinfo=$req3->fetch();
			$total+=$proinfo['prix'];
		?>
		<li><img src="img_gateaux/<?=$artinfo['id']?>.jpg" width="100"><br><a style="text-decoration: none;" href="article.php?id=<?=$artinfo['id']?>"><?=$artinfo['titre']?></a> <?=$proinfo['prix']?>€ <a style="color: #d00000;text-decoration: none;" href="php/delpanier.php?id_article=<?=$artinfo['id']?>">supprimer</a></li>
		<?php
		}
		?><br>
		<br>
		<br>
		<p style="top: 95%;position: absolute; right: 2px;">Total: <?=$total?>€</p>
	</ul>
</body>
</html>