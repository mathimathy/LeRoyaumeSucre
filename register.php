<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=LeRoyaumeSucre;charset=utf8', 'root', '');
require 'topbar/nav.php';

if(isset($_POST['envoyer'])) {
	if(isset($_POST['pseudo'], $_POST['mail'], $_POST['mdp'], $_POST['mdp2']) and !empty($_POST['pseudo']) and !empty($_POST['mail']) and !empty($_POST['mdp']) and !empty($_POST['mdp2'])) {
		if($_POST['mdp']==$_POST['mdp2']) {
			$req=$bdd->prepare('SELECT * FROM membres WHERE mail=?');
			$req->execute(array($_POST['mail']));
			$req=$req->rowCount();
			if($req==0) {
				$name = htmlspecialchars($_POST['pseudo']);
				$mail = htmlspecialchars($_POST['mail']);
				$mdp = sha1($_POST['mdp']);
				$req=$bdd->prepare('INSERT INTO membres (name,mail,mdp) VALUES(?,?,?)');
				$req->execute(array($name,$mail,$mdp));
				$message='Le compte a bien été créer';
			} else {
				$message='L\'email est déjà utiliser';
			}
		} else {
			$message='Les mot de passe ne sont pas identique';
		}
	} else {
		$message='Veuiller remplir tout les champs !';
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
<body style="background-image: url(https://www.selection.ca/wp-content/uploads/sites/15/2016/03/bonbons-halloween.jpg)">
	<h1>Inscription</h1>
	<form action="" method="POST">
		<input type="text" placeholder="Pseudo" name="pseudo"><br>
		<input type="mail" placeholder="Mail" name="mail"><br>
		<input type="password" placeholder="Mot de passe" name="mdp"><br>
		<input type="password" placeholder="Confirmation mot de passe" name="mdp2"><br>
		<input type="submit" value="Envoyer" name='envoyer' id="envoyer"><br>
		<br>
		<?php
		if(isset($message)) {
			echo '<font color="red">'.$message.'</font>';
		}
		?>
	</form>
</body>
</html>