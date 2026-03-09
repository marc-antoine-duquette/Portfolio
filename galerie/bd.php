<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('Location: index.php');
}
require "bdAccess.php";
$charset = 'utf8';

// --- CONNECTION ---
$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_error) {
    echo "<div class=\"alert alert-danger\">Erreur de connection</div>";
    exit;
}

// --- FUNCTIONS ---
function Hs($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function estVide($info)
{
    return !isset($info) || $info == "";
}

function ajouterUtilisateur($mysqli, $nom, $prenom, $pseudo, $mdp)
{
    try {
		$sql = "SELECT nom, prenom FROM utilisateur WHERE pseudo=?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("s", $pseudo);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->fetch_assoc()) {
			return 2; // pseudo déjà utilisé
		}

		// Insérer dans utilisateur
		$sql = "INSERT INTO utilisateur (nom, prenom, pseudo, mdp) VALUES (?, ?, ?, ?)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("ssss", $nom, $prenom, $pseudo, $mdp);
		$stmt->execute();

		session_start();
		$_SESSION['nom'] = $nom;
		$_SESSION['prenom'] = $prenom;
		$_SESSION['pseudo'] = $pseudo;

		return 1;
    } catch (Exception $e) {
        return 3;
    }
}

function logger($mysqli, $pseudo, $mdp)
{
    session_start();
    try {
        $sql = "SELECT nom, prenom FROM utilisateur WHERE pseudo=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $pseudo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (validerMdp($mysqli, $pseudo, $mdp)) {
                $_SESSION['nom'] = $row['nom'];
                $_SESSION['prenom'] = $row['prenom'];
                $_SESSION['pseudo'] = $pseudo;
                header("Location:index.php");
                exit;
            }
        }

        echo "<div class=\"alert alert-danger\">Le pseudonyme ou le mot de passe est invalide</div>";
    } catch (Exception $e) {
        echo "<div class=\"alert alert-danger\">Cet utilisateur n'existe pas</div>";
    }
}

function modifierUtilisateur($mysqli, $pseudo, $mdp, $nom, $prenom)
{
    try {
		$sql = "UPDATE utilisateur SET mdp=?, nom=?, prenom=? WHERE pseudo=?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("ssss", $mdp, $nom, $prenom, $pseudo);
		$stmt->execute();
	} catch (Exception $e) {
        return false;
    }
    
    return true;
}

function supprimerImage($mysqli, $id)
{
    $sql = "SELECT pseudo, fichier FROM images WHERE id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (isset($_SESSION['pseudo']) && $_SESSION['pseudo'] == $row['pseudo']) {
            $sql = "DELETE FROM images WHERE id=?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            $sql = "DELETE FROM commentaires WHERE idImage=?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            unlink($row['fichier']);
            echo $row['fichier'];
        }
    }
}

function ajouterImage($mysqli, $titre, $description, $pseudo)
{
    try {
        // Récupérer le dernier ID
        $sql = "SELECT MAX(id) AS id FROM images";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $id = $row ? $row['id'] : 0;

        $rep = 'images/';
        $fich = $rep . ($id + 1) . basename($_FILES['fichier']['name']);

        if (move_uploaded_file($_FILES['fichier']['tmp_name'], $fich)) {
            $sql = "INSERT INTO images (fichier, titre, descrip, pseudo, datePublic) VALUES (?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            $date = date("Y-m-d H:i:s");
            $stmt->bind_param("sssss", $fich, $titre, $description, $pseudo, $date);
            $stmt->execute();
        } else {
            return false;
        }

        return true;
    } catch (Exception $e) {
        echo "<div class=\"alert alert-danger\">Impossible d'ajouter cette image</div>";
        return false;
    }
}

function validerMdp($mysqli, $pseudo, $mdp)
{
    $sql = "SELECT mdp FROM utilisateur WHERE pseudo=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $pseudo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return password_verify($mdp, $row['mdp']);
    }

    return false;
}

function AjouterCommentaire($mysqli, $texte, $pseudo, $idImage)
{
    try {
        if (strlen(trim($texte)) > 0) {
            $sql = "INSERT INTO commentaires (texte, pseudo, datePub, idImage) VALUES (?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            $date = date("Y-m-d H:i:s");
            $stmt->bind_param("sssi", $texte, $pseudo, $date, $idImage);
            $stmt->execute();
        }
    } catch (Exception $e) {
        echo "<div class=\"alert alert-danger\">Une erreur s'est produite</div>";
    }
}

function ModifierCommentaire($mysqli, $pseudo, $idCommentaire, $nouvTexte)
{
    try {
        if (strlen(trim($nouvTexte)) > 0) {
            $sql = "SELECT pseudo FROM commentaires WHERE id=?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $idCommentaire);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                if ($row['pseudo'] == $pseudo) {
                    $sql = "UPDATE commentaires SET texte=? WHERE id=?";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("si", $nouvTexte, $idCommentaire);
                    $stmt->execute();
                }
            }
        }
        else{
            echo "<div class=\"alert alert-danger\">Le commentaire ne doit pas être vide</div>";
        }
    } catch (Exception $e) {
        echo "<div class=\"alert alert-danger\">Une erreur s'est produite</div>";
    }
}

function SupprimerCommentaire($mysqli, $pseudo, $id)
{
    try {
        $sql = "DELETE FROM commentaires WHERE pseudo=? AND id=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $pseudo, $id);
        $stmt->execute();
    } catch (Exception $e) {
        echo "<div class=\"alert alert-danger\">Une erreur s'est produite</div>";
    }
}

function PrendreCommentaires($mysqli, $idImage)
{
    $sql = "SELECT id, texte, pseudo, datePub FROM commentaires WHERE idImage=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $idImage);
    $stmt->execute();
    $result = $stmt->get_result();

    $tab = [];
    while ($row = $result->fetch_assoc()) {
        $tab[] = $row;
    }

    return $tab;
}

