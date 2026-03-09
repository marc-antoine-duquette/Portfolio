<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "$titre" ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/f6115b3350.js" crossorigin="anonymous"></script>
</head>

<body>

<header>
    <style>
        :root {
			--header-height: 60px;
		}
    </style>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
			<div class="navbar-brand" aria-current="page" href="#">La galerie d'images</div>
            <div>
                <ul class="navbar-nav me-auto">
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i> Accueil</a>
					</li>
				</ul>
            </div>
            <div>
        		<span>
	<?php
    //<img src=\"../../assets/img/gallery.gif\" height=\"24px\" />
	
    //TODO faire un navbar pour mobile
    if (isset($_SESSION) && isset($_SESSION['pseudo'])) {
    ?>
        			<a href="login.php">Se déconnecter</a> | 
        		    <a href="profil.php">Modifier le profil</a>
    <?php
    } else {
    ?>
        			<a href="login.php">Se connecter</a>
    <?php
    }
    ?>
        		</span>
            </div>
        </div>
    </nav>
</header>

<main class="p-3" style="height: calc(100vh - var(--header-height)); overflow: auto;">
<script>
    function onResize(){
        document.querySelector("main").style.setProperty('--header-height', `${document.querySelector("header").clientHeight}px`);
    }
	
    window.addEventListener('resize', onResize);
    onResize();
</script>