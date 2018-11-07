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


<div class="container text-center">
	<section id="chat-list-connectes">
		<h2>envoyer un message privé à </h2>

	</section>

  <!-- Modal -->
		<div class="modal fade" id="myModal" role="dialog">
    		<div class="modal-dialog">
    
      <!-- Modal content-->
      	<div class="modal-content">
        	<div id="cible" class="modal-header">
	        	
	         	<button type="button" class="close" data-dismiss="modal">Fermer &times;</button>
          
        	</div>
		<div id="response"></div>
        <div class="modal-body">
          <form id="private" action="#" method="POST" class="text-center">

          	<textarea name="" id="private-contenu" cols="30" rows="2"></textarea>
    



		</form>

        </div>
	        <div class="modal-footer">
	        	<button type="button" id="privateEnv" class="btn btn-info envoyer" data-dismiss="modal">Envoyer</button>
	          
	        </div>
	    </div>
	      
		</div>
		</div>
	  
</div>



<?php
	$js = ['index'];
	require_once('parts/footer.php');
?>