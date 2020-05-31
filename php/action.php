<?php 
error_reporting(E_ALL & ~ E_NOTICE);
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=leroyaumesucre;charset=utf8', 'root', '');
if(isset($_GET['id'], $_GET['action'], $_SESSION['id']) and !empty($_GET['id']) and !empty($_GET['action']) and !empty($_SESSION['id'])) {
	$id_article = $_GET['id'];
	$action = $_GET['action'];
	$id_user = $_SESSION['id'];
	if($action == 1) {
		$req = $bdd->prepare('SELECT * FROM likes WHERE id_article=? AND id_user=?');
		$req->execute(array($id_article, $id_user));
		$req=$req->rowCount();
		if($req==0) {
			$req3 = $bdd->prepare('INSERT INTO likes (id_article, id_user) VALUES(?,?)');
			$req3->execute(array($id_article, $id_user));
		} else {
			$req2 = $bdd->prepare('DELETE FROM likes WHERE id_article=? AND id_user=?');
			$req2->execute(array($id_article, $id_user));
		}
		header('Location: ../article.php?id='.$id_article);
	} elseif($action == 2) {
		$req = $bdd->prepare('SELECT * FROM dislikes WHERE id_article=? AND id_user=?');
		$req->execute(array($id_article, $id_user));
		$req=$req->rowCount();
		if($req==0) {
			$req3 = $bdd->prepare('INSERT INTO dislikes (id_article, id_user) VALUES(?,?)');
			$req3->execute(array($id_article, $id_user));
		} else {
			$req2 = $bdd->prepare('DELETE FROM dislikes WHERE id_article=? AND id_user=?');
			$req2->execute(array($id_article, $id_user));
		}
		header('Location: ../article.php?id='.$id_article);
	} else {
		header('Location: ../article.php?id='.$id_article);
	}
} else {
	header('Location: ../article.php?id='.$id_article);
}
?>