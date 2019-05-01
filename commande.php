<?php 
require_once 'includes/db.php';
require_once 'includes/connect.php';

if(!empty($currentUser)){
    $iduser = $currentUser["id"];
    $prenom = $currentUser["prenom"];
    $username = $currentUser["name"];
    $email = $currentUser["email"];
    $numero = $currentUser["numrue"];
    $rue = $currentUser["rue"];
    $cp = $currentUser["codepostal"];
    $ville = $currentUser["ville"];
    $pays = $currentUser["pays"];
    $tel = $currentUser["tel"];
  }
  else{
    header("Location: ". uri("login.php"));
    exit();
  }
?>

<?php 
include 'includes/header.php';
?>
	<form method="post" action="<?= uri("calculPrice.php") ?>" id="formPurchase">
          <div class = "mb-2 form-group">
            <h2>Identification</h2>
          </div>

          <div class = "row mb-2 form-group">
            <input type="text" name="prenom" value='<?= ($prenom) ? $prenom:''; ?>' placeholder="*Prénom" required class="form-control col-md-5 offset-md-1" >
            <input type="text" name="nom" value='<?= ($username) ? $username:''; ?>' placeholder="*Nom" required class="form-control col-md-5 offset-md-1">
          </div>

          <div class="row form-group" class = "mb-2">
            <input type="text" name="numero" value='<?= ($numero) ? $numero:''; ?>' placeholder="N°" class="form-control col-md-1 offset-md-1">
            <input type="text" name="rue" value='<?= ($rue) ? $rue:''; ?>' placeholder="*Nom de la rue" class="form-control col-md-8 offset-md-2">
          </div>
          
          <div class = "row mb-2">
            <input type="text" name="cp" value='<?= ($cp) ? $cp:''; ?>' placeholder="*CP" required class="form-control col-md-2 offset-md-1">
            <input type="text" name="ville" value='<?= ($ville) ? $ville:''; ?>' placeholder="*Ville" required class="form-control col-md-5 offset-md-1">
            <input type="text" name="pays" value='<?= ($pays) ? $pays:''; ?>' placeholder="*Pays" class="form-control col-md-2 offset-md-1">
          </div>
          
          <div class = "row mb-2">
            <input type="tel" name="tel" value='<?= ($tel) ? $tel:''; ?>' placeholder="*Tél" required class="form-control col-md-2 offset-md-1">
            <input type="text" name="email" value='<?= ($email) ? $email:''; ?>' placeholder="*E-mail" disabled class="form-control col-md-8 offset-md-1">
          </div>
          <!-- TABLEAU DE COMMANDE -->
          <div class = "mb-2 form-group">
            <h2>Commande</h2>
          </div>
          <table class = 'col-12 col-md-10 offset-md-1' >
            <!-- entete du tableau de commande -->
            <thead>
              <tr class="row">
                  <th class="col-4 ">Nom de la Bière</th> <!-- Nom bière-->
                  <th class="col ">prix HT</th> <!-- prix HT -->
                  <th class="col">prix TTC</th> <!-- prix TTC-->
                  <th class="col">Quantité</th> <!-- quantité-->
              </tr>
            </thead>
            <tbody>
<?php  for ($i=0; $i < count($beerArray) ; $i++):?>
              <tr class="row">
                  <td class="col"><?= (String)$beerArray[$i]["nom"]?></td> <!-- Nom bière-->
                  <td class="col" ><input class="col-12" readonly type="text" id="ht<?= (String)$beerArray[$i]['id']?>" value="<?=(String)number_format($beerArray[$i]['prixht'],2,',',' ').'€';?>"></td> <!-- prix HT -->
                  <td class="col" ><input class="col-12" readonly type="text" id="ttc<?= (String)$beerArray[$i]['id']?>" value="<?=(String)number_format($beerArray[$i]['prixht']*1.2,2,',',' ').'€';?>"></td> <!-- prix TTC-->
                  <td class="col" ><input class="col-12" type="number" name="qty[]" value=0 min= 0 oninput="quantitebiere(this,<?= (String)$beerArray[$i]['id']?>,<?= (String)$beerArray[$i]['prixht']?>);"></td> <!-- quantité-->
              </tr>
<?php  endfor; ?>
            </tbody>
          </table>
          <div class = "row mt-4">
            <!-- Bouton pour envoyer le formulaire -->
            <button type="submit" class="col-2 offset-8 col-md-2 offset-md-8 mt-2 mb-2">Commander</button>
          </div>
    </form>

<?php include 'includes/footer.php'; ?>
