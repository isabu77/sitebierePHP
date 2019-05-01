<h1 class="titreduhaut">Confirmation de commande</h1>

<div style="background-color:red;text-align:center;"><?= (isset($_SESSION["UserError"]) ? $_SESSION["UserError"] . "<hr />":"") ?></div> 
<div style="background-color:lightgreen;text-align:center;"><?php echo (isset($_SESSION["UserSuccess"]) ? $_SESSION["UserSuccess"]:""); unset($_SESSION["UserSuccess"]);  ?></div>

<div style="background-color:red;text-align:center;"><?= (isset($_SESSION["error"]) ? $_SESSION["error"]:"") ?></div> 
<div style="background-color:lightgreen;text-align:center;"><?php echo (isset($_SESSION["success"]) ? $_SESSION["success"]:""); unset($_SESSION["success"]);  ?></div>

<?php
	if (isset($_SESSION["UserError"])){
		unset($_SESSION["UserError"]);
	}
	if (isset($_SESSION["UserSuccess"])){
		unset($_SESSION["UserSuccess"]);
	}
	if (isset($_SESSION["error"])){
		unset($_SESSION["error"]);
	}
	if (isset($_SESSION["success"])){
		unset($_SESSION["success"]);
	}
?>

<section id="commandSection">
    <table class = 'col-md-10 offset-md-1' >
    <!-- 1ere ligne : titre -->
    <thead>
      <tr class="row">
		<th class="col-3">Nomination</th>
		<th class="col-2">Prix HT</th>
		<th class="col-2">Prix TTC</th>
		<th class="col-2">Quantité</th>
		<th class="col-3">Total TTC</th>
      </tr>
    </thead>
     <tfoot>
    <!-- avant derniere ligne : frais de port -->
       <tr class="row">
			<td class="col-3"><strong>FRAIS de PORT</strong></td>
			<td class="col-2"></td>
			<td class="col-2"></td>
			<td class="col-2"></td>
			<td class="col-3"><strong><?= (String)number_format($FraisPort,2,',',' ')?>€</strong></td>
      </tr>
    <!-- derniere ligne : totaux -->
       <tr class="row">
			<td class="col-3"><strong>Total TTC</strong></td>
			<td class="col-2"></td>
			<td class="col-2"></td>
			<td class="col-2"></td>
			<td class="col-3"><strong><?= number_format($totalTTC, 2, ',', '.'); ?>€</strong></td>
      </tr>
     
    </tfoot>
	<tbody>
		<?php foreach($commande as $key => $value) : ?>
			<tr class="row">
				<td class="col-3"><?= $value['nom'] ?></td>
				<td class="col-2"><?= number_format($value['prixht'], 2, ',', '.'); ?>€</td>
				<td class="col-2"><?= number_format($value['prixht']*$tva, 2, ',', '.');  ?>€</td>
				<td class="col-2"><?= $value[5] ?></td>
				<td class="col-3"><?= number_format($value[6]*$tva, 2, ',', '.'); ?>€</td>
			</tr>
		<?php endforeach; ?>
    </tbody>
  </table>
	<p style="text-align: center;">Celle-ci vous sera livrée au <?= $_POST['numero'] ?> <?= $_POST['rue'] ?> <?= $_POST['cp'] ?> <?= $_POST['ville'] ?> sous deux jours</p>
		<p style="text-align:center;">
			<small>Si vous ne réglez pas sous 10 jours, le prix de votre commande sera majoré.(25%/jour de retard)</small>
		</p>
</section>