<?php
$titre = "Connexion";
include "header.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require "bd.php";

    if (!estVide(trim($_POST['pseudo'])) && !estVide(trim($_POST['mdp']))) {
        logger($mysqli, $_POST['pseudo'], $_POST['mdp']);
    } else {
        echo "<div class=\"alert alert-danger\">Le pseudonyme et le mot de passe ne doivent pas être vide</div>";
    }
} else {
    session_start();
    session_destroy();
    session_unset();
    setcookie("PHPSESSID", null, -1);
}
?>

<fieldset class="mb-3">
    <legend>Connexion</legend>
	<form action="login.php" method="POST">
        <div class="row">
            <div class="col-sm-6 mb-3">
                <label for="pseudo" class="form-label mb-2">Pseudonyme:</label>
	    		<input type="text" class="form-control" name="pseudo" id="pseudo" required>
            </div>
            <div class="col-sm-6 mb-3">
                <label for="mdp" class="form-label mb-2">Mot de passe:</label>
	    		<input type="password" class="form-control" name="mdp" id="mdp" required>
            </div>
        </div>
	    <button type="submit" class="btn btn-primary">Envoyer</button>
	</form>
</fieldset>

<a href="inscrip.php">S'inscrire</a>

<?php
include "footer.php";
?>