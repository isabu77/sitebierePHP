<?php include("array_php.php")?>

            <!-- PHP : traitement des paramètres GET  dans l'url -->
<?php
// y a t il des paramètres GET à traiter ?
$submited = (count($_GET) == 0) ? false : true ;
// variables globales
$phrase;
$titre = "Bon de commande de bières"; // titre initial si pas de paramètres GET
$prixTotalHT;
$prixTotalTTC;
$quantiteTotal;

// TRAITEMENT des paramètres GET
if ($submited){
    $prixTotalHT = 0.00;
    $prixTotalTTC = 0.00;
    $quantiteTotal = 0;

    //var_dump($_GET);
    // calcul des totaux du tableau avec le paramètre quantité[] de chaque ligne
    for( $i = 0 ; $i < count($_GET['quantite']) ; $i++){
      $quantite = $_GET['quantite'][$i];
      if ( $quantite > 0){
        // on utilise le tableau initial beerArray pour avoir le prix unitaire de la bière
          $prixTotalHT += $beerArray[$i][3]*$quantite;
          $prixTotalTTC += $beerArray[$i][3]*$quantite*1.2;
          $quantiteTotal += $quantite;
      }

    }

    // afficher la confirmation de commande
    if (($_GET['nom']) 
        && ($_GET['prenom'])
        && ($_GET['rue'])
        && ($_GET['cp'])
        && ($_GET['ville'])
        ){

        // concaténer prénom et nom pour l'afficher avec Bonjour
        $identite = $_GET['prenom'] . ' ' . $_GET['nom'];
        $titre =  "Bonjour " . $identite . ' !';

        // composition de l'adresse
        $phrase = 'Vous habitez ';
        if (isset($_GET['numero'])){
            $phrase = $phrase . 'le ' . $_GET['numero'] . ' ';
        }
        if (isset($_GET['voie'])){
            $phrase = $phrase .  ' ' . $_GET['voie'] . ' ';
        }
        else{
            $phrase = $phrase .  ' rue ';
        }

        // la phrase 
        $phrase = $phrase .  $_GET['rue'] . ' à ' . $_GET['ville']. '<br />';
        
    }
    else{
        // TODO : gérer les erreurs de saisie
        //var_dump($_GET);
        $erreur=[];
        $erreur['nom'] = ($_GET['nom']!="") ?false:  true;
        $erreur['prenom'] = ($_GET['prenom']!="") ?false: true;
        $erreur['rue'] = ($_GET['rue']!="")?false: true ;
        $erreur['cp'] = ($_GET['cp']!="")?false: true;
        $erreur['ville'] = ($_GET['ville']!="")?false: true;
        //var_dump($erreur);
        $submited = false;
        echo "Veuillez remplir tous les champs obligatoires (*)";
    }
}
else{
        // TODO : gérer les erreurs de saisie pour réafficher le formulaire
        $phrase = "Bon de commande de bières";
        $erreur['nom'] = false;
        $erreur['prenom'] = false;
        $erreur['rue'] = false ;
        $erreur['cp'] = false;
        $erreur['ville'] = false;
}

?>

<!-- LA PAGE HTML du formulaire avec le bon de commande  -->
<!DOCTYPE html>
<html>

<head>
  <meta charset='UTF-8' />
  <title>Bon de commande de bières</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!--   PAS DE STYLE pour l'instant, on utilise BOOTSTRAP 
  <link rel='stylesheet' href='style.css' />
 -->
</head>

<body>
<div>
  
  <!-- LE HEADER : affichage du titre initial ou de Bonjour prénom nom ! -->
  <header class="row">
    <h1 class='col-12 rounded text-white text-center bg-info col-md-12'><?=$titre?></h1>
  </header>