function afficherImage($mysqli, $id, $estGest)
{
    echo "<div";
    if (!$estGest)
        echo " class=\"card text-center\"";
    echo ">";
    
    $sql = "SELECT fichier, titre, descrip, pseudo, datePublic FROM images WHERE id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        $fich = $row['fichier'];
        $titre = $row['titre'];
        $descrip = $row['descrip'];
        $pseudo = $row['pseudo'];
        $dateComplete = $row['datePublic'];
        $datePublic = date("j M Y", strtotime($dateComplete));
        
        if ($estGest) {
    		echo "<h1>" . Hs($titre) . "</h1>";
            echo "<img src=\"$fich\" alt=\"" . Hs($titre) . "\" id=\"imgGest\">";

            if (isset($_SESSION['pseudo']) && $_SESSION['pseudo'] == $pseudo) {
                echo "
                <form action=\"gestImage.php\" method=\"post\">
                    <input type=\"hidden\" name=\"id\" value=\"$id\">
                    <input type=\"hidden\" name=\"supprimer\" value=\"supprimer\">
                    <button type=\"submit\" class=\"btn btn-danger mb-3\" id=\"Supprimer\">Supprimer</button>
                </form>";
            }
        } else {
            echo "<img src=\"$fich\" alt=\"" . Hs($titre) . "\" class=\"card-img-top img-gallery\"></a>";
        }
        
        if (!$estGest)
        	echo "<div class=\"card-body\"><h5 class=\"card-title\">" . Hs($titre) . "</h5>";
        else
            echo "<div>" . Hs($descrip) . "</div>";
        echo "<div>Publié par ". Hs($pseudo) . "</div>";
        echo "<div class=\"mb-3\"> le $datePublic</div>";

        $commentaires = PrendreCommentaires($mysqli, $id);
        $nbCommentaires = count($commentaires);

        if ($estGest) {
        	echo "<h3>Commentaires</h3><div class=\"Commentaires row\">";
            
            if (isset($_SESSION['pseudo'])){
            	echo "
            	<div class=\"commentaire mb-3\">
            	    <div>Publier un commentaire</div>
            	    <textarea class=\"form-control\" name=\"commentaire\" id=\"commentaire\" form=\"ajout\" rows=\"3\"></textarea>
            	    <form action=\"gestImage.php\" method=\"post\" id=\"ajout\">
            	        <input type=\"hidden\" name=\"idImage\" value=\"$id\">
            	        <button class=\"btn btn-primary\" type=\"submit\" name=\"gestion\" value=\"ajout\">Publier</button>
            	    </form>
            	</div>";
            }
            
            $numComm = 0;

            // Trier par date DESC
            $colonne = array_column($commentaires, "datePub");
            array_multisort($colonne, SORT_DESC, $commentaires);

            foreach ($commentaires as $commentaire) {
                $idCommentaire = $commentaire['id'];
                $texte = $commentaire['texte'];
                $pseudoComm = $commentaire['pseudo'];
                $dateComplete = date("Y-m-d H:i:s", strtotime($commentaire['datePub']));
                $datePub = date("j M Y", strtotime($dateComplete));

                echo "<div class=\"commentaire mb-3 col-md-4 col-sm-6\">
                        <div>Publié par " . Hs($pseudoComm). " le $datePub.</div>";

                if (isset($_SESSION['pseudo']) && $_SESSION['pseudo'] == $pseudoComm) {
                    echo "
                    <textarea name=\"commentaire\" class=\"form-control\" id=\"commentaire\" form=\"modif$numComm\" rows=\"3\">" . Hs($texte) . "</textarea>
                    <form class=\"mb-3\" action=\"gestImage.php\" method=\"post\" id=\"modif$numComm\">
                        <input type=\"hidden\" name=\"idCommentaire\" value=\"$idCommentaire\">
                        <input type=\"hidden\" name=\"texte\" value=\"" . Hs($texte) . "\">
                        <input type=\"hidden\" name=\"pseudo\" value=\"" . Hs($pseudoComm) . "\">
                        <input type=\"hidden\" name=\"datePub\" value=\"$dateComplete\">
                        <input type=\"hidden\" name=\"idImage\" value=\"$id\">
                        <div class=\"btn-group\">
                        <button class=\"btn btn-primary\" type=\"submit\" name=\"gestion\" value=\"modif\">Modifier</button>
                        <button class=\"btn btn-danger\" type=\"submit\" name=\"gestion\" value=\"suppr\">Supprimer</button>
                        </div>
                    </form>";

                    $numComm++;
                } else {
                    echo "<fieldset>" . Hs($texte) . "</fieldset>";
                }

                echo "</div>";
            }

        } else {
            echo "<div class=\"mb-2\">$nbCommentaires <i class=\"fa-solid fa-comment\"></i></div>";
            echo "<a class=\"btn btn-primary\" href=\"gestImage.php?id=$id\">Détails</a></div>";
        }

        echo "</div>";
        return true;
    }

    return false;
}

function afficherImages($mysqli, $numTri)
{
    try {
        $images = [];

        $sql = "SELECT id, datePublic FROM images";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $images[] = [$row['datePublic'], $row['id']];
        }

        $colonne = array_column($images, 0);

        if ($numTri == 1) {
            array_multisort($colonne, SORT_ASC, $images);
        } else {
            array_multisort($colonne, SORT_DESC, $images);
        }

        foreach ($images as $image) {
            afficherImage($mysqli, $image[1], false);
        }

    } catch (Exception $e) {
        echo "<div class=\"alert alert-danger\">Une erreur s'est produite</div>";
    }
}
    ?>