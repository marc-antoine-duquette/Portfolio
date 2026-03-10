<?php
require "lang.php";
?>

<!DOCTYPE html>
<html lang="<?= $locale ?>">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Portfolio</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-black bg-black fixed-top navbar-shrink" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#page-top">Portfolio</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#about"><?= lang("menu_about") ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="#projects"><?= lang("menu_projects") ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="#competences"><?= lang("menu_skills") ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact"><?= lang("menu_contact") ?></a></li>
                        <li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								<?= $_COOKIE["locale"] ? ucfirst($_COOKIE["locale"]) : "Fr" ?>
							</a>
							<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item lang_btn" href="#" locale="fr">Fr</a></li>
                                <li><a class="dropdown-item lang_btn" href="#" locale="en">En</a></li>
							</ul>
                            
                            <script>
                                document.querySelectorAll(".lang_btn").forEach(element => {
                                    element.onclick = function() {
                                		const expirationDate = new Date();
										expirationDate.setTime(expirationDate.getTime() + (5 * 365.25 * 24 * 60 * 60 * 1000));
										document.cookie = "locale=" + element.getAttribute("locale") + "; expires=" + expirationDate.toUTCString() + "; path=/";
                                        
                                        location.reload();
									};
                                });
                            </script>
						</li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
                <div class="d-flex justify-content-center">
                    <div class="text-center">
                        <h1 class="mx-auto my-0 text-uppercase">Marc-Antoine Duquette</h1>
                    </div>
                </div>
            </div>
        </header>
        <!-- About-->
        <section class="about-section text-center" id="about">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center" style="padding-bottom: 10rem;">
                    <div class="col-lg-8">
                        <h2 class="text-white mb-4"><?= lang("about_title") ?></h2>
                        <?
    					for ($i = 1; $i <= 5; $i++) {
                        ?>
                        <p class="text-white<? if ($i %2 == 0) echo "-50"; ?>"><?= lang("about_me_" . $i) ?></p>
                        <?
						}
    					?>
                    </div>
                </div>
            </div>
        </section>
        <!-- Projects-->
        <section class="projects-section bg-light" id="projects">
			<h2 class="text-black mb-4 text-center"><?= lang("projects_title") ?></h2>
            <div class="container px-4 px-lg-5" style="padding-bottom: 6rem;">
				<div class="card mb-3">
					<div class="row g-0">
						<div class="col-md-4 text-center text-md-start">
							<img src="assets/img/gallery.png" class="img-fluid rounded-start ms-0 ms-lg-4" alt="Image de galerie" width="250px">
						</div>
						<div class="col-md-8">
							<div class="card-body">
								<h5 class="card-title"><?= lang("gallery_title") ?></h5>
								<p class="card-text"><?= lang("gallery_desc") ?></p>
                                <a class="btn btn-primary" href="galerie" target="_blank"><?= lang("visit") ?></a>
							</div>
						</div>
					</div>
				</div>
                <div class="card mb-3">
					<div class="row g-0">
						<div class="col-md-4 text-center text-md-start">
							<img src="assets/img/cart.png" class="img-fluid rounded-start ms-0 ms-lg-4" alt="Image de panier" width="250px">
						</div>
						<div class="col-md-8">
							<div class="card-body">
								<h5 class="card-title"><?= lang("stripe_title") ?></h5>
								<p class="card-text"><?= lang("stripe_desc") ?></p>
                                <a class="btn btn-primary" href="shoppingCart" target="_blank"><?= lang("visit") ?></a>
							</div>
						</div>
					</div>
				</div>
				<div class="card mb-3">
					<div class="row g-0">
						<div class="col-md-4 text-center text-md-start">
							<img src="assets/img/slipperyslime.png" class="img-fluid rounded-start" alt="Image de Slippery Slime">
						</div>
						<div class="col-md-8">
							<div class="card-body">
								<h5 class="card-title"><?= lang("slippery_slime_title") ?></h5>
								<p class="card-text"><?= lang("slippery_slime_desc") ?>
                                    <ul>
                                        <?
    									for ($i = 1; $i <= 11; $i++) {
                        				?>
                        				<li><?= lang("slippery_slime_feature_" . $i) ?></li>
                        				<?
										}
    									?>
                                	</ul>
                                </p>
                                <a class="btn btn-primary" href="https://slipperyslimegame.itch.io/slipperyslime" target="_blank"><?= lang("visit") ?></a>
							</div>
						</div>
					</div>
				</div>
            </div>
            <div class="container px-4 px-lg-5 text-center">
                <a class="btn btn-primary" href="https://github.com/marc-antoine-duquette/Portfolio" target="_blank">
                    <i class="fab fa-github mb-2" style="font-size: 2rem;"></i><br><?= lang("github_code") ?>
                </a>
            </div>
        </section>
        <!-- Compétences techniques-->
        <section class="contact-section bg-dark pb-4" id="competences">
            <div class="container px-4 px-lg-5">
				<h2 class="text-white mb-4 text-center"><?= lang("skills_title") ?></h2>
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
								<h5 class="card-title"><?= lang("skills_languages") ?></h5>
                                <ul class="list-group list-group-flush">
									<li class="list-group-item">HTML</li>
									<li class="list-group-item">CSS</li>
									<li class="list-group-item">PHP</li>
									<li class="list-group-item">C#, Java, C++</li>
									<li class="list-group-item">Python</li>
									<li class="list-group-item">Lua</li>
									<li class="list-group-item">SQL</li>
								</ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
								<h5 class="card-title"><?= lang("skills_frameworks") ?></h5>
                                <ul class="list-group list-group-flush">
									<li class="list-group-item">jQuery</li>
                                    <li class="list-group-item">React Native</li>
                                    <li class="list-group-item">CodeIgniter</li>
								</ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
								<h5 class="card-title"><?= lang("skills_databases") ?></h5>
                                <ul class="list-group list-group-flush">
									<li class="list-group-item">MySQL</li>
									<li class="list-group-item">MongoDB</li>
								</ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
								<h5 class="card-title"><?= lang("skills_software") ?></h5>
                                <ul class="list-group list-group-flush">
									<li class="list-group-item">Word</li>
									<li class="list-group-item">Excel</li>
									<li class="list-group-item">Visual Studio</li>
									<li class="list-group-item">Visual Studio Code</li>
									<li class="list-group-item">Unity</li>
									<li class="list-group-item">Android Studio</li>
								</ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
								<h5 class="card-title"><?= lang("skills_other") ?></h5>
                                <ul class="list-group list-group-flush">
									<li class="list-group-item">Github</li>
									<li class="list-group-item">Plastic SCM</li>
									<li class="list-group-item">Windows</li>
									<li class="list-group-item">Linux</li>
								</ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact-->
        <section class="contact-section bg-black" id="contact">
            <div class="container px-4 px-lg-5">
				<h2 class="text-white mb-4 text-center"><?= lang("contact_title") ?></h2>
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                        <div class="card py-4 h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-lg fa-envelope text-black mb-2"></i>
                                <h4 class="text-uppercase m-0"><?= lang("contact_email") ?></h4>
                                <br class="my-4 mx-auto" />
                                <div class="small text-black-50"><a href="mailto:marc-antoine_duquette@outlook.com">marc-antoine_duquette@outlook.com</a></div>
                            </div>
                        </div>
                    </div>
					<div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                        <div class="card py-4 h-100">
                            <div class="card-body text-center">
                                <i class="fa-brands fa-lg fa-linkedin text-black mb-2"></i>
                                <h4 class="text-uppercase m-0"><?= lang("contact_linkedin") ?></h4>
                                <br class="my-4 mx-auto" />
                                <div class="small text-black-50"><a href="https://www.linkedin.com/in/marc-antoine-duquette/">linkedin.com/in/marc-antoine-duquette/</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="footer bg-black small text-center text-white-50"></footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
