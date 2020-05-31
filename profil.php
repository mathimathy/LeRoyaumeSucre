<?php
require 'topbar/nav.php';
$bdd = new PDO('mysql:host=127.0.0.1;dbname=LeRoyaumeSucre;charset=utf8', 'root', '');
$req = $bdd->prepare('SELECT * FROM membres WHERE id=?');
$req->execute(array($_SESSION['id']));
$userinfo=$req->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Le Royaume Sucré</title>
	<link rel="stylesheet" href="nav.css">
</head>
<body align="center">
	<h1><?=$userinfo['name']?></h1>
	<p><?=$userinfo['mail']?></p>
</body>
</html>