<?php 
$index = false;
include 'includes/header.php'; ?>
<?php
  if(!empty($currentUser)){
      $iduser = $currentUser["id"];
      // lecture des commandes dans la base
      $sql = "SELECT * FROM `commandes` WHERE `iduser` = '" . $iduser . "'";
      $statement = $pdo->query($sql);
      $commandes = $statement->fetchAll();

      if (empty($commandes)){
        header("Location: identification.php");
        exit();
      }
  }
  else{
    header("Location: identification.php");
    exit();
  }
    

?>

<!-- LA PAGE HTML du formulaire et des commandes  -->
<div class='container'>
  
  <!-- affichage du titre initial ou de Bonjour prénom nom ! -->
    <h2 class='col-12 text-center col-md-8 offset-md-1'><?= $currentUser["prenom"]?>, voici vos commandes :</h2>

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

<?php include 'includes/footer.php'; ?>
