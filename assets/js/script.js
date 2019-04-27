
// la fonction  quantitebiere() lancée au changement de la qantité commandée 
// elt : élément de la quantité commandée
// id : dans le tableau beerArray[i][0] passé en paramètre
// prixUnitaireHT : dans le tableau beerArray[i][4] passé en paramètre :
function quantitebiere(elt, id, prixUnitaireHT){
  var quantite = parseInt(elt.value);
  if (Number.isNaN(quantite)){
      elt.value = 0;
      quantite = 0;
  }
  var tva = 1.2;
  //  utiliser les ids par ligne (celui de la table sql)
  var idht="ht"+id;
  var idttc="ttc"+id;
  var eltHT = document.getElementById(idht); //elt.previousElementSibling;
  var eltTTC = document.getElementById(idttc); //elt.previousElementSibling;

  // prix : enleve le signe euro
  var strprixHT = eltHT.value.substring(0, eltHT.value.length-1);
  var strprixTTC = eltTTC.value.substring(0, eltTTC.value.length-1);
  // et remplace la virgule par un point
  strprixHT = strprixHT.replace(',', '.');
  strprixTTC = strprixTTC.replace(',', '.');
  // les transformer en float
  var prixHT = parseFloat(strprixHT);
  var prixTTC = parseFloat(strprixTTC);


  // calcul des prix avec la quantité saisie :
  if (parseInt(elt.value) === 0){
      prixHT = prixUnitaireHT;
      prixTTC = prixUnitaireHT*tva;
  }else{
      prixHT = prixUnitaireHT*quantite;
      prixTTC = prixUnitaireHT*tva*quantite;
  }

  // affectation des valeurs dans les inputs respectifs
  eltHT.value = prixHT.toFixed(2).toString().replace('.', ',') + '€';
  eltTTC.value = prixTTC.toFixed(2).toString().replace('.', ',') + '€';

}

// réponse au bouton + d'ajout d'une bière
function ajoutbiere(elt,tab){
  
  var prevelt = elt.previousElementSibling.previousElementSibling;
  var strprix = prevelt.innerHTML.substring(0, prevelt.innerHTML.length-1);
  strprix = strprix.replace(',', '.');
  var prix = parseFloat(strprix);
  var prixttc = parseFloat(tab);
  prix += prixttc;
  prevelt.innerHTML = prix.toFixed(2).toString().replace('.', ',') + '€';
}

// réponse au bouton - de retrait d'une bière
function retirebiere(elt, tab){
  
  var prevelt = elt.previousElementSibling;
  var strprix = prevelt.innerHTML.substring(0, prevelt.innerHTML.length-1);
  strprix = strprix.replace(',', '.');
  var prix = parseFloat(strprix);
  var prixttc = parseFloat(tab);
  prix -= prixttc;
  if (prix < 0){
    prix = 0;
  }
  prevelt.innerHTML = prix.toFixed(2).toString().replace('.', ',') + '€';
}
