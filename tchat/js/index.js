/*** variables utiles ***/

let $channels = jQuery('#chat-liste-channels');
let $messages = jQuery('#chat-liste-messages');
let $connectes = jQuery('#chat-list-connectes');
let $reponse = jQuery('#response'); 

let $texte = jQuery('#cible');

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

	$.ajax({
    type: "GET",
    url: "services/listusers.php",
    dataType: "json"
}).done(function (users) {

	users.forEach(function(user) {
		$connectes.append('<li><button  type="button" class="btn btn-info target" data-toggle="modal" data-target="#myModal" data-id="' + user.id + '" data-user="' + user.nom + '"  >' + user.nom + '</button></li>');
	});
}).fail(function (jqXHR, textStatus, errorThrown) {
    alert("AJAX call failed: " + textStatus + ", " + errorThrown);
});
jQuery('#chat-list-connectes').trigger('chat:show');
// }, 'json');

/*** panel de sélection de channel ***/

$channels.on('click', 'a', function() {
	display(jQuery(this).data('id'));
});

$(document).on('click','.target', function() {
	
	$texte.html('<h2>message à '+jQuery($(this)).data('user')+'</h2>');
	// ICI
	var id = jQuery(this).data('id');



$.ajax({
    type: "GET",
    url: "services/listmessagesprive.php",
    data: {id: id},
    dataType: "json"
}).done(function (pvm) {
	console.log(pvm)
	pvm.forEach(function(messPriv) {
		if(messPriv.idenvoie==id){
			$reponse.append('<li> votre ami(e) dit : '+ messPriv.contenu + '</li>');
		}else{
			$reponse.append('<li> vous : '+ messPriv.contenu + '</li>');
		}
		
	})
}).fail(function (jqXHR, textStatus, errorThrown) {
    alert("AJAX call failed: " + textStatus + ", " + errorThrown);
});



		$('#private').append('<input type="number" name="id" id="recevoir" hidden="hidden" data-id="'+$(this).data('id')+'" >');
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


//ICI
$('#myModal').on('hidden.bs.modal', function () {
jQuery(document).find('#recevoir').remove();
jQuery(document).find('#response').empty();
})


$(document).on('click', '#privateEnv', function(e) {  
  
	if (jQuery(this).find('#private-contenu').val() == '') {
		alert("Merci d'écrire le message à poster");
		return false;
	}
	var $contenu = jQuery('#private-contenu').val();
	var $recois = jQuery(document).find('#recevoir').data('id'); 
	var $envoie = [$contenu, $recois];
	//alert($envoie);
//	alert($contenu);
	jQuery.post('services/messageprive.php', {contenu: $contenu, recois: $recois}, (reponse) => {
		if (reponse = 1) {
			alert('message envoyé');
		
			jQuery(document).find('#private-contenu').val('');
			jQuery(document).find('#recevoir').remove();
		} else {
			alert('Normalement ça à pas marché');
			jQuery(document).find('#private-contenu').val('');
				jQuery(document).find('#recevoir').remove();

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