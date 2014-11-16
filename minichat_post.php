<?php

setcookie('pseudo',$_POST['pseudo'], time() + 365*24*3600, null, null, false, true);


// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=minichat', 'root', 'root');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Insertion du message à l'aide d'une requête préparée
$req = $bdd->prepare('INSERT INTO `text` (pseudo, message, coordonnees) VALUES(?, ?, ?)');
$req->execute(array($_POST['pseudo'], $_POST['message'], $_POST['coordonnees']));
//print_r($_POST);

// Redirection du visiteur vers la page du minichat
header('Location: contact.php');
?>