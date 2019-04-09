<?php include("array_php.php")?>
<?php
$submited = (count($_GET) == 0) ? false : true ;
$phrase;
$titre = "Bon de commande de bières";
$prixTotalHT;
$prixTotalTTC;
$quantiteTotal;

if ($submited){
    $prixTotalHT = 0.00;
    $prixTotalTTC = 0.00;
    $quantiteTotal = 0;

    //var_dump($_GET);
    // calcul total du tableau
    for( $i = 0 ; $i < count($_GET['quantite']) ; $i++){
      $quantite = $_GET['quantite'][$i];
      if ( $quantite > 0){
          $prixTotalHT += $beerArray[$i][3]*$quantite;
          $prixTotalTTC += $beerArray[$i][3]*$quantite*1.2;
          $quantiteTotal += $quantite;
      }

    }
    // enlève le sigle € et remplace la virgule par un point
    //echo 'TOTAL commande HT : ' . (String)number_format($prixTotalHT,2,',',' ').' €' . '<br />';
    //echo 'TOTAL commande TTC : ' . (String)number_format($prixTotalTTC,2,',',' ').' €' . '<br />';

    // afficher la confirmation de commande
    if (($_GET['nom']) 
        && ($_GET['prenom'])
        && ($_GET['rue'])
        && ($_GET['cp'])
        && ($_GET['ville'])
        ){
        $identite = $_GET['prenom'] . ' ' . $_GET['nom'];

        $titre =  "Bonjour " . $identite . ' !';

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

        // la phrase est dans le titre
        $phrase = $phrase .  $_GET['rue'] . ' à ' . $_GET['ville']. '<br />';
        
        $confirmation =  "Voici le contenu de votre commande";

        // autre syntaxe  pour intégrer les variables dans une chaine :
        //$phrase = "<br /> Bonjour {$identite}";


    }
    else{
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
        $phrase = "Bon de commande de bières";
        $erreur['nom'] = false;
        $erreur['prenom'] = false;
        $erreur['rue'] = false ;
        $erreur['cp'] = false;
        $erreur['ville'] = false;
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset='UTF-8' />
  <title>Bon de commande de bières</title>
<!--   <link rel='stylesheet' href='style.css' />
 -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta charset="utf-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
<div>
  
  <header class="row">
    <h1 class='col-12 rounded text-white text-center bg-info col-md-12'><?=$titre?></h1>
  </header>

<?php if (!$submited){ ?>

  <section id = "section1" class='container'>
    <!-- Forulaire client -->
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
          
          <table class = 'col-md-10 offset-md-1' >
            <!-- 1ere ligne : titre-->
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
            <button type="submit" class="col-md-2 offset-md-6 mt-2">Envoyer</button>
          </div>
    </form>

  </section>
<?php }else{ ?>
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
                  <td class="col-md-2"><input readonly type="text" value="<?=(String)number_format($quantite*$beerArray[$i][3],2,',',' ').'€';?>"></td> <!-- prix HT -->
                  <td class="col-md-2"><input readonly type="text" value="<?=(String)number_format(1.2*$quantite*$beerArray[$i][3],2,',',' ').'€';?>"></td> <!-- prix TTC-->
                  <td class="col-md-4"><input type="number" name="quantite[]" value=<?=$quantite?> min= 0 oninput="quantitebiere(this,<?= (String)$beerArray[$i][3]?>);"></td> <!-- quantité-->
              </tr>
<?php }
      endfor; ?>
            </tbody>
          </table>
          <a class="col-md-2 offset-md-1 mt-2"href="boncommande.php">J'en veux encore !</a>

<?php } ?>
</div>

</body>
<script type="text/javascript"> 

function quantitebiere(elt,tab){
  var eltcol = elt.parentNode;
  var eltTTC = eltcol.previousElementSibling;

  var eltHT = eltTTC.previousElementSibling;

  // les inputs
  eltHT = eltHT.childNodes[0];
  eltTTC = eltTTC.childNodes[0];
 // prix HT : enleve le signe euro
  var strprixHT = eltHT.value.substring(0, eltHT.value.length-1);
  // et remplace la virgule par un point
  strprixHT = strprixHT.replace(',', '.');

  // prix TTC : enleve le signe euro
  var strprixTTC = eltTTC.value.substring(0, eltTTC.value.length-1);
  // et remplace la virgule par un point
  strprixTTC = strprixTTC.replace(',', '.');

  var prixHT = parseFloat(strprixHT);
  var prixTTC = parseFloat(strprixTTC);

  var prixUnitaireHT = parseFloat(tab);

  if (parseInt(elt.value) === 0){
      prixHT = prixUnitaireHT;
      prixTTC = prixUnitaireHT*1.2;
  }else{
      prixHT = prixUnitaireHT*parseInt(elt.value);
      prixTTC = prixUnitaireHT*1.2*parseInt(elt.value);
  }

  eltHT.value = prixHT.toFixed(2).toString().replace('.', ',') + '€';
  eltTTC.value = prixTTC.toFixed(2).toString().replace('.', ',') + '€';

}

</script>
</html>
