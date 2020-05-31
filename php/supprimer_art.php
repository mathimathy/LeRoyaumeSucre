<?php
error_reporting(E_ALL & ~ E_NOTICE);
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=leroyaumesucre;charset=utf8', 'root', '');
if(isset($_GET['id']) and !empty($_GET['id'])) {
	$id = $_GET['id'];
	$req=$bdd->prepare('DELETE FROM articles WHERE id=?');
	$req->execute(array($id));
}
header('Location: ../admin.php');
?>