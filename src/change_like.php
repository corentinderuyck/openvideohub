<?php
session_start();
require("../password.php");

$id = $_GET["id"];
$type = $_GET["type"];

if($type != 1 and $type != 2) {
	exit();
}

try
{
  $bdd = new PDO('mysql:host=localhost;dbname='.$bdd.';charset=utf8', $user, $password);
}
catch (Exception $e)
{
  die('Erreur : ' . $e->getMessage());
}

//check if we have an id
if(isset($_SESSION['id']) == false) {
	echo "3";
	exit();
}

//check if the video is already like
$sqlQuery = "SELECT * FROM `table_".$_SESSION["id"]."` WHERE id_video=".$id;
$recipesStatement = $bdd->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

if($recipes == null) {
	//if not in the array (video not like or don't like)
	if($type == 1) {
		$sqlQuery = "INSERT INTO `table_".$_SESSION["id"]."`(`id_video`, `id_video_like`) VALUES ('".$id."','1')";
		$recipesStatement = $bdd->prepare($sqlQuery);
		$recipesStatement->execute();

		//increment the like number
	  $sqlQuery = "UPDATE `videos` SET likeButton = likeButton + 1 WHERE id=".$id;
	  $recipesStatement = $bdd->prepare($sqlQuery);
	  $recipesStatement->execute();

		echo "1";
	} else {
		$sqlQuery = "INSERT INTO `table_".$_SESSION["id"]."`(`id_video`, `id_video_like`) VALUES ('".$id."','2')";
		$recipesStatement = $bdd->prepare($sqlQuery);
		$recipesStatement->execute();

		//increment the like number
	  $sqlQuery = "UPDATE `videos` SET dontTlikeButton = dontTlikeButton + 1 WHERE id=".$id;
	  $recipesStatement = $bdd->prepare($sqlQuery);
	  $recipesStatement->execute();

		echo "2";
	}
} elseif($recipes[0]["id_video_like"] == 0) {
	//if the autor of the video can't make like
	exit();
} elseif($recipes[0]["id_video_like"] == 1) {
	// if we have already like the video
	if($type == 1) {
		// remove the like
		$sqlQuery = "DELETE FROM `table_1` WHERE id_video=".$id;
	  $recipesStatement = $bdd->prepare($sqlQuery);
	  $recipesStatement->execute();

	  $sqlQuery = "UPDATE `videos` SET likeButton = likeButton - 1 WHERE id=".$id;
	  $recipesStatement = $bdd->prepare($sqlQuery);
	  $recipesStatement->execute();

	  echo "0";

	} else {
		// put don t like
		$sqlQuery = "UPDATE `table_".$_SESSION["id"]."` SET `id_video_like`='2'  WHERE id_video=".$id;
	  $recipesStatement = $bdd->prepare($sqlQuery);
	  $recipesStatement->execute();

	  $sqlQuery = "UPDATE `videos` SET dontTlikeButton = dontTlikeButton + 1 WHERE id=".$id;
	  $recipesStatement = $bdd->prepare($sqlQuery);
	  $recipesStatement->execute();

	  //increment the like number
	  $sqlQuery = "UPDATE `videos` SET likeButton = likeButton - 1 WHERE id=".$id;
	  $recipesStatement = $bdd->prepare($sqlQuery);
	  $recipesStatement->execute();
	  echo "2";
	}
} else {
	// if we have already don t like the video
	if($type == 1) {
		// put like
		$sqlQuery = "UPDATE `table_".$_SESSION["id"]."` SET `id_video_like`='1'  WHERE id_video=".$id;
	  $recipesStatement = $bdd->prepare($sqlQuery);
	  $recipesStatement->execute();

	  $sqlQuery = "UPDATE `videos` SET dontTlikeButton = dontTlikeButton - 1 WHERE id=".$id;
	  $recipesStatement = $bdd->prepare($sqlQuery);
	  $recipesStatement->execute();

	  //increment the like number
	  $sqlQuery = "UPDATE `videos` SET likeButton = likeButton + 1 WHERE id=".$id;
	  $recipesStatement = $bdd->prepare($sqlQuery);
	  $recipesStatement->execute();
	  echo "1";
	} else {
		// remove don t like
		$sqlQuery = "DELETE FROM `table_1` WHERE id_video=".$id;
	  $recipesStatement = $bdd->prepare($sqlQuery);
	  $recipesStatement->execute();

	  $sqlQuery = "UPDATE `videos` SET dontTlikeButton = dontTlikeButton - 1 WHERE id=".$id;
	  $recipesStatement = $bdd->prepare($sqlQuery);
	  $recipesStatement->execute();
	  echo "0";
	}
}

?>