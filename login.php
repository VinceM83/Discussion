<?php
	require_once('config/protect.php');
	if ($identifie) {
		header('Location: index.php');
		exit;
	}

	if (isset($_POST['pseudo'])) {
		$format = ['pseudo' => '', 'mdp' => ''];
		$p = array_intersect_key($_POST, $format);

		require_once('config/connect.php');

		$stmt = $pdo->prepare("SELECT id, pseudo FROM utilisateur WHERE pseudo = :pseudo AND mdp = encode(digest(:mdp, 'sha384'), 'hex');");

		$stmt->execute($p);

		if ($stmt->rowCount()) {
			session_start();
			$_SESSION = $stmt->fetch(PDO::FETCH_ASSOC);
			header('Location: index.php');
			exit;
		} else {
			$err = true;
		}
	}

	require_once('parts/header.php');
?>
<form method="POST">
	<div class="form-group">
		<label for="pseudo">Pseudo :</label>
		<input type="text" name="pseudo" id="pseudo">
	</div>
	<div class="form-group">
		<label for="mdp">Mot de passe :</label>
		<input type="password" name="mdp" id="mdp">
	</div>
	<input type="submit" value="Connexion">
</form>

<?php require_once('parts/footer.php'); ?>