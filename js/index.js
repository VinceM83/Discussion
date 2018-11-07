/*** variables utiles ***/

let $channels = jQuery('#chat-liste-channels');
let $messages = jQuery('#chat-liste-messages');

let idchannel; // le channel en cours, quand il y en a un
let interval; // l'interval de rafraîchissement

let erreurs = {
	postmessage: {
		1: "Quelque chose a foiré, contactez qui vous voulez pour résoudre le problème",
		2: "Vous n'êtes pas identifié",
		3: "Il manque un paramètre dans le message envoyé"
	}
};

erreurs.addchannel = erreurs.postmessage;

/*** fonctions utiles ***/

let refresh = function(channel, callback) {
	jQuery.get('services/listmessages.php', {id: channel}, function(msgs) {
		$messages.html('');
		msgs.forEach(function(message) {
			message.envoi = new Date(message.envoi * 1000);
			$messages.append('<div><dt>' + message.auteur.pseudo + '</dt><dd title="' + message.envoi.toLocaleString() + '">' + message.contenu + '</dd><input type="button" class="modifier" name="modifier" data-user='+message.id+' value="Modifier"> <input type="button" class="supprimer" name="supprimer" data-user='+message.id+' value="Supprimer"></div>');
		});
		if (callback) callback();
	}, 'json');
};

/*suppression d'un message*/
$(document).on('click', '.supprimer', function(e)
{
	e.preventDefault();

	jQuery.get('services/supp_message.php',
		{
			id : jQuery(this).data('user')
		},
		function(data)
		{
			jQuery(this).parent().remove()
		}, 'html');
});

let display = function(id) {
	jQuery.get('services/getchannel.php', {id: id}, function(chan) {
		idchannel = id;
		interval = setInterval(refresh, 1000, idchannel);
		jQuery('#chat-messagerie-channel-nom').text(chan.nom);
		jQuery('#chat-messagerie-channel-auteur').text(chan.auteur.pseudo);
		jQuery("#chat-envoi-channel").val(id);
		refresh(id, function() {
			jQuery('#chat-messagerie').trigger('chat:show');
		});
	}, 'json');
};

/*** au chargement ***/

jQuery.get('services/listchannels.php', function(chans) {
	
	chans.forEach(function(channel) {
		$channels.append('<li><a data-id="' + channel.id + '" data-auteur="' + channel.auteur.pseudo + '">' + channel.nom + '</a></li>');
	});

	jQuery('#chat-selection-channel').trigger('chat:show');

}, 'json');

/*** panel de sélection de channel ***/

$channels.on('click', 'a', function() {
	display(jQuery(this).data('id'));
});

jQuery("#chat-creation-channel").on('submit', function() {
	jQuery.post('services/addchannel.php', jQuery(this).serialize(), function(reponse) {
		if (reponse.erreur) {
			alert(erreurs.addchannel[reponse.erreur]);
		} else {
			display(reponse.channel);
		}
	}, 'json');
	return false;
});

/*** panel de messagerie ***/

jQuery('#chat-envoi-message').on('submit', function() {
	if (jQuery(this).find('#chat-envoi-contenu').val() == '') {
		alert("Merci d'écrire le message à poster");
		return false;
	}

	jQuery.post('services/postmessage.php', jQuery(this).serialize(), (reponse) => {
		if (reponse > 0) {
			alert(erreurs.postmessage[reponse]);
		} else {
			jQuery(this).find('#chat-envoi-contenu').val('');
			refresh(idchannel);
		}
	})
	return false;
});

jQuery('a#chat-switch-channel').on('click', function() {
	clearInterval(interval);
	jQuery('#chat-selection-channel').trigger('chat:show');
});

/*** fonctionnement des panels ***/

jQuery('.chat-panel').on('chat:show', function() {
	jQuery('.chat-panel:visible').fadeOut(400, () => {
		jQuery(this).fadeIn(400);	
	});
	if (!jQuery('.chat-panel:visible').length) jQuery(this).fadeIn(400);
});