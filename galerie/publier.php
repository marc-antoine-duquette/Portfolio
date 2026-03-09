<?php
$titre = "Publication";
require "authentification.php";
require "bd.php";
include "header.php";

$formatsAcceptes = array('image/png', 'image/PNG', 'image/jpeg',
'image/JPEG', 'image/jpg', 'image/JPG', 'image/gif', 'image/GIF');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (in_array($_FILES['fichier']['type'], $formatsAcceptes)) {
        if (isset($_POST['titre'])){
            $titre = $_POST['titre'];
            if (estVide($_POST['descrip'])){
                $descrip = " ";
            } else{
                $descrip = $_POST['descrip'];
            }
            $titre = trim($titre);
            $descrip = trim($descrip);
            if (strlen($titre) > 0 && strlen($descrip) > 0) {
                if (ajouterImage($mysqli, $titre, $descrip, $_SESSION['pseudo'])) {
                    header("Location: index.php");
                } else {
            	    echo "<div class=\"alert alert-danger\">Une erreur s'est produite</div>";
            	}
            } else {
                echo "<div class=\"alert alert-danger\">Le titre et la description ne doivent pas être vide</div>";
            }
        } else{
            echo "<div class=\"alert alert-danger\">Les informations ne doivent pas être vides</div>";
        }
    } else {
        echo "<div class=\"alert alert-danger\">Le fichier n'est pas une image valide</div>";
    }
}
?>

<fieldset class="mb-3">
    <legend>Connexion</legend>
	<form action="publier.php" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 mb-3">
	    		<input type="hidden" name="MAX_FILE_SIZE" value="5000000">
	    		Fichier : <input name="fichier" size="35" type="file" accept="image/jpeg, image/png, image/jpg, image/gif">
                <div>Pas plus que 5 Mo</div>
            </div>
            <div class="col-md-6 mb-3">
				<label for="titre" class="form-label mb-2">Titre de l'image</label>
                <input type="text" class="form-control" id="titre" name="titre" required>
            </div>
            <div class="col-12 mb-3">
                <label for="descrip" class="form-label mb-2">Description de l'image</label>
                <textarea type="text" class="form-control" id="descrip" name="descrip" rows="3"></textarea>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Envoyer l'image</button>
	</form>
</fieldset>

<?php
include "footer.php";
?>