<?php
$bdd = new PDO("mysql:host=127.0.0.1;dbname=channel;charset=utf8", "root", ""); //attention au nom de la bdd > à changer et ce fichier message.php doit être appairé avec celui de JEAN
if(isset($_GET['id']) AND !empty($_GET['id'])) {
   $get_id = htmlspecialchars($_GET['id']);
   $message = $bdd->prepare('SELECT * FROM message WHERE id = ?');
   $message->execute(array($get_id));
   if($message->rowCount() == 1) {
      $message = $message->fetch();
      $id = $message['id'];
     // $titre = $message['titre']; pas dans notre exo
      $contenu = $message['contenu'];
      $likes = $bdd->prepare('SELECT id FROM likes WHERE idmessage = ?');
      $likes->execute(array($id));
      $likes = $likes->rowCount();
      $dislikes = $bdd->prepare('SELECT id FROM dislikes WHERE idmessage = ?');
      $dislikes->execute(array($id));
      $dislikes = $dislikes->rowCount();
   } else {
      die('Ce message n\'existe pas !');
   }
} else {
   die('Erreur');
}
?>
<!DOCTYPE html>
<html>
<head>
   <title>Accueil</title>
   <meta charset="utf-8">
</head>
<body>
   <!-- <img src="miniatures/<?= $id ?>.jpg" width="400" /> attention à changer pour renvoyer vers le message dans le code de JEAN-->
   <h1><?= $message ?></h1>
   <p><?= $contenu ?></p>
   <a href="php/action.php?t=1&id=<?= $id ?>">J'aime</a> (<?= $likes ?>) <!-- ici 1 correspond à Like pour éviter l'interprétation  de !empty dans la ligne 6 du fichier php.action.php) attention à la racine de php/action.php à corriger dans l'architecture des fichiers en référence à ceux de Jean il faut aussi remplacer j'aime par l'emoticon pouce levé-->
   <br />
   <a href="php/action.php?t=2&id=<?= $id ?>">Je n'aime pas</a> (<?= $dislikes ?>) <!-- (ici 2 correspond à Dislike pour éviter l'interprétation  de !empty dans la ligne 6 du fichier php.action.php) il faut aussi remplacer j'aime par l'emoticon pouce baissé-->
</body>
</html>