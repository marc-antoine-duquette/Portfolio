<?php
require "authentification.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$titre = "Profil";
include "header.php";
require "bd.php";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION['pseudo'])) {
    $estValide = false;
	foreach ($_POST as $info => $valeur) {
	    $valeur = trim($valeur);
	    if (estVide($valeur)) {
	        $estValide = true;
	        break;
	    }
	}
    
    if (!$estValide) {
        $pseudo = $_SESSION['pseudo'];
    	$mdpNouv = trim($_POST["mdp"]);
    	$mdpConfirm = trim($_POST["mdpConfirm"]);
    	$mdpAncien = trim($_POST['mdpAncien']);
    	$prenom = trim($_POST['prenom']);
    	$nom = trim($_POST['nom']);
        
        if ($mdpConfirm != $mdpNouv){
            echo '<div class="alert alert-danger">Les mots de passe ne s\'équivalent pas</div>';
        }
        else if (validerMdp($mysqli, $pseudo, $mdpAncien)) {
			$hash = password_hash($mdpNouv, PASSWORD_DEFAULT);
            if (modifierUtilisateur($mysqli, $pseudo, $hash, $nom, $prenom)) {
                $_SESSION['nom'] = $nom;
                $_SESSION['prenom'] = $prenom;
            	echo '<div class="alert alert-success">Profil modifié</div>';
            }
            else{
                echo '<div class="alert alert-danger">Une erreur s\'est produite</div>';
            }
            
        } else {
            echo '<div class="alert alert-danger">Le mot de passe est invalide</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Il manque des informations</div>';
    }
}
?>


<?php
$pseudo = $_SESSION['pseudo'];
?>
<fieldset class="mb-3">
    <legend>Modifier le profil de l'utilisateur <?= Hs($pseudo) ?></legend>
	<form action="profil.php" method="post">
        <div class="row">
            <input type="hidden" name="pseudo" value="<?= Hs($pseudo) ?>" />
            <div class="col-sm-6 mb-3">
	    		<label for="prenom" class="form-label mb-2">Prenom:</label>
        		<input type="prenom" class="form-control" id="prenom" name="prenom" value="<?= Hs($_SESSION['prenom']) ?>" maxlength="64" required>
            </div>
            <div class="col-sm-6 mb-3">
                <label for="nom" class="form-label mb-2">Nom:</label>
        		<input type="nom" class="form-control" id="nom" name="nom" value="<?= Hs($_SESSION['nom']) ?>" maxlength="64" required>
            </div>
            <div class="col-sm-6 mb-3">
                <label for="mdpAncien" class="form-label mb-2">Ancien mot de passe:</label>
        		<input type="password" class="form-control" id="mdpAncien" name="mdpAncien" required>
            </div>
            <div class="col-sm-6 mb-3">
                <label for="mdp" class="form-label mb-2">Nouveau mot de passe:</label>
        		<input type="password" class="form-control" id="mdp" name="mdp" required>
            </div>
            <div class="col-sm-6 mb-3">
                <label for="mdpConfirm" class="form-label mb-2">Confirmer le nouveau mot de passe:</label>
        		<input type="password" class="form-control" id="mdpConfirm" name="mdpConfirm" required>
            </div>
        </div>
	    <button type="submit" class="btn btn-primary">Envoyer</button>
	</form>
</fieldset>
<?php
include "footer.php";
?>