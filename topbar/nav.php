<?php
session_start();
if(isset($_SESSION['id'])) {
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=leroyaumesucre;charset=utf8', 'root', '');
	$req = $bdd->prepare('SELECT * FROM membres WHERE id=?');
	$req->execute(array($_SESSION['id']));
	$userinfo=$req->fetch();
}?>
<?php
if(isset($_SESSION['isConnected']) and $userinfo['Droit']>0) {?>
<nav>
	<ul>
		<li><a href="home.php" class="other">Home</a></li>
		<li><a href="articleList.php" class="other">Liste des gateaux</a></li>
		<li><a href="panier.php" class="other">Mon Panier</a></li>
		<li><a href="profil.php" class="profil">profil</a></li>
		<li><a href="php/deconnection.php" class="profil">deconnection</a></li>
		<?php
		if($userinfo['Droit']==2) {
		?>
		<li><a href="admin.php" class="profil">Administration</a></li>
		<?php
		}
		?>
	</ul>
</nav>
<?php	
}elseif(isset($_SESSION['isConnected'])) {?>
<nav>
	<ul>
		<li><a href="home.php" class="other">Home</a></li>
		<li><a href="articleList.php" class="other">Liste des gateaux</a></li>
		<li><a href="panier.php">Mon Panier</a></li>
		<li><a href="profil.php" class="profil">profil</a></li>
		<li><a href="php/deconnection.php" class="profil">deconnection</a></li>
	</ul>
</nav>
<?php
} else {
?>
<nav>
	<ul>
		<li><a href="home.php" class="other">Home</a></li>
		<li><a href="register.php" class="other">inscription</a></li>
		<li><a href="login.php" class="other">connection</a></li>
	</ul>
</nav>
<?php
}
?>