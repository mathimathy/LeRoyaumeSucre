<?php
require 'topbar/nav.php';
if(isset($_SESSION['isConnected']) and isset($_SESSION['id']) and isset($_GET['id']) and !empty($_GET['id'])) {
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=leroyaumesucre;charset=utf8', 'root', '');
	$req = $bdd->prepare('SELECT * FROM membres WHERE id=?');
	$req->execute(array($_SESSION['id']));
	$userinfo=$req->fetch();
	$req2 = $bdd->prepare('SELECT * FROM articles WHERE id=?');
	$req2->execute(array($_GET['id']));
	$artinfo=$req2->fetch();
	$req3=$bdd->prepare('SELECT * FROM products WHERE id=?');
	$req3->execute(array($_GET['id']));
	$artinfo2=$req3->fetch();
	$like=$bdd->prepare('SELECT * FROM likes WHERE id_article=?');
	$like->execute(array($artinfo['id']));
	$like=$like->rowCount();
	$dislike=$bdd->prepare('SELECT * FROM dislikes WHERE id_article=?');
	$dislike->execute(array($artinfo['id']));
	$dislike=$dislike->rowCount();
	if(isset($_POST['submit'])) {
		if(isset($_POST['commentaire']) and !empty($_POST['commentaire'])) {
			$req4 = $bdd->prepare('INSERT INTO commentaire (id_article, id_user, commentaire) VALUES(?,?,?)');
			$req4->execute(array($artinfo['id'], $_SESSION['id'], $_POST['commentaire']));
			$message = 'Le commentaire a bien été posté';
		} else {
			$message = 'Veuillez remplier tous les champs';
		}
	}
	$commentaire = $bdd->prepare('SELECT * FROM commentaire WHERE id_article=? ORDER BY id DESC');
	$commentaire->execute(array($artinfo['id']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Le Royaume Sucré</title>
	<link rel="stylesheet" href="nav.css">
</head>
<body>
	<h1 align="center"><?=$artinfo['titre']?></h1>
	<br><br>
	<img width="500" class="center" src="img_gateaux/<?= $artinfo['id']?>.jpg">
	<p align="center">Description: <?=$artinfo['contenu']?></p><br>
	<br>
	<p align="right" style="font-size: 20;">Prix: <?=$artinfo2['prix']?>€</p>
	<br>
	<a style="text-decoration: none;background-color: red;color: white;" href="php/addpanier.php?id_article=<?= $artinfo['id']?>" class="right">Ajouter au panier</a>
	<section class="commentaire">
		<a href="php/action.php?id=<?=$artinfo['id']?>&action=1">like (<?=$like?>)</a>  <a href="php/action.php?id=<?=$artinfo['id']?>&action=2">dislike (<?=$dislike?>)</a>
		<h1>Commentaire</h1>
		<form action="" method="POST">
			<input type="text" placeholder="commentaire" name="commentaire" class="commentaire"><br>
			<input type="submit" value="Envoyer !" name="submit">
		</form>
		<?php if(isset($message)) { echo '<font color="red">'.$message.'</font>'; } ?>
		<ul>
		<?php while($m = $commentaire->fetch()) {
			$userinfo = $bdd->prepare('SELECT * FROM membres WHERE id=?');
			$userinfo->execute(array($m['id_user']));
			$userinfo = $userinfo->fetch();

		?>
			<li style="list-style-type: none;"><?=$userinfo['name']?><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$m['commentaire']?></li>
		<?php } ?>
	</ul>
	</section>
</body>
</html>
<?php } else {
	header('Location: connection.php');
}?>