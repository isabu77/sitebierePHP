<?php

require 'connect.php';

$errusername = "";
$errpassword = "";

//var_dump($stock);die();

if(!empty($_POST)){
	//$stock = require 'stock.php';
	$email = $_POST["email"];
	$password = $_POST["password"];
	if (!empty($email) && !empty($password)){
		/* verifier couple user / mdp */
		//bdd -> Isabelle -> table users UNE SEULE FOIS (once)
		require_once 'db.php';
		//$sql = 'SELECT * FROM `users` WHERE `name` = "' . $username . '"';
		$sql = 'SELECT * FROM `users` WHERE `email` = ?';
		$statement = $pdo->prepare($sql);
		$statement->execute([$email]);
		$user = $statement->fetch();
		var_dump($user);die();
		if ($user){
			if (password_verify($password, $user['password'])){
					
				$_SESSION["connect"] = true;
				$_SESSION["email"] = $email;
				$_SESSION["username"] = $user['name'];
				header("Location: index.php");
				// FIN DU TRAITEMENT
				exit();
			}
			else{
				$errpassword = "class= 'danger'";
			}
		}
		else{
			$errusername = "class= 'danger'";
		}
	}
	else{
		/* signaler qu'il manque un champ  */
		if (empty($username) ){
			$errusername = "class= 'danger'";
		}
		if (empty($password) ){
			$errpassword = "class= 'danger'";
		}
	}
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>formulaire de connexion</title>
	<link rel="stylesheet" type="text/css" href="assets/css/form.css">
</head>
<body>
	<div class="wrapper">
		<section class="login-container">
			<div>
				<header>
					<h2>Identification</h2>
				</header>
				<form action="" method="Post">
					<input <?= $errusername ?> type="text" name="email" placeholder="Adresse mail"  />
					<input <?= $errpassword ?> type="password" name="password" placeholder="Mot de passe"  />
					<button type="submit">Connexion</button>
				</form>
				<a href="login.php?deconnect=true">S'inscrire</a>
				<a href="index.php">Accueil</a>
			</div>
		</section>
	</div>
</body>
</html>