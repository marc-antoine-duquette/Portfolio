<?php
$titre = "Inscription";
include "header.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require "bd.php";

	$estValide = true;
	foreach ($_POST as $info => $valeur) {
	    $valeur = trim($valeur);
	    if (estVide($valeur)) {
	        $estValide = false;
	        break;
	    }
	}
    
	if ($estValide) {
	    if ($_POST['mdp'] == $_POST['mdpConfirm']) {
	        $hash = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
            $nom = trim($_POST['nom']);
            $prenom = trim($_POST['prenom']);
            $pseudo = trim($_POST['pseudo']);
            
	        $resultat = ajouterUtilisateur($mysqli, $nom, $prenom, $pseudo, $hash);
	        if ($resultat == 1) {
				header("Location: index.php");
	        } else if ($resultat == 2) {
	            echo '<div class="alert alert-danger">Ce pseudonyme a déjà été utilisé</div>';
	        } else if ($resultat == 3) {
	            echo '<div class="alert alert-danger">Une erreur s\'est produite</div>';
	        }
	    } else {
	        echo '<div class="alert alert-danger">Les mots de passe ne s\'équivalent pas</div>';
	    }
	} else {
	    echo '<div class="alert alert-danger">Aucun champs ne doit être vide</div>';
	}
}
?>

<fieldset>
    <legend>Inscrivez-vous</legend>
    <form action="inscrip.php" method="post">
        <div class="row">
            <div class="col-sm-4 mb-3">
        		<label for="prenom" class="form-label mb-2">Prénom: </label>
        		<input type="text" class="form-control" id="prenom" name="prenom" maxlength="64" required>
            </div>
            <div class="col-sm-4 mb-3">
        		<label for="nom" class="form-label">Nom: </label>
        		<input type="text" class="form-control" id="nom" name="nom" maxlength="64" required>
            </div>
            <div class="col-sm-4 mb-3">
        		<label for="pseudo" class="form-label">Pseudonyme: </label>
        		<input type="text" class="form-control" id="pseudo" name="pseudo" maxlength="64" required>
            </div>
            <div class="col-sm-4 mb-3">
        		<label for="mdp" class="form-label">Mot de passe: </label>
        		<input type="password" class="form-control" id="mdp" name="mdp" required>
            </div>
            <div class="col-sm-4 mb-3">
        		<label for="mdpConfirm" class="form-label">Confirmer le mot de passe: </label>
        		<input type="password" class="form-control" id="mdpConfirm" name="mdpConfirm" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</fieldset>

<?php
include "footer.php";
?>