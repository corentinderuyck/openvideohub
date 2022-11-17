<?php
session_start();
require("../password.php");

if(isset($_SESSION['id'])==false) {
	header('Location: connection.php');
  	exit();
}

$title_video = htmlspecialchars($_POST["title"]);
$description_video = htmlspecialchars($_POST["description"]);

try
{
$bdd = new PDO('mysql:host=localhost;dbname='.$bdd.';charset=utf8', $user, $password);
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}

//we check if the email exists
$sqlQuery = "INSERT INTO `videos`(`name`, `description`, `likeButton`, `dontTlikeButton`, `views`, `autor_name`, `autor_id`) VALUES ('".$title_video."','".$description_video."','0','0','0','".$_SESSION['name']."','".$_SESSION['id']."')";
$recipesStatement = $bdd->prepare($sqlQuery);
$recipesStatement->execute();


//get the id
$sqlQuery = "SELECT * FROM `videos` ORDER BY id DESC";
$recipesStatement = $bdd->prepare($sqlQuery);
$recipesStatement->execute();
$recipesvideo = $recipesStatement->fetchAll();


//put the video in the table table_id
$sqlQuery = "INSERT INTO `table_".$_SESSION["id"]."`(`id_video`, `id_video_like`) VALUES ('".$recipesvideo[0]["id"]."','0')";
$recipesStatement = $bdd->prepare($sqlQuery);
$recipesStatement->execute();

//store the video and image
move_uploaded_file($_FILES['video']['tmp_name'], "../media/".$recipesvideo[0]["id"].".mp4");
move_uploaded_file($_FILES['video_desc']['tmp_name'], "../media/".$recipesvideo[0]["id"].".jpg");

header('Location: profile.php?error=0');
exit();

?>