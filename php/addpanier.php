<?php
session_start();
if(isset($_SESSION['id']) and isset($_GET['id_article']) and !empty($_GET['id_article'])) {
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=leroyaumesucre;charset=utf8', 'root', '');
	$req=$bdd->prepare('INSERT INTO panier (id_article,id_acheteur) VALUES(?,?)');
	$req->execute(array($_GET['id_article'], $_SESSION['id']));
	header('Location: ../panier.php');
}
?>