<?php
session_start();
require("../password.php");

$id = htmlspecialchars($_GET['id']);

//check the id
if($id == null or (intval($id) != 1 and intval($id) != 0)) {
	header('Location: connection.php');
  	exit();
}

if($id==1) {
	//if registration
	$email = addslashes(htmlspecialchars($_POST['email']));
	$password_co = addslashes(htmlspecialchars($_POST["password"]));
	$name = addslashes(htmlspecialchars($_POST["name"]));

	//check if a valid email
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('Location: connection.php');
  		exit();
	}

	try
	{
	$bdd = new PDO('mysql:host=localhost;dbname='.$bdd_name.';charset=utf8', $user, $password);
	}
	catch (Exception $e)
	{
	die('Erreur : ' . $e->getMessage());
	}

	//we check if the email exists
	$sqlQuery = "SELECT * FROM `users` WHERE email='".$email."'";
	$recipesStatement = $bdd->prepare($sqlQuery);
	$recipesStatement->execute();
	$recipes = $recipesStatement->fetchAll();

	if($recipes != null) {
		header('Location: connection.php?error=0');
	  	exit();
	}

	//we checkif the name exists
	$sqlQuery = "SELECT * FROM `users` WHERE name='".$name."'";
	$recipesStatement = $bdd->prepare($sqlQuery);
	$recipesStatement->execute();
	$recipes = $recipesStatement->fetchAll();

	if($recipes != null) {
		header('Location: connection.php?error=1');
	  	exit();
	}

	//we put in the DB
	$sqlQuery = "INSERT INTO `users`(`email`, `password`, `name`) VALUES ('".$email."','".password_hash($password_co, PASSWORD_DEFAULT)."','".$name."')";
	$recipesStatement = $bdd->prepare($sqlQuery);
	$recipesStatement->execute();

	//find the id of the user
	$sqlQuery = "SELECT * FROM `users` WHERE name='".$name."'";
	$recipesStatement = $bdd->prepare($sqlQuery);
	$recipesStatement->execute();
	$recipes = $recipesStatement->fetchAll();

	$id_user = $recipes[0]["id"];

	//create table for user
	$sqlQuery = "CREATE TABLE table_".$id_user." (id_video int, id_video_like int)";
	$recipesStatement = $bdd->prepare($sqlQuery);
	$recipesStatement->execute();

	$_SESSION["id"] = $id_user;
	$_SESSION["name"] = $name;
	header('Location: /index.php');
  	exit();
} else {
	//if connection
	$email = addslashes(htmlspecialchars($_POST['email']));
	$password_co = addslashes(htmlspecialchars($_POST["password"]));

	try
	{
	$bdd = new PDO('mysql:host=localhost;dbname='.$bdd_name.';charset=utf8', $user, $password);
	}
	catch (Exception $e)
	{
	die('Erreur : ' . $e->getMessage());
	}

	//we check if the password and email are ok
	$sqlQuery = "SELECT * FROM `users` WHERE email='".$email."'";
	$recipesStatement = $bdd->prepare($sqlQuery);
	$recipesStatement->execute();
	$recipes = $recipesStatement->fetchAll();

	if($recipes == null) {
		header('Location: connection.php?error=2');
	  	exit();
	}

	if(password_verify($password_co, $recipes[0]["password"]) == false) {
		header('Location: connection.php?error=2');
	  	exit();
	  } else {
	  	$_SESSION['id'] = $recipes[0]["id"];
	  	$_SESSION["name"] = $recipes[0]["name"];
		header('Location: /index.php');
	  	exit();
	  }
}
?>