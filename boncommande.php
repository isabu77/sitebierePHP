<?php require_once 'db.php';
// vérif connecté
require 'connect.php';
?>

            <!-- PHP : traitement des paramètres GET  dans l'url -->
<?php
// y a t il des paramètres GET à traiter ?
$submited = (count($_GET) == 0) ? false : true ;
// variables globales
$phrase;
$titre = "Bon de commande de bières pour : ". $username; // titre initial si pas de paramètres GET
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
          $prixTotalHT += $beerArray[$i][4]*$quantite;
          $prixTotalTTC += $beerArray[$i][4]*$quantite*1.2;
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
        $identite = strtoupper($_GET['prenom'] . ' ' . $_GET['nom']);
        $titre =  "Bonjour " . $identite . ' !';

        // composition de l'adresse
        $address = "";
        if(isset($_GET["numero"])){
          $address .= $_GET["numero"].' ';
        }
        if(isset($_GET["voie"])){
          $address .= $typeVoies[$_GET["voie"]].' ';
        }
        $address .= ucfirst($_GET["rue"]);
        $ville = $_GET["cp"]." ".ucfirst($_GET["ville"]);
        $phrase = "Bonjour, {$identite} vous habitez le {$address} à {$ville}";

  
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
 -->
  <link rel='stylesheet' href='assets/css/style.css' />
</head>

<body>
<div>
  
  <!-- LE HEADER : affichage du titre initial ou de Bonjour prénom nom ! -->
  <header class="row">
    <h2 class='col-12 rounded text-white text-center bg-info col-md-12'>-----</h2>
    <h1 class='col-12 rounded text-white text-center bg-info col-md-12'><?=$titre?></h1>
  </header>

<?php if (!$submited){ ?>
  <!-- PREMIER APPEL : si pas de paramètre GET  dans l'url -->
  <section id = "section1" class='container'>
    <!-- Formulaire client avec envoi sur soi-meme en mode GET -->
    <form action="" method="get" class = 'col-md-12'>
          <div class = "mb-2 form-group">
            <h2>Identification</h2>
          </div>

          <div class = "row mb-2 form-group">
            <input type="text" name="prenom" placeholder="*Prénom" required class="form-control col-md-5 offset-md-1" value='<?php echo isset($_GET["prenom"]) ? $_GET["prenom"]:''; ?>'>
            <input type="text" name="nom" placeholder="*Nom" required class="form-control col-md-5 offset-md-1">
          </div>

          <div class="row form-group" class = "mb-2">
            <input type="text" name="numero" placeholder="N°" class="form-control col-md-1 offset-md-1">
            <input type="text" name="rue" placeholder="*Nom de la rue" class="form-control col-md-8 offset-md-2">
          </div>
          
          <div class = "row mb-2">
            <input type="text" name="cp" placeholder="*CP" required class="form-control col-md-2 offset-md-1">
            <input type="text" name="ville" placeholder="*Ville" required class="form-control col-md-5 offset-md-1">
            <input type="text" name="pays" placeholder="*Pays" required class="form-control col-md-2 offset-md-1">
          </div>
          
          <div class = "row mb-2">
            <input type="text" name="tél" placeholder="*Tél" required class="form-control col-md-2 offset-md-1">
            <input type="text" name="email" placeholder="*E-mail" required class="form-control col-md-8 offset-md-1">
            <input type="password" name="password" placeholder="*Mot de passe" required class="form-control col-md-8 offset-md-1">
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
                  <td class="col-md-4"><?= (String)$beerArray[$i][1]?></td> <!-- Nom bière-->
                  <td class="col-md-2"><input readonly type="text" id="ht<?= (String)$beerArray[$i][0]?>" value="<?=(String)number_format($beerArray[$i][4],2,',',' ').'€';?>"></td> <!-- prix HT -->
                  <td class="col-md-2"><input readonly type="text" id="ttc<?= (String)$beerArray[$i][0]?>" value="<?=(String)number_format($beerArray[$i][4]*1.2,2,',',' ').'€';?>"></td> <!-- prix TTC-->
                  <td class="col-md-4"><input type="number" name="quantite[]" value=0 min= 0 oninput="quantitebiere(this,<?= (String)$beerArray[$i][0]?>,<?= (String)$beerArray[$i][4]?>, '');"></td> <!-- quantité-->
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
                  <td class="col-md-4"><?= (String)$beerArray[$i][1]?></td> <!-- Nom bière-->
                  <td class="col-md-2"><?=(String)number_format($quantite*$beerArray[$i][4],2,',',' ').'€';?></td> <!-- prix HT -->
                  <td class="col-md-2"><?=(String)number_format(1.2*$quantite*$beerArray[$i][4],2,',',' ').'€';?></td> <!-- prix TTC-->
                  <td class="col-md-4"><?=$quantite?></td> <!-- quantité-->
              </tr>
<?php }
      endfor; ?>
            </tbody>
          </table>
          <a class="col-md-2 offset-md-1 mt-2"href="boncommande.php">J'en veux encore !</a>

<?php } ?>
</div>

  <footer>
 <!-- MENU  -->
    <nav id = "primary_nav" class="col-12 col-md-12 text-center font-weight-bold">
      <ul class="row">
        <li><a href="index.php">Les bières</a></li>
        <li><a href="identification.php">S'identifier</a></li>
        <li><a href="boncommande.php">Commander</a></li>
        <li><a href="">Mes commandes</a></li>
        <li><a href="identification.php?deconnect=true">Déconnexion</a></li>
       
        <li class = "top"><a href="#home">Top</a></li>
      </ul>
      
    </nav>
    
  </footer>

<!-- SCRIPT JS : la fonction  quantitebiere() lancée au changement de la qantité commandée -->
  <script src="assets/js/functions.js"></script>
</body>


</html>
