<?php

if (session_status() != PHP_SESSION_ACTIVE){
	session_start();
}
if(isset($_GET["deconnect"]) && $_GET["deconnect"]){
	unset($_SESSION["user"]);
	$connect = false;
} 
	if (isset($_SESSION["user"])) {
		$currentUser = $_SESSION["user"];
		$connect = true;
	}else{
		$currentUser = [];
		$connect = false;
	}

/*if (isset($_SESSION["connect"])) {
	$connect = $_SESSION["connect"];
	//if (isset($_SESSION["username"])) {
	if (isset($_SESSION["user"])) {
		$currentUser = $_SESSION["user"];
		$userfirstname = $_SESSION["userfirstname"];
		$username = $_SESSION["username"];
		$useremail = $_SESSION["email"];
	}else{
		$currentUser = [];
		$userfirstname = "";
		$username = "";
		$useremail = "";
		$connect = false;
	}
}else{
	$connect = false;
	$username = "";
	$userfirstname = "";
	$useremail = "";
	$currentUser = [];
}*/

// pas de balise de fin quand on inclut un php dans un autre php