<?php

session_start();
if(isset($_GET["deconnect"]) && $_GET["deconnect"]){
	unset($_SESSION["connect"]);
	$connect = false;
} 

if (isset($_SESSION["connect"])) {
	$connect = $_SESSION["connect"];
	if (isset($_SESSION["username"])) {
		$username = $_SESSION["username"];
		$connect = true;
	}else{
		$username = "";
		$connect = false;
	}
}else{
	$connect = false;
	$username = "";
}

// pas de balise de fin quand on inclut un php dans un autre php