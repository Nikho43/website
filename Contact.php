<?php
    session_start();
 
    if(!empty($_POST['pseudo']))//Si un pseudo a été rentré dans le formulaire
    {
        $pseudo_tchat = securisation_variable($_POST['pseudo']);//on l'affecte
        setcookie('pseudo', $pseudo_tchat, time() + 365*24*3600, null, null, false, true);//On créé le cookie
    }
    elseif(!empty($_COOKIE['pseudo']))//Si aucun pseudo dans le formulaire, mais un pseudo retenu par un cookie
    {
        $pseudo_tchat = $_COOKIE['pseudo'];//On l'affecte
    }
?>

<!DOCTYPE html>

<html>

<head>
<?php include("header.php"); ?>
</head>


<body>

<h1>NikolasBricePhotography
</h1>

<?php include("menu.php"); ?>

<form action="minichat_post.php" method="post">
    
      <label for="pseudo">Pseudo</label> : <input type="text" name="pseudo" id="pseudo" value =" <?php echo $pseudo_tchat; ?> "/><br /></p>
      <label for="coordonnees">Coordonnees</label> : <input type="tel" name="coordonnees" placeholder="Ex : 514 123 4567"/><br /></p>
        <label for="message">Message</label><br />
        <textarea name="message" id="message" rows="10" cols="50" placeholder="Veuillez inscrire votre message ici. Maximum de 400 caractères."/></textarea>

     <br />

        <input type="submit" value="Envoyer" />
  </p>
    </form>

<?php
// Connexion à la base de données
try
{
  $bdd = new PDO('mysql:host=localhost;dbname=minichat', 'root', 'root');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Récupération des 10 derniers messages
$reponse = $bdd->query('SELECT pseudo, coordonnees, message FROM text ORDER BY ID DESC LIMIT 0, 10');

// Affichage de chaque message (toutes les données sont protégées par htmlspecialchars)
while ($donnees = $reponse->fetch())
{
  echo '<p><strong>' . htmlspecialchars($donnees['pseudo']) . '</strong> : ' . htmlspecialchars($donnees['message']) . '</p>';
}

$reponse->closeCursor();

?>

    </body>

<?php include("footer.php"); ?>

</html>