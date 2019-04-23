# Sitebiere PHP

## Site de commande de bières contenant :

## - La première page de description des bières disponibles
Un menu :
### S'identifier
### Commander
### Mes commandes
### Déconnexion

## - "S'identifier" permet de saisir son adresse mail et son mot de passe pour se connecter
### un lien "s'inscrire" ouvre un formulaire d'inscription
### un lien "Les bières" revient à la première page

## - "Commander" contient le bon de commande à envoyer :
### - un formulaire contient le nom et les coordonnées de l'acheteur
### - un tableau contient le nom de la bière, le prix HT et TTC et la quantité à saisir par ligne
le changement de quantité calcule automatiquement les prix HT et TTC de la ligne
### - un bouton "envoyer" affiche la page de confirmation de la commande :
Bonjour nom prénom !
Voici la confirmation de votre commande

le tableau qui récapitule les bières commandées, les frais de port (5.40 € si le total TTC dépasse 30 €) et le total à payer

## - La page 'Mes commandes' contient la liste des commandes :
### une ligne par commande avec le n° de la commande, le nombre de produits différents et le total TTC de la commande

## - "Déconnexion" déconnecte l'utilisateur et affiche la page "Identification"
