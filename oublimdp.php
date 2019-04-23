<?php 
//bdd ->  UNE SEULE FOIS (once)
require_once 'db.php';

$errusername = "";
$erremail = "";


if(!empty($_POST)){
	$email = $_POST["email"];
	$username = $_POST["username"];
	if (!empty($email) && !empty($username)){
		/* verifier le user name */
		$sql = 'SELECT * FROM `users` WHERE `name` = :name AND `email` = :email';
		$statement = $pdo->prepare($sql);
		$statement->execute([':email' 	=> $email, 
							':name' 	=> $username]);
		$user = $statement->fetch();
		if ($user){
			// générer un nouveau mot de passe à sauvegarder dans la table users
			$passwordrdn = rand();
			$password = password_hash($passwordrdn, PASSWORD_BCRYPT);
			// modification des infos du user dans la base
			$sql = 'UPDATE `users` SET `password` = :password WHERE `users`.`id` = :id ';
			  //var_dump($sql);die();
			$statement = $pdo->prepare($sql);
			$result = $statement->execute([
			        ':password'  => $password, 
			        ':id'  => $user['id']
			        ]);
			if (!$result){
				// TODO signaler problème 
				die("erreur modification du password en base");
			}
			// envoyer le mot de passe à l'adresse mail saisie
/*			if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
			{
				$passage_ligne = "\r\n";
			}
			else
			{*/
				$passage_ligne = "\n";
			//}
			$boundary = "-----=".md5(rand());
			$header = "From: \"isabu77\"<montluconaformac2019@gmail.com>".$passage_ligne;
			//=====Création du header de l'e-mail
			$header = "From: \"isabu77\"<montluconaformac2019@gmail.com>".$passage_ligne;
			$header .= "MIME-Version: 1.0".$passage_ligne;
			$header .= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
			//==========		


			//=====Définition du sujet.
			$sujet = "Réinitialisation du mot de passe sur le site Bières";
			//=========	

			//=====Création du message.
			$message_text = "votre nouveau mot de passe est : " . $passwordrdn;
			$message = $passage_ligne."--".$boundary.$passage_ligne;
			$message .= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
			$message .= "Content-Transfer-Encoding: 8bit".$passage_ligne;
			$message.= $passage_ligne.$message_text.$passage_ligne;
			
			$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
			$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
			
			//=====Envoi de l'e-mail.
			$res = mail($email,$sujet,$message,$header);
			//==========

			//$res = mail($email, "Réinitialisation du mot de passe sur le site Bières", $texte);
			if ($res){
				// s'identifier avec le nouveau mot de passe
				header("Location: identification.php");
				// FIN DU TRAITEMENT
				exit();
			}
			else{
				$erremail = "class= 'danger'";
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
		if (empty($email) ){
			$erremail = "class= 'danger'";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Réinitialisation du mot de passe</title>
	<link rel="stylesheet" type="text/css" href="assets/css/form.css">
</head>
<body>
	<div class="wrapper">
		<section class="login-container">
			<div>
				<header>
					<h1>Site Bière</h1>
					<h1>Réinitialisation du mot de passe</h1>
				</header>
				<form action="" method="Post">
					<span>Pour récupérer votre compte, saisissez votre nom et votre adresse mail de connexion pour recevoir votre mot de passe</span>
					<input <?= $errusername ?> type="text" name="username" placeholder="NOM utilisateur"  />
					<input <?= $erremail ?> type="email" name="email" placeholder="Adresse mail"  />
					<button type="submit">Envoyer</button>
				</form>
			</div>
		</section>
	</div>
</body>
</html>