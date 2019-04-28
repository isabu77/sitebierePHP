<?php
require_once 'db.php';
require_once 'connect.php';

if(isset($_POST['email'])) {

	$beerTotal = $beerArray;

	$commande = [];
    $tabIds = [];
	$totalTTC = 0;
 	foreach($_POST['qty'] as $key => $value) {
		if($value > 0) {
			$beerTotal[$key][5] = $value;				// quantité commandée
			$beerTotal[$key][6] = $beerTotal[$key][4]*$value; // prix HT * quantité
          	$totalTTC += $beerTotal[$key][6] * $tva;
			array_push($commande, $beerTotal[$key]);	// ligne de commande
			array_push($tabIds, $beerTotal[$key][0]);  // l'id de la bière
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
    $sql = "SELECT * FROM `users` WHERE `email` = '" . $_POST['email'] . "'";
    $statement = $pdo->query($sql);
    $user = $statement->fetch();

    if(!empty($user)){
		$iduser = $user["id"];
		$prenom = $_POST["prenom"];
		$nom = $_POST["nom"];
		$email = $_POST["email"];
		$numero = $_POST["numero"];
		$rue = $_POST["rue"];
		$cp = $_POST["cp"];
		$ville = $_POST["ville"];
		$pays = $_POST["pays"];
		$tel = $_POST["tel"];

		// modification des infos du user dans la base
		$sql = 'UPDATE `users` SET `email` = :email, `name` = :name, `prenom`= :prenom, `numrue`= :numrue, `rue`=:rue,`codepostal`= :codepostal, `ville`= :ville, `pays`= :pays, `tel`= :tel WHERE `users`.`id` = :id ';
		  //var_dump($sql);die();
		$statement = $pdo->prepare($sql);
		$result = $statement->execute([
		        ':email'  => $email, 
		        ':name'   => $username,
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
        	// TODO signaler problème d'insertion
        	die("erreur modification du user en base");
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
			// TODO signaler problème d'insertion
			die("erreur enregistrement de la commande en base");
		}
	}
}
else{
	$commande = [];
    $tabIds = [];
	$FraisPort = 5.40;
}

include '../includes/header.php';

include '../confirmationDeCommande.php'; ?>

<?php include '../includes/footer.php'; ?>