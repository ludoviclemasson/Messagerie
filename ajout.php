<?php

include('db.php');

if (!empty($_POST)) {
	//par défaut, on dit que le formulaire est entièrement valide
	//si on trouve ne serait-ce qu'une seule erreur, on
	//passera cette variable à false
	$formIsValid = true;


	$author = strip_tags($_POST['author']);
	$email = strip_tags($_POST['email']);
	$message = strip_tags($_POST['message']);

	//Le tableau erreurs permet d'afficher
	//Les éventuels problèmes à l'utilisateur
	$errors = [];

	// On teste ici si le nom est rempli,
	//puis s'il n'est pas trop court ou trop long 
	if (empty($author)) {

		$formIsValid = false;
		$errors[] = "Veuillez renseigner votre nom !";
	} elseif (mb_strlen($author) <= 1) {
		$formIsValid = false;
		$errors[] = "Votre nom est court, très court. Veuillez le rallonger !";
	} elseif (mb_strlen($author) > 60) {
		$formIsValid = false;
		$errors[] = "Votre nom est trop long !";
	}


	//validation de l'email
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$formIsValid = false;
		$errors[] = "Votre email n'est pas valide !";
	}

	//Validation message
	if (empty($message)) {

		$formIsValid = false;
		$errors[] = "Veuillez saisir votre message";
	}

	if ($formIsValid == true) {
		//on écrit tout d'abord notre requête SQL, dans une variable
		$sql = "INSERT INTO messages 
            (author, email, message, created_date)
            VALUES 
            (:author, :email, :message, NOW())";

		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			":author" => $author,
			":email" => $email,
			":message" => $message,
		]);
	}
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Ajout de message</title>

	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<div class="container">
		<h1>Mon site</h1>
		<nav>
			<a href="ajout.php">Ajouter un message</a>
			<a href="messages.php">Voir les messages</a>
		</nav>
		<h2>Ajouter un message !</h2>
		<form method="post">
			<div>
				<label for="author">Votre nom</label>
				<input type="text" name="author" id="author">
			</div>
			<div>
				<label for="email">Votre email</label>
				<input type="email" name="email" id="email">
			</div>
			<div>
				<label for="message">Votre message</label>
				<textarea name="message" id="message"></textarea>
			</div>

			<?php
			
			//affiche les éventuelles erreurs de validations
			if (!empty($errors)) {
				foreach ($errors as $error) {
					echo '<div>' . $error . '</div>';
				}
			}
			?>

			<button>Envoyer !</button>
		</form>


	</div>
</body>

</html>