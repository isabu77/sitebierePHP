<?php
require_once 'includes/connect.php';
require_once 'includes/function.php';

$errusername = "";
$errpassword = "";
$errEmail = false;
$errMessage = "";

$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);

if(!empty($_POST)){
	if(	isset($_POST["email"]) && !empty($_POST["email"]) &&
		isset($_POST["password"]) && !empty($_POST["password"]) &&
		isset($_POST["robot"]) && empty($_POST["robot"])//protection robot
	){
		userConnect($_POST["email"], $_POST["password"]);
	}
	if (!$_SESSION['user']){
		$errusername = "class= 'danger'";
		$errusername = "class= 'danger'";
		$errEmail = true;
		$errMessage = "Email ou mot de passe invalides";
		//die('bac à sable');
	}


/*	$email = $_POST["email"];
	$password = $_POST["password"];
	if (!empty($email) && !empty($password)){
		$sql = 'SELECT * FROM `users` WHERE `email` = ?';
		$statement = $pdo->prepare($sql);
		$statement->execute([$email]);
		$user = $statement->fetch();
		if ($user && password_verify(htmlspecialchars($password), $user['password'])){
				
			unset($user["password"]);
			if (session_status() != PHP_SESSION_ACTIVE){
				session_start();
			}
			$_SESSION["user"] = $user;
			$_SESSION["connect"] = true;
			$_SESSION["email"] = $email;
			$_SESSION["username"] = $user['name'];
			$_SESSION["userfirstname"] = $user['prenom'];
			header("Location: commande.php");
			// FIN DU TRAITEMENT
			exit();
		}
		else{
			$errusername = "class= 'danger'";
			$errEmail = true;
			$errMessage = "Email ou mot de passe invalides";
		}
	}
	else{
		if (empty($username) ){
			$errusername = "class= 'danger'";
		}
		if (empty($password) ){
			$errpassword = "class= 'danger'";
		}
		$errEmail = true;
		$errMessage = "Email ou mot de passe invalides";
	}*/
}
else{
	$sql = 'SELECT * FROM `users`';
  	$statement = $pdo->query($sql);
 	$users = $statement->fetchAll();
  
	// si pas de compte, enchainer sur l'inscription 
	if(empty($users)){
		header("Location: ". uri("inscription.php"));
		// FIN DU TRAITEMENT
		exit();
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
					<input <?= $errusername ?> type="email" name="email" placeholder="Adresse mail"  />
					<input <?= $errpassword ?> type="password" name="password" placeholder="Mot de passe"  />
					<input type="text" name="robot" hidden/>
					<button type="submit">Connexion</button>
					<label class="danger" <?= $errEmail ? ' ': 'hidden'; ?> >ERREUR ! <?= $errMessage ?></label>
				</form>
				<a href="oublimdp.php">J'ai oublié mon mot de passe</a>
				<br />
				<a href="inscription.php?deconnect=true">S'inscrire</a>
				<a href="index.php">Les bières</a>
			</div>
		</section>
	</div>
</body>
</html>