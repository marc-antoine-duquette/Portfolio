<?php
$titre = "Accueil";
session_start();
require "bd.php";
include "header.php";

$estAuthentifié = isset($_SESSION["prenom"]) && isset($_SESSION["nom"]);
?>

<style>
    .img-gallery {
        max-height: 200px;
        object-fit: contain;
        max-width: calc(100vw - 2rem);
		align-self: center;
    }
	@media (min-width: 576px) {
		.img-gallery {
    	    max-width: calc(50vw - 1rem);
    	}
	}
	@media (min-width: 992px) {
		.img-gallery {
    	    max-width: calc(33.33vw - .66rem);
    	}
	}
	@media (min-width: 1400px) {
		.img-gallery {
    	    max-width: calc(20vw - .4rem);
    	}
	}
    @media (max-width: 768px) {
		.btn-group {
			width: 100%;
			flex-direction: column; 
		}
		.btn-group .btn {
			display: block;
			width: 100%;
		    border-radius: 0.25rem !important;
			margin-top: -1px;
            margin-left: -1px;
		}
	}
</style>

<div class="btn-group" role="group" aria-label="Basic example">
<?php
if ($estAuthentifié) {

    echo "<a id=\"Publier\" href=\"publier.php\" class=\"btn btn-primary\"><i class=\"fa-solid fa-plus\"></i> Publier une image</a>";

    }
?>
<a href="index.php?tri=desc" class="btn btn-secondary"><i class="fa-solid fa-arrow-down-short-wide"></i> Afficher par plus récents</a>
<a href="index.php?tri=asc" class="btn btn-secondary"><i class="fa-solid fa-arrow-down-wide-short"></i> Afficher par plus anciens</a>
</div>

<div id="divImages">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['tri']) && $_GET['tri'] == 'asc') {
        afficherImages($mysqli, 1);
    } else {
        afficherImages($mysqli, 2);
    }
    
    ?>

</div>

<?php
include "footer.php";
?>