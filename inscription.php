<?php
require_once 'includes/function.php';
if (session_status() != PHP_SESSION_ACTIVE){
	session_start();
}

if(isset($_GET["deconnect"]) && $_GET["deconnect"]){
	unset($_SESSION["connect"]);
} 
if (isset($_SESSION["connect"])) {
	$connect = $_SESSION["connect"];
}else{
	$connect = false;
}
if($connect){
    header("Location: ". uri("login.php"));
	// FIN DU TRAITEMENT
	exit();
}

$errEmail = false;
$errMessage = "";

// traitement du formulaire d'inscription : ajout du compte dans la table users
if(!empty($_POST)){
	if(	isset($_POST["username"]) && !empty($_POST["username"]) &&
 		isset($_POST["prenom"]) && !empty($_POST["prenom"]) &&
		isset($_POST["numero"]) && !empty($_POST["numero"]) &&
		isset($_POST["rue"]) && !empty($_POST["rue"]) &&
		isset($_POST["cp"]) && !empty($_POST["cp"]) &&
		isset($_POST["ville"]) && !empty($_POST["ville"]) &&
		isset($_POST["pays"]) && !empty($_POST["pays"]) &&
		isset($_POST["tel"]) && !empty($_POST["tel"]) &&
		isset($_POST["email"]) && !empty($_POST["email"]) &&
		isset($_POST["password"]) && !empty($_POST["password"]) &&
		isset($_POST["robot"]) && empty($_POST["robot"]) && // protection robot
		isset($_POST["password_verif"]) && !empty($_POST["password_verif"])
	){
		$username = strtolower($_POST["username"]);
		$prenom = strtolower($_POST["prenom"]);
		$email = strtolower($_POST["email"]);
		$password = $_POST["password"];
		$passwordVerif = $_POST["password_verif"];
	    $numero = $_POST["numero"];
	    $rue = $_POST["rue"];
	    $cp = $_POST["cp"];
	    $ville = $_POST["ville"];
	    $pays = $_POST["pays"];
	    $tel = $_POST["tel"];

		if (!empty($username) && !empty($password) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) != false){
			$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);
			$sql = 'SELECT * FROM `users` WHERE `email` = ?';
			$statement = $pdo->prepare($sql);
			$statement->execute([$email]);
			$user = $statement->fetch();
			if (!$user){
				// vérifier la taille du password
				if (strlen($password) >= 5 && strlen($password) <= 10){
					// vérifier le password
					if ($password === $passwordVerif){
						// insérer le user dans la base avec cryptage du password
						$password = password_hash(htmlspecialchars($password), PASSWORD_BCRYPT);
						$sql = 'INSERT INTO `users` (`email`, `name`, `password`, `prenom`,`numrue`,`rue`,`codepostal`,`ville`,`pays`,`tel`) 
								VALUES (:email, :name, :password, :prenom,:numrue,:rue,:codepostal,:ville,:pays,:tel)';
						$statement = $pdo->prepare($sql);
						$result = $statement->execute([
											':email' 	=> htmlspecialchars($email), 
											':name' 	=> htmlspecialchars($username),
											':password' => $password, 
											':prenom' 	=> htmlspecialchars($prenom), 
											':numrue' 	=> htmlspecialchars($numero), 
											':rue' 		=> htmlspecialchars($rue), 
											':codepostal' => htmlspecialchars($cp), 
											':ville' 	=> htmlspecialchars($ville), 
											':pays' 	=> htmlspecialchars($pays), 
											':tel' 		=> htmlspecialchars($tel) 
											]);
						if ($result){
							// connexion directe et bon de commande
							$sql = 'SELECT * FROM `users` WHERE `email` = ?';
							$statement = $pdo->prepare($sql);
							$statement->execute([$email]);
							$user = $statement->fetch();
							unset($user["password"]);
							if (session_status() != PHP_SESSION_ACTIVE){
								session_start();
							}
							$_SESSION["user"] = $user;
							$_SESSION["connect"] = true;
							$_SESSION["username"] = $username;
							$_SESSION["email"] = $email;
    						header("Location: ". uri("commande.php"));
							// FIN DU TRAITEMENT
							exit();
						}else{
							// TODO signaler problème d'insertion
							$errEmail = true;
							$errMessage = "Insertion dans la base";
						}
					}else{
						// TODO signaler mdp différents
						$errEmail = true;
						$errMessage = "Les mots de passe sont différents";
					}
				}else{
					// TODO : signaler taille invalide du mdp
					$errEmail = true;
					$errMessage = "Le mot de passe doit avoir entre 5 et 13 caractères";

				}
			}else{
				// TODO signaler l'existence du username
				//die("cet utilisateur existe");
				//$errId = Document::getElementById("errlogin");
				$errEmail = true;
				$errMessage = "Ce compte existe déjà ! (même email)";
				//$errId.value =  "cet email existe déjà pour " . $user["prenom"] . " " . $user["name"];
			}
		}else{
			// TODO signaler les champs vides
			$errEmail = true;
			$errMessage = "Champs vides ou adresse mail invalide";
		}
	}else{
		$errEmail = true;
		$errMessage = "Champs vides ou invalides";

	}
}else{
	$errEmail = false;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>formulaire d'inscription</title>
	<link rel="stylesheet" type="text/css" href="assets/css/form.css">
</head>
<body>
	<div class="wrapper">
		<section class="login-container">
			<div>
				<header>
					<h1>Inscription</h1>
				</header>
				<form action="" method="Post">

		            <input type="text" name="username" placeholder="*Nom" required>
		            <input type="text" name="prenom" placeholder="*Prénom">
		            <input type="email" name="email" placeholder="*E-mail" required>
		            <input type="password" name="password" placeholder="*Mot de passe" required>
					<input  type="password" name="password_verif" placeholder="*Confirmez le mot de passe"  />
		            <input type="text" name="numero" placeholder="N°">
		            <input type="text" name="rue" placeholder="Nom de la rue" >
		            <input type="text" name="cp" placeholder="CP">
		            <input type="text" name="ville" placeholder="Ville">
		            <input type="text" name="pays" placeholder="Pays">
		            <input type="tel" name="tel" placeholder="Tél">
		            <input type="text" name="robot" hidden>

					<button type="submit">S'inscrire</button>
					<label class="danger" <?= $errEmail ? ' ': 'hidden'; ?> >ERREUR ! <?= $errMessage ?></label>
				</form>
				<a href="index.php">Les bières</a>
			</div>
		</section>
	</div>
	<footer>
		
	</footer>
</body>
</html>