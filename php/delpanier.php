<?php
session_start();
if(isset($_SESSION['id']) and isset($_GET['id_article']) and !empty($_GET['id_article'])) {
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=leroyaumesucre;charset=utf8', 'root', '');
	$req=$bdd->prepare('DELETE FROM panier WHERE id_article=? and id_acheteur=?');
	$req->execute(array($_GET['id_article'], $_SESSION['id']));
	header('Location: ../panier.php');
}
?>