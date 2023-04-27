<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>S'enregistrer</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top">Damien JANDARD</a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="/">Accueil</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Register Section-->
    <section class="masthead page-section" id="register">
        <div class="container">
            <!-- Register Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">S'enregistrer</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Register Section Form-->
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- * * Register Form * *-->
                    <!-- * * * * * * * * * * * * * * *-->
                    <form id="registerForm" method="post" action="?action=adduser">
                        <!-- Email address input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="email" name="email" type="email" placeholder="name@example.com" value="<?php if (isset($_GET['email'])) echo $_GET['email']  ?>" />
                            <label for="email">Email</label>
                        </div>
                        <!-- Password input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="password" name="password" type="password" placeholder="JdIcA48*" />
                            <label for="password">Mot de passe</label>
                        </div>
                        <!-- Confirm password input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="confirmPassword" name="confirmPassword" type="password" placeholder="JdIcA48*" aria-labelledby="passwordHelpBlock" />
                            <label for="confirmPassword">Confirmation du mot de passe</label>
                        </div>
                        <div id="passwordHelpBlock" class="form-text mb-3">
                            Votre mot de passe doit comporter au moins 8 caractères et doit inclure au moins une lettre majuscule, une lettre minuscule un chiffre et un caractère spécial.
                        </div>
                        <!-- Submit Button-->
                        <button class="btn btn-primary btn-xl" id="submitButton" type="submit">S'enregistrer</button>
                        <?php
                        if (isset($_GET['error'])) {
                        ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?php
                                if ($_GET['error'] === "1") {
                                    echo "Adresse email non valide !";
                                } elseif ($_GET['error'] === "2") {
                                    echo "Aucun mot de passe n'a été saisi !";
                                } elseif ($_GET['error'] === "3") {
                                    echo "Les mots de passes ne sont pas identiques !";
                                } elseif ($_GET['error'] === "4") {
                                    echo "Votre mot de passe ne respecte pas les règles de sécurité !";
                                } else {
                                    if (isset($_GET['email'])) {
                                        echo "Un compte existe déjà pour cette adresse email ! <a href='?action=login&email=" . $_GET['email']  . "'>Se connecter</a>";
                                    } else {
                                        echo "Un compte existe déjà pour cette adresse email ! <a href='?action=login'>Se connecter</a>";
                                    }
                                }
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="footer text-center">
        <div class="container">
            <div class="row">
                <!-- Footer Location-->
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Localisation</h4>
                    <p class="lead mb-0">
                        01140 SAINT DIDIER SUR CHALARONNE
                    </p>
                </div>
                <!-- Footer Social Icons-->
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Mes réseaux</h4>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-github"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-linkedin-in"></i></a>
                </div>
                <!-- Footer About Text-->
                <div class="col-lg-4">
                    <h4 class="text-uppercase mb-4">Administration</h4>
                    <a class="btn btn-outline-light btn-social mx-1" title="S'enregistrer" href="?action=register"><i class="fa-solid fa-user-plus"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" title="Se connecter" href="?action=login"><i class="fa-solid fa-lock"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>