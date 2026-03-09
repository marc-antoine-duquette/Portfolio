<?php

session_start();

if (!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("Location: index.php");
}
else{
    $prenom = $_SESSION['prenom'];
    $nom = $_SESSION['nom'];
}
?>