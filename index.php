<?php 
require 'connect.php';
// Connexion et Lecture de la table sitebiere pour la remplir à partir du tableau si elle est vide 
require_once 'db.php';

?>
<!-- PAGE PRINCIPALE de présentation des bières -->
<!DOCTYPE html>
<html>

<head>
  <meta charset='UTF-8' />
  <title>Les bières</title>
<!--   <link rel='stylesheet' href='style.css' />
 -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity    ="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="shortcut icon" href="assets/img/arbreVert.jpg">
</head>

<body id="home">
<div class="wrapper" class='container'>
  <!-- Entete  -->
  <header class="row">
    <h2 class='col-12 rounded text-white text-center bg-info col-md-12'>-----</h2>
    <h1 class='col-12 rounded text-white text-center bg-info col-md-12'>Les bières</h1>
    <h1 class='col-12 rounded text-white text-center bg-info col-md-12'>Compte : <?= $username?> </h1>
  </header>
  <!-- MENU  -->
    <nav id = "primary_nav" class="col-12 col-md-12 text-center font-weight-bold">
      <ul class="row">
        <li><a href="index.php">Les bières</a></li>
        <li><a href="identification.php">S'identifier</a></li>
        <li><a href="boncommande.php">Commander</a></li>
        <li><a href="mescommandes.php">Mes commandes</a></li>
        <li><a href="identification.php?deconnect=true">Déconnexion</a></li>
       
        <li class = "top"><a href="#home">Top</a></li>
      </ul>
      
    </nav>
    <!-- Bouton de lancement du fichier boncommande.php -->
<!--     <a href="boncommande.php">
        <input type = "button" value = "J'en veux !" class="col-6 col-md-6 offset-md-3 text-center font-weight-bold">
    </a>
 -->    <section class = 'row'>
      <!-- BOUCLE de lecture du tableau pour afficher un article par bière -->
<?php for ($i=0; $i < count($beerArray) ; $i++):?>
      <article class='text-center col-md-4 col-sm-6'>
        
        <h3 class="text-center text-truncate text-success font-weight-bold col-md-12"><?= (String)$beerArray[$i][1]?></h3>
        <img class="col-4 col-md-4 w-100" src="<?= (String)$beerArray[$i][2] ?>"/>
        <p class='text-justify col-md-10 offset-md-1 offset-sm-2' ><?= substr((String)$beerArray[$i][3],0,150) . '...';  ?></p>
        <div class = row>
          <label class='col-md-4 offset-md-2 text-center font-weight-bold' >Prix</label>
          <label class='col-md-3 offset-md-1 font-weight-bold'>Quantité</label>
        </div>
        <div class = row>
          <input readonly hidden type="text" id="ht<?= (String)$beerArray[$i][0]?>" value="<?=(String)number_format($beerArray[$i][4],2,',',' ').'€';?>">
          <input readonly type="text" id="ttc<?= (String)$beerArray[$i][0]?>" value="<?=(String)number_format($beerArray[$i][4]*1.2,2,',',' ').'€';?>" class='col-md-4 offset-md-2 text-center font-weight-bold' >
          <input type="number" class='col-md-3 offset-md-1 font-weight-bold' name="quantite[]" value=0 min= 0 oninput="quantitebiere(this,<?= (String)$beerArray[$i][0]?>,<?= (String)$beerArray[$i][4]?>, '');">
        </div>
     </article>
<?php  endfor; ?>
  </section>

</div>

<!-- JAVASCRIPT : fonctions de réponse aux boutons onclick -->
  <script src="assets/js/functions.js"></script>
</body>


</html>
