<?php
require("password.php");

try
{
$bdd = new PDO('mysql:host=localhost;dbname='.$bdd.';charset=utf8', $user, $password);
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}

$sqlQuery = "CREATE TABLE videos
(
  	id INT PRIMARY KEY AUTO_INCREMENT,
    name text,
    description text,
    likeButton INT,
    dontTlikeButton INT,
    views INT,
    autor_name text,
    autor_id INT
)";
$recipesStatement = $bdd->prepare($sqlQuery);
$recipesStatement->execute();

$sqlQuery = "CREATE TABLE users
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    email text,
    password text,
    name text
)";
$recipesStatement = $bdd->prepare($sqlQuery);
$recipesStatement->execute();


echo "the database is ready";
?>