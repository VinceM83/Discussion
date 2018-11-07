<?php
	require_once('config/protect.php');
	if (!$identifie) {
		header('Location: login.php');
		exit;
	}

	require_once('parts/header.php');
?>
<h1>Bienvenue sur le salon de discussion sans nom, <?=$_SESSION['pseudo'];?></h1>

<article class="chat-panel" id="chat-selection-channel">
	<h2>Choisis un channel</h2>
	<ul class="list-unstyled" id="chat-liste-channels"></ul>
	<h2>ou crées-en un nouveau</h2>
	<form id="chat-creation-channel">
		<div class="form-group">
			<label for="channel">Nom du channel :</label>
			<input type="text" name="channel">
		</div>
		<input type="submit" value="Créer">
	</form>
</article>

<article class="chat-panel" id="chat-messagerie">
	<h2>Channel <span id="chat-messagerie-channel-nom"></span></h2>
	<h4>créé par <span id="chat-messagerie-channel-auteur"></span></h4>
	<dl class="list-unstyled" id="chat-liste-messages"></dl>

	<form id="chat-envoi-message">
		<div class="form-group">
			<input type="hidden" name="channel" id="chat-envoi-channel">
			<label for="contenu">Poster un message :</label>
			<input type="text" name="contenu" id="chat-envoi-contenu">
		</div>
		<input type="submit" value="Envoyer">
	</form>

	<a id="chat-switch-channel">Changer de channel</a>
</article>


<!-- tableau listant les gens connectés -->

<div class="container" style="margin-top: 3em;">

	<input type="hidden" id="user_id" value="<?=$_SESSION['id'];?>">
	<table class="table">
		<thead class="hidden">
			<tr>
				<th>Nom</th>
				<th>État</th>
			</tr>
		</thead>
		<tbody id="connectes-liste"></tbody>
	</table>
</div>

<?php

	$js = ['index'];
	require_once('parts/footer.php');
?>