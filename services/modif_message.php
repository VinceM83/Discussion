<?php
	require_once("../config/connect.php");
	$id= intval($_GET['id']);

	$modif_message= $pdo->query('SELECT id, contenu FROM message WHERE id='.$_GET['id']);
	$modif_message= $modif_message->fetch(PDO::FETCH_ASSOC);


?>

<h2> Modification du message </h2>
	<form id="modif-message" action="services/modif_message_traitement.php" method="POST">
		<p>
			<label for="message">Message</label>
			<textarea name="contenu" id="contenu"> <?= $modif_message['contenu']?> </textarea>
		</p>
		<p>
			<input type="hidden" name="id" value="<?= $id?>">
			<input type="submit" name="envoieModif" id="envoieModif" value="Editer">
		</p>
	</form>