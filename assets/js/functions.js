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

// la fonction  quantitebiere() lancée au changement de la qantité commandée 
function quantitebiere(elt,tab){
  // récupérer l'élément parent de l'input quantité = la cellule en colonne
  var eltcol = elt.parentNode;
  // récupérer l'élément précédent de cette cellule : le prix TTC
  var eltTTC = eltcol.previousElementSibling;
  // récupérer encore l'élément précédent : le prix HT 
  var eltHT = eltTTC.previousElementSibling;

  // les inputs enfants des 2 cellules prixHT et prixTTC :
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

  // les transformer en float
  var prixHT = parseFloat(strprixHT);
  var prixTTC = parseFloat(strprixTTC);

  // le prix HT unitaire est dans le tableau original passé en paramètre :
  var prixUnitaireHT = parseFloat(tab);

  // calcul des prix avec la quantité saisie :
  if (parseInt(elt.value) === 0){
      prixHT = prixUnitaireHT;
      prixTTC = prixUnitaireHT*1.2;
  }else{
      prixHT = prixUnitaireHT*parseInt(elt.value);
      prixTTC = prixUnitaireHT*1.2*parseInt(elt.value);
  }

  // affectation des valeurs dans les inputs respectifs
  eltHT.value = prixHT.toFixed(2).toString().replace('.', ',') + '€';
  eltTTC.value = prixTTC.toFixed(2).toString().replace('.', ',') + '€';

}
