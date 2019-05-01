<?php
require_once 'includes/db.php';
// vérif connecté
require 'includes/connect.php';

            //  PHP : traitement des paramètres GET  dans l'url 

// y a t il des paramètres GET à traiter ?
$submited = (count($_GET) == 0) ? false : true ;
// variables globales
$titre = "Bon de commande"; // titre initial si pas de paramètres GET
$prixTotalHT;
$prixTotalTTC;
$quantiteTotal;

// TRAITEMENT des paramètres GET de la commande
if ($submited){
    $prixTotalHT = 0.00;
    $prixTotalTTC = 0.00;
   $quantiteTotal = 0;
    $tabIds = [];
    $j = 0;
    //var_dump($_GET);
    // calcul des totaux du tableau avec le paramètre quantité[] de chaque ligne
    for( $i = 0 ; $i < count($_GET['quantite']) ; $i++){
      $quantite = $_GET['quantite'][$i];
      if ( $quantite > 0){
        // on utilise le tableau initial beerArray pour avoir le prix unitaire de la bière
          $prixTotalHT += $beerArray[$i][4]*$quantite;
          $prixTotalTTC += $beerArray[$i][4]*$quantite*1.2;
          $quantiteTotal += $quantite;
          $tabIds[$j++] = $beerArray[$i][0];
      }

    }
    // FRAIS de PORT
    $FraisPort = 0.00;
    if ($prixTotalTTC < 30){
        $FraisPort = 5.40;
    }
    $prixTotalTTC += $FraisPort;

    // afficher la confirmation de commande
    if (($_GET['nom']) 
/*        && ($_GET['prenom'])
        && ($_GET['rue'])
        && ($_GET['cp'])
        && ($_GET['ville'])
*/        ){

        // concaténer prénom et nom pour l'afficher avec Bonjour
        //$identite = strtoupper($_GET['prenom'] . ' ' . $_GET['nom']);
        $titre =  "Voici la confirmation de votre commande";// . $identite . ' !';

        // lecture du user dans la base pour le mettre à jour
        $sql = "SELECT * FROM `users` WHERE `email` = '" . $useremail . "'";
        $statement = $pdo->query($sql);
        $user = $statement->fetch();

        if(!empty($user)){
          $iduser = $user["id"];
          $prenom = $_GET["prenom"];
          $nom = $_GET["nom"];
          $email = $_GET["email"];
          $numero = $_GET["numero"];
          $rue = $_GET["rue"];
          $cp = $_GET["cp"];
          $ville = $_GET["ville"];
          $pays = $_GET["pays"];
          $tel = $_GET["tel"];
          // enregistrement de la commande dans la base
         $serial = serialize($tabIds);

          $sql = 'INSERT INTO `commandes` (`iduser`, `idsproduits`, `prixttc`) 
                        VALUES (:iduser, :idsproduits, :prixttc)';
          $statement = $pdo->prepare($sql);
          $result = $statement->execute([
                      ':iduser'  => $iduser, 
                      ':idsproduits'   => $serial,
                      ':prixttc' => $prixTotalTTC
                       ]);
          if (!$result){
            // TODO signaler problème d'insertion
            die("erreur enregistrement de la commande en base");
          }
          // modification des infos du user dans la base
          $sql = 'UPDATE `users` SET `email` = :email, `name` = :name, `prenom`= :prenom, `numrue`= :numrue, `rue`=:rue,`codepostal`= :codepostal, `ville`= :ville, `pays`= :pays, `tel`= :tel WHERE `users`.`id` = :id ';
              //var_dump($sql);die();
          $statement = $pdo->prepare($sql);
          $result = $statement->execute([
                    ':email'  => $email, 
                    ':name'   => $username,
                    ':prenom'   => $prenom, 
                    ':numrue'   => $numero, 
                    ':rue'    => $rue, 
                    ':codepostal' => $cp, 
                    ':ville'  => $ville, 
                    ':pays'   => $pays, 
                    ':tel'    => $tel ,
                    ':id'    => $iduser 
                    ]);
          if (!$result){
            // TODO signaler problème d'insertion
            die("erreur modification du user en base");
          }

          }
        }
    else{
        // TODO : gérer les erreurs de saisie
        //var_dump($_GET);
        $erreur=[];
        $erreur['nom'] = ($_GET['nom']!="") ?false:  true;
        $erreur['prenom'] = ($_GET['prenom']!="") ?false: true;
/*        $erreur['rue'] = ($_GET['rue']!="")?false: true ;
        $erreur['cp'] = ($_GET['cp']!="")?false: true;
        $erreur['ville'] = ($_GET['ville']!="")?false: true;
*/        //var_dump($erreur);
        $submited = false;
        echo "Veuillez remplir tous les champs obligatoires (*)";
    }
}
else{
        // TODO : gérer les erreurs de saisie pour réafficher le formulaire
        $erreur['nom'] = false;
        $erreur['prenom'] = false;
/*        $erreur['rue'] = false ;
        $erreur['cp'] = false;
        $erreur['ville'] = false;
*/}

?>

<!-- LA PAGE HTML du formulaire avec le bon de commande  -->
<?php 
$index = false;
include 'includes/header.php';
require_once 'includes/function.php';
?>

