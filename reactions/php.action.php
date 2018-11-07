<?php

//il faut créér 2 nouvelles tables LIKE et DISLIKE ayant chacune 3 colonnes avec id + idmessage + notre idutilisateur

$bdd = new PDO("mysql:host=127.0.0.1;dbname=channel;charset=utf8", "root", ""); //attention au nom de la bdd > à changer
if(isset($_GET['t'],$_GET['id']) AND !empty($_GET['t']) AND !empty($_GET['id'])) { //
   $getid = (int) $_GET['id'];
   $gett = (int) $_GET['t']; //t c'est le type de l'action
   $sessionid = 5; //exemple message ayant l'id 5
   $check = $bdd->prepare('SELECT id FROM message WHERE id = ?');
   $check->execute(array($getid));
   if($check->rowCount() == 1) {
      if($gett == 1) {
         $check_like = $bdd->prepare('SELECT id FROM likes WHERE idmessage = ? AND idutilisateur = ?');
         $check_like->execute(array($getid,$sessionid));
         $del = $bdd->prepare('DELETE FROM dislikes WHERE idmessage = ? AND idutilisateur = ?');
         $del->execute(array($getid,$sessionid));
         if($check_like->rowCount() == 1) {
            $del = $bdd->prepare('DELETE FROM likes WHERE idmessage = ? AND idutilisateur = ?');
            $del->execute(array($getid,$sessionid));
         } else {
            $ins = $bdd->prepare('INSERT INTO likes (idmessage, idutilisateur) VALUES (?, ?)');
            $ins->execute(array($getid, $sessionid));
         }
         
      } elseif($gett == 2) {
         $check_like = $bdd->prepare('SELECT id FROM dislikes WHERE idmessage = ? AND idutilisateur = ?');
         $check_like->execute(array($getid,$sessionid));
         $del = $bdd->prepare('DELETE FROM likes WHERE idmessage = ? AND idutilisateur = ?');
         $del->execute(array($getid,$sessionid));
         if($check_like->rowCount() == 1) {
            $del = $bdd->prepare('DELETE FROM dislikes WHERE idmessage = ? AND idutilisateur = ?');
            $del->execute(array($getid,$sessionid));
         } else {
            $ins = $bdd->prepare('INSERT INTO dislikes (idmessage, idutilisateur) VALUES (?, ?)');
            $ins->execute(array($getid, $sessionid));
         }
      }
      header('Location: http://127.0.0.1/channel/message/message.php?id='.$getid); //attention au nom de la bdd
   } else {
      exit('Erreur fatale. <a href="http://127.0.0.1/channel/message/">Revenir à l\'accueil</a>');//à vérifier
   }
} else {
   exit('Erreur fatale. <a href="http://127.0.0.1/channel/message/">Revenir à l\'accueil</a>');//à vérifier
}