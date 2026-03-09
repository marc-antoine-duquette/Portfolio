<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$titre = "Gestion d'image";
session_start();
require "bd.php";
include "header.php";
?>

<div id="divGrandeImage">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        if (isset($_POST['supprimer']) && isset($_POST['id'])) {
            supprimerImage($mysqli, $_POST['id']);
            header("Location: index.php");
        }
        else if (isset($_SESSION['pseudo']) && isset($_POST['gestion']) && isset($_POST['idImage'])){
            $idImage = $_POST['idImage'];
            $pseudo = $_SESSION['pseudo'];
            if (isset($_POST['idCommentaire'])){
                if ($_POST['gestion']=='modif') {
                    ModifierCommentaire($mysqli, $pseudo, intval($_POST['idCommentaire']), $_POST['commentaire']);
                } else if ($_POST['gestion']=='suppr') {
                    SupprimerCommentaire($mysqli, $pseudo, intval($_POST['idCommentaire']));
                }
            }
            else if ($_POST['gestion']=='ajout' && isset($_POST['commentaire'])){
                AjouterCommentaire($mysqli, $_POST['commentaire'], $pseudo, $idImage);
            }
            header("Location: gestImage.php?id=$idImage");
        }
        else if (isset($_POST['idImage'])){
            afficherImage($mysqli, $_POST['idImage'], true);
            echo "<div class=\"alert alert-danger\">Une erreur s'est produite</div>";
        }
        else{
            echo "<a href=\"index.php\">Retourner à l'accueil</a>";
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
        afficherImage($mysqli, $_GET['id'], true);
    }
    ?>
</div>

<?php
include "footer.php";
?>