<div class='container'>
  
  <!-- affichage du titre initial ou de Bonjour prénom nom ! -->
    <h1 class='rounded text-center'><?=$titre?></h1>

<?php if (!$submited){ 
  // PREMIER AFFICHAGE : si pas de paramètre GET  dans l'url , on commande 
  // lecture du user dans la base
/*  $sql = "SELECT * FROM `users` WHERE `email` = '" . $useremail . "'";
  $statement = $pdo->query($sql);
  $user = $statement->fetch();
*/
  if(!empty($currentUser)){
    $iduser = $currentUser["id"];
    $prenom = $currentUser["prenom"];
    $email = $currentUser["email"];
    $password = $currentUser["password"];
    $numero = $currentUser["numrue"];
    $rue = $currentUser["rue"];
    $cp = $currentUser["codepostal"];
    $ville = $currentUser["ville"];
    $pays = $currentUser["pays"];
    $tel = $currentUser["tel"];
  }
  else{
    header("Location: ". uri("identification.php"));
    exit();
  }
  ?>
  <!-- PREMIER AFFICHAGE : si pas de paramètre GET  dans l'url , on commande -->
  <section>
    <!-- Formulaire client avec envoi sur soi-meme en mode GET -->
    <form action="" method="get" class = 'col-md-12'>
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
            <input type="text" name="email" value='<?= ($email) ? $email:''; ?>' placeholder="*E-mail" required class="form-control col-md-8 offset-md-1">
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
                  <td class="col"><?= (String)$beerArray[$i][1]?></td> <!-- Nom bière-->
                  <td class="col" ><input class="col-12" readonly type="text" id="ht<?= (String)$beerArray[$i][0]?>" value="<?=(String)number_format($beerArray[$i][4],2,',',' ').'€';?>"></td> <!-- prix HT -->
                  <td class="col" ><input class="col-12" readonly type="text" id="ttc<?= (String)$beerArray[$i][0]?>" value="<?=(String)number_format($beerArray[$i][4]*1.2,2,',',' ').'€';?>"></td> <!-- prix TTC-->
                  <td class="col" ><input class="col-12" type="number" name="quantite[]" value=0 min= 0 oninput="quantitebiere(this,<?= (String)$beerArray[$i][0]?>,<?= (String)$beerArray[$i][4]?>);"></td> <!-- quantité-->
              </tr>
<?php  endfor; ?>
            </tbody>
          </table>
          <div class = "row mt-4">
            <!-- Bouton pour envoyer le formulaire -->
            <button type="submit" class="col-2 offset-8 col-md-2 offset-md-8 mt-2 mb-2">Envoyer</button>
          </div>
    </form>
 
  </section>
<?php }else{ ?>
            <!-- SECOND AFFICHAGE : traitement des paramètres GET  dans l'url -->
            <!-- CONFIRMATION de la COMMANDE et affichage des FRAIS de PORT -->
    <table class = 'col-md-10 offset-md-1' >
    <!-- 1ere ligne : titre -->
    <thead>
      <tr class="row">
          <th class="col-4">Nom de la Bière</th> <!-- Nom bière-->
          <th class="col-2">prix HT</th> <!-- prix HT -->
          <th class="col-2">prix TTC</th> <!-- prix TTC-->
          <th class="col-4">Quantité</th> <!-- quantité-->
      </tr>
    </thead>
     <tfoot>
    <!-- avant derniere ligne : frais de port -->
       <tr class="row">
          <th class="col-4">FRAIS de PORT</th> <!-- Nom bière-->
          <th class="col-2"></th> <!-- prix HT -->
          <th class="col-2"><?= (String)number_format($FraisPort,2,',',' ').' €'?></th> 
          <th class="col-4"></th> <!-- quantité-->
      </tr>
    <!-- derniere ligne : totaux -->
       <tr class="row">
          <th class="col-4">TOTAL</th> <!-- Nom bière-->
          <th class="col-2"><?= (String)number_format($prixTotalHT,2,',',' ').' €'?></th> <!-- prix HT -->
          <th class="col-2"><?= (String)number_format($prixTotalTTC,2,',',' ').' €'?></th> <!-- prix TTC-->
          <th class="col-4"><?= $quantiteTotal?></th> <!-- quantité-->
      </tr>
     
    </tfoot>
    <tbody>
<?php  for ($i=0; $i < count($_GET['quantite']) ; $i++):?>
<?php  
      $quantite = $_GET['quantite'][$i];
      if ( $quantite > 0){
?>
    <tr class="row">
        <td class="col-4"><?= (String)$beerArray[$i][1]?></td> <!-- Nom bière-->
        <td class="col-2"><?=(String)number_format($quantite*$beerArray[$i][4],2,',',' ').'€';?></td> <!-- prix HT -->
        <td class="col-2"><?=(String)number_format(1.2*$quantite*$beerArray[$i][4],2,',',' ').'€';?></td> <!-- prix TTC-->
        <td class="col-4"><?=$quantite?></td> <!-- quantité-->
    </tr>
<?php }
      endfor; ?>
    </tbody>
  </table>

<?php } ?>
</div>

<?php include 'includes/footer.php'; ?>
