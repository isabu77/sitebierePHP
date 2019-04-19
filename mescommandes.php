<?php
require_once 'db.php';
// vérif connecté
require 'connect.php';
   // lecture du user dans la base pour le mettre à jour
    $sql = "SELECT * FROM `users` WHERE `name` = '" . $username . "'";
    $statement = $pdo->query($sql);
    $user = $statement->fetch();

    if(!empty($user)){
      $iduser = $user["id"];
      // lecture des commandes dans la base
      $sql = "SELECT * FROM `commandes` WHERE `iduser` = '" . $iduser . "'";
      $statement = $pdo->query($sql);
      $commandes = $statement->fetchAll();

      if (!empty($commandes)){

      }
    }else{
        header("Location: identification.php");
        exit();
    }

?>

<!-- LA PAGE HTML du formulaire et des commandes  -->
<!DOCTYPE html>
<html>

<head>
  <meta charset='UTF-8' />
  <title>mes commandes de bières</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel='stylesheet' href='assets/css/style.css' />
</head>

<body>
<div class='wrapper container'>
  
  <!-- LE HEADER : affichage du titre initial ou de Bonjour prénom nom ! -->
  <header class="row">
    <h2 class='col-12 rounded text-white text-center bg-info col-md-12'></h2>
    <h2 class='col-12 rounded text-white text-center bg-info col-md-8 offset-md-1'><?= $user["prenom"]?>, voici vos commandes :</h2>
<!--     <h1 class='col-12 rounded text-white text-center bg-info col-md-12'><?=$titre?></h1>
 -->  
  </header>

 <!-- MENU  -->
    <nav id = "primary_nav" class="col-12 col-md-12 text-center font-weight-bold">
      <ul class="row">
        <li><a href="index.php">Les bières</a></li>
        <li><a href="identification.php">S'identifier</a></li>
        <li><a href="boncommande.php">Commander</a></li>
         <li><a href="identification.php?deconnect=true">Déconnexion</a></li>
      </ul>
    </nav>

    <table class = 'col-10 offset-1 col-md-10 offset-md-1' >
    <!-- 1ere ligne : titre -->
    <thead>
      <tr class="row">
          <th class="col-2 offset-1 col-md-2 offset-md-1">N° commande</th> 
          <th class="col-2 offset-2 col-md-2 offset-md-2">Nb produits</th> 
          <th class="col-4 offset-1 col-md-2 offset-md-2">Prix total</th> 
      </tr>
    </thead>
    <!-- derniere ligne : total -->
     <tfoot>
    <!-- TODO : total de toutes les commandes --> 
    </tfoot>
    <tbody>
<?php 
  foreach ($commandes as $commande){
      // tableau des ids produits
      $idProds = unserialize($commande['idsproduits']);
      echo '<tr class="row">';
      echo '<th class="col-2 offset-1 col-md-2 offset-md-1">'. $commande['id'] . '</th>';
      echo '<th class="col-2 offset-2 col-md-2 offset-md-2">' . count($idProds) . '</th> ';
      echo '<th class="col-4 offset-1 col-md-2 offset-md-2">' . (String)number_format($commande['prixttc'], 2,',',' ') . ' €</th> ';
      echo '</tr>';
  }
?>    
    </tbody>
  </table>
</div>

  <footer>
    
  </footer>

</body>


</html>
