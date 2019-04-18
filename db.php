<?php
require 'config.php';

// connexion bdd -> Isabelle -> table biere en forçant le type en UTF8
$dsn = 'mysql:dbname='.$dbname.';host='.$dbhost.';charset=UTF8';

try {
	$pdo = new PDO($dsn, $user, $psw);

} catch (Exception $e) {
	echo 'connexion échouée : ' . $e->getMessage();
}
try {
  $sql = 'SELECT * FROM `sitebiere`';
  $statement = $pdo->query($sql);
  $beerArray = $statement->fetchAll();
  
  // la remplir à partir du tableau si elle est vide 
  if(empty($beerArray)){
    require 'array_php.php';
    for ($i=0; $i < count($beerArrayOrigin) ; $i++){
      
          $sql = 'INSERT INTO `sitebiere` (`nom`, `image`, `description`, `prixht`) 
                  VALUES (:nom, :image, :description, :prixht)';
          $statement = $pdo->prepare($sql);
          $result = $statement->execute([
                    ':nom' => (String)$beerArrayOrigin[$i][0], 
                    ':image' => (String)$beerArrayOrigin[$i][1],
                    ':description' => (String)$beerArrayOrigin[$i][2],
                    ':prixht' => (String)$beerArrayOrigin[$i][3]
                  ]);
          if (!$result)
          {
            var_dump("erreur d'insert");die();
            break;
          }
    }
  }

} catch (Exception $e) {
	die( 'lecture échouée : ' . $e->getMessage());
	
}
