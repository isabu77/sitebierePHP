<?php
require_once 'config.php';
require_once 'includes/function.php';

// Connexion et Lecture de la table sitebiere pour la remplir à partir du tableau si elle est vide 
$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);

try {
  $sql = 'SELECT * FROM `sitebiere`';
  $statement = $pdo->query($sql);
  $beerArray = $statement->fetchAll();
  
  // la remplir à partir du tableau si elle est vide 
  if(empty($beerArray)){
    require_once 'array_php.php';
    $sql = 'INSERT INTO `sitebiere` (`nom`, `image`, `description`, `prixht`) 
            VALUES (:nom, :image, :description, :prixht)';
    $statement = $pdo->prepare($sql);
    foreach ($beerArrayOrigin as $value) {
        $result = $statement->execute([
                                    ':nom'  => (String)$value[0],
                                    ':image'    => (String)$value[1],
                                    ':description'  => (String)$value[2],
                                    ':prixht'  => (String)$value[3]
                                    ]);
        if (!$result)
        {
          var_dump("erreur d'insertion");die();
          break;
        }
    }
    $sql = 'SELECT * FROM `sitebiere`';
    $statement = $pdo->query($sql);
    $beerArray = $statement->fetchAll();

  }

} catch (Exception $e) {
	die( 'lecture échouée : ' . $e->getMessage());
	
}
