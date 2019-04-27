<?php 
include 'includes/header.php';
require_once 'includes/function.php';

?>
<!-- PAGE PRINCIPALE de présentation des bières -->

  <!-- Entete  class="row"-->
  <section class = "row">
      <!-- BOUCLE de lecture du tableau pour afficher un article par bière -->
<?php for ($i=0; $i < count($beerArray) ; $i++):?>
      <article class='text-center col-md-4 col-sm-6'>
        
        <h3 class="text-center text-truncate text-success font-weight-bold col-md-12"><?= (String)$beerArray[$i][1]?></h3>
        <img class="col-4 col-md-4 w-100" src="<?= (String)$beerArray[$i][2] ?>"/>
        <p class='text-justify col-md-10 offset-md-1 offset-sm-2' ><?= substr((String)$beerArray[$i][3],0,150) . '...';  ?></p>
        <div class = "row">
          <label class='col-4 offset-2 col-md-4 offset-md-2 text-center font-weight-bold' >Prix</label>
          <label class='col-3 offset-1 col-md-3 offset-md-1 font-weight-bold'>Quantité</label>
        </div>
        <div class = "row">
          <input readonly hidden type="text" id="ht<?= (String)$beerArray[$i][0]?>" value="<?=(String)number_format($beerArray[$i][4],2,',',' ').'€';?>">
          <input readonly type="text" id="ttc<?= (String)$beerArray[$i][0]?>" value="<?=(String)number_format($beerArray[$i][4]*1.2,2,',',' ').'€';?>" class='col-4 offset-2 col-md-4 offset-md-2 text-center font-weight-bold' >
          <input type="number" class='col-3 offset-1 col-md-3 offset-md-1 font-weight-bold' name="quantite[]" value=0 min= 0 oninput="quantitebiere(this,<?= (String)$beerArray[$i][0]?>,<?= (String)$beerArray[$i][4]?>);">
        </div>
     </article>
<?php  endfor; ?>
  </section>

<?php include 'includes/footer.php'; ?>


