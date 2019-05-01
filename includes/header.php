<?php
require_once 'function.php';
require_once 'connect.php';
require_once 'db.php';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Les bières d'Isa</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity    ="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="<?= uri("assets/css/style.css") ?>">
	<link rel="stylesheet" type="text/css" href="<?= uri("assets/css/styles.css") ?>">
	<link rel="shortcut icon" href="assets/img/beerIcon.ico">
</head>
<body>
<div class='wrapper container'>
  <header class="menu" >
    <h1 class='col-12 rounded text-white text-center bg-info '>Les bières d'Isa</h1>
    <h1 class='col-12 rounded text-white text-center bg-info '>Compte: <?= (empty($currentUser) ? " " :$currentUser["prenom"]) . " " . (empty($currentUser) ? " " :$currentUser["name"]) ?></h1>
    <input type="checkbox" class= "burger">
  <!-- MENU id='primary_nav' class="col-12 text-center font-weight-bold" -->
    <nav class="rounded">
      <ul><!-- class="row" -->
        <li <?= $connect ? 'hidden':'';?> ><a href=<?= uri("login.php") ?> >S'identifier</a></li>
        <li <?= $connect ? 'hidden':'';?> ><a href=<?= uri("inscription.php?deconnect=true") ?> >S'inscrire</a></li>
        <li <?= (basename($_SERVER['REQUEST_URI']) == "index.php") ? 'hidden':'';?> ><a href=<?= uri("index.php") ?>>Boutique</a></li>
        <li><a href=<?= uri("commande.php") ?> >Commander</a></li>
        <li><a href=<?= uri("mescommandes.php") ?> >Mes commandes</a></li>
        <li <?= $connect ? '':'hidden';?>><a href=<?= uri("login.php?deconnect=true") ?>>Déconnexion</a></li>
      </ul>
    </nav>
  </header >
