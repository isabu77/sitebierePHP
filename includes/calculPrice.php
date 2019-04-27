<?php

if(isset($_POST['mail'])) {
	include ('../ressources/donnees.php');

	$beerTotal = $beerArray;

	$commande = [];
	foreach($_POST['qty'] as $key => $value) {
		if($value > 0) {
			$beerTotal[$key][4] = $value;
			$beerTotal[$key][5] = $beerTotal[$key][3]*$value;
			array_push($commande, $beerTotal[$key]);
		}
	}

	$totalTTC = 0;
	foreach ($commande as $key => $value) {
		$totalTTC += $value[5];
	}
}

include '../includes/header.php';

include '../confirmationDeCommande.php'; ?>

<?php include '../includes/footer.php'; ?>