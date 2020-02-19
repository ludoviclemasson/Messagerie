<?php
include("db.php");

//Après avoir lié notre base de données, on lui demande tous les messages contenus.

$sql = "SELECT * 
        FROM messages
        ORDER BY created_date DESC";

//envoie ma requête SQL au serveur MySQL
$stmt = $pdo->prepare($sql);

//demande à MySQL d'exécuter ma requête
//(les données sont toujours là-bas !)
$stmt->execute();

//récupère les messages depuis le serveur MySQL
$messages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Tous les messages</title>

	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<div class="container">
		<h1>Mon site</h1>
		<nav>
			<a href="ajout.php">Ajouter un message</a>
			<a href="messages.php">Voir les messages</a>
		</nav>

		<section>
			<h2>Tous les messages !</h2>

			<!-- afficher tous les messages -->

			<?php

			// A l'aide d'une fonction
			//On affiche le nombre de messages affichés
			echo '<h5>Affichage de ' . count($messages) . ' messages.</h5>';

			foreach ($messages as $message) {
				echo '<article class="message"><p>' . $message['message'] . '</p></article>';
				echo '</article>';
			}
			?> 	
		</section>
	</div>
</body>

</html>