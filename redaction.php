<?php
error_reporting(E_ALL & ~ E_WARNING);
require 'topbar/nav.php';
$bdd = new PDO('mysql:host=127.0.0.1;dbname=leroyaumesucre;charset=utf8', 'root', '');
if(isset($_SESSION['isConnected'], $_SESSION['id'])) {
	$req=$bdd->prepare('SELECT * FROM membres WHERE id=?');
	$req->execute(array($_SESSION['id']));
	$userinfo=$req->fetch();
	if($userinfo['Droit']>0) {
		if(isset($_POST['envoyer'])) {
			if(isset($_POST['title'], $_POST['contenu'], $_POST['price'], $_FILES['miniature']) and !empty($_POST['contenu']) and !empty($_POST['title']) and !$_POST['price']==NULL and !empty($_FILES['miniature'])) {
				if(exif_imagetype($_FILES['miniature']['tmp_name'])==2) {
					$title=$_POST['title'];
					$contenu=$_POST['contenu'];
					$editor=$userinfo['id'];
					$req=$bdd->prepare('INSERT INTO articles (titre,contenu,editor,date_time_publication) VALUES(?,?,?,NOW())');
					$req->execute(array($title, $contenu, $editor));
					$req2 = $bdd->prepare('INSERT INTO products (name, prix) VALUES(?,?)');
					$req2->execute(array($title, $_POST['price']));
					$lastid=$bdd->lastInsertId();
					$chemin = 'img_gateaux/'.$lastid.'.jpg';
					move_uploaded_file($_FILES['miniature']['tmp_name'], $chemin);
					$message = 'Le gateau a bien été mis en ligne';
				} else {
					$message = 'La photo doit être au format JPG ou JPEG';
				}
				
			} else {
				$message = 'Veuillez remplir tous les champs';
			}
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Le Royaume Sucré</title>
	<link rel="stylesheet" href="nav.css">
	<link rel="stylesheet" href="form.css">
</head>
<body>
	<h1>Création d'un gateau</h1>
	<form action="" method="POST" enctype="multipart/form-data">
		<input type="text" placeholder="Nom du gateau" name="title"><br>
		<textarea name="contenu" cols="68" rows="5" placeholder="Explication"></textarea><br>
		<input type="number" min="0" name="price" step="0.01" placeholder="prix"><br>
		<input type="file" name="miniature"><br>
		<input type="submit" name="envoyer" value="Créer"><br>
	</form>
	<?php
	if(isset($message)) {
		echo "<font color=\"red\">".$message.'</font>';
	}
	?>
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
</head>
<body>
	<h1>Vous n'avez pas le droit de créer des gateaux</h1>
</body>
</html>
<?php
	}
?>
<?php
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Le Royaume Sucré</title>
</head>
<body>
	<h1>Veuillez vous connecter !</h1>
</body>
</html>
<?php } ?>