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
			$messages.append('<dt>' + message.auteur.pseudo + '</dt><dd title="' + message.envoi.toLocaleString() + '">' + message.contenu + '</dd>');
		});
		if (callback) callback();
	}, 'json');
};

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

// jQuery.ajax(type : 'get', 'services/listchannels.php', function(chans) {
// 	console.log('coucou');
$.ajax({
    type: "GET",
    url: "services/listchannels.php",
    dataType: "json"
}).done(function (chans) {

	chans.forEach(function(channel) {
		$channels.append('<li><a data-id="' + channel.id + '" data-auteur="' + channel.auteur.pseudo + '">' + channel.nom + '</a></li>');
	});
}).fail(function (jqXHR, textStatus, errorThrown) {
    alert("AJAX call failed: " + textStatus + ", " + errorThrown);
});
	// chans.forEach(function(channel) {
	// 	$channels.append('<li><a data-id="' + channel.id + '" data-auteur="' + channel.auteur.pseudo + '">' + channel.nom + '</a></li>');
	// });

	jQuery('#chat-selection-channel').trigger('chat:show');

// }, 'json');

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


/*** liste des gens connectés ***/

/*** MAJ du ts dans la table utilisateur ***/

let $fromstart = jQuery('#user_id');

$fromstart.on('fromstart:refresh',function(){
	let user_id = jQuery('#user_id').val();
	console.log(user_id);
	let ts = jQuery.now();
	console.log(ts);
	jQuery.post('services/editconnexionts.php', {ts:ts, id:user_id}, function(reponse) {
		console.log(reponse);
	});
}).trigger('fromstart:refresh');

setInterval(function(){
	$fromstart.trigger('fromstart:refresh');
}, 5000);

/*** MAJ du tableau listant les gens connectés ***/

let $liste = jQuery('#connectes-liste');

$liste.on('connectes:refresh', function() {
	jQuery.get('services/listutilisateurs.php', function(data) {
		if (data.length > 0) {
			$liste.siblings('thead').show();
			$liste.html('');
			data.forEach(function(user) {
				let ligne = jQuery('<tr>');
				ligne.append('<td>' + user.pseudo + '</td>');
				if(user.connexion_ts > ($.now()-6000)){
					ligne.append('<td><i class="fas fa-podcast fa-lg" style="color:green"></i></td>');
				} else {
					ligne.append('<td><i class="fas fa-microphone-slash fa-lg" style="color:red"></i></td>');
				};
				$liste.append(ligne);
			});
		} else {
			$liste.siblings('thead').hide();
			$liste.html('<tr><th>Pas d\'utilisateurs à afficher</th></tr>');
		}
	}, 'json');
	
}).trigger('connectes:refresh');

setInterval(function(){
	$liste.trigger('connectes:refresh');
}, 5000);