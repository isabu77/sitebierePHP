<?php include("array_php.php")?>
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
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
<div class='container'>
  <!-- Entete  -->
  <header class="row">
    <h1 class='col-12 rounded text-white text-center bg-info col-md-12'>Les bières</h1>
     
 </header>
    <!-- Bouton de lancement du fichier boncommande.php -->
    <a href="boncommande.php">
        <input type = "button" value = "J'en veux !" class="col-6 col-md-6 offset-md-3 text-center font-weight-bold">
    </a>
    <section class = 'row'>
      <!-- BOUCLE de lecture du tableau pour afficher un article par bière -->
<?php for ($i=0; $i < count($beerArray) ; $i++):?>
      <article class='text-center col-md-4 col-sm-6'>
        <h3 class="text-center text-truncate text-success font-weight-bold col-md-12"><?= (String)$beerArray[$i][0]?></h3>
        <img class="col-4 col-md-4 w-100" src="<?= $beerArray[$i][1] ?>"/>
        <p class='text-justify col-md-10 offset-md-1 offset-sm-2' ><?= substr((String)$beerArray[$i][2],0,150) . '...';  ?></p>
        <div class = row>
          <h3 class='col-md-8 text-center font-weight-bold' id='<?= $i; ?>'><?=(String)number_format($beerArray[$i][3]*1.2,2,',',' ') . '€';?></h3>
          <button onclick= retirebiere(this,<?=$beerArray[$i][3]*1.2?>) class="col-md-1 text-center font-weight-bold">-</button>
          <button onclick= ajoutbiere(this,<?=$beerArray[$i][3]*1.2?>) class="col-md-1 text-center font-weight-bold">+</button>
        </div>
     </article>
<?php  endfor; ?>
  </section>

</div>

<!-- JAVASCRIPT : fonctions de réponse aux boutons onclick -->
  <script src="assets/js/functions.js"></script>
</body>


</html>
