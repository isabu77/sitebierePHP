<?php
require_once 'includes/db.php';
require_once 'includes/connect.php';

if(isset($_POST)) {

	$beerTotal = $beerArray;

	$commande = [];
    $tabIds = [];
	$totalTTC = 0;
 	foreach($_POST['qty'] as $key => $value) {
		if($value > 0) {
			$beerTotal[$key][5] = $value;				// quantité commandée
			$beerTotal[$key][6] = $beerTotal[$key]['prixht']*$value; // prix HT * quantité
          	$totalTTC += $beerTotal[$key][6] * $tva;
			array_push($commande, $beerTotal[$key]);	// ligne de commande
			array_push($tabIds, $beerTotal[$key]['id']);  // l'id de la bière
 		}
	}

    // FRAIS de PORT : 5.40 € jusqu'à 30 €
    $FraisPort = 5.40;
    if ($totalTTC < 30){
	    $totalTTC += $FraisPort;
    }else{
   		$FraisPort = 0.00;

    }

    // lecture du user dans la base pour le mettre à jour
    $sql = "SELECT * FROM `users` WHERE `email` = '" . $currentUser["email"] . "'";
    $statement = $pdo->query($sql);
    $user = $statement->fetch();

    if(!empty($user)){
		$currentUser["id"] = $iduser = $user["id"];
		$currentUser["prenom"] = $prenom = htmlspecialchars($_POST["prenom"]);
		$currentUser["name"] = $nom = htmlspecialchars($_POST["nom"]);
		$currentUser["numrue"] = $numero = htmlspecialchars($_POST["numero"]);
		$currentUser["rue"] = $rue = htmlspecialchars($_POST["rue"]);
		$currentUser["codepostal"] = $cp = htmlspecialchars($_POST["cp"]);
		$currentUser["ville"] = $ville = htmlspecialchars($_POST["ville"]);
		$currentUser["pays"] = $pays = htmlspecialchars($_POST["pays"]);
		$currentUser["tel"] = $tel = htmlspecialchars($_POST["tel"]);
		//$_SESSION["user"] = $currentUser;

		// modification des infos du user dans la base
		$sql = 'UPDATE `users` SET `email` = :email, `name` = :name, `prenom`= :prenom, `numrue`= :numrue, `rue`=:rue,`codepostal`= :codepostal, `ville`= :ville, `pays`= :pays, `tel`= :tel WHERE `users`.`id` = :id ';
		  //var_dump($sql);die();
		$statement = $pdo->prepare($sql);
		$result = $statement->execute([
		        ':email'  => $currentUser["email"], 
		        ':name'   => $nom,
		        ':prenom'   => $prenom, 
		        ':numrue'   => $numero, 
		        ':rue'    => $rue, 
		        ':codepostal' => $cp, 
		        ':ville'  => $ville, 
		        ':pays'   => $pays, 
		        ':tel'    => $tel ,
		        ':id'    => $iduser 
		        ]);
      	if (!$result){
      		$_SESSION["UserError"] = "erreur de modification de vos coordonnées en base.";
      	}else{
      		$_SESSION["UserSuccess"] = "Vos coordonnées ont bien été modifiées.";
      	}

		// enregistrement de la commande dans la base
		$serial = serialize($tabIds);

		$sql = 'INSERT INTO `commandes` (`iduser`, `idsproduits`, `prixttc`) 
		            VALUES (:iduser, :idsproduits, :prixttc)';
		$statement = $pdo->prepare($sql);
		$result = $statement->execute([
		          ':iduser'  => $iduser, 
		          ':idsproduits'   => $serial,
		          ':prixttc' => $totalTTC
		           ]);
      	if (!$result){
      		$_SESSION["error"] = "Erreur d'enregistrement de la commande en base.";
      	}else{
      		$_SESSION["success"] = "La commande a bien été enregistrée.";
      	}
	}
}
else{
	$commande = [];
    $tabIds = [];
	$FraisPort = 5.40;
	$totalTTC = 0;
}

include 'includes/header.php';

include 'confirmationDeCommande.php'; ?>

<?php include 'includes/footer.php'; ?>