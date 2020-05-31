<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=LeRoyaumeSucre;charset=utf8', 'root', '');
require 'topbar/nav.php';

if(isset($_POST['envoyer'])) {
	if(isset($_POST['mail'], $_POST['mdp']) and !empty($_POST['mail']) and !empty($_POST['mdp'])) {
		
		$req=$bdd->prepare('SELECT * FROM membres WHERE mail=? AND mdp=?');
		$req->execute(array($_POST['mail'], sha1($_POST['mdp'])));
		$reqcount=$req->rowCount();
		$userinfo=$req->fetch();
		if($reqcount==1) {
			$_SESSION['isConnected']=1;
			$_SESSION['id']=$userinfo['id'];
			header('Location: home.php');

		} else {
			$message = 'Le mot de passe ou l\'email n\'est pas correct';
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
<body style="
	background-image: url(https://cdn-image.foodandwine.com/sites/default/files/styles/medium_2x/public/candytopia-ft-blog1117.jpg?itok=wwzj6Kdz);
">
	<h1 align="center">Connection</h1>
	<form action="" method="POST">
		<input type="mail" placeholder="Mail" name="mail" size="50"><br>
		<input type="password" placeholder="Mot de passe" name="mdp" size="50"><br>
		<input type="submit" value="Envoyer" name='envoyer'><br>
	</form>
	<br>
		<?php
		if(isset($message)) {
			echo '<font color="red">'.$message.'</font>';
		}
		?>
</body>
</html>