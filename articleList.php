<?php
require 'topbar/nav.php';
if(isset($_SESSION['isConnected']) and isset($_SESSION['id'])) {
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=leroyaumesucre;charset=utf8', 'root', '');
	$req = $bdd->prepare('SELECT * FROM membres WHERE id=?');
	$req->execute(array($_SESSION['id']));
	$userinfo=$req->fetch();
	$req2 = $bdd->prepare('SELECT * FROM articles');
	$req2->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Le Royaume Sucré</title>
	<link rel="stylesheet" href="nav.css">
</head>
<body>
	<h1>Liste des gateaux</h1>
	<?php
	if($userinfo['Droit']>0) {
	?>
	<a href="redaction.php">Ajouter un gateau</a>
	<?php
	}?>

	<ul style="list-style-type: none;text-decoration: none;">
	<?php
	while($m=$req2->fetch()) { ?>
		<li>
			<a style="text-decoration: none;" href="article.php?id=<?=$m['id']?>">
			<img src="img_gateaux/<?= $m['id']?>.jpg" width="200"><br>
			<?=$m['titre']?> : <?=date('d F Y', strtotime($m['date_time_publication']))?></a>
		</li>
		<br>
	
	<?php
	}
	?>
	</ul>
</body>
</html>
<?php
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Le Royaume Sucré</title>
	<link rel="stylesheet" href="nav.css">
</head>
<body>
	<h1>Liste des gateaux</h1>
	<p><font color="red">Veuiller vous connectez pour voir la liste des gateaux</font></p>
</body>
</html>
<?php
}
?>