<?php if (!$submited){ ?>
  <!-- PREMIER APPEL : si pas de paramètre GET  dans l'url -->
  <section id = "section1" class='container'>
    <!-- Formulaire client avec envoi sur soi-meme en mode GET -->
    <form action="" method="get" class = 'col-md-12'>
          <div class = "row mb-2">
          <input type="text" name="nom" placeholder="*Nom" required class="col-md-5 offset-md-1">
          <input type="text" name="prenom" placeholder="*Prénom" required class="col-md-5 offset-md-1">
          </div>
          <div class = "row mb-2">
          <input type="text" name="numero" placeholder="N°" class="col-md-1 offset-md-1">
          <input type="text" name="voie" placeholder="Type de voie" class="col-md-3 offset-md-1">
          <input type="text" name="rue" placeholder="*Rue" class="col-md-5 offset-md-1">
          </div>
          
          <div class = "row mb-2">
           <input type="text" name="cp" placeholder="*CP" required class="col-md-2 offset-md-1">
          <input type="text" name="ville" placeholder="*Ville" required class="col-md-5 offset-md-1">
          <input type="text" name="pays" placeholder="*Pays" required class="col-md-2 offset-md-1">
          </div>
          
          <div class = "row mb-2">
           <input type="text" name="tél" placeholder="*Tél" required class="col-md-2 offset-md-1">
          <input type="text" name="email" placeholder="*E-mail" required class="col-md-8 offset-md-1">
          </div>
          <!-- TABLEAU DE COMMANDE -->
          <table class = 'col-md-10 offset-md-1' >
            <!-- entete du tableau de commande -->
            <thead>
              <tr class="row">
                  <th class="col-md-4">Nom de la Bière</th> <!-- Nom bière-->
                  <th class="col-md-2">prix HT</th> <!-- prix HT -->
                  <th class="col-md-2">prix TTC</th> <!-- prix TTC-->
                  <th class="col-md-4">Quantité</th> <!-- quantité-->
              </tr>
            </thead>
            <tbody>
<?php  for ($i=0; $i < count($beerArray) ; $i++):?>
              <tr class="row">
                  <td class="col-md-4"><?= (String)$beerArray[$i][0]?></td> <!-- Nom bière-->
                  <td class="col-md-2"><input readonly type="text" value="<?=(String)number_format($beerArray[$i][3],2,',',' ').'€';?>"></td> <!-- prix HT -->
                  <td class="col-md-2"><input readonly type="text" value="<?=(String)number_format($beerArray[$i][3]*1.2,2,',',' ').'€';?>"></td> <!-- prix TTC-->
                  <td class="col-md-4"><input type="number" name="quantite[]" value=0 min= 0 oninput="quantitebiere(this,<?= (String)$beerArray[$i][3]?>);"></td> <!-- quantité-->
              </tr>
<?php  endfor; ?>
            </tbody>
          </table>
          <div class = "row mt-4">
            <!-- Bouton pour envoyer le formulaire -->
            <button type="submit" class="col-md-2 offset-md-6 mt-2">Envoyer</button>
          </div>
    </form>

  </section>
<?php }else{ ?>
            <!-- SECOND APPEL : traitement des paramètres GET  dans l'url -->
            <!-- CONFIRMATION de la COMMANDE -->
    <h2 class='col-12 rounded text-white text-center bg-info col-md-8 offset-md-1'>Voici la confirmation de votre commande</h2>

            <table class = 'col-md-10 offset-md-1' >
            <!-- 1ere ligne : titre -->
            <thead>
              <tr class="row">
                  <th class="col-md-4">Nom de la Bière</th> <!-- Nom bière-->
                  <th class="col-md-2">prix HT</th> <!-- prix HT -->
                  <th class="col-md-2">prix TTC</th> <!-- prix TTC-->
                  <th class="col-md-4">Quantité</th> <!-- quantité-->
              </tr>
            </thead>
            <!-- derniere ligne : totaux -->
             <tfoot>
               <tr class="row">
                  <th class="col-md-4">TOTAL</th> <!-- Nom bière-->
                  <th class="col-md-2"><?= (String)number_format($prixTotalHT,2,',',' ').' €'?></th> <!-- prix HT -->
                  <th class="col-md-2"><?= (String)number_format($prixTotalTTC,2,',',' ').' €'?></th> <!-- prix TTC-->
                  <th class="col-md-4"><?= $quantiteTotal?></th> <!-- quantité-->
              </tr>
             
            </tfoot>
            <tbody>
<?php  for ($i=0; $i < count($_GET['quantite']) ; $i++):?>
<?php  
      $quantite = $_GET['quantite'][$i];
      if ( $quantite > 0){
?>
              <tr class="row">
                  <td class="col-md-4"><?= (String)$beerArray[$i][0]?></td> <!-- Nom bière-->
                  <td class="col-md-2"><?=(String)number_format($quantite*$beerArray[$i][3],2,',',' ').'€';?></td> <!-- prix HT -->
                  <td class="col-md-2"><?=(String)number_format(1.2*$quantite*$beerArray[$i][3],2,',',' ').'€';?></td> <!-- prix TTC-->
                  <td class="col-md-4"><?=$quantite?></td> <!-- quantité-->
              </tr>
<?php }
      endfor; ?>
            </tbody>
          </table>
          <a class="col-md-2 offset-md-1 mt-2"href="boncommande.php">J'en veux encore !</a>

<?php } ?>
</div>

<!-- SCRIPT JS : la fonction  quantitebiere() lancée au changement de la qantité commandée -->
  <script src="assets/js/functions.js"></script>
</body>


</html>
